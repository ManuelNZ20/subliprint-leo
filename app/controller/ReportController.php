<?php
require_once(__DIR__.'/../model/ProductsModel.php');
require_once('generar_reporte_controller.php');

$productModel = new ProductModel();
echo 'ReportePDF.php';
echo $_POST['idInventory'];
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btn-generate-report-inventory'])) {
        // GetProductsByInventory
        try {
            $idInventory = $_POST['idInventory'];
            $products = $productModel->getProductsByIdInventory($idInventory);
            $titulo = 'Reporte de inventario';
            $encabezado = array('id','Nombre','Precio', 'Stock');
            $datos = array();
            foreach ($products as $product) {
                $datos[] = array(
                    'id' => $product['idProduct'],
                    'name' => $product['nameProduct'],
                    'price' => $product['price'],
                    'stock' => $product['amountInit']
                );
            }
            $reporte = new ReportePDF($titulo, $encabezado, $datos);
            $reporte->setTitleReport('Reporte de inventario');
            $reporte->generarPDF('Reporte de inventario');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
  
}

class ReportController {

    
}
?>