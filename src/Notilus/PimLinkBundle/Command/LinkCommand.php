<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 23/11/15
 * Time: 14:38
 */

namespace Notilus\PimLinkBundle\Command;

use Notilus\PimLinkBundle\Map\Implementations\PimMap;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;

use Notilus\PimLinkBundle\Helper\CsvHelper;
use Notilus\PimLinkBundle\Map\Implementations;
use Notilus\PimLinkBundle\Map;

class LinkCommand extends Command
{
    private $_logger;
    private $_csvhelper;

    public function __construct() {
        parent::__construct();

        $this->_logger = new Logger("PIMLINK");
        $this->_csvhelper = new CsvHelper();
    }

    protected function configure()
    {
        $this
            ->setName('pimlink:execute')
            ->addArgument('file', InputArgument::REQUIRED, "PIM csv products file" )
            ->addArgument("option", InputArgument::REQUIRED, "Targeted application ('weka', 'ti', etc.)")
            ->setDescription('Creates the link between PIM and external client site web')
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

        $file = $input->getArgument('file');
        $option = $input->getArgument('option');

        $this->_logger->info('Provided PIM file : '.$file);
        $this->_logger->info('Targeted application : '.$option);


        $this->_logger->info("Creating SRC data source");
        $source = new PimMap();
        $source->getProducts($file);


        $this->_logger->info("Creating DST data source : ".$option);
        if ($dst_class_name = $this->checkTarget($option)) {
            $this->_logger->info("Class was found");
            $destination = new $dst_class_name();
            $destination->getProducts();
        } else {
            $this->_logger->info("No class found for option  : ".$option);
            exit ;
        }

        //Diff products
        if ($destination->checkAndCreateProductsList())
            $source->diffProducts($destination);
    }

    private function checkTarget($option) {
        $option = strtolower($option);

        $this->_logger->info("Checking if class exists");
        $class_name = ucfirst($option)."Map";
        if (class_exists('Notilus\PimLinkBundle\Map\Implementations\\'.$class_name)) {
            return 'Notilus\PimLinkBundle\Map\Implementations\\'.$class_name;
        }
        return false;
    }

}