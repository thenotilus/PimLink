<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 23/11/15
 * Time: 15:21
 */

namespace Notilus\PimLinkBundle\Helper;

use Symfony\Component\Yaml;


use Monolog\Logger;

class CsvHelper
{

    public function getCSV($file) {
        $logger = new Logger("CSVHELPER");

        $logger->info("Extract of CSV file : ".$file);

        $arr = array_map('str_getcsv', file($file));

        if (!$this->check_csv_array($arr)) {
            $logger->info("Extracted array is KO");
            return false;
        }

        $logger->info("Extracted array is OK");
        // Reference list
//        foreach($arr[0] as $n => $col) {
//            printf("%s: %d\n", $col, $n);
//        }

        return $arr;
    }


    public function relationalArray($arr) {
        $yaml = new Yaml\Parser();
        $reference = $yaml->parse(file_get_contents(__DIR__.'/../reference.yml'));
        $relational = array();
        $reference = array_keys($reference);

        unset($arr[0]);
        foreach ($arr as $r => $row) {
            foreach ($row as $k => $col) {
                $relational[$r][$reference[$k]] = $col;
            }
        }
        return $relational;
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


    public function check_reference($array_list) {
        $logger = new Logger("CSVHELPER");
        $yaml = new Yaml\Parser();
        $reference = $yaml->parse(file_get_contents(__DIR__.'/../reference.yml'));

        $logger->info("Checking reference map");
        foreach ($array_list as $sku => $arr) {
            $col = array_keys($arr);
            $unknown_count = 0;


            foreach ($reference as $name => $r) {
                if (!array_key_exists($name, $arr)) {
                    $logger->error("Missing reference in product : '".$name."'");
                    $unknown_count++;
                }
            }

            if ($unknown_count > 0) {
                $logger->info("################################");
                $logger->info("Bug report for product : ".$sku);
                $logger->info("Number of non-referenced columns : ".$unknown_count);
                $logger->info("Reference map check KO");
                return false;
            }
        }

        $logger->info("Reference map check OK");
        return true;
    }
}