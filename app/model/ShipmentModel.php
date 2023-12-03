<?php
require_once(__DIR__.'/../../config/database.php');

class ShipmentInformationModel {
    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function getShipmentInformation() {
        $sql = "SELECT * FROM shipmentinformation";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function getShipmentInformationById($idLastBuyUser) {
        $sql = "SELECT * FROM shipmentinformation WHERE idBuyUser=:idLastBuyUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idLastBuyUser',$idLastBuyUser);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    public function addDataContactUserShipmentInformation($idBuyUser,$idUser, $nameUser,$lastNameUser,$phoneContact,$address,$reference,$city) {
        $sql = "INSERT INTO shipmentinformation(idBuyUser,idUser,nameUser,lastnameUser,phoneContact,address,reference,location) VALUES(:idBuyUser,:idUser,:nameUser,:lastNameUser,:phoneContact,:address,:reference,:location)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idBuyUser',$idBuyUser);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':nameUser',$nameUser);
        $stmt->bindParam(':lastNameUser',$lastNameUser);
        $stmt->bindParam(':phoneContact',$phoneContact);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':reference',$reference);
        $stmt->bindParam(':location',$city);
        $stmt->execute();
        $stmt->closeCursor();
        return $stmt?true:false;

    }
}

?>