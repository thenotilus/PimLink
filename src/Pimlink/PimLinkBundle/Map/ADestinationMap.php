<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:35
 */

namespace Pimlink\PimLinkBundle\Map;
use Pimlink\PimLinkBundle\Entity\Expert;
use Pimlink\PimLinkBundle\Entity\Product;
use Pimlink\PimLinkBundle\Helper\PimFileHelper;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Yaml\Parser;

abstract class ADestinationMap
{

    protected $data;
    protected $products;
    protected $experts;
    protected $logger;
    protected $database;
    protected $pimhelper;
    protected $client;
    protected $type;
    protected $reference;
    protected $mapping;

    function __construct($type, $client_name) {
        $this->pimhelper = new PimFileHelper();
        $this->logger = new Logger("DST");
        $this->reference = $this->pimhelper->get_reference_fields($type);
        $this->client = $client_name;
        $this->type = $type;

        $this->logger->info("Instantiate class");
        $this->initConnection();
        $mapping_file = __DIR__."/mapping/".$type."/".$client_name.".yml";
        if (file_exists($mapping_file)) {
            $yaml = new Parser();
            $this->logger->info("A mapping file ".$mapping_file. " was found !");
            $this->mapping = $yaml->parse(file_get_contents($mapping_file));
            if (empty($this->mapping)) {
                $this->logger->info("Could not read mapping file : ".$mapping_file);
                $this->logger->warning("Make sure all extractors were implemented.");
            }
        } else {
            $this->logger->info("No mapping file ".$mapping_file. " found !");
            $this->logger->warning("If there is no mapping file, make sure you implemented all extractors.");
        }
    }

    // Create product from given array
    public function createDataProduct($raw_data = array(), $sku) {
        $product = new Product($raw_data);
        foreach ($this->reference as $name => $p) {
            $f_name = "extract_".$this->pimhelper->normalize_field($name);
            $value = $this->$f_name($product->raw_data);
            $product->setField($name, $value);
        }
        // Set product entity
        $this->products[$sku] = $product;
    }

    // Create exert from given array
    public function createDataExpert($raw_data = array(), $id) {
        $expert = new Expert($raw_data);
        foreach ($this->reference as $name => $p) {
            $f_name = "extract_".$this->pimhelper->normalize_field($name);
            $value = $this->$f_name($expert->raw_data);
            $expert->setField($name, $value);
        }
        // Set product entity
        $this->experts[$id] = $expert;
    }

    //Iterate and check if created product list is okay with reference
    public function checkProductsList() {
        if (!is_array($this->products) || !count($this->products)) {
            $this->logger->info("No ".$this->type." found in DST.");
        }
        $this->logger->info("Checking products List");
        foreach ($this->products as $sku => $product) {
            $errors = $this->pimhelper->check_one_reference($this->type, $product->getData());
            if ($errors > 0) {
                $this->logger->info($errors." Fields are missing in product : ".$sku);
                die;
            }
        }
        $this->logger->info("Fields were created in every products");
        return true;
    }

    public function checkExpertsList() {
        if (!is_array($this->experts) || !count($this->experts)) {
            $this->logger->info("No ".$this->type." found in DST.");
        }
        $this->logger->info("Checking experts List");
        foreach ($this->experts as $id => $expert) {
            $errors = $this->pimhelper->check_one_reference($this->type, $expert->getData());
            if ($errors > 0) {
                $this->logger->info($errors." Fields are missing in expert : ".$id);
                die;
            }
        }
        $this->logger->info("Fields were created in every experts");
        return true;
    }

    public function getProducts() {
        return $this->products;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getExperts()
    {
        return $this->experts;
    }

    protected function getSRCField($dst_field) {
        $flipped = array_flip($this->mapping);
        $field = null;
        if (array_key_exists($dst_field, $flipped)) {
            $field = $flipped[$dst_field];
        }
        return $field;
    }

    protected function  getDSTField($src_field) {
        $field = null;
        if (array_key_exists($src_field, $this->mapping)) {
            $field = $this->mapping[$src_field];
            if ($field == "NA" || is_numeric($field))
                $field = null;
        }
        return $field;
    }

    private function getFieldData($extracted_product_array, $function_name) {
        $src_field = $this->pimhelper->rev_normalize_field(substr(strlen('extract_'), $function_name));

        if ($dst_field = $this->getDSTField($src_field)) {
            return ($extracted_product_array[$dst_field]);
        }
        return '';
    }

    // Connectors init
    public abstract function initConnection();
    public abstract function extract_products();
    public abstract function extract_experts();


    // Connectors implementation Products
    public abstract function updateProduct(Product $new_product, $sku);
    public abstract function deleteProduct($sku);
    public abstract function createProduct(Product $product, $sku);
    public abstract function deactivateProduct($sku);

    // Connectors implementation Experts
    public abstract function updateExpert(Expert $new_expert, $id);
    public abstract function deleteExpert($id);
    public abstract function createExpert(Expert $new_expert, $id);
    public abstract function deactivateExpert($id);

    // Extractors products
    public function extract_sku($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_sku_sap($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_statut_workflow($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_type_produit($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_format_apprentissage($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_pack($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_serious_game($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_difficulte_formation($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_eligible_cpf($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_certifiante($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_formation_anglais($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_partenaire($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_marque($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_duree_formation($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_unite_duree($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_prerequis($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_cibles($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_titre__web($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_titre__print($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_sur_titre__web($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_sous_titre__web($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_sous_titre__print($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_objectifs($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_les_plus($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_programme__web($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_programme__print($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_temoignage($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_contact_chef_marche($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_journee_complementaire__web($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_tarif_ht__EUR($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_tarif_ht_journee_complementaire__EUR($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_tarif_petite_collectivite__EUR($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_tags($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_intervenant($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_image($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_lien_video($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_description_courte($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_texte_seo($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_duree_sequencee($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_gamme($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_family($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_categories($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_enabled($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}

    //Extractors experts
    public function extract_id($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_activite($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_biographie($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_email($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_lien_interview($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_metier($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_nom($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_photo($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_prenom($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_siteWeb($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_societe($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}
    public function extract_telephone($extracted_product_array){return $this->getFieldData($extracted_product_array, __FUNCTION__);}


}