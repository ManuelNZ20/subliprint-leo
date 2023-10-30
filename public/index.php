<?php

// Incluye el archivo del enrutador
require_once '../config/router.php';

$router = new Router();

// Define rutas
$router->get('/roberto-cotlear/public/', 'HomeController@index');
$router->get('/roberto-cotlear/app/views/products/', 'ProductController@index');
// $router->get('/products/(\d+)', 'ProductController@show');

// Ejecuta el enrutador
$router->run();
?>