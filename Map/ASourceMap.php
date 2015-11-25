<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Notilus\PimLinkBundle\Map;
use Monolog\Logger;

abstract class ASourceMap implements IMap
{

    protected $data;
    protected $products;
    protected $logger;
    public $name;

    function __construct($name) {
        $this->logger = new Logger($name);
    }

    // CLASSIQUE IMPLEM
    public function getDataSource()
    {
        return $this->data;
    }

    public function getProductBySKU($sku)
    {
        foreach ($this->products as $k => $product) {
            if ($k == $sku) return $product;
        }
        return null;
    }


    public function diffDataSource($dst)
    {
        // TODO: Implement diffDataSource() method.
        return null;
    }

    // USELESS FUNCTION
    public function addProduct($product) {}
    public function removeProductBySKU($sku) {}
    public function setProductStatus($sku, $status = 0) {}
    public function updateSource($new_data){}

}