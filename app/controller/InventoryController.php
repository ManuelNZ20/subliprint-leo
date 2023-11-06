<?php
require __DIR__.'/../model/InventoryModel.php';
$controllerInventory = new InventoryController();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btnInventory'])) {
        if($_POST['btnInventory']=='Crear') {
            $controllerInventory -> createInventory();
        }
    }
    if (isset($_POST['btnDelete'])) { // si se ha enviado el formulario
        $controllerInventory->deleteInventory(); // llamar al metodo deleteInventory del controlador
        header('Location: ../../app/views/admin/inventory.php'); // redireccionar a la vista de inventarios
    }
}


class InventoryController {
    private $inventoryModel;
    
    public function __construct() {
        $this->inventoryModel = new InventoryModel();
    }

    public function index() {
        require '../app/views/admin/inventory.php';
    }

    public function getInventory() {
        $inventory = $this -> inventoryModel -> getInventory();
        return $inventory;
    }

    public function getInventoryById($id) {
        $inventory = $this -> inventoryModel -> getInventoryById($id);
        return $inventory;
    }

    public function createInventory() {
        if($_POST['dateInventory']
        && $_POST['idProvider'] 
        && $_POST['noteInventory'])  {
            try {
                $date = $_POST['dateInventory'];
                $idProvider = $_POST['idProvider'];
                $note = $_POST['noteInventory'];
                $create = $this -> inventoryModel -> createInventory($date,$idProvider,$note);
                if($create) {
                    echo 'Creado correctamente';
                    header('Location: '.'../../app/views/admin/inventory.php');
                }
                else {
                    echo "Error al crear el inveddntario";
                    
                }
            } catch (\Throwable $th) {
                echo "Error al crear edsdsdl inventario".$th->getMessage();
            }
        }
    }


    public function deleteInventory() {
        if($_GET['id']) {
            $id = $_GET['id']; // obtener el id del inventario
            $this->inventoryModel->deleteInvetory($id); // llamar al metodo deleteInventory del modelo
            header('Location: ../../app/views/admin/inventory.php'); // redireccionar a la vista de inventarios
        }
    }

    public function countInventory() {
        $count = $this -> inventoryModel -> counInvetory();
        return $count;
    }

    
    public function paginationInventory($pageInit, $pageEnd) {
        $pagination = $this -> inventoryModel -> paginationInventory($pageInit, $pageEnd);
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['search-inventory'])) {
                $pagination = $this -> inventoryModel -> searchInventory();
            } elseif (isset($_GET['all-inventory'])) {
                $pagination = $this -> inventoryModel -> paginationProvider($pageInit, $pageEnd);
            }
        } 
        return $pagination;
    }
}
?>