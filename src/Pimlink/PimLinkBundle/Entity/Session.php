<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 25/11/15
 * Time: 16:16
 */

namespace Pimlink\PimLinkBundle\Entity;


class Session
{
    private $data;

    function __construct($raw_data)
    {
        $this->data = $raw_data;
    }

}