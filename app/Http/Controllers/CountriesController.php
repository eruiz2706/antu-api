<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\CountryDetail;
use App\Helpers\CountryWS;

/**
 * @author Eduardo Ruiz
 */
class CountriesController extends Controller
{

    /**
    * @desc Metodo usado para retornar el listado de paises consultas a un webservices,
    * si el webservices no responde se retorna informacion previa almacenada en base de datos
    * @return json
    */
    public function getAll(){
        $countries = [];
        
        $countryWS = new CountryWS();
        $result_countries = $countryWS->listOfCountryNamesByCode();

        if(!empty($result_countries)){
            Country::truncate();
            foreach($result_countries as $r_country){
                $country = new Country();
                $country->code = $r_country->sISOCode;
                $country->name = $r_country->sName;
                $country->save();
            }
        }
        $countries = Country::all();

        return response()->json([
            "status_code" => 200,
            "error" => "",
            "message" =>  "list of countries",
            "data" => [
                "countries" => $countries,
            ]
        ],200);
    }

    /**
    * @desc Metodo usado para retornar informacion detallada de un pais,consultado a un webservices,
    * si el webservices no responde se retorna informacion previa almacenada en
    *base de datos
    * @param String $code - codigo de pais a consultar
    * @return json
    */
    public function getDetailByCode($code){
        
        $countryDetail = [];
        
        $countryWS = new CountryWS();
        $result_country = $countryWS->fullCountryInfo($code);
        
        if(!empty($result_country)){
            CountryDetail::where('code',$code)->delete();

            $countryDetail = new CountryDetail();
            $countryDetail->code = $result_country->sISOCode;
            $countryDetail->name = $result_country->sName;
            $countryDetail->capital_city = $result_country->sCapitalCity;
            $countryDetail->phone_code = $result_country->sPhoneCode;
            $countryDetail->continent_code = $result_country->sContinentCode;
            $countryDetail->currency_code = $result_country->sCurrencyISOCode;
            $countryDetail->flag = $result_country->sCountryFlag;

            if(isset($result_country->Languages->tLanguage->sISOCode)){
                $languajes = [[
                    'sISOCode' => $result_country->Languages->tLanguage->sISOCode,
                    'sName' => $result_country->Languages->tLanguage->sName,
                ]];
            }else{
                if(isset($result_country->Languages->tLanguage)){
                    $languajes = $result_country->Languages->tLanguage;
                }else{
                    $languajes = [];
                }
            }
            $countryDetail->languaje = json_encode($languajes);
            $countryDetail->save();
            
        }
        $countryDetail = CountryDetail::where('code',$code)->first();

        if(!empty($countryDetail)){
            $countryDetail->languaje = json_decode($countryDetail->languaje);
        }

        return response()->json([
            "status_code" => 200,
            "error" => "",
            "message" =>  "country detail",
            "data" => [
                "country" => $countryDetail,
            ]
        ],200);
    }
}
