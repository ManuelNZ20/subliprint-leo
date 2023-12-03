<?php
require_once(__DIR__.'/../model/BuyModel.php');
require_once(__DIR__.'/../model/OrderModel.php');
require_once(__DIR__.'/../model/UserModel.php');
require_once(__DIR__.'/../model/CartModel.php');
require_once(__DIR__.'/../model/ShipmentModel.php');

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
    private $cartModel;
    private $shipmentModel;
    public function __construct() {
        $this->buyModel = new BuyModel();
        $this->userModel = new UserModel();
        $this->cartModel = new CartModel();
        $this->shipmentModel = new ShipmentInformationModel();
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
            $user = $this->userModel->getUserById($idUser);
            // Eliminar el carrito
            $this->cartModel->clearCart();
            // redireccionar a la vista de detalle de la orden
            $idBuy = $this->getLastInsertId($idUser);
            // Almacenar la información de envío
            $idLastBuy = $this->buyModel->getLastInsertId($idUser);
            $this->shipmentModel->addDataContactUserShipmentInformation($idLastBuy['lastId'],$idUser,$name,$lastname,$phone,$address,$reference,$city);
            // Enviar correo de confirmación de orden
            $this->sendEmailConfirmBuyOrder($user,$idBuy);
            header('Location: ../../app/views/order/orderDetail.php?idOrder='.$idBuy);
        }
    }
    
    public function sendEmailConfirmBuyOrder($user,$idBuyUser) {
        // Enviar correo con PHPMailer
        // $buy = $this->buyModel->getBuyUserProductsTotal($idBuyUser);
        $buy = $this->buyModel->getBuyUserProductsTotal($idBuyUser);
        try {
            $user_email = $_ENV['USER_EMAIL'];
            $user_password = $_ENV['USER_PASSWORD'];
            $the_subject = 'Confirmar orden';
            $address_to = $user['mail'];
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->Username = $user_email;
            $mail->Password = $user_password;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->FromName = 'Confirmar orden';
            $mail->Port = 465;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->CharSet = 'UTF-8';
            $mail->From = $user_email;
            $mail->addAddress($address_to);// correo del usuario
            $mail->Subject = $the_subject;
            $mail->Body = '<!DOCTYPE html>'.
            '<html lang="es">'.
            '<head>'.
            '<meta charset="UTF-8">'.
            '<title>Confirmar orden</title>'.
            '</head>'.
            '<body>'.
            '<div class="container">'.
            '<div class="row">'.
            '<div class="col-md-12">'.
            '<div class="card">'.
            '<div class="card-header">'.
            '<h3>Confirmar orden No pagada</h3>'.
            '</div>'.
            '<div class="card-body">'.
            '<p>Hola '.$user['name'].' '.$user['lastname'].'.</p>'.
            '<p>'."\"¡Hola! Parece que la orden aún no ha sido pagada. Puedes completar el pago revisando los detalles de tu orden. Haz clic en 'Ver detalles' para proceder con el pago. ¡Gracias!\"".'</p>'.
            '<a href="" class="btn btn-success">Confirmar orden</a>'.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'.
            '<table class="table table-bordered">'.
            '<thead>'.
            '<tr>'.
            '<th scope="col">ID</th>'.
            '<th scope="col">Producto</th>'.
            '<th scope="col">Cantidad</th>'.
            '<th scope="col">Precio</th>'.
            '<th scope="col">Subtotal</th>'.
            '</tr>'.
            '</thead>'.
            '<tbody>';
            $total = 0;
            foreach($buy as $b):
              $total += $b['total_producto'];
              $mail->Body .= '<tr>'.
              '<td>'.$b['idProduct'].'</td>'.
              '<td>'.$b['nameProduct'].'</td>'.
              '<td>'.$b['amountProduct'].'</td>'.
              '<td>S/. '.$b['priceProduct'].'</td>'.
              '<td>S/. '.$b['total_producto'].'</td>'.
              '</tr>';
            endforeach;
            $mail->Body .= '</tbody>'.
            '</table>'.
            '<p>El total de la orden es: S/. '.$total.' Soles </p>'.
            '<p>Gracias por consultar nuestros productos y servicios, esperamos que haya encontrado lo que estaba buscando.</p>'.
            '</div>'.
            '</body>'.
            '</html>';
            $mail->IsHTML(true);
            if(!$mail->send()) {
                echo 'Error al enviar el correo';
                return;
            } else {
                echo 'Correo enviado correctamente';
                return;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    public function getLastInsertId($idUser) {
        return $this->buyModel->getLastInsertId($idUser)['idBuyUser'];
    }

    public function getBuyUser($idBuyUser) {
        return $this->buyModel->getBuyUser($idBuyUser);
    }

    public function getBuyByLastId($idBuyUser) {
        return $this->buyModel->getBuyByLastId($idBuyUser);
    }

    public function getBuyUserProductsTotal($idBuyUser) {
        return $this->buyModel->getBuyUserProductsTotal($idBuyUser);
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