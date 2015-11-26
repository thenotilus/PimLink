<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:21
 */
namespace Notilus\PimLinkBundle\Map\Implementations;

use Notilus\PimLinkBundle\Helper\CsvHelper;
use Notilus\PimLinkBundle\Entity\Product;
use Notilus\PimLinkBundle\Map\ADestinationMap;
use Notilus\PimLinkBundle\Map\ASourceMap;
use Symfony\Bridge\Monolog\Logger;

class PimMap extends ASourceMap
{

    private $_csvhelper;
    private $_logger;

    function __construct() {
        $this->_csvhelper = new CsvHelper();
        $this->_logger = new Logger("PIM");
        $this->_logger->info("Instantiate class");
    }


    public function getProducts($file)
    {
        $this->reference = $file;
        $source_data = $this->_csvhelper->getCSV($file);
        $source_data = $this->_csvhelper->relationalArray($source_data);

        if ($this->_csvhelper->check_reference($source_data) && !$source_data) {
            $this->_logger->info("Data source extraction failed.");
        } else {
            $this->_logger->info("Creating products list");
            $this->data = $source_data;
            foreach ($source_data as $d) {
                $this->products[$d['sku']] = new Product($d);
            }
        }
        $this->_logger->info("Source is ready");
    }


    /**
     * @param ADestinationMap $destination
     */
    public function diffProducts(ADestinationMap $destination)
    {

    }
}