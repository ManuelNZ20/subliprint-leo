<?php
require_once(__DIR__.'/../../config/database.php');


class InfoPageModel {

    private $dbCon;

    public function __construct() {
        $this->dbCon = new ConnectionDataBase();
    }

    public function getInformationPage() {
        $sql = "SELECT * FROM infopage";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }
    
    public function updateInformationPage($name,$ruc,$address,$phone,$email,$dollarValue) {
        $sql = "UPDATE infopage SET name=:name,ruc=:ruc,address=:address,phone=:phone,email=:email,dollarValue=:dollarValue WHERE id=1";
        $stmt = $this->dbCon->getConnection()->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':ruc',$ruc);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':dollarValue',$dollarValue);
        $stmt->execute();
        $stmt->closeCursor();
        return $stmt?true:false;
    }

}

?>