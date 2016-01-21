<?php

/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 15:26
 */

namespace Pimlink\PimLinkBundle\Entity;

use Pimlink\PimLinkBundle\Helper\PimFileHelper;

class Product
{
    private $data;
    public $raw_data; // Used to store data extracted from database

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

    // Generated methods
    public function get_sku() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_sku($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_sku_sap() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_sku_sap($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_statut_workflow() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_statut_workflow($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_type_produit() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_type_produit($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_format_apprentissage() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_format_apprentissage($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_pack() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_pack($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_serious_game() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_serious_game($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_difficulte_formation() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_difficulte_formation($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_eligible_cpf() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_eligible_cpf($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_certifiante() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_certifiante($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_formation_anglais() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_formation_anglais($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_partenaire() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_partenaire($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_marque() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_marque($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_duree_formation() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_duree_formation($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_unite_duree() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_unite_duree($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_prerequis() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_prerequis($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_cibles() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_cibles($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_titre__web() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_titre__web($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_titre__print() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_titre__print($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_sur_titre__web() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_sur_titre__web($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_sous_titre__web() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_sous_titre__web($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_sous_titre__print() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_sous_titre__print($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_objectifs() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_objectifs($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_les_plus() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_les_plus($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_programme__web() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_programme__web($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_programme__print() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_programme__print($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_temoignage() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_temoignage($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_contact_chef_marche() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_contact_chef_marche($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_journee_complementaire__web() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_journee_complementaire__web($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_tarif_ht__EUR() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_tarif_ht__EUR($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_tarif_ht_journee_complementaire__EUR() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_tarif_ht_journee_complementaire__EUR($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_tarif_petite_collectivite__EUR() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_tarif_petite_collectivite__EUR($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_tags() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_tags($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_intervenant() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_intervenant($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_image() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_image($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_lien_video() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_lien_video($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_description_courte() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_description_courte($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_texte_seo() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_texte_seo($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_duree_sequencee() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_duree_sequencee($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_gamme() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_gamme($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_family() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_family($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_categories() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_categories($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

    public function get_enabled() {
        return $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))];
    }

    public function set_enabled($value) {
        $this->data[PimFileHelper::rev_normalize_field(substr(__FUNCTION__, 4))] = $value;
    }

}