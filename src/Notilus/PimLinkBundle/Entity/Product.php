<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 15:26
 */

namespace Notilus\PimLinkBundle\Entity;

class Product
{
    private $data;

    function __construct($raw_data) {
        $this->data = $raw_data;
    }

    //get field in data
    function getField($fieldname) {
        foreach ($this->data as $name => $d) {
            if ($fieldname == $name) {
                return $d;
            }
        }
        return null;
    }

}