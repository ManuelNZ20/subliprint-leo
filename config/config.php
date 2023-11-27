<?php

// DATABASE
require_once(__DIR__.'/../vendor/autoload.php');
// uso de la libería de composer
// Usar el archivo .env
$dontenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dontenv->load();

// En Producción
$bandera = false; // falso para desarrollo y verdadero para producción

if($bandera===true){
    define('DRIVER', $_ENV['P_DRIVER']);
    define('HOST', $_ENV['P_HOST']);
    define('USER', $_ENV['P_USER']);
    define('PASS', $_ENV['P_PASSWORD']);
    define('BASE', $_ENV['P_BASE']);
    define('PORT', $_ENV['P_PORT']);
}else{
    define('DRIVER', $_ENV['D_DRIVER']);
    define('HOST', $_ENV['D_HOST']);
    define('USER', $_ENV['D_USER']);
    define('PASS', $_ENV['D_PASSWORD']);
    define('BASE', $_ENV['D_BASE']);
    define('PORT', $_ENV['D_PORT']);
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