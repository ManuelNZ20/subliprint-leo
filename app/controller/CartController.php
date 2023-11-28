<?php
require_once(__DIR__.'/../model/CartModel.php');
require_once(__DIR__.'/../model/ProductsModel.php');
$cartController = new CartController();

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

    public function getProducts() {
        $productModel = new ProductModel();
        $cart = $this->getCart();
        $products = array(); // array de productos
        
        foreach ($cart as $cartProduct) {
            $product = $productModel->getProductByIdInventoryByProduct($cartProduct['id']); // obtenemos el producto por id de inventario
        
            // Agregar el campo 'amount' al producto
            $product['amount'] = intval($cartProduct['amount']);
            $product['subtotal'] = $product['price'] * $cartProduct['amount'];
            array_push($products, $product); // agregamos el producto al array de productos
        }
        
        return $products; // retornamos el array de productos
        
    }

    public function getSubTotal() {
        $products = $this->getProducts();
        $subTotal = 0;
        foreach($products as $product) {
            $subTotal += $product['subtotal'];
        }
        return $subTotal;
    }
    public function clearCart() {
        $this->cartModel->clearCart();
    }
    public function getSession() 
    {
        return $this->cartModel->getSession();
    }
}

?>