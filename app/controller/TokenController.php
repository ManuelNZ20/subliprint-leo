<?php
// Establecer la hora local
session_start();
date_default_timezone_set('America/Lima');
require_once(__DIR__.'/../model/TokenModel.php');
require_once(__DIR__.'/../model/UserModel.php');
$token = new TokenController();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['btnVerifyToken'])) {
        $tokenPost = $_POST['token-1'].$_POST['token-2'].$_POST['token-3'].$_POST['token-4'].$_POST['token-5'].$_POST['token-6'].$_POST['token-7'].$_POST['token-8'];
        $tokenVerify = $token->getVerifyToken($_POST['idUserToken']);
        if($tokenVerify) {
            if($tokenVerify['token'] == $tokenPost) {
                $idUser = $_POST['idUserToken'];
                unset($_SESSION['idUserToken']);
                header('Location: ../../app/views/auth/resetPassword.php?idUser='.$idUser);
                exit;
            } else {
                $_SESSION['errorToken'] = 'El token es incorrecto';
                header('Location: ../../app/views/auth/verifyToken.php');
                exit;
            }
        } else {
            $_SESSION['errorToken'] = 'El token ha expirado';
            return;
            header('Location: ../../app/views/auth/verifyToken.php');
            exit;
        }
    } elseif(isset($_POST['btnVerifyTokenConfirmRegister'])) {
        $tokenPost = $_POST['token-1'].$_POST['token-2'].$_POST['token-3'].$_POST['token-4'].$_POST['token-5'].$_POST['token-6'].$_POST['token-7'].$_POST['token-8'];
        $tokenVerify = $token->getVerifyToken($_POST['idUserTokenAccount']);
        if($tokenVerify) {
            if($tokenVerify['token'] == $tokenPost) {
                $userModel = new UserModel();
                $idUser = $_POST['idUserTokenAccount'];
                $userModel->activeAccountUserById($idUser);
                $_SESSION['successActiveAccount'] = 'Se ha activado tu cuenta correctamente';
                $_SESSION['stateToken'] = 1;
                unset($_SESSION['idUserToken']);
                unset($_SESSION['stateToken']);
                header('Location: ../../app/views/auth/login.php');
                exit;
            } else {
                $_SESSION['errorTokenAccount'] = 'El token es incorrecto';
                $_SESSION['stateToken'] = 0;
                header('Location: ../../app/views/auth/verifyTokenConfirmRegister.php');
                exit;
            }
        } else {
            $_SESSION['errorTokenAccount'] = 'El token ha expirado';
            $_SESSION['stateToken'] = 0;
            header('Location: ../../app/views/auth/verifyTokenConfirmRegister.php');
            exit;
        }
    }
}

class TokenController {
    private $tokenModel;

    public function __construct() {
        $this->tokenModel = new TokenModel();
    }

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

    public function updateStateToken($idToken,$stateToken) {
        $updateStateToken = $this->tokenModel->updateStateToken($idToken,$stateToken);
        return $updateStateToken?true:false;
    }

    public function getVerifyToken($idUser) {
        $getVerifyToken = $this->tokenModel->getVerifyToken($idUser);
        if($getVerifyToken) { // Si existe el token
            $date = new DateTime($getVerifyToken['expire_token']); // Fecha de creación del token
            $dateNow = new DateTime(); // Fecha actual
            if($dateNow-> format('Y-m-d H:i:s') > $date-> format('Y-m-d H:i:s')) { // Si la fecha actual es mayor a la fecha de creación + 10 minutos
                $_SESSION['errorToken'] = 'El token ha expirado';
                $this->updateStateToken($getVerifyToken['idToken'],'Expirado');
                return false;
            } else {
                return $getVerifyToken;
            }
        } else {
            return false;
        }
        return $getVerifyToken;
    }

}

?>