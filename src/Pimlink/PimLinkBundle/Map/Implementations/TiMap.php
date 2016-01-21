<?php
/**
 * Created by PhpStorm.
 * User: seth
 * Date: 26/11/15
 * Time: 11:08
 */

namespace Pimlink\PimLinkBundle\Map\Implementations;

use Mage;
use Pimlink\PimLinkBundle\Map\ADestinationMap;
use Pimlink\PimLinkBundle\Entity\Product;

use Weka_Core_Helper_Data;

//Require_once $this->get('kernel')->getRootDir().'/../app/Mage.php';
Require_once '/home/seth/Work/magento_catalogue/app/Mage.php';


class TiMap extends ADestinationMap
{

    public function initConnection()
    {
        $this->logger->info("Connecting to model");

        Mage::app();
        $store = Mage::app()->getStore(Weka_Core_Helper_Data::TI_STORE_CODE);
        Mage::app()->setCurrentStore($store->getId());

        $this->database = Mage::getModel("ti_catalog/product");
    }

    public function extract()
    {
        $this->logger->info("Retrieving products");
        $products = $this->database->getCollection()->addAttributeToSelect('*');
        foreach ($products as $p) {
            $pr = new Product();
            $this->createDataProduct($pr->getData(), $pr->getSku());
        }
    }


    public function updateProduct($new_product, $sku)
    {
        // TODO: Implement updateProduct() method.
    }

    public function deleteProduct($sku)
    {
        // TODO: Implement deleteProduct() method.
    }

    public function createProduct($product, $sku)
    {
        // TODO: Implement createProduct() method.
    }

    public function deactivateProduct($sku)
    {
        // TODO: Implement deactivateProduct() method.
    }

    public function extract_sku($extracted_product_array)
    {
        // TODO: Implement extract_sku() method.
    }

    public function extract_sku_sap($extracted_product_array)
    {
        // TODO: Implement extract_sku_sap() method.
    }

    public function extract_statut_workflow($extracted_product_array)
    {
        // TODO: Implement extract_statut_workflow() method.
    }

    public function extract_type_produit($extracted_product_array)
    {
        // TODO: Implement extract_type_produit() method.
    }

    public function extract_format_apprentissage($extracted_product_array)
    {
        // TODO: Implement extract_format_apprentissage() method.
    }

    public function extract_pack($extracted_product_array)
    {
        // TODO: Implement extract_pack() method.
    }

    public function extract_serious_game($extracted_product_array)
    {
        // TODO: Implement extract_serious_game() method.
    }

    public function extract_difficulte_formation($extracted_product_array)
    {
        // TODO: Implement extract_difficulte_formation() method.
    }

    public function extract_eligible_cpf($extracted_product_array)
    {
        // TODO: Implement extract_eligible_cpf() method.
    }

    public function extract_certifiante($extracted_product_array)
    {
        // TODO: Implement extract_certifiante() method.
    }

    public function extract_formation_anglais($extracted_product_array)
    {
        // TODO: Implement extract_formation_anglais() method.
    }

    public function extract_partenaire($extracted_product_array)
    {
        // TODO: Implement extract_partenaire() method.
    }

    public function extract_marque($extracted_product_array)
    {
        // TODO: Implement extract_marque() method.
    }

    public function extract_duree_formation($extracted_product_array)
    {
        // TODO: Implement extract_duree_formation() method.
    }

    public function extract_unite_duree($extracted_product_array)
    {
        // TODO: Implement extract_unite_duree() method.
    }

    public function extract_prerequis($extracted_product_array)
    {
        // TODO: Implement extract_prerequis() method.
    }

    public function extract_cibles($extracted_product_array)
    {
        // TODO: Implement extract_cibles() method.
    }

    public function extract_titre__web($extracted_product_array)
    {
        // TODO: Implement extract_titre__web() method.
    }

    public function extract_titre__print($extracted_product_array)
    {
        // TODO: Implement extract_titre__print() method.
    }

    public function extract_sur_titre__web($extracted_product_array)
    {
        // TODO: Implement extract_sur_titre__web() method.
    }

    public function extract_sous_titre__web($extracted_product_array)
    {
        // TODO: Implement extract_sous_titre__web() method.
    }

    public function extract_sous_titre__print($extracted_product_array)
    {
        // TODO: Implement extract_sous_titre__print() method.
    }

    public function extract_objectifs($extracted_product_array)
    {
        // TODO: Implement extract_objectifs() method.
    }

    public function extract_les_plus($extracted_product_array)
    {
        // TODO: Implement extract_les_plus() method.
    }

    public function extract_programme__web($extracted_product_array)
    {
        // TODO: Implement extract_programme__web() method.
    }

    public function extract_programme__print($extracted_product_array)
    {
        // TODO: Implement extract_programme__print() method.
    }

    public function extract_temoignage($extracted_product_array)
    {
        // TODO: Implement extract_temoignage() method.
    }

    public function extract_contact_chef_marche($extracted_product_array)
    {
        // TODO: Implement extract_contact_chef_marche() method.
    }

    public function extract_journee_complementaire__web($extracted_product_array)
    {
        // TODO: Implement extract_journee_complementaire__web() method.
    }

    public function extract_tarif_ht__EUR($extracted_product_array)
    {
        // TODO: Implement extract_tarif_ht__EUR() method.
    }

    public function extract_tarif_ht_journee_complementaire__EUR($extracted_product_array)
    {
        // TODO: Implement extract_tarif_ht_journee_complementaire__EUR() method.
    }

    public function extract_tarif_petite_collectivite__EUR($extracted_product_array)
    {
        // TODO: Implement extract_tarif_petite_collectivite__EUR() method.
    }

    public function extract_tags($extracted_product_array)
    {
        // TODO: Implement extract_tags() method.
    }

    public function extract_intervenant($extracted_product_array)
    {
        // TODO: Implement extract_intervenant() method.
    }

    public function extract_image($extracted_product_array)
    {
        // TODO: Implement extract_image() method.
    }

    public function extract_lien_video($extracted_product_array)
    {
        // TODO: Implement extract_lien_video() method.
    }

    public function extract_description_courte($extracted_product_array)
    {
        // TODO: Implement extract_description_courte() method.
    }

    public function extract_texte_seo($extracted_product_array)
    {
        // TODO: Implement extract_texte_seo() method.
    }

    public function extract_duree_sequencee($extracted_product_array)
    {
        // TODO: Implement extract_duree_sequencee() method.
    }

    public function extract_gamme($extracted_product_array)
    {
        // TODO: Implement extract_gamme() method.
    }

    public function extract_family($extracted_product_array)
    {
        // TODO: Implement extract_family() method.
    }

    public function extract_categories($extracted_product_array)
    {
        // TODO: Implement extract_categories() method.
    }

    public function extract_enabled($extracted_product_array)
    {
        // TODO: Implement extract_enabled() method.
    }
}