<?php
include '../../../config/config.php';

class ConnectionDataBase {
    private $con;

    public function __construct()
    {
        $this->con = new PDO("mysql:host=".HOST.";dbname=".BASE.";port=".PORT, USER, PASS);
        if (!$this->con) {
            echo "Error en la conexión";
            exit;
        } else {
            echo "Conexión exitosa";
            return;
        }
        echo '<br>FAKNSKL';
    }

    public function getConnection()
    {
        return $this->con;
    }

}
?>