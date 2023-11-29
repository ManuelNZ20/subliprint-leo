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

    public function getUserById($idUser) {
        $sql = "SELECT * FROM user WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function activeAccountUserById($idUser) {
        $sql = "UPDATE user SET stateAccount = 1 WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        return $stmt?true:false;
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
        $sql = "UPDATE user SET name = :name, lastname = :lastname, address = :address, reference = :reference, phone = :phone, city = :city, update_user = :update_user WHERE idUser = :idUser";
        
        $update_user = date('Y-m-d');
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':lastname',$lastname);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':reference',$reference);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':update_user',$update_user);
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

    public function updateTypeUser($idUser,$idTypeUser) {
        $sql = "UPDATE user SET idTypeUser = :idTypeUser WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':idTypeUser',$idTypeUser);
        $stmt->execute();
        return $stmt?true:false;
    }
    public function updatePasswordUser($idUser,$password) {
        $sql = "UPDATE user SET password = :password WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':password',$password);
        $stmt->execute();
        return $stmt?true:false;
    }
    
    // Crear un grafico que muestre el total de usuarios por tipo de usuario
    public function listUserTypeChart() {
        $sql = "SELECT tu.name ,COUNT(*) AS total FROM user u INNER JOIN typeuser tu ON u.idTypeUser = tu.idTypeUser 
        GROUP BY tu.idTypeUser;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $stmt->closeCursor();
        return $data;
    }
}
?>