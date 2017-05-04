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
                if ($item->moneda != "Pesos") {
                    $item->PrecioDescuento = $item->PrecioDescuento * $item->tipocambio;
                }

                $product->key = (string)$item->clave;
                $product->code = (string)$item->codigo_fabricante;
                $product->desc = (string)$item->descripcion;
                $product->group = (string)$item->grupo;
                $product->brand = (string)$item->marca;
                $product->qty = (int)$item->disponible;
                $product->offerPrice = (float)$item->PrecioDescuento;
                $product->price = (string)$item->precio;
                $product->currency = (string)$item->moneda;
                $product->image = (string)$item->imagen;
                $product->currencyRate = (string)$item->tipocambio;
                $product->warranty = (string)$item->garantia;
                $product->promotionDescription = (string)$item->DescripcionPromocion;
                $product->promotionDateEnd = (string)$item->VencimientoPromocion;

                foreach ($item as $key => $value) {
                    if (substr($key, 0, 6) == "VENTAS") {
                        $product->branches[] = [
                            "branch" => substr($key, 7, strlen($key)),
                            "qty" => (float)$value
                        ];

                        $product->quantity_total += (float)$value;
                    }
                }
                
                if($product->quantity_total > 0 || $product->qty > 0)
                    $this->productsCollection[] = $product;

            }
        }
        
        return $this->productsCollection;
    }
}

class ProductStruct {
    public
        $key,
        $code,
        $desc,
        $group,
        $brand,
        $supplier_id = 1,
        $qty,
        $price,
        $currency,
        $offerPrice,
        $image,
        $warranty,
        $quantity_total = 0,
        $promotionDescription,
        $promotionDateEnd,
        $currencyRate,
        $branches = [];
}