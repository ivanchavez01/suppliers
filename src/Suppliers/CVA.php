<?php
namespace Suppliers\Suppliers;
use Suppliers\Suppliers\SuppliersInterface;

class CVA implements SuppliersInterface 
{
    public $urlService = 'http://www.grupocva.com/catalogo_clientes_xml/lista_precios.xml';
    public $customer   = '38388';
    public $paramsDefault = [
        "sucursales"    => 1,
        "subgrupo"      => 1, 
        "tc"            => 1, 
        //"depto"         => 1,
        "promos"        => 1,
        "TipoCompra"    => 1,
        "ModenaPesos"   => 1
    ];

    public function __construct(array $params = []) {
        $params = array_merge($params, ["cliente" => $this->customer]);

        if(!empty($this->paramsDefault))
            $params = array_merge($params, $this->paramsDefault);

        $paramsURL = '?'.$this->implodeUrl($params);

        $this->urlService .= $paramsURL;
    }

    public function getProducts(array $params = []) {
        try {
            $http = new \GuzzleHttp\Client();
            $paramsURL = $this->implodeUrl($params);
            $this->urlService .= $paramsURL;

            $res = $http->request('GET', $this->urlService, [
                "headers" => [
                    "Content-Type" => "text/xml"
                ]
            ]);

            return new \Suppliers\Adapters\ProductsAdapter($res->getBody());
        } catch(\InvalidArgumentException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function Order(){}


    private function implodeUrl($paramArray = []) {
        if(!empty($paramArray)) {
            $paramStr = "";
            foreach($paramArray as $param => $value) 
                $paramStr .= $param."=".$value."&";
            
            
            return $paramStr;
        }

        return "";
    }
}