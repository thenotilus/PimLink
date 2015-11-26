<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Notilus\PimLinkBundle\Map;
use Notilus\PimLinkBundle\Entity\Product;
use Notilus\PimLinkBundle\Helper\CsvHelper;
use Symfony\Bridge\Monolog\Logger;

abstract class ADestinationMap
{
    protected $data;
    protected $products;
    protected $logger;

    public abstract function getProducts();
    public abstract function updateProduct($sku, $data);
    public abstract function deleteProduct($sku);
    public abstract function addProduct($data = array());

    public function addProducts($data = array()) {
        $products[$data['sku']] = new Product($data);
    }

    public function checkAndCreateProductsList() {
        $logger = new Logger("ADST");
        $csvhelper = new CsvHelper();

        $source_data = $csvhelper->check_reference($this->data);
        $logger->info("Checking data");
        if (is_array($this->data) && count($this->data)) {

        } else {
            return false;
        }
    }
}