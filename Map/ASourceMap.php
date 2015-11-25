<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Notilus\PimLinkBundle\Map;
use Monolog\Logger;

abstract class ASourceMap
{

    protected $data;
    protected $products;
    protected $logger;

    public abstract function getProducts($data);
    public abstract function diffProducts(ADestinationMap $destination);

}