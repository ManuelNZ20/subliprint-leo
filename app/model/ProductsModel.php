<?php
require_once(__DIR__.'/../../config/database.php');

class ProductModel {
    private $dbCon;
    
    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }
    //  Obtenemos el número de productos de la tabla productinventory por id de inventario
    public function countProducts($idInventory) {
        $sql = "SELECT COUNT(*) AS products FROM productinventory WHERE idInventory = :idInventory";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idInventory',$idInventory,PDO::PARAM_INT);
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
        $sql = "INSERT INTO product (idProduct,nameProduct,brand,description,statusProduct,imgProduct,price,unit,create_at,update_at,idCategory) VALUES 
         (:idProduct,:nameProduct,:brand,:description,:statusProduct,:imgProduct,:price,:unit,:create_at,:update_at,:idCategory)";
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

        // Obtenemos el id del producto recien creado
        $idProduct = $id;

        // Llamamos al procedimiento almacenado para crear el producto en el inventario
        $sql = "CALL CreateProductInventory(:idProduct,:idInventory,:priceInit,:amountInit)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$idProduct,PDO::PARAM_STR);
        $stmt->bindParam(':idInventory',$idInventory,PDO::PARAM_INT);
        $stmt->bindParam(':priceInit',$price);
        $stmt->bindParam(':amountInit',$amount,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt? true : false;
    }

    // Eliminamos un producto de la tabla products y de la tabla productinventory
    public function deleteProduct($idProduct) {
        $sql = "CALL DeleteProduct(:idProduct)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$idProduct,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt? true : false;
    }

    public function updateProdudct($amount,$id,$name,$brand,$description,$status,$img,$price,$unit,$update,$idCategory) {
        // Actualizar producto
        $sql = "UPDATE product SET nameProduct = :nameProduct, brand = :brand, description = :description, statusProduct = :statusProduct, imgProduct = :imgProduct, price = :price, unit = :unit, update_at = :update_at, idCategory = :idCategory WHERE idProduct = :idProduct";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$id);
        $stmt->bindParam(':nameProduct',$name);
        $stmt->bindParam(':brand',$brand);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':statusProduct',$status);
        $stmt->bindParam(':imgProduct',$img);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':unit',$unit);
        $stmt->bindParam(':update_at',$update);
        $stmt->bindParam(':idCategory',$idCategory);
        $stmt->execute();
        // Actualizar producto en el inventario
        $sql = "CALL UpdateProductInventory(:idProduct,:priceInit,:amountInit)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$id,PDO::PARAM_STR);
        $stmt->bindParam(':priceInit',$price);
        $stmt->bindParam(':amountInit',$amount,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt? true : false;
    }

    // Obtenemos el producto por id de producto
    public function getProductByIdInventoryByProduct($idProduct) {
        $sql = 'CALL GetProductByIdProduct(:idProduct)';
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idProduct',$idProduct,PDO::PARAM_STR);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function paginationProduct($idInventory,$pageInit,$pageEnd) {
        $sql = "CALL GetProductsByInventoryPagination(:idInventory,:pageInit,:pageEnd)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idInventory',$idInventory,PDO::PARAM_INT);
        $stmt->bindParam(':pageInit',$pageInit,PDO::PARAM_INT);
        $stmt->bindParam(':pageEnd',$pageEnd,PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function searchProduct($idInventory,$search) {
        $sql = "CALL SearchProduct(:idInventory,:search)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idInventory',$idInventory,PDO::PARAM_INT);
        $stmt->bindParam(':search',$search);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function filterProductsByCategory($idInventory,$idCategory) {
        if($idCategory=='all') {
            return $this->getProductsByIdInventory($idInventory);
        }
        else 
        {
            return $this->getProductsByInventoryAndCategory($idInventory,$idCategory);
        }
    }

    // Filtrar productos por id de categoria para la pagina principal
    public function getProductsByCategory($idCategory) {
        $sql = "SELECT 
        p.idProduct,
        p.nameProduct,
        p.brand,
        p.description,
        p.statusProduct,
        p.imgProduct,
        p.price,
        p.unit,
        p.create_at,
        p.update_at,
        c.nameCategory,
        pi.amountInit
    FROM product p
    INNER JOIN category c ON p.idCategory = c.idCategory
    INNER JOIN productinventory pi ON pi.idProduct = p.idProduct
    INNER JOIN inventory ip ON ip.idInventory = pi.idInventory
    WHERE p.idCategory = :idCategory AND pi.amountInit > 0 AND p.statusProduct = 'activo'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idCategory',$idCategory,PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getProductsByInventoryAndCategory($idInventory,$idCategory) {
        $sql = "CALL GetProductsByInventoryAndCategory(:idInventory,:idCategory)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idInventory',$idInventory,PDO::PARAM_INT);
        $stmt->bindParam(':idCategory',$idCategory,PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getProducts() {
        $sql = "SELECT * FROM product p 
        INNER JOIN productinventory pi 
        ON pi.idProduct=p.idProduct WHERE pi.amountInit > 0 AND p.statusProduct = 'activo'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getProductsRand() {
        $sql = "SELECT * FROM product p 
        INNER JOIN productinventory pi 
        ON pi.idProduct=p.idProduct WHERE pi.amountInit > 0 AND p.statusProduct = 'activo' ORDER BY RAND() LIMIT 10";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }


}
?>