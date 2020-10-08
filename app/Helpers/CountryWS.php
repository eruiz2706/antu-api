<?php
namespace App\Helpers;
use SoapClient;

/**
* @desc clase utilizada para realizar consumos de informacion de webservices de paises
* @author Eduardo Ruiz
*/
class CountryWS{

    private $url;
    private $error;

    public function __construct(){
      $this->url = "http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL";
    }

    /**
    * @desc Metodo retorna listado de paises
    * @return Object
    */
    public function listOfCountryNamesByCode(){
      try {
        $client = new SoapClient($this->url);
        $response = $client->__soapCall("ListOfCountryNamesByCode", array());
        $result = $response->ListOfCountryNamesByCodeResult->tCountryCodeAndName;
        return $result;
      } catch ( \SoapFault $e ) {
          $this->error = $e->getMessage();
          return [];
      }
    }

    /**
    * @desc Metodo retorna informacion detallada de un pais, realizando la consulta por el codigo de pais
    * @return Object
    */
    public function fullCountryInfo(String $code){
      try {
        $client = new SoapClient($this->url);
        $params =[
            'sCountryISOCode' => $code
        ];
        $response = $client->__soapCall("FullCountryInfo", array($params));
        $result = $response->FullCountryInfoResult;
        return $result;
      } catch ( \SoapFault $e ) {
          $this->error = $e->getMessage();
          return [];
      }
    }
}
