<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Notilus\PimLinkBundle\Map;
use Monolog\Logger;

abstract class ADestinationMap
{
    protected $data;
    protected $products;
    protected $logger;


    public abstract function getProducts($data);
    public abstract function mapFields($data);
    public abstract function updateProduct($data);
    public abstract function deleteProduct($data);
    public abstract function addProduct($data);
    public abstract function addProducts($data);

}