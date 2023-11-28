<?php
require_once(__DIR__.'/../model/BuyModel.php');
require_once(__DIR__.'/../model/OrderModel.php');
require_once(__DIR__.'/../model/UserModel.php');
$buyController = new BuyController();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btn-addOrder'])) {
        $total = 0;
        $cart = unserialize($_POST['cart']);
        foreach($cart as $c) {
            $total += $c['subtotal'];
        }
        $buyController->addBuy($total);
        exit;
    } else if(isset($_POST['btn-deleteOrder'])) {
        $idBuyUser = $_POST['idBuyUser'];
        $buyController->deleteBuyUser($idBuyUser);
        exit;
    }
    // Confirmar Compra 
    $json = file_get_contents('php://input'); // obtener los datos que envia paypal
    $data = json_decode($json,true);
    $buyController->onApproveBuy($data['orderID']);
    exit;
}

class BuyController {
  
    private $buyModel;
    private $userModel;
    public function __construct() {
        $this->buyModel = new BuyModel();
        $this->userModel = new UserModel();
    }

    public function addBuy($totalOrder) {
        if(isset($_POST['cart']) &&
           isset($_POST['idUser'])) {
            $idUser = $_POST['idUser'];
            $cart = unserialize($_POST['cart']);
            $json_cart = json_encode($cart); // convertir el array en json
            $this->buyModel->addBuy($idUser,$totalOrder,$json_cart);
            // actualizar datos del usuario
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $address = $_POST['address'];
            $reference = $_POST['reference'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $this->userModel->updateUser($idUser,$name,$lastname,$address,$reference,$phone,$city);
            $idBuy = $this->getLastInsertId($idUser);
            header('Location: ../../app/views/order/orderDetail.php?idOrder='.$idBuy);
        }
    }

    public function getLastInsertId($idUser) {
        return $this->buyModel->getLastInsertId($idUser)['idBuyUser'];
    }

    public function getBuyUser($idBuyUser) {
        return $this->buyModel->getBuyUser($idBuyUser);
    }

    public function getBuyUserDetails($idBuyUser) {
        return $this->buyModel->getBuyUserDetails($idBuyUser);
    }

    public function getBuyUserDataUser($idUser,$idBuyUser) {
        return $this->buyModel->getBuyUserDataUser($idUser,$idBuyUser);
    }

    public function deleteBuyUser($idBuyUser) {
        if($this->buyModel->deleteBuyUser($idBuyUser)) {
            header('Location: ../../app/views/order/orders.php');
            return true;
        } else {
            return false;
        }
    }

    public function onApproveBuy($idBuyUser) {
        if($this->buyModel->onApproveBuy($idBuyUser)) {
            return true;
        } else { 
            return false;
        }
    }

    public function listOrdersBuyByMonth() {// listar las compras por mes
        return $this->buyModel->listOrdersBuyByMonth();
    }

}
?>