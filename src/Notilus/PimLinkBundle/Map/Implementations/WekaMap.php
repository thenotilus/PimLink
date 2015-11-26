<?php


/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:22
 */

namespace Notilus\PimLinkBundle\Map\Implementations;


use Monolog\Logger;
use Notilus\PimLinkBundle\Helper\CsvHelper;
use Notilus\PimLinkBundle\Map\ADestinationMap;

class WekaMap extends ADestinationMap
{

    private $_logger;

    function __construct() {
        $this->_csvhelper = new CsvHelper();
        $this->_logger = new Logger("WEKA");
        $this->_logger->info("Instantiate class");
    }

    public function getProducts($data)
    {
        // TODO: Implement getProducts() method.
    }

    public function mapFields($data)
    {
        // TODO: Implement mapFields() method.
    }

    public function updateProduct($data)
    {
        // TODO: Implement updateProduct() method.
    }

    public function deleteProduct($data)
    {
        // TODO: Implement deleteProduct() method.
    }

    public function addProduct($data)
    {
        // TODO: Implement addProduct() method.
    }

    public function addProducts($data)
    {
        // TODO: Implement addProducts() method.
    }
}