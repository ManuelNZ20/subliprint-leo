<?php
require_once(__DIR__.'/../../config/database.php');

class InventoryModel {
    private $dbCon;

    // Constructor, conexión a la base de datos
    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function counInvetory() {
        $sql = "SELECT COUNT(*) FROM inventory";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }
    // Listar Inventario
    public function getInventory() {
        $sql = "SELECT i.idInventory,i.note, i.dateInventory, providers.name
        FROM inventory i INNER JOIN providers ON i.idProvider = providers.idProvider;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $inventory;
    }

    public function getInventoryById($id) {
        $sql = "SELECT i.idInventory,i.note, i.dateInventory,provider.name FROM inventory i INNER JOIN providers ON i.idProvider=providers.idProvider WHERE idInventory = :id";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $inventory = $stmt->fetch(PDO::FETCH_ASSOC);
        return $inventory;
    }

    // Crear Inventario
    public function createInventory($date,$idProvider,$note) {
        $sql = "INSERT INTO inventory (note, dateInventory, idProvider) VALUES (:note,:dateInventory, :idProvider)";
        try {
            $stmt = $this->dbCon->getConnection()->prepare($sql);
            $stmt->bindParam(':note', $note, PDO::PARAM_STR);
            $stmt->bindParam(':dateInventory', $date, PDO::PARAM_STR);
            $stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            echo "Error al crear el inventario".$th->getMessage();
        }
    }

    // Procedimiento almacenado para eliminar un invetario, por id de inventario, cuando no existe un producto en el inventario
    public function deleteInvetory($idInventory) {
        $sqlProcedure = "CALL deleteInventoryChecking(:idInventory)";
        $stmt = $this->dbCon->getConnection()->prepare($sqlProcedure);
        $stmt->bindParam(':idInventory', $idInventory);
        $stmt->execute();
    }
    public function searchInventory() {
        if(isset($_GET['date'])) {
            $search = $_GET['date'];
            $sql = "SELECT * FROM inventory i INNER JOIN providers ON i.idProvider = providers.idProvider WHERE i.dateInventory LIKE '%$search%'";
            $stmt = $this->dbCon->getConnection()->prepare($sql);
            $stmt->execute();
            $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $inventory;
        }
    }

    public function paginationInventory($pageInit,$pageEnd) {
        $sql = "SELECT * FROM inventory i INNER JOIN providers ON i.idProvider = providers.idProvider LIMIT :offset, :limit";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':offset', $pageInit, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $pageEnd, PDO::PARAM_INT);
        $stmt->execute();
        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $inventory;
    }  
}
?>