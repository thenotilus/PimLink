<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 15:26
 */


class Product
{

    private $data;

    function __construct($raw_data) {
        $this->data = $raw_data;
    }
}