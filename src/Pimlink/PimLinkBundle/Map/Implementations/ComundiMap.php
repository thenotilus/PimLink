<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 26/11/15
 * Time: 16:49
 */

namespace Pimlink\PimLinkBundle\Map\Implementations;


use Pimlink\PimLinkBundle\Entity\Product;
use Pimlink\PimLinkBundle\Map\ADestinationMap;

class ComundiMap extends ADestinationMap
{


    public function initConnection()
    {
        // TODO: Implement initConnection() method.
    }

    public function extract()
    {
        // TODO: Implement extract() method.
    }

    public function updateProduct(Product $new_product, $sku)
    {
        // TODO: Implement updateProduct() method.
    }

    public function deleteProduct($sku)
    {
        // TODO: Implement deleteProduct() method.
    }

    public function createProduct(Product $product, $sku)
    {
        // TODO: Implement createProduct() method.
    }

    public function deactivateProduct($sku)
    {
        // TODO: Implement deactivateProduct() method.
    }
}