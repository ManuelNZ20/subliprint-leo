<?php
include '../../../app/model/ProviderModel.php';

$contollerProvider = new ProviderController();

// crear proveedor
if(isset($_POST['createProvider'])) {
    $contollerProvider -> createProvider();
    return;
}


class ProviderController {
    private $providerModel;

    public function __construct() {
        $this->providerModel = new ProviderModel();
    }

    public function index() {
        include '../app/views/admin/providers.php';
    }

    public function getProvider() {
        $providers = $this -> providerModel -> getProvider();
        return $providers;
    }

    // test listCategory
    public function getCategory() {
        $categories = $this -> providerModel -> getCategory();
        return $categories;
    }

    public function createProvider() {
        if(isset($_POST['name']) && isset($_POST['state']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['email']) && isset($_POST['dateRegister'])) {
            $name = $_POST['name'];
            $state = $_POST['state'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $dateRegister = $_POST['dateRegister'];

            $create = $this -> providerModel -> createProvider($name, $state, $phone, $address, $email, $dateRegister);
            if($create) {
                echo "Proveedor creado";
                header('Location: ../app/views/admin/providers.php');
            } else {
                echo "Error al crear proveedor";
            }
        } else {
            echo "Error al crear proveedor";
        }
    }



}

?>