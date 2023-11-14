<?php
require_once(__DIR__.'/../../config/database.php');
require_once('UserModel.php');

class AuthModel {
    private $dbCon;
    private $userModel;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
        $this->userModel = new UserModel();

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

   

    
}

?>