<?php
namespace Suppliers\Adapters;

class ProductsAdapter
{
    public function __construct($requestSupplier = []) {
        $xmlUTF8  = utf8_encode($requestSupplier); 
        $xmlArray =  @simplexml_load_string($xmlUTF8);
        $this->productsCollection = [];

        if(!empty($xmlArray)) {
            foreach($xmlArray as $item) {
                $product = new ProductStruct();
               
                $product->key           = (string)$item->clave;
                $product->code          = (string)$item->codigo_fabricante;
                $product->desc          = (string)$item->descripcion;
                $product->group         = (string)$item->grupo;
                $product->brand         = (string)$item->marca;
                $product->qty           = (int)$item->disponible;
                $product->price         = (string)$item->precio;
                $product->currency      = (string)$item->moneda;
                $product->image         = (string)$item->imagen;
                $product->currencyRate  = (string)$item->tipocambio;

                foreach($item as $key => $value) {
                    if(substr($key, 0, 6) == "VENTAS") {
                        if((float)$value > 0) {
                            $product->branches[] = [
                                "branch" => substr($key, 7, strlen($key)),
                                "qty"    => (float)$value
                            ];

                            $product->qty += (float)$value;
                        }
                    }
                }                

                $this->productsCollection[]   = $product;
            }
        }
        
        return $this->productsCollection;
    }
}

class ProductStruct {
    public $key, $code, $desc, $group, $brand, $qty, $price, $currency, $image, $currencyRate, $branches = [];
}