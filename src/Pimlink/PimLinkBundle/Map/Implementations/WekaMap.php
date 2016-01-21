<?php


/**
 * Created by PhpStorm.
 * User: seth
 * Date: 24/11/15
 * Time: 14:22
 */

namespace Pimlink\PimLinkBundle\Map\Implementations;

use Exception;
use Mage;
use Mage_Catalog_Model_Product_Status;
use Mage_Catalog_Model_Product_Visibility;
use Pimlink\PimLinkBundle\Entity\Expert;
use Pimlink\PimLinkBundle\Helper\PimFileHelper;
use Pimlink\PimLinkBundle\Map\ADestinationMap;
use Pimlink\PimLinkBundle\Entity\Product;

use Weka_Core_Helper_Data;
//Require_once '../app/Mage.php';
Require_once '/home/seth/Work/magento_catalogue/app/Mage.php';


class WekaMap extends ADestinationMap
{

    public $resource;
    public $store;
    public $website;
    public $attributeSetId;
    public $productsList;
    public $expertsList;

    public function initConnection()
    {
        $this->logger->info("Connecting to model");

        // Set Database
        Mage::app();
        $this->store = Mage::app()->getStore(Weka_Core_Helper_Data::WEKA_STORE_CODE);
        Mage::app()->setCurrentStore($this->store->getStoreId());
        $this->database = Mage::getModel("weka_catalog/product");

        // set resource
        $this->resource = Mage::getSingleton('core/resource');

        // Some other usefull data
        $this->attributeSetId[] = Mage::getModel("eav/entity_attribute_set")
            ->load('Formation', 'attribute_set_name')->getAttributeSetId();
        $this->attributeSetId[] = Mage::getModel("eav/entity_attribute_set")
            ->load('Cycle de formations', 'attribute_set_name')->getAttributeSetId();
    }

    public function extract_products()
    {
        $this->logger->info("Retreiving data");
        $list_products = $this->database->getCollection()
            ->setStoreId($this->store->getStoreId())
            ->addAttributeToFilter('attribute_set_id', array('in' => array($this->attributeSetId)))
            ->addAttributeToSelect('*');
        $this->logger->info($list_products->count() . " products extracted.");
        foreach ($list_products as $sku => $extracted_product) {
            $this->productsList[$sku] = $extracted_product;
            $extracted_data = $extracted_product->getData();
            $this->createDataProduct($extracted_data, $extracted_data['sku']);
        }
    }

    public function extract_experts()
    {
        $this->logger->info("Retreiving data");
        $readConnection = $this->resource->getConnection('core_read');
        $experts_query = "SELECT * FROM weka_expert";
        $extracted_experts = $readConnection->fetchAll($experts_query);
        foreach ($extracted_experts as $id => $extracted_expert) {
            $this->expertsList[$id] = $extracted_expert;
            $this->createDataExpert($extracted_expert, $id);
        }
    }

    // ##################
    // Products implems #
    // ##################

    public function updateProduct(Product $updated_product, $sku)
    {
        $updated_product_data = $updated_product->getData();
        $product = $this->productsList[$this->products[$sku]->raw_data['entity_id']];
        foreach ($updated_product_data as $key => $value) {
            $field_key = PimFileHelper::rev_normalize_field($key);
            $product->setData($field_key, $value);
        }
        // Then save product
        $product->save();
    }

    public function deleteProduct($sku)
    {
        $this->deactivateProduct($sku);
    }

    public function createProduct(Product $new_product, $sku)
    {
        //http://inchoo.net/magento/programming-magento/programatically-manually-creating-simple-magento-product/
        $product = $this->database;
        try {
            $product
                ->setTypeId("virtual")
                ->setWeight(0)
                ->setWebsiteIds(array(1)) //website ID WEKA : 1
                ->setStoreId(Weka_Core_Helper_Data::WEKA_STORE_CODE) //you can set data in store scope
                ->setAttributeSetId($this->attributeSetId[0]) //ID of a attribute set named 'default'
                ->setCreatedAt(strtotime('now')) //product creation time
                ->setUpdatedAt(strtotime('now')) //product update time

                ->setSku($sku) //SKU
                ->setName($new_product->get_titre__web()) //product name
                ->setStatus(1) //product status (1 - enabled, 2 - disabled)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility

                ->setPrice($new_product->get_tarif_ht__EUR()) //price in form 11.22
                ->setMetaDescription($new_product->get_description_courte())
                ->setDescription($new_product->get_programme__web())
                ->setShortDescription($new_product->get_sous_titre__web());

            // Then save
            $product->save();
        } catch(Exception $e){
            $this->logger->error($e->getMessage());
        }
    }

    public function deactivateProduct($sku)
    {
        $product = $this->productsList[$this->products[$sku]->raw_data['entity_id']];
        $product->setStatus(Mage_Catalog_Model_Product_Status::STATUS_DISABLED);
        $product->save();
    }

    // #################
    // Experts implems #
    // #################

    public function updateExpert(Expert $new_expert, $id)
    {
        $key_string = strtolower($new_expert->get_nom()."-".$new_expert->get_prenom());
        $key_string = str_replace(' ', '', $key_string);
        $key_string = str_replace("'", '', $key_string);
        $writeConnection = $this->resource->getConnection('core_write');
        $data_string = "";
        $data_string .=
            "description='".str_replace("'", "\\'", $new_expert->get_activite())."', "
            ."id='".$new_expert->get_id()."', "
            ."short_description='".str_replace("'", "\\'", $new_expert->get_biographie())."', "
            ."poste='".$new_expert->get_metier()."', "
            ."last_name='".$new_expert->get_nom()."', "
            ."picture='".$new_expert->get_photo()."', "
            ."first_name='".$new_expert->get_prenom()."', "
            ."website='".$new_expert->get_siteWeb()."', "
            ."entreprise='".$new_expert->get_societe()."', "
            ."status_ids=',0,', "
            ."thematic_ids=',0,', "
            ."url_key='".$key_string."', "
            ."formateur_url_key='".$key_string."', "
            ."formation_url_key='".$key_string."'"
            ;
        $update_query = "UPDATE weka_expert SET ".$data_string." WHERE id = ".$id;
        $writeConnection->query($update_query);
    }

    public function deleteExpert($id)
    {
        // TODO: Implement deleteExpert() method.
    }

    public function createExpert(Expert $new_expert, $id)
    {
        $key_string = strtolower($new_expert->get_nom()."-".$new_expert->get_prenom());
        $key_string = str_replace(' ', '', $key_string);
        $key_string = str_replace("'", '', $key_string);
        $writeConnection = $this->resource->getConnection('core_write');
        $data_string = ""
            ."'".$key_string."', " //url_key
            ."'".$key_string."', " //formateur_key
            ."'".$key_string."', " //formation_key
            ."'".$id."', " //id
            ."'".$new_expert->get_prenom()."', " //first_name
            ."'".$new_expert->get_nom()."', " // last_name
            ."'".$new_expert->get_siteWeb()."', " //website
            ."'".$new_expert->get_photo()."', " //picture
            ."'".str_replace("'", "\\'", $new_expert->get_biographie())."', " //short_description
            ."'".str_replace("'", "\\'", $new_expert->get_activite())."', " //description
            ."',0,', " //status_ids
            ."',0,', " //thematic_ids
            ."'".$new_expert->get_societe()."', " // entreprise
            ."'".$new_expert->get_metier()."' " //poste
        ;
        $update_query = "INSERT INTO weka_expert VALUES (".$data_string.")";
        $writeConnection->query($update_query);
    }

    public function deactivateExpert($id)
    {
        // TODO: Implement deactivateExpert() method.
    }

    // #####################
    // Overrides Products  #
    // #####################

    public function extract_statut_workflow($extracted_product_array)
    {
        return "statut_brouillon";
    }

    public function extract_enabled($extracted_product_array)
    {
        return 1;
    }

}