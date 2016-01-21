<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 23/11/15
 * Time: 15:21
 */

namespace Pimlink\PimLinkBundle\Helper;

use Symfony\Component\Yaml;
use Monolog\Logger;

class PimFileHelper
{


    /**
     * Create Data from PIM CSV file
     * @param $file
     * @return array|bool
     */
    static public function getCSV($file) {
        $logger = new Logger("PIMHELP");

        $logger->info("Extract of CSV file : ".$file);
        $arr = array();
        if ($handle = fopen($file, "r")) {
            while ($data_arr = fgetcsv($handle)) {
                $arr[] = $data_arr;
            }
        }
        if (!self::check_csv_array($arr)) {
            $logger->info("Extracted array is KO");
            return false;
        }

        self::print_fields_name($arr[0]);
        $logger->info("Extracted array is OK");
        return $arr;
    }


    /**
     * this function can be called with the array created from CSV
     * Prints the functions getter setters
     * Lazy Developer purpose
     * @param $fields
     */
    static public function print_fields_name($fields) {
        foreach($fields as $n => $col) {
//            printf("%s: %d\n", $col, $n); // Fields lists
//            printf("public abstract function extract_%s(".'$extracted_product_array'.");\n", self::normalize_field($col)); // extrators
//            printf('public function extract_%s($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}'."\n", self::normalize_field($col)); // extrators
//            printf('public function get_%s() {'."\n\t".'return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];'."\n}\n\n", self::normalize_field($col)); // getters
//            printf('public function set_%s($value) {'."\n\t".'$this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;'."\n}\n\n", self::normalize_field($col)); // setters
        }
//        die;
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
    public function relationalArray($type, $arr) {
        $yaml = new Yaml\Parser();
        $reference = $yaml->parse(file_get_contents(__DIR__.'/../reference/'.$type.'.yml'));
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
        $logger->info("First column count : ".$column_count);
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
    static public function check_list_reference($type, $array_list) {
        $logger = new Logger("CSVHELPER");
        $logger->info("Checking reference map");

        foreach ($array_list as $sku => $arr) {
            $unknown_count = self::check_one_reference($type, $arr);
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
     * To create the reference file from given csv source file
     * @param $type
     * @param $csv_file
     */
    static public function create_reference($type, $csv_file) {
        $logger = new Logger("CSVHELPER");
        $logger->info("Creating reference file ...");
        $arr = self::getCSV($csv_file);
        $file = __DIR__.'/../reference/'.$type.'.yml';
        if ($arr & isset($arr[0])) {
            $keys = $arr[0];
            $data = "";
            foreach ($keys as $id => $entry) {
                $data .= $entry . ": ".$id."\n";
            }
            file_put_contents($file, $data);
        } else {
            $logger->info("Could not create reference file because source csv file is not OK.");
            die;
        }
    }

    /**
     * Check one product array and sends number of know error detected
     * @param $arr
     * @return int
     */
    static public function check_one_reference($type, $arr) {
        $logger = new Logger("CSVHELPER");
        $reference = self::get_reference_fields($type);
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
    static public function get_reference_fields($type) {
        $yaml = new Yaml\Parser();
        $reference = $yaml->parse(file_get_contents(__DIR__.'/../reference/'.$type.'.yml'));

        return $reference;
    }

}