<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Pimlink\PimLinkBundle\Map;
use Monolog\Logger;
use Pimlink\PimLinkBundle\Helper\PimFileHelper;

abstract class ASourceMap
{

    protected $data;
    protected $products;
    protected $experts;
    protected $logger;
    protected $reference;
    protected $client;
    protected $type;

    function __construct($type) {
        $this->pimhelper = new PimFileHelper();
        $this->logger = new Logger("PIM");
        $this->logger->info("Instantiate class");
        $this->type = $type;
        $this->reference = $this->pimhelper->get_reference_fields($this->type);
    }

    public abstract function extract($data);
    public abstract function diffProducts(ADestinationMap $destination);
    public abstract function diffExperts(ADestinationMap $destination);

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getExperts()
    {
        return $this->experts;
    }

}