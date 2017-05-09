<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;

use Illuminate\Support\Facades\App;
use \Illuminate\Database\Eloquent\Model;
/**
 * Description of DiveEvent
 *
 * @author Brieuc
 */
class Country  extends Model  {
    //put your code here
    protected $table = 'countries';
    
    public function translations(){       
        return $this->hasMany('\App\Models\CountryTranslation', 'country_key','country_key');
    }

    
    
    public function getName(){
       
        return  $this->translations()->where('lang', 'like', App::getLocale())->first()->country_name;
    }
    public static function getArrayCountriesName($lng){
            $arrayCountries = CountryTranslation::getArrayCountriesByLng($lng);

            $arrayReturn = [];
            foreach($arrayCountries as $countryTrans){
                $arrayReturn[$countryTrans->country->country_key] = $countryTrans->name;
            }

            return $arrayReturn;
    }
   
        
}

?>