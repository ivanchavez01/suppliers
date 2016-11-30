<?php 
namespace Suppliers;

class Suppliers {

    public static function products() {
        return new \Suppliers\ProductsInstance();
    }
}


class ProductsInstance {
    public $supplier;
    public $driver = "CVA";


    public function driver($driver = "") {
        if($driver != "")
            $this->driver = $driver;

        return $this;
    }

    public function supplier($supplier = "") {
        $this->supplier = $supplier;
        return $this;
    }

    public function params(array $params = []) {
        $this->params = $params;
        return $this;
    }

    public function get() {
        $class = '\\Suppliers\\Suppliers\\'.$this->driver;
        if(class_exists($class)) {
            try {
                $instanceSupplier = new $class();
                return $instanceSupplier->getProducts($this->params);
            } catch (\Exception $ex) {
                throw new \Exception($ex->getMessage());
            }
        } else {
            die("Driver ".$this->driver." not installed.");
        }
    }
}