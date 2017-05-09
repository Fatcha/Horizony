<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
/**
 * Description of DiveEvent
 *
 * @author Brieuc
 */
class CountryTranslation  extends Model  {
    //put your code here
    protected $table = 'countries_translation';
    
   public function country(){
       
        return $this->belongsTo('App\Models\Country', 'country_key','country_key');
    }

    public static  function getArrayCountriesByLng($lng){
        $arrayCountries = CountryTranslation::
            where('lang','=',$lng)
            ->orderBy('name','asc')
            ->get();
        return $arrayCountries;
    }
   
        
}

?>
