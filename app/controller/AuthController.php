<?php
session_start();
date_default_timezone_set('America/Lima');
require_once(__DIR__.'/../model/AuthModel.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController();
    if(isset($_POST['btnLogin'])) {
        $authController->login();
    } elseif(isset($_POST['btnRegister'])) {
        $authController->createUser();
    }
}


class AuthController {
    private $authModel;
    
    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function index() {
        // Lógica para la página de inicio de sesión
        $title = 'Inicio de sesión';
        include '../app/views/auth/login.php';
    }

    public function show($id) {
        echo "Mostrar usuario #$id";
    }

    public function login () {
        $user = $this->authModel->getUser($_POST['mail']);
        if($user) {
                if(password_verify($_POST['password']
                    ,$user['password'])) {
                    $_SESSION['idUser'] = $user['idUser'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['last_page'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../../../public/';
                    header('Location: ../../../public/'/* .$_SESSION['last_page'] */);
                    exit;
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                            Contraseña incorrecta
                        </div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                El correo electrónico no está registrado
                </div>';
        }
        return;
    }

    public function createUser() {
        $user = $this->authModel->getUser($_POST['mail']);
        if($user) {
                echo '<div class="alert alert-danger" role="alert">
                        El correo electrónico ya está registrado
                    </div>';
                return;
        } else {
            if($_POST['password'] != $_POST['confirmPassword']) {
                echo '<div class="alert alert-danger" role="alert">
                Las contraseñas no coinciden
                </div>';
                return;
            } else {
                if(isset($_POST['name']) && 
                   isset($_POST['lastname']) && 
                   isset($_POST['address']) && 
                   isset($_POST['reference']) &&
                   isset($_POST['mail']) &&
                   isset($_POST['phone']) &&
                   isset($_POST['city'])) {
                    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                    $name = $_POST['name'];
                    $lastname = $_POST['lastname'];
                    $address = $_POST['address'];
                    $reference = $_POST['reference'];
                    $mail = $_POST['mail'];
                    $phone = $_POST['phone'];
                    $city = $_POST['city'];
                    $idTypeUser = $_POST['idTypeUser']??1;
                    $create = date('Y-m-d');
                    $user = $this->authModel->register($password,$name,$lastname,$address,$reference,$mail,$phone,$city,$idTypeUser,$create);
                    if($user) {
                        header('Location: ../../app/views/auth/login.php');
                        exit;
                    } else {
                        echo '<div class="alert alert-danger" role="alert">
                        Error al crear el usuario
                            </div>';
                    }
                }
            }
        }
       
    }

    
}  

?>