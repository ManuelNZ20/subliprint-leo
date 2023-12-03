<?php
require_once(__DIR__.'/../../config/database.php');
// hora local
date_default_timezone_set('America/Lima');
class OrderModel {
    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    // obtener el ultimo id de la tabla orders
    public function getOrderProductsBuyDetails($idBuyUser) {
        $sql = "SELECT \n"
    . "      bu.idBuyUser,\n"
    . "      bu.stateBuy,\n"
    . "      bu.dateBuy,\n"
    . "     orb.dateOrder,\n"
    . "     ord.idProduct,\n"
    ."      orb.stateOrder,\n"
    . "     p.nameProduct,\n"
    . "     p.description,\n"
    . "     p.imgProduct,\n"
    . "    ord.priceProduct,\n"
    . "    ord.amountProduct,\n"
    . "    orb.total,\n"
    . "    us.name,\n"//DATOS DEL USUARIO
    . "    us.lastname,\n"
    . "    us.address,\n"
    . "    us.reference,\n"
    . "    us.mail,\n"
    . "    us.city,\n"
    . "    us.phone\n"
    . "   FROM orderdetail ord \n"
    . "  INNER JOIN orderbuy orb\n"
    . "  ON ord.idOrderBuy = orb.idOrderBuy \n"
    . "  INNER JOIN product p\n"
    . "  ON ord.idProduct = p.idProduct\n"
    . "  INNER JOIN buyuser bu\n"
    . "  ON bu.idOrder = orb.idOrderBuy\n"
    . "  INNER JOIN user us\n"
    . "  ON us.idUser = bu.idUser\n"
    . "  WHERE bu.idBuyUser = :idBuyUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idBuyUser',$idBuyUser);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }


    public function countOrderProducts() {
        $sql = "SELECT COUNT(*) FROM orderbuy";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $data;
    }

    public function countOrderBuy() {
        $sql = "SELECT COUNT(*) FROM orderbuy obuy INNER JOIN
        buyuser buyu ON obuy.idOrderBuy = buyu.idOrder
        WHERE buyu.stateBuy='Pagado'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $data;
    }

    public function countOrderBuyState() {
        $sql = "SELECT COUNT(*) FROM orderbuy obuy INNER JOIN
        buyuser buyu ON obuy.idOrderBuy = buyu.idOrder
        WHERE obuy.stateOrder='Pendiente' AND buyu.stateBuy='Pagado'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $data;
    }

    // esta funcion permite sumar el total de ordenes de compra
    public function sumOrderBuyState() {
        $sql = "SELECT SUM(orderbuy.total) FROM buyuser INNER JOIN orderbuy ON buyuser.idOrder=orderbuy.idOrderBuy WHERE buyuser.stateBuy='Pagado'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $data;
    }
    // Confirmar envío de pedido
    public function onApproveOrder($idOrderBuy) {
        $sql = "UPDATE buyuser bu INNER JOIN orderbuy od ON bu.idOrder=od.idOrderBuy
        SET od.stateOrder = 'Aceptado',od.dateConfirm=:dateConfirm WHERE bu.idBuyUser=:idOrderBuy;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idOrderBuy',$idOrderBuy);
        $dateConfirm = date('Y-m-d H:i:s');
        $stmt->bindParam(':dateConfirm',$dateConfirm);
        $stmt->execute();
        $stmt->closeCursor();
    }

    // confirmar envio del pedido
    public function onSendOrder($idOrderBuy) {
        $sql = "UPDATE buyuser bu INNER JOIN orderbuy od ON bu.idOrder=od.idOrderBuy
        SET od.stateOrder = 'Enviado', od.dateDelivery=:dateDelivery WHERE bu.idBuyUser=:idOrderBuy;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idOrderBuy',$idOrderBuy);
        $dateDelivery = date('Y-m-d H:i:s');
        $stmt->bindParam(':dateDelivery',$dateDelivery);
        $stmt->execute();
        $stmt->closeCursor();
        // Actualizar la cantidad de productos
        $sql = "SELECT ord.idProduct,ord.amountProduct FROM buyuser buy INNER JOIN orderbuy orb ON buy.idOrder=orb.idOrderBuy INNER JOIN orderdetail ord ON ord.idOrderBuy=orb.idOrderBuy WHERE buy.idBuyUser=:idOrderBuy;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idOrderBuy',$idOrderBuy);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($products as $product) {
            $sql = "UPDATE productinventory pin INNER JOIN product pr ON pr.idProduct=pin.idProduct SET pin.amountInit=pin.amountInit-:amountProduct WHERE pr.idProduct=:idProduct;";
            $stmt = $this->dbCon->getConnection()->prepare($sql);
            $stmt->bindParam(':amountProduct',$product['amountProduct']);
            $stmt->bindParam(':idProduct',$product['idProduct']);
            $stmt->execute();
            $stmt->closeCursor();
        }

    }

    // listar todas las ordenes de la tabla orderbuy que su estado sea diferente de 'Aceptado'
    public function listOrderBuyState() {
        $sql = "SELECT buy.idBuyUser,o.idLastOrderBuy, o.idOrderBuy,us.name,o.dateOrder,o.total,o.stateOrder FROM buyuser buy INNER JOIN user us ON buy.idUser = us.idUser INNER JOIN orderbuy o ON o.idOrderBuy = buy.idOrder WHERE o.stateOrder='Pendiente' AND buy.stateBuy='Pagado';";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function listOrdersBuy() {
        $sql = "SELECT buy.idBuyUser,o.dateDelivery,o.idLastOrderBuy, o.idOrderBuy,us.name,o.dateOrder,o.total,o.stateOrder FROM buyuser buy INNER JOIN user us ON buy.idUser = us.idUser INNER JOIN orderbuy o ON o.idOrderBuy = buy.idOrder WHERE buy.stateBuy='Pagado';";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function paginationOrdersBuy($init,$end) {
        $sql = "SELECT buy.idBuyUser,o.dateDelivery,o.idLastOrderBuy, o.idOrderBuy,us.name,o.dateOrder,o.total,o.stateOrder FROM buyuser buy INNER JOIN user us ON buy.idUser = us.idUser INNER JOIN orderbuy o ON o.idOrderBuy = buy.idOrder WHERE buy.stateBuy='Pagado' LIMIT :init,:end;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':init',$init,PDO::PARAM_INT);
        $stmt->bindParam(':end',$end,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    } 

    // consulta para buscar por nombre de usuario, id de orden, fecha de orden, total de orden y estado de orden
    public function searchOrderBuy($search) {
        $sql = "SELECT buy.idBuyUser,o.dateDelivery,o.idLastOrderBuy, o.idOrderBuy,us.name,o.dateOrder,o.total,o.stateOrder FROM buyuser buy INNER JOIN user us ON buy.idUser = us.idUser INNER JOIN orderbuy o ON o.idOrderBuy = buy.idOrder WHERE buy.stateBuy='Pagado' AND us.name LIKE :search OR o.idOrderBuy LIKE :search OR o.dateOrder LIKE :search OR o.total LIKE :search OR o.stateOrder LIKE :search 
        OR buy.idBuyUser LIKE :search;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindValue(':search','%'.$search.'%');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function filterStateOrderBuy($stateOrder) {
        $sql = "SELECT buy.idBuyUser,o.dateDelivery,o.idLastOrderBuy, o.idOrderBuy,us.name,o.dateOrder,o.total,o.stateOrder FROM buyuser buy INNER JOIN user us ON buy.idUser = us.idUser INNER JOIN orderbuy o ON o.idOrderBuy = buy.idOrder WHERE buy.stateBuy='Pagado' AND o.stateOrder=:stateOrder;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':stateOrder',$stateOrder);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    // obtener datos para formar un grafico que muestre el total de ordenes por estado
    public function listOrderBuyStateChart() {
        $sql = "SELECT ob.stateOrder,COUNT(*) AS total FROM buyuser bu INNER JOIN orderbuy ob ON bu.idOrder=ob.idOrderBuy GROUP BY ob.stateOrder;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $stmt->closeCursor();
        return $data;
    }

    // obtener datos para formar un grafico que muestre el total de ordenes por semana con el nombre del dia en español ya sea Monday es Lunes, Tuesday es Martes, etc
    public function listOrderBuyWeekChart()
    {
        // $sql = "SELECT DAYNAME(o.dateOrder) AS dayName
        // ,COUNT(*) AS total FROM buyuser bu INNER JOIN orderbuy o ON bu.idOrder=o.idOrderBuy WHERE bu.stateBuy='Pagado' GROUP BY DAYNAME(o.dateOrder);";
        $sql = "SELECT IF(DAYNAME(o.dateOrder)='Monday','Lunes',IF(DAYNAME(o.dateOrder)='Tuesday','Martes',IF(DAYNAME(o.dateOrder)='Wednesday','Miercoles',IF(DAYNAME(o.dateOrder)='Thursday','Jueves',IF(DAYNAME(o.dateOrder)='Friday','Viernes',IF(DAYNAME(o.dateOrder)='Saturday','Sabado',IF(DAYNAME(o.dateOrder)='Sunday','Domingo',''))))))) AS dayName ,COUNT(*) AS total FROM buyuser bu INNER JOIN orderbuy o ON bu.idOrder=o.idOrderBuy WHERE bu.stateBuy='Pagado' GROUP BY DAYNAME(o.dateOrder) ORDER BY o.dateOrder ASC;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $orders;
    }
    

}


?>