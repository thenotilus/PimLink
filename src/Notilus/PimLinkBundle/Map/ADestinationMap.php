<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Notilus\PimLinkBundle\Map;
use Notilus\PimLinkBundle\Entity\Product;
use Notilus\PimLinkBundle\Helper\PimFileHelper;
use Symfony\Bridge\Monolog\Logger;

abstract class ADestinationMap
{

    protected $data;
    protected $products;
    protected $logger;
    protected $database;
    protected $pimhelper;
    protected $reference;

    function __construct() {
        $this->pimhelper = new PimFileHelper();
        $this->logger = new Logger("DST");
        $this->reference = $this->pimhelper->get_reference_fields();

        $this->logger->info("Instantiate class");
        $this->initConnection();
    }

    public abstract function initConnection();

    public abstract function extractProducts();
    public abstract function updateProduct($new_product, $sku);
    public abstract function deleteProduct($sku);
    public abstract function createProduct($product, $sku);
    public abstract function deactivateProduct($sku);

    public function addProduct($raw_data = array(), $sku) {
        $product = new Product($raw_data);
        foreach ($this->reference as $name => $p) {
            $f_name = "extract_".$this->pimhelper->normalize_field($name);
            // Call extract_field_name with product raw data
            $value = $this->$f_name($product->raw_data);
            $product->setField($name, $value);
        }
        // Set product entity
        $this->products[$sku] = $product;
    }

    public function getProducts() {
        return $this->products;
    }

    public abstract function extract_sku($extracted_product_array);
    public abstract function extract_type_module($extracted_product_array);
    public abstract function extract_statut_workflow($extracted_product_array);
    public abstract function extract_format_apprentissage($extracted_product_array);
    public abstract function extract_pack($extracted_product_array);
    public abstract function extract_marque($extracted_product_array);
    public abstract function extract_duree_formation($extracted_product_array);
    public abstract function extract_unite_duree($extracted_product_array);
    public abstract function extract_format_cycle($extracted_product_array);
    public abstract function extract_eligible_cpf($extracted_product_array);
    public abstract function extract_certifiante($extracted_product_array);
    public abstract function extract_diplomante($extracted_product_array);
    public abstract function extract_difficulte_formation($extracted_product_array);
    public abstract function extract_formation_anglais($extracted_product_array);
    public abstract function extract_partenaire($extracted_product_array);
    public abstract function extract_titre__web($extracted_product_array);
    public abstract function extract_sur_titre__web($extracted_product_array);
    public abstract function extract_sous_titre__web($extracted_product_array);
    public abstract function extract_contact_chef_marche($extracted_product_array);
    public abstract function extract_prerequis($extracted_product_array);
    public abstract function extract_objectifs($extracted_product_array);
    public abstract function extract_cibles($extracted_product_array);
    public abstract function extract_les_plus($extracted_product_array);
    public abstract function extract_programme__web($extracted_product_array);
    public abstract function extract_tarif_ht__EUR($extracted_product_array);
    public abstract function extract_tarif_ht_journee_complementaire__EUR($extracted_product_array);
    public abstract function extract_serious_game($extracted_product_array);
    public abstract function extract_tarif_petite_collectivite__EUR($extracted_product_array);
    public abstract function extract_tags($extracted_product_array);
    public abstract function extract_intervenant($extracted_product_array);
    public abstract function extract_image($extracted_product_array);
    public abstract function extract_lien_video($extracted_product_array);
    public abstract function extract_temoignage($extracted_product_array);
    public abstract function extract_description_courte($extracted_product_array);
    public abstract function extract_texte_seo($extracted_product_array);
    public abstract function extract_family($extracted_product_array);
    public abstract function extract_categories($extracted_product_array);
    public abstract function extract_groups($extracted_product_array);
    public abstract function extract_option__groups($extracted_product_array);
    public abstract function extract_option__products($extracted_product_array);
    public abstract function extract_journee_complementaire__groups($extracted_product_array);
    public abstract function extract_journee_complementaire__products($extracted_product_array);
    public abstract function extract_session__groups($extracted_product_array);
    public abstract function extract_session__products($extracted_product_array);
    public abstract function extract_enabled($extracted_product_array);


    public function checkProductsList() {
        if (!is_array($this->products) || !count($this->products)) {
            $this->logger->info("No products found in DST.");
            die();
        }
        $this->logger->info("Checking products List");
        foreach ($this->products as $sku => $product) {
            $errors = $this->pimhelper->check_one_reference($product->getData());
            if ($errors > 0) {
                $this->logger->info($errors." Fields are missing in product : ".$sku);
                die;
            }
        }
        $this->logger->info("Fields were created in every products");
        return true;
    }
}