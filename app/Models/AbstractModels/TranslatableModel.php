<?php

namespace  App\Models\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * Created by PhpStorm.
 * User: bri
 * Date: 24-Dec-16
 * Time: 14:35
 */

abstract class TranslatableModel extends Model{

    protected $foreignKeyTranslation = "";
    protected $translateClass = "";

    public function translation($locale){
        return $this->hasOne($this->translateClass, $this->foreignKeyTranslation)->where('locale', '=', $locale)->first();
    }

    public function getLocaleField($fieldName, $locale = null, $defaultValue = 'no_translation'){
        $translation = $this->translation($locale === null ? App::getLocale() : $locale);
        return $translation?  $translation->$fieldName : $defaultValue;
    }

    public function setLocaleField($fieldName, $locale, $value){
        $val =  $value == null ? '': $value;
        $translation = $this->translation($locale === null ? App::getLocale() : $locale);
        if(!$translation){
          //  echo "No translation: $this->translateTable $this->id $fieldName, $locale, $value";
           // $translation =  call_user_func($this->translateTable.'::addTranslation',$this->id,$locale);
            $translation = $this->addTranslation($locale);

        }

        $translation->$fieldName = $val;
        $translation->save();

        return $translation;
    }

    private  function addTranslation($locale){
        $refField = $this->foreignKeyTranslation;

        $trans = new $this->translateClass;// \ReflectionClass() ;
        $trans->$refField = $this->id;
        $trans->locale = $locale;
        $trans->save();

        return $trans;
    }
}