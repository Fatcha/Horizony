<?php

class UploadPicture{
    
    public static function doUploadPicture($src_file, $target_name,  $target_path, $width, $height, $remove_src_file , $watermark , $isAlreadyCropped) {
        $returnArray = array();
       
        $handle = new Upload($src_file);
Log::info('Flag >>>>>>>>>>>>333');

        if ($handle != null) {
            
            if(empty($handle->image_src_type)){
                $ext = 'jpg';
            }else{
                $ext = $handle->image_src_type;
            }
            
            $handle->file_new_name_body = $target_name;
            $handle->file_new_name_ext      = $ext;

            $handle->image_resize = true;
            $handle->image_x        = $width;
            $handle->image_y        = $height;
            $handle->image_ratio    = true;
            $handle->file_max_size = 100000000;
            // -- Watermark 
            if ($watermark) {
                $aWatermark = config("app_picture_watermark");
                $handle->image_watermark = $_SERVER['DOCUMENT_ROOT'] . $aWatermark[$watermark - 1];
                $handle->image_watermark_position = "BR";
            }

            $handle->image_ratio_no_zoom_in = true;

            $handle->process($target_path);

            if ($remove_src_file) {
                $handle->clean();
            }


            $returnArray['success'] = true;
            $returnArray['ext']     = $ext;
            $returnArray['handle'] = $handle;
            return $returnArray;
        } else {
            $returnArray['success'] = false;
            return $returnArray;
        }
    }
    public static function cropAutomatic($img_server_src , $img_server_dst){
        
                        $arrayReturn = array();
                    
                        $src = $img_server_src;
                        $dst_file = $img_server_dst;
                        
                        // -- check image size
                        $pictureSize = getimagesize ( $src );
                        
                       //Documentation :  Index 0 and 1 contains respectively the width and the height of the image.
                        $widthPicture = $pictureSize[0];
                        $heightPicture = $pictureSize[1];
                        if( $widthPicture > $heightPicture){
                            $startX = ($widthPicture/2) - ($heightPicture/2);
                            $startY = 0;
                            $widthCrop =  $heightPicture;
                            $heightCrop =  $heightPicture;
                        }else{
                            $startX = 0;
                            $startY = ($heightPicture/2) - ($widthPicture/2);
                            $widthCrop =  $widthPicture;
                            $heightCrop =  $widthPicture;
                        }

                        $objImage = new ImageManipulation($src);
                        if ($objImage->imageok) {
                            $objImage->setCrop($startX, $startY, $widthCrop, $heightCrop);
                            $objImage->resize(config('global.picture_small_width'));
                            $objImage->save($dst_file);
                            $arrayReturn['success']  = true;
                        }else{
                            $arrayReturn['success']  = false;
                        }
                        return $arrayReturn;
    }
}
?>
