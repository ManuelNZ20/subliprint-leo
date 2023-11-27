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
        $json_cart = json_encode($cart); // conver
        echo $json_cart;
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
    echo $data['payer']['payer_info']['payment_method'];
    // var_dump($json);
    // var_dump($data);
    $buyController->onApproveBuy($data['orderID']);
    echo "Compra aprobada";
    // return;
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
            $idBuy = $this->getLastInsertId($idUser);
            // actualizar datos del usuario
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $address = $_POST['address'];
            $reference = $_POST['reference'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $this->userModel->updateUser($idUser,$name,$lastname,$address,$reference,$phone,$city);
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


}
?>