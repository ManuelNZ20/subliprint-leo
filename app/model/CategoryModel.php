<?php
require_once(__DIR__.'/../../config/database.php');


class CategoryModel {
    private $dbCon;

    // Constructor, conexión a la base de datos
    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    // Listar Categoria
    public function getCategory() {
        $sql = "SELECT * FROM category";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function getCategoryActive() {
        $sql = "SELECT * FROM category WHERE statusCategory = 'activo'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

}
?>