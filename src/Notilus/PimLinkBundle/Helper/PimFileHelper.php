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

class PimFileHelper
{

    /**
     * Create Data from PIM CSV file
     * @param $file
     * @return array|bool
     */
    public function getCSV($file) {
        $logger = new Logger("PIMHELP");

        $logger->info("Extract of CSV file : ".$file);
        $arr = array_map('str_getcsv', file($file));
        if (!$this->check_csv_array($arr)) {
            $logger->info("Extracted array is KO");
            return false;
        }

        $this->print_fields_name($arr[0]);
        $logger->info("Extracted array is OK");
        return $arr;
    }


    /**
     * this function can be called with the array created from CSV
     * Prints the functions getter setters
     * Lazy Developer purpose
     * @param $fields
     */
    public function print_fields_name($fields) {
        foreach($fields as $n => $col) {
            //printf("%s: %d\n", $col, $n); // Fields lists
            //printf("public abstract function extract_%s(".'$extracted_product_array'.");\n", $this->normalize_field($col)); // extrators
            //printf('public function get_%s() {'."\n\t".'return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];'."\n}\n\n", $this->normalize_field($col)); // getters
            //printf('public function set_%s($value) {'."\n\t".'$this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;'."\n}\n\n", $this->normalize_field($col)); // setters
        }
        //die;
    }

    /**
     * Takes a field name and writes it back normalized for PHP function spelling issues
     * @param $name
     * @return mixed
     */
    static public function normalize_field($name) {
        return (str_replace('-', '__', $name));
    }


    /**
     * Takes a field feeding function name and writes back the original field name
     * @param $name
     * @return mixed
     */
    static public function rev_normalize_field($name) {
        return (str_replace('__', '-', $name));
    }

    /**
     * Take a CSV extracted array and sends back a relational array with data inside
     * @param $arr
     * @return array
     */
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
     * check array created from CSV is okay
     * @param $arr
     * @return bool
     */
    static public function check_csv_array($arr) {
        $logger = new Logger("PIMHELP");

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


    /**
     * Check an array of products and raise error if there is known problem
     * @param $array_list
     * @return bool
     */
    static public function check_list_reference($array_list) {
        $logger = new Logger("CSVHELPER");
        $yaml = new Yaml\Parser();
        $logger->info("Checking reference map");

        foreach ($array_list as $sku => $arr) {
            $unknown_count = self::check_one_reference($arr);
            if ($unknown_count > 0) {
                $logger->info("################################");
                $logger->info("Bug report for product : ".$sku);
                $logger->info("Number of non-referenced columns : ".$unknown_count);
                $logger->info("Reference map check KO");
                die;
            }
        }

        $logger->info("Reference map check OK");
        return true;
    }


    /**
     * Check one product array and sends number of know error detected
     * @param $arr
     * @return int
     */
    static public function check_one_reference($arr) {
        $logger = new Logger("CSVHELPER");
        $reference = self::get_reference_fields();

        $unknown_count = 0;
        foreach ($reference as $name => $r) {
            if (!array_key_exists($name, $arr)) {
                $logger->error("Missing reference : '".$name."'");
                $unknown_count += 1;
            }
        }
        return $unknown_count;
    }


    /**
     * Sends back the reference array
     * @return mixed
     */
    static public function get_reference_fields() {
        $yaml = new Yaml\Parser();
        $reference = $yaml->parse(file_get_contents(__DIR__.'/../reference.yml'));

        return $reference;
    }

}