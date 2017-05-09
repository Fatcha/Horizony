<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mlss
 *
 * @author brba
 */
class Mlss extends Model {
    
    protected $table = 'mlss';
    
    /**
     * t is an alias of getContent
     * @param type $content_key
     * @param type $default_content
     * @param type $replaceArray
     * @param type $lng
     * @return type
     */
    public static function t($content_key, $default_content = null, $replaceArray = array(), $lng = null  ){
        return self::getContent($content_key, $default_content , $replaceArray, $lng  );
    }
    
    public static function getContent($content_key, $default_content = null, $replaceArray = array(), $lng = null  ) {
        
        if($lng === null){
            $lng = Lang::getLocale();
        }
        
        if (strlen($lng) > 2) {
            $lng = substr($lng, 0, 2);
        }
        //$req=mysql_query("select content_text FROM wa_text_content WHERE    LIMIT 1") or die ("getText:".mysql_error());
        $content = self::getRowContent($content_key, $lng, $default_content);

        if ($content === false) {
            
           $content =  self::createContent($content_key, $lng, $default_content);
//            self::getRowContent($content_key, $lng, $default_content);
        }
        
        $contentReturn = $content->content_text;
        if ($contentReturn == "") {
            if ($default_content != "") {
                // return defautlt content with *
                // specify the content didn't exist
                $contentReturn = $default_content . "*";
            }
            $contentReturn = $content_key;
        }

        foreach ($replaceArray as $key => $values) {
            $contentReturn = str_replace($key, $values, $contentReturn);
        }
        // if admin save label in request to display label admin on footer
//        $user_rules = sfContext::getInstance()->getUser()->getAttribute("user_rules");
//        if ($user_rules == "admin") {
//            $aTemp["key"] = $content_key;
//            $aTemp["label"] = $contentReturn;
//            $labelContainer = sfContext::getInstance()->getRequest()->getParameter('labelContainer', array());
//            array_push($labelContainer, $aTemp);
//            sfContext::getInstance()->getRequest()->setParameter('labelContainer', $labelContainer);
//        }

        //$request->getParameter
        return nl2br($contentReturn);
    }

    private  static function getRowContent($content_key, $lng, $default_content) {
        
        $mlss = Mlss::where('content_key' ,'=' ,$content_key)
                        ->where('content_language' ,'=' ,$lng)
                        ->first();
        if($mlss){
            return $mlss;
        }
        return false;
        
    }

    private static function createContent($content_key, $lng, $content_text) {
        $newContent = new Mlss;
        $newContent->content_key            = $content_key;
        $newContent->content_language   = $lng;
        $newContent->content_text           = $content_text;
        $newContent->save();
        
        return $newContent;
    }

    public static function updateContent($content_key, $lng, $content_text) {
        $content_text = str_replace("\r", "", $content_text);
        $content_text = str_replace("\n", "<br />", $content_text);
        // upgrade web type + pay thread cost
        Doctrine_Query::create()
                ->update('Mlss')
                ->set("content_text", '?', $content_text)
                ->where("content_key='" . $content_key . "' and content_language='" . $lng . "'")
                ->limit(1)
                ->fetchOne();
        return;
    }

}

