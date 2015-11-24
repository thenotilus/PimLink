<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 23/11/15
 * Time: 14:38
 */

namespace Notilus\PimLinkBundle\Command;

use ReflectionClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;

use Notilus\PimLinkBundle\Helper\CsvHelper;
use Notilus\PimLinkBundle\Map;

class LinkCommand extends Command
{
    private $_logger;
    private $_csvhelper;


    private $_classmap = [
        "weka" => "WekaMap",
        "ti" => "TIMap",
    ];

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
            ->addArgument("option", InputArgument::REQUIRED, "Targeted application ('all', 'Weka', 'TI', etc.)")
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


        if (!$source_data = $this->_csvhelper->getCSV($file)) {
            $this->_logger->info("Source Class could not be instantiated.");
        } else {
            $source = new Map\PimMap();
            $source->setDataSource($source_data);

            $destination = null;
            if ($dest_class_name = $this->checkTarget($option)) {
                $name  = "Map\\".$dest_class_name;
                $destination = new ReflectionClass('Map\\'.$name);
                $destination->setDataSource($source_data);
            }
        }


//        if (!$this->callTarget($option,$file))
//            $this->_logger->info("Link process failed.");
//        else
//            $this->_logger->info("Link process is successful !");
    }



    private function checkTarget($option) {
        $option = strtolower($option);

        if (in_array($option, strtolower($this->_classmap))
            && class_exists(ucfirst($option)."Map")) {
            return ucfirst($option)."Map";
        }
        return false;
    }

    /**
     * @param $option
     * @param $file
     * @return bool
     */
    private function callTarget($option, $file) {
        $lowoption = strtolower($option);
        $csvhelper = new CsvHelper();
        $v_data = $csvhelper->getCSV($file);

        if (!$v_data) {
            $this->_logger->info("Data extraction failed. Check the csv file.");
            return false;
        }

        if (in_array(strtolower($option), $this->_classmap)
            && class_exists(ucfirst($lowoption)."Map"))
        {
            $class = ucfirst($lowoption)."Map";
            $this->_logger->info("Targeted Class : ".$class);
            return ucfirst($lowoption)."Map";
        }
        return false;
    }

}