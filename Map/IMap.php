<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:27
 */

namespace Notilus\PimLinkBundle\Map;

interface IMap
{

    public function getField($reference_name);

    public function setDataSource($data);

    public function getDataSource();

    public function diffDataSource($src);

    public function getProductBySKU($sku);

    public function removeProductBySKU($sku);

    public function addProduct($sku);

    public function setProductStatus($sku, $status = 0);

}