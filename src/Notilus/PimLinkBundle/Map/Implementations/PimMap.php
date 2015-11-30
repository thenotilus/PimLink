<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:21
 */
namespace Notilus\PimLinkBundle\Map\Implementations;

use Notilus\PimLinkBundle\Helper\PimFileHelper;
use Notilus\PimLinkBundle\Entity\Product;
use Notilus\PimLinkBundle\Map\ADestinationMap;
use Notilus\PimLinkBundle\Map\ASourceMap;
use Symfony\Bridge\Monolog\Logger;

class PimMap extends ASourceMap
{

    public function extractProducts($file)
    {
        $source_data = $this->pimhelper->getCSV($file);
        $source_data = $this->pimhelper->relationalArray($source_data);

        if ($this->pimhelper->check_list_reference($source_data) && !$source_data) {
            $this->logger->info("Data source extraction failed.");
        } else {
            $this->logger->info("Creating products list");
            $this->data = $source_data;
            foreach ($source_data as $d) {
                $this->products[$d['sku']] = new Product($d);
            }
        }
        $this->logger->info("Source is ready");
    }


    /**
     * @param ADestinationMap $destination
     */
    public function diffProducts(ADestinationMap $destination)
    {
        $dst_products = $destination->getProducts();
        foreach ($dst_products as $pr) {
            $dst_sku = $pr->get_sku();

            if (!in_array($dst_sku, $this->products)) { // If product is not referenced, just deactivate
                $this->logger->info("Desactivating product : ".$dst_sku);
                $destination->deactivateProduct($dst_sku);
            } else if (array_diff($pr->getData(), $this->products[$dst_sku]->getData())) { // If product is different just modify
                $this->logger->info("Updating product : ".$dst_sku);
                $destination->updateProduct($this->products[$dst_sku] ,$dst_sku);
            } else { // In every other case, just create product
                $this->logger->info("Creating product product : ".$dst_sku);
                $destination->createProduct($this->products[$dst_sku] ,$dst_sku);
            }
        }
    }
}