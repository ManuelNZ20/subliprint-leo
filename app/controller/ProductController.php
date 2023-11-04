<?php
// ProductController.php
class ProductController
{
    public function index()
    {
        // Lógica para la página de productos
        $title = 'Productos';
        include '../app/views/products/products.php';
    }

    public function show($id)
    {
        echo "Mostrar producto #$id";
    }
}

?>