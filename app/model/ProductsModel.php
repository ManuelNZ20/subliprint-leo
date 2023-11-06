<?php
require_once(__DIR__.'/../../config/database.php');
class ProductModel {
    private $dbCon;
    
    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }
    //  Obtenemos el número de productos de la tabla productinventory por id de inventario
    public function countProducts($idInvetnory) {
        $sql = "SELECT COUNT(*) AS products FROM productinventory WHERE idInventory = :idInventory";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idInventory',$idInvetnory,PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count;
    }
    // Obtenemos el id del producto por id de inventario
    public function createIdUUID() {
        $sql = "SELECT UPPER(LEFT(UUID(), 8)) AS id";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id;
    }
    // Obtenemos los productos por id de inventario
    public function getProductsByIdInventory($idInventory) {
        $sql = "CALL GetProductsByInventory(:idInventory)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idInventory',$idInventory,PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    // Obtenemos el número de productos de la tabla productinventory por id de producto
    public function countProductByIdProductInventory($idProduct) {
        $sql = "SELECT COUNT(*) FROM productinventory WHERE idProduct = :idProduct";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$idProduct,PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product;
    }
    // Creamos un productos en la tabla products y en la tabla productinventory
    public function createProduct($idInventory,$amount,$id,$name,$brand,$description,$status,$img,$price,$unit,$create,$update,$idCategory) {
        // Creamos el producto
        $sql = "INSERT INTO products (idProduct,nameProduct,brand,description,statusProduct,imgProduct,price,unit,create_at,update_at,idCategory) VALUES (:idProduct,:nameProduct,:brandProduct,:descriptionProduct,:statusProduct,:imgProduct,:priceProduct,:unitProduct,:create_at,:update_at,:idCategory)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$id);
        $stmt->bindParam(':nameProduct',$name);
        $stmt->bindParam(':brand',$brand);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':statusProduct',$status);
        $stmt->bindParam(':imgProduct',$img);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':unit',$unit);
        $stmt->bindParam(':create_at',$create);
        $stmt->bindParam(':update_at',$update);
        $stmt->bindParam(':idCategory',$idCategory);
        $stmt->execute();
        $stmt = null;

        // Obtenemos el id del producto recien creado
        $idProduct = $this->dbCon->getConnection()->lastInsertId();

        // Llamamos al procedimiento almacenado para crear el producto en el inventario
        $sql = "CALL CreateProductInventory(:idProduct,:idInventory,:priceInit,:amountInit)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$idProduct,PDO::PARAM_INT);
        $stmt->bindParam(':idInventory',$idInventory,PDO::PARAM_INT);
        $stmt->bindParam(':priceInit',$price);
        $stmt->bindParam(':amountInit',$amount,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt? true : false;
    }



}

?>