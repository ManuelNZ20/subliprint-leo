<?php
require_once(__DIR__.'/../../config/database.php');

class TokenModel {

    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function getToken($idUser) {
        $sql = "SELECT * FROM token WHERE idUser = :idUser";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createToken($idUser,$token,$detailsToken) {
        $sql = "INSERT INTO token (idUser,token,detailsToken) VALUES (:idUser,:token,:detailsToken)";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->bindParam(':token',$token);
        $stmt->bindParam(':detailsToken',$detailsToken);
        $stmt->execute();
        return $stmt?true:false;
    }

    public function updateToken($idToken,$token) {
        $sql = "UPDATE token SET token=:token WHERE idToken=:idToken";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':token',$token);
        $stmt->bindParam(':idToken',$idToken);
        $stmt->execute();
        return $stmt?true:false;
    }

    public function getVerifyToken($idUser) {
        // script para activar un trigger
        $sql = "SELECT * FROM token WHERE token.idUser=:idUser AND stateToken='Habilitado'
        ORDER BY create_token DESC LIMIT 1;";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':idUser',$idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStateToken($idToken,$stateToken) {
        $sql = "UPDATE token SET stateToken=:stateToken WHERE idToken=:idToken";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':stateToken',$stateToken);
        $stmt->bindParam(':idToken',$idToken);
        $stmt->execute();
        return $stmt?true:false;
    }

}
?>