<?php
include '../../../config/database.php';

class ProviderModel {
    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function createProvider($name, $state, $phone, $address, $email, $dateRegister) {
        $sql = "INSERT INTO providers (name, state, phone, address, email, dateRegister) VALUES (:name, :state, :phone, :address, :email, :dateRegister)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':state', $state, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':dateRegister', $dateRegister, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt) {
            echo "Proveedor creado";
            return true;
        } else {
            echo "Error al crear proveedor";
            return false;
        }

        
    }

    public function updateProvider() {

    }

    public function deleteProvider() {

    }

    public function getProvider() {
        $sql = "SELECT * FROM providers";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $providers;
    }

    public function getCategory() {
        $sql = "SELECT * FROM category";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
}


?>