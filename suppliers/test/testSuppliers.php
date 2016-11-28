<?php
require("../vendor/autoload.php");

class testSuppliers {
    public function getProducts() {
        try{
            $params = [
                "marca" => "lenovo"
            ];
            $products = \Suppliers\Suppliers::products()
                ->supplier('CVA')
                ->params($params)
                ->get();

            print_r($products); exit;
        } catch(Exception $ex) {
            die($ex->getMessage());
        }
    }
}

$test = new testSuppliers();
$test->getProducts();