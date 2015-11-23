<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 23/11/15
 * Time: 15:21
 */

namespace Notilus\PimLinkBundle\Helper;



use Monolog\Logger;

class CsvHelper
{

    public function getCSV($file) {
        $logger = new Logger("CSVHELPER");

        $logger->info("Extract of CSV file : ".$file);

        $arr = array_map('str_getcsv', file($file));

        if (!$this->check_csv_array($arr)) {
            return false;
        }

        return $arr;
    }

    /**
     * @param $arr
     * @return bool
     */
    public function check_csv_array($arr) {
        $logger = new Logger("CSVHELPER");

        if (!count($arr)) {
            $logger->info("Received csv array seems empty.");
            return false;
        }

        $column_count = count($arr[0]);
        foreach ($arr as $l => $row) {
            if (count($row) != $column_count) {
                $logger->info("Number of columns doesn't match on line : ".($l+1));
                return false;
            }
        }

        return true;
    }

}