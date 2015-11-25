<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Notilus\PimLinkBundle\Map;
use Monolog\Logger;

abstract class ADestinationMap implements IMap
{
    protected $data;
    protected $products;
    protected $logger;
    public $name;

    function __construct($name) {
        $this->logger = new Logger($name);
    }

    // CLASSIC IMPLEM
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

    public function addProduct($data)
    {
        // TODO: Implement addProduct() method.
    }

    public function removeProductBySKU($sku)
    {
        // TODO: Implement removeProductBySKU() method.
    }

    public function setProductStatus($sku, $status = 0)
    {
        // TODO: Implement setProductStatus() method.
    }

    // USELESS METHODS
    public function diffDataSource($src){}

}