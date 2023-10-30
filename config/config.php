<?php
require_once '../../../vendor/autoload.php';
// uso de la libería de composer
$dontenv = Dotenv\Dotenv::createImmutable('../../../');
$dontenv->load();

define('DRIVER', $_ENV['DRIVER']);
define('HOST', $_ENV['HOST']);
define('USER', $_ENV['USER']);
define('PASS', $_ENV['PASSWORD']);

define('BASE', $_ENV['BASE']);
define('PORT', $_ENV['PORT']);


?>