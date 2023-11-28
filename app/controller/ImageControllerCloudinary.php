<?php
require_once(__DIR__ . '../../../vendor/autoload.php');
require_once(__DIR__.'/../../config/config.php');

use Cloudinary\Configuration\Configuration;
// Use the SearchApi class for searching assets
use Cloudinary\Api\Search\SearchApi;
// Use the AdminApi class for managing assets
use Cloudinary\Api\Admin\AdminApi;
// Use the UploadApi class for uploading assets
use Cloudinary\Api\Upload\UploadApi;

class ImageControllerCloudinary {
    
    public function __construct () {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => CLOUDINARY_NAME, 
                'api_key' => CLOUDINARY_API_KEY, 
                'api_secret' => CLOUDINARY_API_SECRET],
            'url' => [
                'secure' => true]]);
    }

    public function uploadImage($img,$route) {
        $upload = (new UploadApi())->upload($route.$img, [
            'folder' => 'products',
            'resource_type' => 'auto',
        ]);
        return $upload['secure_url'];
    }

    public function deleteImage($img) {
            $id_public = explode('/', $img);// separar la url de la imagen
            $image_url = $id_public[7].'/'.$id_public[8];
            $extension =  pathinfo($image_url, PATHINFO_EXTENSION);
            if ($extension == 'jpg') {
                $img_delete = str_replace('.jpg', '', $image_url);
            } 
            else if ($extension == 'png') {
                $img_delete = str_replace('.png', '', $image_url);
            } 
            else if ($extension == 'jpeg') {
                $img_delete = str_replace('.jpeg', '', $image_url);
            } 
            else if ($extension == 'gif') {
                $img_delete = str_replace('.gif', '', $image_url);
            }
            else {
                $img_delete = $image_url;
            }


            $upload = (new AdminApi())->deleteAssets($img_delete, [
                'resource_type' => 'image',
                'type' => 'upload',
            ]);
    }
    public function updateImage($imgOriginal,$imgNew,$route) {
        $this->deleteImage($imgOriginal);
        $uploadSecure = $this->uploadImage($imgNew,$route);
        return $uploadSecure;
    }
}

?>
