<?php
// ProductController.php
class ProductController
{
    public function index()
    {
        // Lógica para la página de productos
        // echo "Página de productos";
        
        $title = 'Productos';
        // $data = [
        //     'title' => 'Productos'
        // ];
        // extract($data);
        include '../app/views/products/products.php';
    }

    public function show($id)
    {
        // Lógica para mostrar un producto específico
        echo "Mostrar producto #$id";
    }
}

?>