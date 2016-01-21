<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 21/01/16
 * Time: 10:21
 */

namespace Pimlink\PimLinkBundle\Entity;

use Pimlink\PimLinkBundle\Helper\PimFileHelper;

class Expert
{
    private $data;
    public $raw_data;

    function __construct($raw_data) {
        $this->raw_data = $raw_data;
    }

    // get field in data
    public function getField($fieldname) {
        $normalized_field = (String)PimFileHelper::normalize_field($fieldname)  ;
        return $this->$normalized_field();
    }

    // Set data field
    public function setField($fieldname, $value) {
        $normalized_field = (String)"set_".PimFileHelper::normalize_field($fieldname);
        $this->$normalized_field($value);
    }

    public function getData() {
        return $this->data;
    }

    public function replicateData() {
        $this->data = $this->raw_data;
    }


    //Generated methods
    public function get_id() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_id($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_activite() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_activite($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_biographie() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_biographie($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_email() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_email($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_lien_interview() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_lien_interview($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_metier() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_metier($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_nom() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_nom($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_photo() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_photo($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_prenom() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_prenom($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_siteWeb() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_siteWeb($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_societe() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_societe($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_telephone() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_telephone($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }
}