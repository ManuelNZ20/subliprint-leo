<?php
// session_start();
require_once(__DIR__.'/../../config/database.php');
$cartModel = new CartModel();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['idProduct'];
    $amount = $_POST['amount'];
    $cartModel->addProduct($id,$amount);
    header('Location: ../../app/views/products/productDetail.php?idProduct='.$id);
}

class CartModel {

    public function __construct() {
        if(!isset($_SESSION)) {
            session_start();
        }
    }
    // función sin uso de base de datos
    public function addProduct($id,$amount) {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // verificar si el producto ya existe en el carrito
        if(isset($_SESSION['cart'][$id])) {
            // si existe, sumar la cantidad
            $_SESSION['cart'][$id]['amount'] += $amount;
        } else {
            // si no existe, agregarlo al carrito
            $_SESSION['cart'][$id] = array(
                'id' => $id,
                'amount' => $amount
            );
        }
    }

    public function countProducts() {
        return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    }
    
    public function getCart() {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    }
    
    public function clearCart() {
        unset($_SESSION['cart']);
    }

    public function getSession() {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    }



}
?>