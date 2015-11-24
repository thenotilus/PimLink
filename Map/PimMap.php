<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:21
 */
namespace Notilus\PimLinkBundle\Map;

use Product;

class PimMap extends ASourceMap
{

    function __construct() {
        parent::__construct("pim");
    }

    function setDataSource($data) {
        $this->data = $data;
        foreach ($data as $d) {
            $this->products[$d['sku']] = new Product($d);
        }
    }
}