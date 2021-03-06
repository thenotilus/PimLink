# PimLink
Symfony bundle for Weka


## Welcome to PIMLink Developer Tool

-- First of all, you have to know that this tool is created for lazy developers.
-- What is done MUST not be undone separately. Make sure when adding something that it is needed by every inheriting class

#### The design of the tool is very simple.

We have two main Abstract designed to answer all needs.
Pimlink/PimLinkBundle/Map/ADestinationMap and Pimlink/PimLinkBundle/Map/ASourceMap
These two are implementing the reference fields of the PIM. 
Check the file Pimlink/PimLinkBundle/reference.yml

There is a Helper : PimFileHelper
Helps you manage extractions from the PIM csv File.
Methods inside are static and well documented.

##### Creating a new connector is simple as abc..

*A connector is a PHP class.*

The name of the class must be well formatted.
For example : If you a creating a new connector for comundi ?
-The command action name is "comundi" (lowercase)
-The name of the Class is "Pimlink/PimLinkBundle/Map/Implementations/ComundiMap" (CamelCase is very important)
-If the connector is a destination client data base, the class inherits ADestinationMap (ASourceMap on the other side)
- Inheritance : ADestinationMap

Once the class ready, you need to created all the abstract methods and they need to be implemented

* initConnection() 
Your database connector or ORM must be instantiated
Put the instance inside the variable protected attribute : $this->database

* extractProducts()
First make a request to fetch all products in an multidimensional array
Iterate on each product and call the existing method addProduct with the 'sku'

    $products = $this->database->getAllProductsMethod();
    foreach ($products as $product) {
        $this->addProduct($product, $sku);
    }
This methods create an array of Products ($this->products) 

* deactivateProduct($sku)
Find the product with its sku an make action in database to deactivate product.

* Update, delete and create used to call database actions
    public abstract function updateProduct($new_product, $sku);
    public abstract function deleteProduct($sku);
    public abstract function createProduct($product, $sku);

All other methods prefixed by "extract_" are used to create a proper product according to the reference
The raw_data of a product is transmitted and you must extract the asked array.
The name of a field is related to the name of extract_ functions
Please check the function  normalize_field from the PimFileHelper/

##### HOW TO LAUNCH
example : 

    $> php pim_link/app/console pimlink:execute pimfile.csv comundi
