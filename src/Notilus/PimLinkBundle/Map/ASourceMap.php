<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Notilus\PimLinkBundle\Map;
use Monolog\Logger;
use Notilus\PimLinkBundle\Helper\PimFileHelper;

abstract class ASourceMap
{

    protected $data;
    protected $products;
    protected $logger;
    protected $reference;

    function __construct() {
        $this->pimhelper = new PimFileHelper();
        $this->logger = new Logger("PIM");
        $this->logger->info("Instantiate class");
        $this->reference = $this->pimhelper->get_reference_fields();
    }

    public abstract function extractProducts($data);
    public abstract function diffProducts(ADestinationMap $destination);

}