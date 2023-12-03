<?php
require_once(__DIR__.'/../model/InfoPageModel.php');
$controllerInfoPage = new InfoPageController();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btnUpdateInfoPage'])) {
        $controllerInfoPage -> updateInformationPage();
    }
}

class InfoPageController {

    private $infoPageModel;

    public function __construct() {
        $this->infoPageModel = new InfoPageModel();
    }


    public function getInformationPage() {
        $data = $this->infoPageModel->getInformationPage();
        return $data;
    }

    public function updateInformationPage() {
        if($_POST['name'] && $_POST['ruc'] && $_POST['address'] && $_POST['phone'] && $_POST['email'] && $_POST['dollarValue']) {
            try {
                $name = $_POST['name'];
                $ruc = $_POST['ruc'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $dollarValue = $_POST['dollarValue'];
                $update = $this->infoPageModel->updateInformationPage($name,$ruc,$address,$phone,$email,$dollarValue);
                if($update) {
                    session_start();
                    $_SESSION['messageInfoPage'] = 'Se actualizo la informacion de la pagina';
                    header('Location: '.'../../app/views/admin/admin.php');
                }
                else {
                    session_start();
                    $_SESSION['messageInfoPage'] = 'No se actualizo la informacion de la pagina';
                    header('Location: '.'../../app/views/admin/admin.php');
                    
                }
            } catch (\Throwable $th) {
                echo "Error al actualizar la informacion de la pagina".$th->getMessage();
            }
        }
    }



}

?>