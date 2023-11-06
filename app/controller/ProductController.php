<?php
    session_start();
?>
<?php
require_once(__DIR__.'/../model/ProductsModel.php');
// ProductController.php
class ProductController
{
    private $productModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
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
        if(isset($_POST['create-product'])) {
            $idInventory = $_POST['idInventory'];
            $amount = $_POST['amount'];
            $id = $_POST['id'];
            $name = $_POST['name'];
            $brand = $_POST['brand'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $img = $_POST['img'];
            $price = $_POST['price'];
            $unit = $_POST['unit'];
            $create = $_POST['create_at'];
            $update = $_POST['update_at'];
            $idCategory = $_POST['idCategory'];
            $product = $this->productModel->createProduct($idInventory,$amount,$id,$name,$brand,$description,$status,$img,$price,$unit,$create,$update,$idCategory);
            
            if($product) {
                $_SESSION['message'] = 'Producto creado correctamente';
                $_SESSION['message_type'] = 'success';
                header('Location: ../views/admin/products.php');
            } else {
                $_SESSION['message'] = 'Error al crear el producto';
                $_SESSION['message_type'] = 'danger';
                header('Location: ../views/admin/products.php');
            }
        }
    }


}

?>