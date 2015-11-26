<?php


/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:22
 */

namespace Notilus\PimLinkBundle\Map\Implementations;

use Mage;
use Monolog\Logger;
use Notilus\PimLinkBundle\Helper\CsvHelper;
use Notilus\PimLinkBundle\Map\ADestinationMap;
use Notilus\PimLinkBundle\Entity\Product;

use Weka_Core_Helper_Data;
//Require_once '../app/Mage.php';
Require_once '/home/seth/Work/magento_catalogue/app/Mage.php';


class WekaMap extends ADestinationMap
{

    private $_logger;
    private $collection;

    function __construct() {
        $this->_csvhelper = new CsvHelper();
        $this->_logger = new Logger("WEKA");
        $this->_logger->info("Instantiate class");

        $this->_logger->info("Connecting to model");
        Mage::app();
        $store = Mage::app()->getStore(Weka_Core_Helper_Data::WEKA_STORE_CODE);
        Mage::app()->setCurrentStore($store->getId());
        $this->collection = Mage::getModel("weka_catalog/product");
    }

    public function getProducts()
    {
        $this->_logger->info("Retreiving products");
        $products = $this->collection->getCollection()->addAttributeToSelect('*');
        foreach ($products as $p) {
            $this->data[$p->getSku()] = $p->getData();
        }
    }

    public function updateProduct($sku, $data = null)
    {
        // TODO: Implement updateProduct() method.
    }

    public function deleteProduct($data = null)
    {
        // TODO: Implement deleteProduct() method.
    }

    public function addProduct($data = null)
    {
        // TODO: Implement addProduct() method.
    }

    public function addProducts($data = null)
    {
        // TODO: Implement addProducts() method.
    }
}