<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models\Fatcha\Helpers;
/**
 * Description of StringManager
 *
 * @author bba
 */
class StringManager {

    public static function isEmail($emailStr) {
        return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $emailStr);
    }

    public static function formatUrlsInText($text, $targetBlank = false) {
        $arrayReturn = array();
        $arrayReturn['found_instance'] = false;
        
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        preg_match_all($reg_exUrl, $text, $matches);
        $usedPatterns = array();
        foreach ($matches[0] as $pattern) {
            if (!array_key_exists($pattern, $usedPatterns)) {
                $arrayReturn['found_instance'] = true;
                $usedPatterns[$pattern] = true;
                $text = str_replace($pattern, '<a href="' . $pattern . '" rel="nofollow" '.($targetBlank? 'target="_blank"' : '').'>' . $pattern . '</a>', $text);
            }
        }
        
        
        $arrayReturn['text']  = $text;
        return $arrayReturn;
    }

    public static function addYoutubeHtml($text) {
        
        $arrayReturn = array();
        $arrayReturn['found_instance'] = false;
        $reg_exUrl = "/((http:\/\/)?(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/v\/)([\w-]{11}).*|http:\/\/(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/watch(?:\?|#\!)v=)([\w-]{11}).*?)(\S*)/";
//        $reg_exUrl = "/http:\/\/(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/watch(?:\?|#\!)v=)([\w-]{11}).* /";
        preg_match_all($reg_exUrl, $text, $matches);
        $usedPatterns = array();
        foreach ($matches[0] as $pattern) {
            if (!array_key_exists($pattern, $usedPatterns)) {
                $arrayReturn['found_instance'] = true;
                $usedPatterns[$pattern] = true;
                $text =str_replace($pattern, '<video id="vid'.  CryptId::cryptIdToHash(rand(0,100000)).'" src="" class="video-js vjs-default-skin responsive" controls 
                            preload="auto"   width="100%" 
                            data-setup=\'{ "techOrder": ["youtube"], "src": "' . $pattern . '" }\'>
                     </video>', $text); ;
                     //http://img.youtube.com/vi/<insert-youtube-video-id-here>/1.jpg
            }
        }
        $arrayReturn['text']  = $text;
        return $arrayReturn;
    }

    public static function getLaravelRouteWithoutPhpFileLegacy($str){
        $phpExtensionPos = strpos($str,'.php');
        if($phpExtensionPos === false){
            return $str;
        }

        $path = substr($str, ($phpExtensionPos+4));

        return $path;

    }

}

?>
