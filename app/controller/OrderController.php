<?php
require_once(__DIR__.'/../model/OrderModel.php');
require_once(__DIR__.'/../model/BuyModel.php');
require_once(__DIR__.'/../model/UserModel.php');
$orderController = new OrderController();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btn-successOrder'])) {
        $idBuyUser = $_POST['idBuyUser'];
        $idUser = $_POST['idUser'];
        $orderController->onApproveOrder($idBuyUser,$idUser);
        session_start();
        header('Location: '.$_SESSION['last_page']);
        exit;
    } elseif(isset($_POST['btn-sendOrder'])) {
        $idBuyUser = $_POST['idBuyUser'];
        $idUser = $_POST['idUser'];
        $orderController->onSendOrder($idBuyUser,$idUser);
        session_start();
        header('Location: '.$_SESSION['last_page']);
        exit;
    }
}


class OrderController {
  
    private $orderModel;
    private $buyModel;
    private $userModel;
    
    public function __construct() 
    {
        $this->orderModel = new OrderModel();
        $this->buyModel = new BuyModel();
        $this->userModel = new UserModel();
    }

    public function getOrderProductsBuyDetails($idBuyUser) 
    {
        return $this->orderModel->getOrderProductsBuyDetails($idBuyUser);
    }

    public function countOrderProducts() 
    {
        return $this->orderModel->countOrderProducts();
    }

    public function countOrderBuy() 
    {
        return $this->orderModel->countOrderBuy();
    }

    public function countOrderBuyState() 
    {
        return $this->orderModel->countOrderBuyState();
    }

    public function sumOrderBuyState() 
    {
        return $this->orderModel->sumOrderBuyState();
    }

    public function listOrderBuyState() 
    {
        return $this->orderModel->listOrderBuyState();
    }

    public function listOrderBuyStateChart() 
    {
        return $this->orderModel->listOrderBuyStateChart();
    }
    // Confirmar envío de pedido
    public function onApproveOrder($idOrderBuy,$idUser) 
    {
        $user = $this->userModel->getUserById($idUser);
        $this->sendEmailOnApproveOrder($user,$idOrderBuy);
        $this->orderModel->onApproveOrder($idOrderBuy);
    }

    // Enviar correo de que su orden a sido revisada y esta en camino
    public function sendEmailOnApproveOrder($user,$idBuyUser) {
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
            $mail->FromName = 'Orden aceptada y en camino a su destino';
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
            '<title>Orden aceptada y en camino a su destino</title>'.
            '</head>'.
            '<body>'.
            '<div class="container">'.
            '<div class="row">'.
            '<div class="col-md-12">'.
            '<div class="card">'.
            '<div class="card-header">'.
            '<h3>Confirmar orden Pagada y en camino a su destino
            </h3>'.
            '</div>'.
            '<div class="card-body">'.
            '<p>Hola '.$user['name'].' '.$user['lastname'].'.</p>'.
            '<p>'."\"¡Hola! Gracias por su compra. Su pedido ha sido recibido y está siendo procesado. Recibirá un correo electrónico de confirmación una vez que su pedido haya sido enviado. ¡Gracias!\"".'</p>'.
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

    // Confirmar envío de pedido
    public function onSendOrder($idOrderBuy,$idUser) 
    {
        $user = $this->userModel->getUserById($idUser);
        $this->sendEmailOnSendOrder($user,$idOrderBuy);
        $this->orderModel->onSendOrder($idOrderBuy);
    }

    public function sendEmailOnSendOrder($user,$idBuyUser) {
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
            $mail->FromName = 'Orden enviada';
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
            '<h3>Confirmar envío de orden</h3>'.
            '</div>'.
            '<div class="card-body">'.
            '<p>Hola '.$user['name'].' '.$user['lastname'].'.</p>'.
            '<p>'."\"¡Hola! Gracias por su compra. Su pedido ha sido enviado y recibido.
             ¡Gracias!\"".'</p>'.
            '<a href="" class="btn btn-success">Confirmar orden</a>'.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'.
            '<h3>Detalles de la orden</h3>'.
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

    public function listOrdersBuy() 
    {
        return $this->orderModel->listOrdersBuy();
    }

    public function listOrderBuyWeekChart() {
        return $this->orderModel->listOrderBuyWeekChart();
    }

    public function paginationOrdersBuy($init,$end) {
        $orders = $this->orderModel->paginationOrdersBuy($init,$end);
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['search-order'])) {
                $search = $_GET['term'];
                $orders = $this->orderModel->searchOrderBuy($search);
                return $orders;
            }elseif(isset($_GET['filter-order'])) {
                $stateOrder = $_GET['stateOrder'];
                $orders = $this->orderModel->filterStateOrderBuy($stateOrder);
            } else if(isset($_GET['all-order'])) {
                $orders = $this->orderModel->paginationOrdersBuy($init,$end);
            }
        }
        return $orders;
    }
}
?>