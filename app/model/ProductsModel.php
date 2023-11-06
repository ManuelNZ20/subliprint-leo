<?php
require_once(__DIR__.'/../../config/database.php');

class ProductModel {
    private $dbCon;
    
    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function countProducts() {
        $sql = "SELECT COUNT(*) FROM products";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }

}

?>