<?php
require __DIR__.'/../model/ProviderModel.php';
$controllerProvider = new ProviderController();
// crear proveedor
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btnProvider'])) {
        if($_POST['btnProvider']=='Crear') {
            $controllerProvider -> createProvider();
            header('Location: '.'../../app/views/admin/providers.php');
        }elseif($_POST['btnProvider']=='Guardar') {
            $id = $_GET['id'];
            $controllerProvider -> updateProvider($id);
            header('Location: '.'../../app/views/admin/providers.php');
        }
    } 
    // eliminar proveedor
    if (isset($_POST['btnDelete'])) { // si se ha enviado el formulario
        $id = $_GET['id']; // obtener el id del proveedor
        $controllerProvider->deleteProvider($id); // llamar al metodo deleteProvider del controlador
        header('Location: ../../app/views/admin/providers.php'); // redireccionar a la vista de proveedores
    }
}


// eliminar proveedor
class ProviderController {
    private $providerModel;

    public function __construct() {
        $this->providerModel = new ProviderModel();
    }

    public function index() {
        require '../app/views/admin/providers.php';
    }

    public function getProvider() {
        $providers = $this -> providerModel -> getProvider();
        return $providers;
    }
    // buscar al proveedor por id
    public function getProviderById($id) {
        $provider = $this -> providerModel -> getProviderById($id);
        return $provider;
    }


    public function filterProvider() {
        $providers = $this -> providerModel -> filterProvider();
        return $providers;
    }
    // buscar proveedor
    public function searchProvider() {
        // mostrar todos los proveedores
        // conocer que es un método get y que no se ha enviado el formulario

        $providers = $this -> providerModel -> getProvider();
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['search-provider'])) 
            {
            // llamar al metodo searchProvider del modelo
            $providers = $this -> providerModel -> searchProvider();
            }elseif (isset($_GET['filter-provider'])) {
                $providers = $this -> providerModel -> filterProvider();
            }elseif (isset($_GET['all-provider'])) {
                $providers = $this -> providerModel -> getProvider();
            }
        } 
        // buscar proveedor si se ha enviado el formulario
        return $providers;
    }
    // test listCategory
    public function getCategory() {
        $categories = $this -> providerModel -> getCategory();
        return $categories;
    }

    public function createProvider() {
        if(isset($_POST['nameProvider']) &&
           isset($_POST['stateProvider']) &&
           isset($_POST['phoneProvider']) &&
           isset($_POST['addressProvider']) &&
           isset($_POST['emailProvider']) &&
           isset($_POST['dateProvider']) &&
           isset($_POST['descriptionProvider'])
           ) {
            $name = $_POST['nameProvider'];
            $state = $_POST['stateProvider'];
            $phone = $_POST['phoneProvider'];
            $address = $_POST['addressProvider'];
            $email = $_POST['emailProvider'];
            $dateRegister = $_POST['dateProvider'];
            $description = $_POST['descriptionProvider'];
            $create = $this -> providerModel -> createProvider($name, $state, $phone, $address, $email, $dateRegister,$description);
            if($create) {
                echo '<div class="alert alert-success">'.
                    '<strong>Éxito!</strong> Provider creado exitosamente'.
                    '</div>';
                } else {
                echo '<div class="alert alert-danger">'.
                '<strong>Error!</strong> No se pudo crear el proveedor Interno'.
                '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">'.
            '<strong>Error!</strong> No se pudo crear el proveedor Fuera'.
            '</div>';
            return;
        }
    }
    // Actualizar al proveedor
    public function updateProvider($id) {
        if(isset($_POST['nameProvider']) &&
            isset($_POST['stateProvider']) &&
            isset($_POST['phoneProvider']) &&
            isset($_POST['addressProvider']) &&
            isset($_POST['emailProvider']) &&
            isset($_POST['dateProvider']) &&
            isset($_POST['descriptionProvider'])) {

            $name = $_POST['nameProvider'];
            $state = $_POST['stateProvider'];
            $phone = $_POST['phoneProvider'];
            $address = $_POST['addressProvider'];
            $email = $_POST['emailProvider'];
            $dateRegister = $_POST['dateProvider'];
            $description = $_POST['descriptionProvider'];
            echo $description;
            $update = $this -> providerModel -> updateProvider($id, $name, $state, $phone, $address, $email, $dateRegister,$description);
            if($update) {
                echo '<div class="alert alert-success">'.
                    '<strong>Éxito!</strong> Proveedor actualizado exitosamente'.
                    '</div>';
                    return;
                } else {
                    echo '<div class="alert alert-danger">'.
                    '<strong>Error!</strong> No se pudo actualizar el proveedor'.
                    '</div>';
                    return;
                }
            } else {
                echo '<div class="alert alert-danger">'.
                '<strong>Error!</strong> No se pudo actualizar el proveedor'.
                '</div>';
        }
    }

    // eliminar proveedor
    public function deleteProvider($id) {
        $delete = $this -> providerModel -> deleteProvider($id);
        if($delete) {
            echo '<div class="alert alert-success">'.
                '<strong>Éxito!</strong> Proveedor eliminado exitosamente'.
                '</div>';
                return;
            } else {
                echo '<div class="alert alert-danger">'.
                '<strong>Error!</strong> No se pudo eliminar el proveedor'.
                '</div>';
                return;
            }
    }
    public function paginationProvider($pageInit, $pageEnd) {
        $pagination = $this -> providerModel -> paginationProvider($pageInit, $pageEnd);
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['search-provider'])) {
                // llamar al metodo searchProvider del modelo
                $pagination = $this -> providerModel -> searchProvider();
            }elseif (isset($_GET['filter-provider'])) {
                $pagination = $this -> providerModel -> filterProvider();
            }elseif (isset($_GET['all-provider'])) {
                $pagination = $this -> providerModel -> paginationProvider($pageInit, $pageEnd);
            }
        } 
        return $pagination;
    }

}

?>