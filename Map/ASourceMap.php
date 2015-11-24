<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */


namespace Notilus\PimLinkBundle\Map;
use Monolog\Logger;

class ASourceMap implements IMap
{

    protected $data;
    protected $products;
    protected $logger;
    public $name;

    function __construct($name) {
        $this->logger = new Logger($name);
    }

    public function setDataSource($data)
    {
        // SET ARRAY RAW DATA
        // THEN SET ARRAY OF PRODUCT() KEYED BY SKU
    }

    public function getProductBySKU($sku)
    {
        // TODO: Implement getProductBySKU() method.
    }

    public function removeProductBySQU($sku)
    {
        // ############################
        // NOTHING HERE AND NO OVERRIDE
    }

    public function addProduct($product)
    {
        // ############################
        // NOTHING HERE AND NO OVERRIDE
    }

    public function getDataSource()
    {
        return $this->data;
    }

    public function diffDataSource($src)
    {
        // TODO: Implement diffDataSource() method.
    }

    public function removeProductBySKU($sku)
    {
        // TODO: Implement removeProductBySKU() method.
    }

    public function setProductStatus($sku, $status = 0)
    {
        // TODO: Implement setProductStatus() method.
    }

    public function getField($reference_name)
    {
        // IMPLEMENT FOR EACH DESTINATION CLASS
        return null;
    }
}