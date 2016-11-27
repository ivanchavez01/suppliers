<?php
namespace \Suppliers;
use SupplierInterface;

class CVA implements SuppliersInterface 
{
    public $urlService = 'http://www.grupocva.com/catalogo_clientes_xml/lista_precios.xml';
    public $customer   = '38388';
    public $paramsDefault = [
        "sucursales"    => 1, 
        "subgrupo"      => 1, 
        "tc"            => 1, 
        "depto"         => 1,
        "promos"        => 1,
        "TipoCompra"    => 1,
        "ModenaPesos"   => 1
    ];

    public function __construct(array $params = []) {
        $params = array_merge($params, ["cliente" => $this->customer]);

        if(!empty($this->paramsDefault))
            $params = array_merge($params, $this->paramsDefault);

        $paramsURL = '?'.implode('&', $params);
    }

    public function getProducts() {
        
    }

    public function Order(){}
}


$suppliers = new Suppliers();

$suppliers->cva->getProducts();