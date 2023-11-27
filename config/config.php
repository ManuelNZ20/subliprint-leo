<?php

// DATABASE
require_once(__DIR__.'/../vendor/autoload.php');
// uso de la libería de composer
// Usar el archivo .env
$dontenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dontenv->load();

// En Producción
$bandera = false;

if($bandera){
    define('DRIVER', $_ENV['DRIVER']);
    define('HOST', $_ENV['HOST']);
    define('USER', $_ENV['USER']);
    define('PASS', $_ENV['PASSWORD']);
    // 
    define('BASE', $_ENV['BASE']);
    define('PORT', $_ENV['PORT']);
}else{
    define('DRIVER', $_ENV['DRIVER']);
    define('HOST', $_ENV['HOST']);
    define('USER', $_ENV['USER']);
    define('PASS', $_ENV['PASSWORD']);
    // 
    define('BASE', $_ENV['BASE']);
    define('PORT', $_ENV['PORT']);
}

// define('DRIVER', $_ENV['DRIVER']);
// define('HOST', $_ENV['HOST']);
// define('USER', $_ENV['USER']);
// define('PASS', $_ENV['PASSWORD']);
// // 
// define('BASE', $_ENV['BASE']);
// define('PORT', $_ENV['PORT']);

// Cloudinary 
define('CLOUDINARY_NAME', $_ENV['CLOUDINARY_NAME']);
define('CLOUDINARY_API_KEY', $_ENV['CLOUDINARY_API_KEY']);
define('CLOUDINARY_API_SECRET', $_ENV['CLOUDINARY_API_SECRET']);

// Paypal
define('PAYPAL_CLIENT_ID', $_ENV['PAYPAL_C']);


?>