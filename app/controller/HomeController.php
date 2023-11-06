<?php
// HomeController.php, iniciar código
class HomeController
{
    public function index()
    {
        $title = 'Inicio';
        include '../app/views/home/home.php';
    }
}

?>