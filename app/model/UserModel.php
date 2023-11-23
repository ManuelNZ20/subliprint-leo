<?php
require_once(__DIR__.'/../../config/database.php');

class UserModel {
    
    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function createUser($password,$name,$lastname,$address,$reference,$mail,$phone,$city,$idTypeUser,$create) {
        $sql = "INSERT INTO user (password,name,lastname,address,reference,mail,phone,city,idTypeUser,create_user) VALUES (:password,:name,:lastname,:address,:reference,:mail,:phone,:city,:typeuser,:create_user)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':lastname',$lastname);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':reference',$reference);
        $stmt->bindParam(':mail',$mail);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':typeuser',$idTypeUser);
        $stmt->bindParam(':create_user',$create);
        $stmt->execute();
        return $stmt?true:false;
    }

    public function getUser($mail) {
        $sql = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':mail',$mail);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getUserData($idUser) {
        $sql = "SELECT idUser,
        password,
        name,
        lastname,
        address,
        reference,
        mail,
        phone,
        city,
        idTypeUser,
        create_user,
        update_user
         FROM user 
        WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNameTypeUser($idUser) {
        $sql = "SELECT *,tu.name as nameTypeUser FROM user u INNER JOIN typeuser tu ON u.idTypeUser = tu.idTypeUser WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($idUser,$name,$lastname,$address,$reference,$phone,$city) {
        $sql = "UPDATE user SET name = :name, lastname = :lastname, address = :address, reference = :reference, phone = :phone, city = :city,update_user = :update_user WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':lastname',$lastname);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':reference',$reference);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':update_user',date('Y-m-d'));
        $stmt->execute();
        return $stmt?true:false;
    }

    public function getTypeUser() {
        $sql = "SELECT * FROM typeuser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function detectedAdmin($idUser) {
        $sql = "SELECT idTypeUser FROM user u INNER JOIN typeuser tu ON u.idTypeUser = tu.idTypeUser WHERE idUser = :idUser AND tu.typeUser = 'Administrador'";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function countUser() {
        $sql = "SELECT COUNT(*) FROM user";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUsers() {
        $sql = "SELECT * FROM user";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchUser($name) {
        $sql = "SELECT * FROM user WHERE name LIKE :name";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindValue(':name','%'.$name.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>