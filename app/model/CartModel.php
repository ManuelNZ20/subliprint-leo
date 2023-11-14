<?php
require_once(__DIR__.'/../../config/database.php');

class CartModel {

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



}
?>