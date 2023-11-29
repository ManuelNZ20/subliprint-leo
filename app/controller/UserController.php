<?php
require_once(__DIR__.'/../model/UserModel.php');

$userController = new UserController();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btn-updateUser'])) {
        $idUser = $_POST['idUser'];
        $name = $_POST['nameUser'];
        $lastname = $_POST['lastnameUser'];
        $address = $_POST['addressUser'];
        $reference = $_POST['addressReference'];
        $phone = $_POST['phoneUser'];
        $city = $_POST['cityUser'];
        $updateUser = $userController->updateUser($idUser,$name,$lastname,$address,$reference,$phone,$city);
    } elseif(isset($_POST['btnConfirm'])) {
        $idUser = $_POST['idUser'];
        $typeUser = $_POST['typeUser'];
        $updateUser = $userController->updateTypeUser($idUser,$typeUser);
    }
}


class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getUser($mail) {
        $user = $this->userModel->getUser($mail);
        return $user;
    }

    public function detectedAdmin($idUser) {
        $detectedAdmin = $this->userModel->detectedAdmin($idUser);
        return $detectedAdmin?true:false;
    }

    public function getUserData($idUser) {
        $userData = $this->userModel->getUserData($idUser);
        return $userData;
    }
    
    public function getNameTypeUser($idUser) {
        $nameTypeUser = $this->userModel->getNameTypeUser($idUser);
        return $nameTypeUser;
    }


    public function countUser() {
        $countUser = $this->userModel->countUser();
        return $countUser;
    }

    public function getUsers() {
        $users = $this->userModel->getUsers();
        return $users;
    }

    public function updateTypeUser($idUser,$typeUser) {
        $updateTypeUser = $this->userModel->updateTypeUser($idUser,$typeUser);
        if($updateTypeUser)
        {   
            session_start();
            $_SESSION['messageUser'] = 'Se actualizo el tipo de usuario';
            header('location: ../../app/views/admin/users.php');
        }
        return $updateTypeUser?true:false;
    }

    public function updateUser($idUser,$name,$lastname,$address,$reference,$phone,$city) {
        $updateUser = $this->userModel->updateUser($idUser,$name,$lastname,$address,$reference,$phone,$city);
        return $updateUser?true:false;
    }

    public function searchUser() {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(isset($_GET['search-user'])) {
                $term = $_GET['term'];
                $searchUser = $this->userModel->searchUser($term);
                return $searchUser;
            } elseif(isset($_GET['all-user'])) {
                return $this->getUsers();
            } else {
                return $this->getUsers();
            }
        }
    }

     // Crear un grafico que muestre el total de usuarios por tipo de usuario
    public function listUserTypeChart() {
        $listUserTypeChart = $this->userModel->listUserTypeChart();
        return $listUserTypeChart;
    }
}

?>