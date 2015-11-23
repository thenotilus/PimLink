<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 23/11/15
 * Time: 14:38
 */

namespace Notilus\PimLinkBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;

use Notilus\PimLinkBundle\Helper\CsvHelper;

class LinkCommand extends Command
{
    private $_logger;

    private $_classmap = [
        "weka" => "WekaMap",
        "ti" => "TIMap",
    ];

    public function __construct() {
        parent::__construct();

        $this->_logger = new Logger("PIMLINK");
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

        if (!$this->callTarget($option,$file))
            $this->_logger->info("Link process failed.");
        else
            $this->_logger->info("Link process is successful !");
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
            $this->_logger("Targeted Class : ".$class);
        } else {
            return false;
        }

    }

}