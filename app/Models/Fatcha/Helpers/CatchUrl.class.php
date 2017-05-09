<?php
class CatchUrl{

    public function __construct(){
        
    }

    public static function imgAddProtocol($img,$domain){
     $pos = stripos($img, "http://");
      if ($pos === false) {
        $img=$domain."/".$img;
      }
        return $img;
    }

    public static function parse($url){
         $dom=new simple_html_dom();
         $dom->load_file($url);
       //   foreach($dom->find('img') as $element)
       //echo $element->src . '<br>';
        $arrayReturn=array();
       
        $arrayReturn["page_title"] = $dom->find('title',0)->innertext;
        $arrayReturn["meta_descr"]  =$dom->find('meta[name=description]',0)->content;
        $arrayReturn["meta_keywd"]  = $dom->find('meta[name=keywords]',0)->content;
        $arrayReturn["img"]  = array();
        foreach($dom->find('img') as $el){
          array_push($arrayReturn["img"],self::imgAddProtocol($el->src,$url));
        }
      //  print_r($dom->find('img'));
       
        return $arrayReturn;
        /*$arrayReturn=array();
        $arrayReturn["page_title"] = "n/a";
        $arrayReturn["meta_descr"]  = "n/a";
        $arrayReturn["meta_keywd"]  = "n/a";
        $arrayReturn["img"]  = array();
        if ($handle = @fopen($url, "r")) {
            $content = "";
            while (!feof($handle)) {
                $part = fread($handle, 1024);
                $content .= $part;
                //if (eregi("</head>", $part)) break;
            }
            fclose($handle);
            $lines = preg_split("/\r?\n|\r/", $content); // turn the content in rows
            $is_title = false;
            $is_descr = false;
            $is_keywd = false;
            $is_img = false;
            //$close_tag = ($xhtml) ? " />" : ">"; // new in ver. 1.01
            foreach ($lines as $val) {
                if (preg_match("<title>([^>]*)<\/title>/si", $val, $title)) {
                    $arrayReturn["page_title"] = $title[0];
                    $is_title = true;
                }
                if (preg_match("<meta name=\"description\" content=\"(.*)\"([[:space:]]?/)?>", $val, $descr)) {
                     $arrayReturn["meta_descr"] = $descr[1];
                    $is_descr = true;
                }
                if (preg_match("<meta name=\"keywords\" content=\"(.*)\"([[:space:]]?/)?>", $val, $keywd)) {
                    $arrayReturn["meta_keywd"] = $keywd[1];
                    $is_keywd = true;
                }
                if (preg_match('/(<img)\s (src="([a-zA-Z0-9\.;:\/\?&=_|\r|\n]{1,})")/isxmU', $val, $img) ) {
                    //$h1count = preg_match_all('/(<img)\s (src="([a-zA-Z0-9\.;:\/\?&=_|\r|\n]{1,})")/isxmU',$val,$patterns);
                   $h1count = preg_match_all('/(<img)\s (src="([a-zA-Z0-9\.;:\/\?&=_|\r|\n]{1,})")/isxmU',$val,$patterns);
                  
                    $res = array();
                    array_push($arrayReturn["img"],$patterns[3]);
                    //array_push($arrayReturn["img"],count($patterns[3]));

                    //$arrayReturn["img"] = $img[1];
                    $is_img = true;
                }
                if ($is_title && $is_descr && $is_keywd && $is_img) break;
            }
        }
        
        return $arrayReturn;*/
    }
}
?>
