<?php

class ArrayHelper {
    
    private $key ;
    
    public function __construct() {
        ;
    }

      function cmp($a, $b) {
        if ($a[$this->key] == $b[$this->key] ) {
            return 0;
        }
        return ($a[$this->key]  < $b[$this->key] ) ? -1 : 1;
    }

    public  function sortArrayByKey($array , $key) {
        $this->key = $key;
        
        uasort($array, array($this, 'cmp'));
        
        return $array;
    }

}

?>