<?php
require_once(__DIR__.'/../../config/database.php');

class BuyModel {
    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    // Agregar una orden de compra usando un procedimiento almacenado
    public function addBuy($idUser,$totalOrder,$products) {
        $sql = "CALL InsertOrderProducts(:idUser,:totalOrder,:products)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':totalOrder',$totalOrder);
        $stmt->bindParam(':products',$products);
        $stmt->execute();
        $stmt->closeCursor();
        return $stmt?true:false;
    }

    public function getLastInsertId($idUser) {
        $sql = "SELECT lastId,idBuyUser,buyuser.stateBuy FROM buyuser WHERE idUser=:idUser ORDER BY lastId DESC LIMIT 1
        "; // obtener el ultimo id de la tabla orders
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function getBuyUser($idBuyUser) {
        $sql = "SELECT * FROM buyuser WHERE idBuyUser=:idBuyUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idBuyUser',$idBuyUser);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function getBuyUserDetails($idBuyUser) {
        $sql = "SELECT buy.idBuyUser,buy.stateBuy,buy.dateBuy ,ob.dateOrder,ob.stateOrder FROM buyuser buy INNER JOIN orderbuy ob ON buy.idOrder=ob.idOrderBuy WHERE idUser=:idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idBuyUser);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function deleteBuyUser($idBuyUser) {
        $sql = "DELETE buyuser,orderbuy,orderdetail FROM buyuser INNER JOIN orderbuy ON buyuser.idOrder=orderbuy.idOrderBuy INNER JOIN orderdetail ON orderbuy.idOrderBuy=orderdetail.idOrderBuy WHERE buyuser.idBuyUser=:idBuyUser AND buyuser.stateBuy!='Pagado'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idBuyUser',$idBuyUser);
        $stmt->execute();
        $stmt->closeCursor();
        return $stmt?true:false;
    }



    public function getBuyUserDataUser($idUser,$idBuyUser) {
        $sql = "SELECT b.idBuyUser,b.stateBuy,b.dateBuy,u.name,u.lastname,u.address,u.reference,u.phone,u.city FROM buyuser b INNER JOIN user u ON u.idUser = b.idUser 
        WHERE b.idUser=:idUser AND b.idBuyUser =:idBuyUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':idBuyUser',$idBuyUser);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function onApproveBuy($idBuyUser) {
        $sql = "UPDATE buyuser SET stateBuy='Pagado' WHERE idBuyUser=:idBuyUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idBuyUser',$idBuyUser);
        $stmt->execute();
        $stmt->closeCursor();
        return $stmt?true:false;
    }

    // Grafico que muestra el total de ordenes pagadas por los usuarios por lista de todos los meses del año actual y el total de ordenes pagadas por mes 
    public function listOrdersBuyByMonth() {
        $sql = "SELECT
        MONTHNAME(calendar.month) AS monthName,
        IFNULL(COUNT(buy.dateBuy), 0) AS total
    FROM (
        SELECT
            DATE_FORMAT(STR_TO_DATE(CONCAT('2023-', LPAD(a.m, 2, '0'), '-01'), '%Y-%m-%d'), '%Y-%m-%d') AS month
        FROM (
            SELECT 1 AS m UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
        ) AS a
    ) calendar
    LEFT JOIN buyuser buy ON MONTH(buy.dateBuy) = MONTH(calendar.month) AND YEAR(buy.dateBuy) = YEAR(calendar.month) AND buy.stateBuy='Pagado'
    GROUP BY MONTHNAME(calendar.month);
    ";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $products;
    }

    // Grafico que muestra el total de ganancias por semana
    public function listOrdersBuyByWeek() {
        $sql = "SELECT
        WEEK(calendar.week) AS weekName,
        IFNULL(COUNT(buy.dateBuy), 0) AS total
    FROM (
        SELECT
            DATE_FORMAT(STR_TO_DATE(CONCAT('2023-', LPAD(a.m, 2, '0'), '-01'), '%Y-%m-%d'), '%Y-%m-%d') AS week
        FROM (
            SELECT 1 AS m UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
        ) AS a
    ) calendar 
    LEFT JOIN buyuser buy ON WEEK(buy.dateBuy) = WEEK(calendar.week) AND YEAR(buy.dateBuy) = YEAR(calendar.week) AND buy.stateBuy='Pagado'
    GROUP BY WEEK(calendar.week);
    ";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $products;
    }


}


?>