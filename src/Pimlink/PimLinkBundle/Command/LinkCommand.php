<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 23/11/15
 * Time: 14:38
 */

namespace Pimlink\PimLinkBundle\Command;

use Pimlink\PimLinkBundle\Map\Implementations\PimMap;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;

use Pimlink\PimLinkBundle\Helper\PimFileHelper;
use Pimlink\PimLinkBundle\Map\Implementations;
use Pimlink\PimLinkBundle\Map;

class LinkCommand extends Command
{
    private $_logger;
    private $_csvhelper;

    public function __construct() {
        parent::__construct();

        $this->_logger = new Logger("PIMLINK");
        $this->_csvhelper = new PimFileHelper();
    }

    protected function configure()
    {
        $this
            ->setName('pimlink:execute')
            ->addArgument("type", InputArgument::REQUIRED, "Type of data to import ('experts', 'products')" )
            ->addArgument("file", InputArgument::REQUIRED, "PIM csv products file" )
            ->addArgument("client", InputArgument::REQUIRED, "Targeted application ('weka', 'ti', etc.)")
            ->setDescription('Creates the link between PIM and external client site web')
            ->setHelp("$> pimlink:execute [experts/products] [experts/products].csv [client_name]");
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_logger->info("#############");
        $this->_logger->info("### START ###");
        $this->_logger->info("#############");

        // Get arguments
        $file = $input->getArgument('file');
        $client = $input->getArgument('client');
        $type = $input->getArgument('type');

        $this->_logger->info('Provided PIM file : '.$file);
        $this->_logger->info('Procedure for : '.$type);
        $this->_logger->info('Targeted application : '.$client);

        // Creating reference from csv file
        $this->_csvhelper->create_reference($type, $file);

        $extract_type = "extract_".$type;
        // Instantiation of Source class (csv file)
        $this->_logger->info("Creating SRC data source");
        $source = new PimMap($type);
        $source->setType($type);
        $source->setClient($client);
        $source->extract($file);

        //Instantiation of Destination class
        $this->_logger->info("Creating DST data source : ".$client);
        if ($dst_class_name = $this->checkTarget($client)) {
            $this->_logger->info("Class was found");
            $destination = new $dst_class_name($type, $client);
            $destination->setType($type);
            $destination->setClient($client);
            $destination->$extract_type();
        } else {
            $this->_logger->info("No class found for option  : ".$client);
            exit ;
        }

        //Diff products
        if ($type == "experts") {
            if ($destination->checkExpertsList())
                $source->diffExperts($destination);
        } else {
            // check products here
            if ($destination->checkProductsList())
                $source->diffProducts($destination);
        }
    }

    private function checkTarget($option) {
        $option = strtolower($option);

        $this->_logger->info("Checking if class exists");
        $class_name = ucfirst($option)."Map";
        if (class_exists('Pimlink\PimLinkBundle\Map\Implementations\\'.$class_name)) {
            return 'Pimlink\PimLinkBundle\Map\Implementations\\'.$class_name;
        }
        return false;
    }

}