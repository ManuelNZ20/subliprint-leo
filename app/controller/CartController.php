<?php
require_once(__DIR__.'/../model/CartModel.php');
$cartController = new CartController();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartController->addProduct();
    echo json_encode($cartController->countProducts());
}

class CartController {
    public $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    public function addProduct() {
        if(isset($_POST['id']) && isset($_POST['amount'])) {
            $id = $_POST['id'];
            $amount = $_POST['amount'];
            $this->cartModel->addProduct($id,$amount);
        } else {
            echo "Error al agregar el producto";
        }
    }

    public function countProducts() {
        return $this->cartModel->countProducts();
    }
    public function getCart() {
        return $this->cartModel->getCart();
    }

    public function clearCart() {
        $this->cartModel->clearCart();
    }
}

?>