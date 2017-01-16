<?php

/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 15/08/16
 * Time: 04:13 PM
 */
namespace So2platform\Publicprofile\Helpers;

class imageUpload
{
    public function upload($data,$dir_name){
        $random_name = md5(uniqid());
        $image_name = $random_name.'.'.$data->file('image')->getClientOriginalExtension();
        $data->file('image')->move(
            base_path() . '/public/uploads/'.$dir_name, $image_name
        );
        return $image_name;
    }

    /* File upload validator */
    public function validateUpload($request){
        if(isset($request->post_image)) {
            foreach ($request->post_image as $i){
                /* If server max upload size it's exceeded then returns false */
                if($i->getClientSize() != false) {
                    if ($i->getClientOriginalExtension() == "png" ||
                        $i->getClientOriginalExtension() == "jpeg" ||
                        $i->getClientOriginalExtension() == "jpg" ||
                        $i->getClientOriginalExtension() == "JPG" ||
                        $i->getClientOriginalExtension() == "PNG" ||
                        $i->getClientOriginalExtension() == "JPEG" ||
                        $i->getClientOriginalExtension() == "BMP" ||
                        $i->getClientOriginalExtension() == "bmp"
                    ) {
                        //do nothing
                    } else {
                        return 'Invalid format: ' . $i->getClientOriginalExtension();
                    }
                }else{
                    return 'File too large';
                }
            }
        }else {
            return 'Error: Upload at least 1 file';
        }
        return null;
    }

    public function s3Upload($file,$dir_name, $name = ""){
        $random_name = date("Y-m-d").md5(uniqid());
        if($name != "") {
            $random_name = $name;
        }
        $image_name = $random_name.'.'.$file->getClientOriginalExtension();
        $file->storeAs($dir_name, $image_name, 's3');
        return $image_name;
    }
}