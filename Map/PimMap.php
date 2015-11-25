<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:21
 */
namespace Notilus\PimLinkBundle\Map;

use Notilus\PimLinkBundle\Helper\CsvHelper;
use Notilus\PimLinkBundle\Element;
use Symfony\Bridge\Monolog\Logger;

class PimMap extends ASourceMap
{

    private $_csvhelper;
    private $_logger;

    function __construct() {
        parent::__construct("pim");

        $this->_csvhelper = new CsvHelper();
        $this->_logger = new Logger("PIM");
        $this->_logger->info("Instantiate class");
    }

    // GET FILE CONTENT AND CREATE DATA SOURCE
    // Here $data is the filename
    function setDataSource($data) {
        $source_data = $this->_csvhelper->getCSV($data);
        $source_data = $this->_csvhelper->relationalArray($source_data);
        if (!$source_data) {
            $this->_logger->info("Data source extraction failed.");
        } else {
            $this->_logger->info("Creating products list");
            $this->data = $source_data;
            foreach ($source_data as $d) {
                $this->products[$d['sku']] = new Element\Product($d);
            }
        }
        $this->_logger->info("Source is ready");
    }
}