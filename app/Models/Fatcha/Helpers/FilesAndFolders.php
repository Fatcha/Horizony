<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FilesAndFolders
 *
 * @author brba
 */
class FilesAndFolders {
    //put your code here
    
    public static function getFilesFromFolder($dir){
        
        $filesArray = scandir($dir);
        
        $arrayReturn = array();
        
        if(count($filesArray)>2){
            foreach($filesArray as $file){
                if($file == '..' || $file == '.'){
                    continue;
                }
                $arrayReturn[] = $file;
            }
        }
        
        return $arrayReturn;
    }
}

?>
