<?php

namespace App\Services;
use App\PostImage;
 
class FileUploadService {
 
    public function savePostImage($images, $post_id)
    {
        $path = '';
        if(isset($images) === true){
          
            foreach($images as $image){
                $path = $image->store('post_images', 'public');
                PostImage::create([
                    'post_id' => $post_id,
                    'image' => $path,
                ]);
            }
        }

    }

    public function saveUserImage($image)
    {
        $path = '';
        if( isset($image) === true ){
            $path = $image->store('user_images', 'public');
        }
        return $path;
    
    }
    
}