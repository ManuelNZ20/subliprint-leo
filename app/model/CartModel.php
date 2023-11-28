<?php
require_once(__DIR__.'/../../config/database.php');
$cartModel = new CartModel();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btn-addCart'])) {
        $id = $_POST['idProduct'];
        $amount = $_POST['amount'];
        $cartModel->addProduct($id,$amount);
        header('Location: ../../app/views/products/productDetail.php?idProduct='.$id);
    } elseif(isset($_POST['btn-updateCart'])) {
        $id = $_POST['idProduct'];
        $amount = $_POST['amount'];
        $cartModel->updateQuantity($id,$amount);
        header('Location: ../../app/views/cart/carts.php');
    } elseif(isset($_POST['btn-clearCart'])) {
        $cartModel->clearCart();
        header('Location: ../../app/views/cart/carts.php');
    }elseif(isset($_POST['btn-deleteProduct'])) {
        $id = $_POST['idProduct'];
        $cartModel->deleteProduct($id);
        header('Location: ../../app/views/cart/carts.php');
    }
}

class CartModel {

    public function __construct() {
        if(!session_id()) {
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
            $this->updateQuantity($id,$amount);
        } else {
            // si no existe, agregarlo al carrito
            $_SESSION['cart'][$id] = array(
                'id' => $id,
                'amount' => $amount
            );
        }
    }

    public function updateQuantity($id,$amount) {
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['amount'] = 0;
            $_SESSION['cart'][$id]['amount'] = intval($amount); // convertir a entero
        }
    }

    public function deleteProduct($id) {
        if(isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
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