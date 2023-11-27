<?php
require_once(__DIR__.'/../../config/database.php');
require_once('UserModel.php');
require_once('TokenModel.php');

class AuthModel {
    private $dbCon;
    private $userModel;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
        $this->userModel = new UserModel();
        $this->tokenModel = new TokenModel();
    }

    // Registramos un usuario
    public function register($password,$name,$lastname,$address,$reference,$mail,$phone,$city,$idTypeUser,$create) {
        $registerUser = $this->userModel->createUser($password,$name,$lastname,$address,$reference,$mail,$phone,$city,$idTypeUser,$create);
        return $registerUser?true:false;
    }

    public function getUser($mail) {
        $getUser = $this->userModel->getUser($mail);
        return $getUser;
    }

    public function getUserById($idUser) {
        $getUserById = $this->userModel->getUserById($idUser);
        return $getUserById;
    }

    public function updatePasswordUser($idUser,$newPassword) {
        $updatePasswordUser = $this->userModel->updatePasswordUser($idUser,$newPassword);
        return $updatePasswordUser?true:false;
    }
    // Token Model

    public function getToken($idUser) {
        $getToken = $this->tokenModel->getToken($idUser);
        return $getToken;
    }

    public function updateToken($idToken,$token) {
        $updateToken = $this->tokenModel->updateToken($idToken,$token);
        return $updateToken?true:false;
    }

    public function createToken($idUser,$token,$detailsToken) {
        $createToken = $this->tokenModel->createToken($idUser,$token,$detailsToken);
        return $createToken?true:false;
    }

    

   

    
}

?>