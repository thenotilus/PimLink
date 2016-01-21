<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:21
 */
namespace Pimlink\PimLinkBundle\Map\Implementations;

use Pimlink\PimLinkBundle\Entity\Expert;
use Pimlink\PimLinkBundle\Entity\Product;
use Pimlink\PimLinkBundle\Map\ADestinationMap;
use Pimlink\PimLinkBundle\Map\ASourceMap;

class PimMap extends ASourceMap
{

    public function extract($file)
    {
        $source_data = $this->pimhelper->getCSV($file);
        $source_data = $this->pimhelper->relationalArray($this->type, $source_data);

        if ($this->pimhelper->check_list_reference($this->type, $source_data) && !$source_data) {
            $this->logger->info("Data source extraction failed.");
        } else {
            $this->logger->info("Creating list");
            $this->data = $source_data;
            foreach ($source_data as $d) {
                if ($this->type == 'experts') {
                    $this->experts[$d['id']] = new Expert($d);
                    $this->experts[$d['id']]->replicateData();
                } else {
                    $this->products[$d['sku']] = new Product($d);
                    $this->products[$d['sku']]->replicateData();
                }
            }
        }

        $this->logger->info("Source is ready.");
    }

    /**
     * @param ADestinationMap $destination
     */
    public function diffExperts(ADestinationMap $destination) {
        $dst_experts = $destination->getExperts();
        // Check and update destination experts
        foreach ($dst_experts as $dst_id => $dst_expert) {

            if (!key_exists($dst_id, $this->experts)) { // If expert is not referenced, just deactivate
                $this->logger->info("Desactivating expert : ".$dst_id);
//                $destination->deactivateExpert($dst_id);

            } else { // just update product
                $this->logger->info("Updating expert : ".$dst_id);
                $destination->updateExpert($this->experts[$dst_id] ,$dst_id);
            }
        }
        // Check And create missing products
        foreach ($this->experts as $src_id => $src_expert) {
            if (!key_exists($src_id, $dst_experts)) {
                $this->logger->info("Create expert : ".$src_id);
                $destination->createExpert($src_expert, $src_id);
            }
        }
    }


    /**
     * @param ADestinationMap $destination
     */
    public function diffProducts(ADestinationMap $destination)
    {
        $dst_products = $destination->getProducts();

        // Check and update destination products
        foreach ($dst_products as $dst_sku => $dst_product) {

            if (!key_exists($dst_sku, $this->products)) { // If product is not referenced, just deactivate
                $this->logger->info("Desactivating product : ".$dst_sku);
//                $destination->deactivateProduct($dst_sku);

            } else { // just update product
                if ($this->products[$dst_sku]->get_statut_workflow() != "Validé")
                    continue;
                $this->logger->info("Updating product : ".$dst_sku);
//                $destination->updateProduct($this->products[$dst_sku] ,$dst_sku);
            }
        }
        // Check And create missing products
        foreach ($this->products as $src_sku => $src_product) {
            if (!key_exists($src_sku, $dst_products)) {
                if ($this->products[$src_sku]->get_statut_workflow() != "Validé")
                    continue;
                $this->logger->info("Create product : ".$src_sku);
//                $destination->createProduct($src_product, $src_sku);
            }
        }
    }
}