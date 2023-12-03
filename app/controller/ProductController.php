<?php
date_default_timezone_set('America/Lima');
require_once(__DIR__.'/../model/ProductsModel.php');
require_once __DIR__.'../../../config/config.php';// configuracion de cloudinary para subir imagenes
require_once(__DIR__.'/ImageControllerCloudinary.php');
$productController = new ProductController();




if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['create-update-product'])) {
        if($_POST['create-update-product']=='Crear') {
            $productController->createImageHelpers();
            $productController->createProduct();
        } elseif($_POST['create-update-product']=='Guardar') {
            $productController->updateProduct();
        }/* elseif($_POST['create-update-product']=='Cancelar') {
            header('Location: ../../app/views/admin/products.php?idInventory='.$_POST['idInventory']);
        } */
    } elseif(isset($_POST['btnDelete'])) {
        $productController->deleteProduct();
    } 
}

// ProductController.php
class ProductController
{
    private $productModel;
    private $upload;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->upload = new ImageControllerCloudinary();
    }
    public function index()
    {
        // Lógica para la página de productos
        $title = 'Productos';
        include '../app/views/products/products.php';
    }

    public function show($id)
    {
        echo "Mostrar producto #$id";
    }

    public function countProducts($idInventory) {
        $count = $this->productModel->countProducts($idInventory);
        return $count;
    }

    public function createIdUUID() {
        $id = $this->productModel->createIdUUID();
        return $id;
    }

    public function getProductsByIdInventory($idInventory) {
        $products = $this->productModel->getProductsByIdInventory($idInventory);
        return $products;
    }

    public function createProduct() {
        if(isset($_POST['idInventory'])
        && isset($_POST['amountProduct'])
        && isset($_POST['idProduct'])
        && isset($_POST['nameProduct'])
        && isset($_POST['brandProduct'])
        && isset($_POST['descriptionProduct'])
        && isset($_POST['statusProduct'])
        && isset($_POST['priceProduct'])
        && isset($_POST['unitProduct'])
        && isset($_POST['categoryProduct'])
        && isset($_POST['expireProduct'])
            ) {

            if($_FILES['imgProduct']['name']!=="") {
                $imgProduct = $_FILES['imgProduct']['name'];
                // $route = $_SERVER['DOCUMENT_ROOT'].'/roberto-cotlear/app/controller/helpers/';
                $route = __DIR__.'/helpers/';
                $uploadSecure = $this->upload->uploadImage($imgProduct,$route);
                $this->deleteImageHelpers($imgProduct);
            } else {
                header('Location: ../../app/views/admin/products.php');
            }
            $idInventory = $_POST['idInventory'];
            $amount = $_POST['amountProduct'];
            $id = $_POST['idProduct'];
            $name = $_POST['nameProduct'];
            $brand = $_POST['brandProduct'];
            $description = $_POST['descriptionProduct'];
            $status = $_POST['statusProduct'];
            $img = $uploadSecure;
            $price = $_POST['priceProduct'];
            $unit = $_POST['unitProduct'];
            $create = date('Y-m-d H:i:s');
            $update = date('Y-m-d H:i:s');
            $expire = $_POST['expireProduct'];
            $idCategory = $_POST['categoryProduct'];
            $product = $this->productModel->createProduct($idInventory,$amount,$id,$name,$brand,$description,$status,$img,$price,$unit,$create,$update,$idCategory,$expire);
            
            if($product) {
                $this->deleteImageHelpers($imgProduct);
                header('Location: ../../app/views/admin/products.php?idInventory='.$idInventory);
            } else {
                $this->deleteImageHelpers($imgProduct);
                header('Location: ../../app/views/admin/products.php');
            }
        }else {
            echo 'Error al crear el producto';
            return;
        }
    }

    public function updateProduct() {
        if(isset($_POST['idInventory'])
        && isset($_POST['amountProduct'])
        && isset($_POST['idProduct'])
        && isset($_POST['nameProduct'])
        && isset($_POST['brandProduct'])
        && isset($_POST['descriptionProduct'])
        && isset($_POST['statusProduct'])
        && isset($_POST['priceProduct'])
        && isset($_POST['unitProduct'])
        && isset($_POST['categoryProduct'])
        && isset($_POST['expireProduct'])
        ) {
            // si se sube una imagen, se elimina la imagen anterior y se sube la nueva
            $idInventory = $_POST['idInventory'];// id del inventario, nos permite redireccionar a la pagina de productos segun el inventario
            $amount = $_POST['amountProduct'];
            $id = $_POST['idProduct'];
            $name = $_POST['nameProduct'];
            $brand = $_POST['brandProduct'];
            $description = $_POST['descriptionProduct'];
            $status = $_POST['statusProduct'];
            $price = $_POST['priceProduct'];
            $unit = $_POST['unitProduct'];
            $update_product = date('Y-m-d H:i:s');
            $update = $update_product;
            $expire = $_POST['expireProduct'];
            $idCategory = $_POST['categoryProduct'];
            $imgInit =    $this->productModel->getProductByIdInventoryByProduct($id)['imgProduct']; // obtener la imagen anterior
            if($_FILES['imgProduct']['name']!=="") {
                $this->upload->deleteImage($imgInit); // eliminar imagen anterior
                $this->createImageHelpers();
                $imgProduct = $_FILES['imgProduct']['name'];
                // Que la ruta no dependa del nombre de la carpeta del proyecto osea sin el nombre de roberto-cotlear
                $route = __DIR__.'/helpers/';
                // $route = $_SERVER['DOCUMENT_ROOT'].'//app/controller/helpers/';
                $uploadSecure = $this->upload->uploadImage($imgProduct,$route); // subir imagen a cloudinary
                $img = $uploadSecure;
            }else {
                $img = $imgInit;
            }
            
            $product = $this->productModel->updateProduct($amount,$id,$name,$brand,$description,$status,$img,$price,$unit,$update,$idCategory,$expire);
            
            if($product) {
                $this->deleteImageHelpers($imgProduct);
                header('Location: ../../app/views/admin/products.php?idInventory='.$idInventory);
            } else {
                $this->deleteImageHelpers($imgProduct);
                header('Location: ../../app/views/admin/products.php');
            }
        }else {
            echo 'Error al crear el producto';
            exit;
        }
    }

    public function getMostProductSold() {
        $products = $this->productModel->getMostProductSold();
        return $products;
    }

    public function deleteProduct() {
        if(isset($_GET['id'])
        &&isset($_GET['idInventory'])) {
            $id = $_GET['id'];
            $idInventory = $_GET['idInventory'];
            $productImg = $this->getProductByIdInventoryByProduct($id);
            $img = $productImg['imgProduct'];
            $this->upload->deleteImage($img);
            $product = $this->productModel->deleteProduct($id);
            if($product) {
                $this->deleteImageHelpers($img);
                header('Location: ../../app/views/admin/products.php?idInventory='.$idInventory);
            } else {
                $this->deleteImageHelpers($imgProduct);
                header('Location: ../../app/views/admin/products.php?idInventory='.$idInventory);
            }
        }
    }
    // Obtenemos el producto por id de producto
    public function getProductByIdInventoryByProduct($idProduct) {
        $product = $this->productModel->getProductByIdInventoryByProduct($idProduct);
        return $product;
    }
    //TODO:Implementar en el product el metodo searchProduct
    public function searchProduct($idInventory,$search) {
        $products = $this->productModel->searchProduct($idInventory,$search);
        return $products;
    }

    public function paginationProduct($idInventory,$init,$end) {
        $products = $this->productModel->paginationProduct($idInventory,$init,$end);
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['search-product'])) {
                $search = $_GET['term'];
                $products = $this->productModel->searchProduct($idInventory,$search);
                return $products;
            }elseif(isset($_GET['filter-product'])) {
                $idCategory = $_GET['filterCategory'];
                $products = $this->productModel->filterProductsByCategory($idInventory,$idCategory);
            } else if(isset($_GET['all-product'])) {
                $products = $this->productModel->paginationProduct($idInventory,$init,$end);
            }
        }
        return $products;
    }

    public function getProducts() {
        $products = $this->productModel->getProducts();
        return $products;
    }

    public function getProductsRand() {
        $products = $this->productModel->getProductsRand();
        return $products;
    }

    public function getProductsByCategory() {
        $products = $this->productModel->getProducts();
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['filter-productCategory'])) {
                $idCategory = $_GET['filterCategory'];
                $products = $this->productModel->getProductsByCategory($idCategory);
                return $products;
            } else if(isset($_GET['all-product'])) {
                $products = $this->productModel->getProducts();
                return $products;
            }
        }
        return $products;
    }

    public function listProductsCategoryChart() {
        $products = $this->productModel->listProductsCategoryChart();
        return $products;
    }

    // AlMACENAR IMAGENES TEMPORALES
    public function createImageHelpers() {
        $fileName = $_FILES['imgProduct']['name'];
        $tmp = $_FILES['imgProduct']['tmp_name'];
        if($tmp!="") {
            move_uploaded_file($tmp,'helpers/'.$fileName);
        }
    }
    // eliminar imagen de la carpeta
    public function deleteImageHelpers($img) {
        if (file_exists('helpers/' . $img)) {
            unlink('helpers/' . $img);
        }
    }

}

?>