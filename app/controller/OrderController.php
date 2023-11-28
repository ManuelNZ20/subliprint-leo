<?php
require_once(__DIR__.'/../model/OrderModel.php');
$orderController = new OrderController();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btn-successOrder'])) {
        $idBuyUser = $_POST['idBuyUser'];
        $orderController->onApproveOrder($idBuyUser);
        session_start();
        header('Location: '.$_SESSION['last_page']);
        exit;
    } elseif(isset($_POST['btn-sendOrder'])) {
        $idBuyUser = $_POST['idBuyUser'];
        $orderController->onSendOrder($idBuyUser);
        session_start();
        header('Location: '.$_SESSION['last_page']);
        exit;
    }
}


class OrderController {
  
    private $orderModel;

    public function __construct() 
    {
        $this->orderModel = new OrderModel();
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
    public function onApproveOrder($idOrderBuy) 
    {
        $this->orderModel->onApproveOrder($idOrderBuy);
    }

    // Confirmar envío de pedido
    public function onSendOrder($idOrderBuy) 
    {
        $this->orderModel->onSendOrder($idOrderBuy);
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