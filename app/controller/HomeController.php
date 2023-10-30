<?php
// HomeController.php
class HomeController
{
    public function index()
    {
        // Lógica para la página de inicio
        // ob_start();
        // include '../app/views/home/home.php';
        // ob_get_clean();
        $title = 'Inicio';
        include '../app/views/home/home.php';
    }
}

?>