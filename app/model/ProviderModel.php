<?php
include __DIR__.'/../../config/database.php';

class ProviderModel {
    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    // crear proveedor
    public function createProvider($name, $state, $phone, $address, $email, $dateRegister,$description) {
        $sql = "INSERT INTO providers (name, state, phone, address, email, dateRegister,description) VALUES (:name, :state, :phone, :address, :email, :dateRegister, :description)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':state', $state, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':dateRegister', $dateRegister, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    // Actualizar al proveedor
    public function updateProvider($id,$name, $state, $phone, $address, $email, $dateRegister,$description) {
        $sql = "UPDATE providers SET name = :name, state = :state, phone = :phone, address = :address, email = :email, dateRegister = :dateRegister, description = :description WHERE idProvider = :id";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':state', $state, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':dateRegister', $dateRegister, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    // eliminar proveedor
    public function deleteProvider($id) {
        $sql = "DELETE FROM providers WHERE idProvider = :id";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    // buscar proveedor
    public function searchProvider() {
        if(isset($_GET['term'])) {
            $search = $_GET['term'];
            $sql = "SELECT * FROM providers WHERE name LIKE '%$search%'";
            $stmt = $this->dbCon->getConnection()->prepare($sql);
            $stmt->execute();
            $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $providers;
        }
    }

    // listar proveedores
    public function getProvider() {
        $sql = "SELECT * FROM providers";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $providers;
    }
    public function filterProvider() {
        if(isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            if($filter == 'all') {
                $sql = "SELECT * FROM providers";
            }else {
                $sql = "SELECT * FROM providers WHERE state = '$filter'";
            }
            $stmt = $this->dbCon->getConnection()->prepare($sql);
            $stmt->execute();
            $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $providers;
        }
    }

    // buscar proveedor por el id
    public function getProviderById($id) {
        $sql = "SELECT * FROM providers WHERE idProvider = :id";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $provider = $stmt->fetch(PDO::FETCH_ASSOC);
        return $provider;
    }
    // test para determinar la conexión con la base de datos
    public function getCategory() {
        $sql = "SELECT * FROM category";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    public function paginationProvider($page) {
        $sql = "SELECT * FROM providers LIMIT $page, 5";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $providers;
    }
}


?>