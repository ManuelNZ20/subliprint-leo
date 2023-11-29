<?php
error_reporting(E_ALL); // Error/Exception engine, always use E_ALL permite mostrar todos los errores
ini_set('display_errors', 1); // Error/Exception display, use ini_set to override permite mostrar todos los errores
session_start();
date_default_timezone_set('America/Lima');
require_once(__DIR__.'/../model/AuthModel.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController();
    if(isset($_POST['btnLogin'])) {
        $authController->login();
    } elseif(isset($_POST['btnRegister'])) {
        $authController->createUser();
    } elseif(isset($_POST['btnRecoverPassword'])) {
        $authController->recoverPassword();
    } elseif(isset($_POST['btnResetPassword'])) {
        $authController->resetPassword();
    } elseif(isset($_POST['btnSendMailContact'])) {
        $authController->sendMailContact();
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
            if($user['stateAccount'] == 0) {
              $_SESSION['error'] = 'La cuenta no está activada, verifica tu correo electrónico';
              header('Location: ../../app/views/auth/login.php');
              exit;
            }
            if(password_verify($_POST['password']
            ,$user['password'])) {
              $_SESSION['idUser'] = $user['idUser'];
              $_SESSION['name'] = $user['name'];
              header('Location: '.$_SESSION['last_page'] ?? '../../app/views/home/home.php');
              exit;
          } else {
              $_SESSION['error'] = 'La contraseña es incorrecta';
              header('Location: ../../app/views/auth/login.php');
              exit;
          }
        } else {
            $_SESSION['error'] = 'El correo electrónico no está registrado';
            header('Location: ../../app/views/auth/login.php');
            exit;
        }
    }

    public function createUser() {
        $user = $this->authModel->getUser($_POST['mail']);
        if($user) {
            $_SESSION['messageCreateUser'] = 'El correo electrónico ya está registrado';
            header('Location: ../../app/views/auth/checkIn.php');
        } else {
            if($_POST['password1'] != $_POST['password2']) {
                $_SESSION['messageCreateUser'] = 'Las contraseñas no coinciden';
                header('Location: ../../app/views/auth/checkIn.php');
            } else {
                if(isset($_POST['name']) && 
                   isset($_POST['lastname']) && 
                   isset($_POST['address']) && 
                   isset($_POST['reference']) &&
                   isset($_POST['mail']) &&
                   isset($_POST['phone']) &&
                   isset($_POST['city'])) {
                    $password = password_hash($_POST['password1'],PASSWORD_DEFAULT);
                    $name = $_POST['name'];
                    $lastname = $_POST['lastname'];
                    $address = $_POST['address'];
                    $reference = $_POST['reference'];
                    $mail = $_POST['mail'];
                    $phone = $_POST['phone'];
                    $city = $_POST['city'];
                    $idTypeUser = $_POST['idTypeUser'] ?? 1;
                    $create = date('Y-m-d');
                    $user = $this->authModel->register($password,$name,$lastname,$address,$reference,$mail,$phone,$city,$idTypeUser,$create);
                    if($user) {
                        // Enviar un correo electrónico para confirmar el correo electrónico del usuario
                        $tokenUser = bin2hex(random_bytes(4));
                        $user = $this->authModel->getUser($mail);
                        $token = $this->authModel->createToken($user['idUser'],$tokenUser,'Confirmar cuenta');
                        $this->sendMailTokenConfirmAccount($user['idUser'],$user['mail'],$tokenUser);
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

    // función para que el usuario nos envie un mensaje de correo electronico desde el formulario de contacto
    public function sendMailContact() {
        $user_email = $_ENV['USER_EMAIL'];
        $user_password = $_ENV['USER_PASSWORD'];
        $the_subject = 'Contacto';
        $address_to = $_POST['mail'];
        $subject = $_POST['subject'];
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->Username = $user_email; // Correo completo a utilizar
        $mail->Password = $user_password; // Contraseña
        $mail->SMTPSecure = 'ssl';
        $mail->Host  = 'smtp.gmail.com'; // Servidor SMTP
        $mail->Port = 465; // Puerto SMTP en el servidor SMTP
        $mail->FromName = 'Ferretería Roberto Cotlear';
        $mail->From = $user_email; // Desde donde enviamos (Para mostrar)
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->AddAddress($user_email); // Esta es la dirección a donde enviamos
        $mail->IsHTML(true); // El correo se envía como HTML
        $mail->Subject = 'Contacto'; // Este es el titulo del email.
        $mail->Body = '<!DOCTYPE html>'.
        '<html lang="en">'.
        '<head>
            <title>Contacto</title>
        </head>'.
        '<body>'.
            '<footer style="background-color: #f8f9fa; padding: 25px 0; margin-top: 25px;">'.
                '<div class="container">'.
                    '<div class="row">'.
                        '<div class="col-md-12">'.
                        '<h1 style="text-align: center;">Ferretería Roberto Cotlear</h1>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</footer>'.
        '<main style="padding: 25px 0; margin-top: 25px;">'.
            '<div class="container">'.
                '<div class="row">'.
                    '<div class="col-md-12">'.
                        '<div class="">'.
                            '<div class="">'.
                            '<h1>Contacto</h1>'.
                            '<p>De: '.$address_to.'</p>'.
                            '<p>'.$subject.'</p>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</div>'.
        '</main>'.
        '<header style="background-color: #f8f9fa; padding: 25px 0; margin-top: 25px;">'.
            '<div class="container">'.
            '<div class="row">'.
            '<div class="col-md-12">'.
                '<p style="text-align: center;">Av. Sanchez Cerro 929-633</p>'.
                '<p style="text-align: center;">Teléfono: 969518850</p>'.
                '<p style="text-align: center;">Correo electrónico: ventas@ferreteriacotlear.com</p>'.
                '<p style="text-align: center;">Horario de atención: Lunes a Sábado de 8:00 a.m. a 6:00 p.m.</p>'.
                '<p style="text-align: center;">Domingos de 8:00 a.m. a 1:00 p.m.</p>'.
                '<p style="text-align: center;">Feriados de 8:00 a.m. a 1:00 p.m.</p>'.
            '</div>'.
            '</div>'.
            '</div>'.
        '</header>'.
        '</body>'.
        '</html>';
        $mail->AltBody = 'Este es el mansaje en texto plano para clientes que no admitan HTML';
        $mail->CharSet = 'UTF-8';
        if(!$mail->Send()) {
            $_SESSION['messageSendMail'] = 'Error al enviar el correo electrónico: '. $mail->ErrorInfo;
            header('Location: ../../app/views/about/contact.php');
            exit;
        } else {
            $_SESSION['messageSendMail'] = 'Mensaje enviado correctamente';
            header('Location: ../../app/views/about/contact.php');
            exit;
        }
    }


    public function sendMailTokenConfirmAccount($idUser,$mail,$token) {
        $user = $this->authModel->getUser($mail);
        $user_email = $_ENV['USER_EMAIL'];
        $user_password = $_ENV['USER_PASSWORD'];
        $the_subject = 'Recuperar contraseña';
        $address_to = $mail;
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->Username = $user_email; // Correo completo a utilizar
        $mail->Password = $user_password; // Contraseña
        $mail->SMTPSecure = 'ssl';
        $mail->Host  = 'smtp.gmail.com'; // Servidor SMTP
        $mail->Port = 465; // Puerto SMTP en el servidor SMTP
        $mail->FromName = 'Ferretería Roberto Cotlear';
        $mail->From = $user_email;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->AddAddress($address_to); // Esta es la dirección a donde enviamos
        $mail->IsHTML(true);
        $mail->Subject = 'Confirmar cuenta'; // Este es el titulo del email.
        $mail->Body = '<!DOCTYPE html>'.
        '<html lang="en">'.
        '<head>
            <title>Confirmar cuenta</title>
        </head>'.
        '<body>'.
            '<footer style="background-color: #f8f9fa; padding: 25px 0; margin-top: 25px;">'.
                '<div class="container">'.
                    '<div class="row">'.
                        '<div class="col-md-12">'.
                        '<h1 style="text-align: center;">Ferretería Roberto Cotlear</h1>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</footer>'.
        '<main style="padding: 25px 0; margin-top: 25px;">'.
            '<div class="container">'.
                '<div class="row">'.
                    '<div class="col-md-12">'.
                        '<div class="">'.
                            '<div class="">'.
                            '<h1>Confirmar cuenta</h1>'.
                            '<p>Hola '.$user['name'].' '.$user['lastname'].'.</p>'.
                            '<p>Gracias por registrarte en Ferretería Roberto Cotlear.</p>'.
                            '<p>Para confirmar tu cuenta, ingresa el siguiente token:'.
                            '<strong>'.$token.'</strong></p>'.
                            '<p>Si tienes alguna pregunta, no dudes en ponerte en contacto con nosotros.</p>'.
                            '<p>Saludos cordiales, Ferretería Roberto Cotlear</p>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</div>'.
        '</main>'.
        '<header style="background-color: #f8f9fa; padding: 25px 0; margin-top: 25px;">'.
            '<div class="container">'.
            '<div class="row">'.
            '<div class="col-md-12">'.
                '<p style="text-align: center;">Av. Sanchez Cerro 929-633</p>'.
                '<p style="text-align: center;">Teléfono: 969518850</p>'.
                '<p style="text-align: center;">Correo electrónico:ventas@ferreteriacotlear.com</p>'.
                '<p style="text-align: center;">Horario de atención: Lunes a Sábado de 8:00 a.m. a 6:00 p.m.</p>'.
                '<p style="text-align: center;">Domingos de 8:00 a.m. a 1:00 p.m.</p>'.
                '<p style="text-align: center;">Feriados de 8:00 a.m. a 1:00 p.m.</p>'.
            '</div>'.
            '</div>'.
            '</div>'.
        '</header>'.
        '</body>'.
        '</html>';
        $mail->AltBody = 'Este es el mansaje en texto plano para clientes que no admitan HTML';
        $mail->CharSet = 'UTF-8';
        if(!$mail->Send()) {
            $_SESSION['errorMail'] = 'Error al enviar el correo electrónico: '. $mail->ErrorInfo.'confirme su cuenta';
            header('Location: ../../app/views/auth/login.php');
            exit;
        } else {
            // enviar el idUser con el metodo get
            $_SESSION['successMailAccount'] = 'Tu cuenta se ha creado correctamente, verifica tu correo electrónico';
            $_SESSION['user'] = $user;
            header('Location: ../../app/views/auth/verifyTokenConfirmRegister.php');
            exit;
        }
    }

    public function sendMailTokenPasswork($idUser,$mail,$token) {
        $user = $this->authModel->getUser($mail);
        $user_email = $_ENV['USER_EMAIL'];
        $user_password = $_ENV['USER_PASSWORD'];
        $the_subject = 'Recuperar contraseña';
        $address_to = $mail;
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->Username = $user_email; // Correo completo a utilizar
        $mail->Password = $user_password; // Contraseña
        $mail->SMTPSecure = 'ssl';
        $mail->Host  = 'smtp.gmail.com'; // Servidor SMTP
        $mail->Port = 465; // Puerto SMTP en el servidor SMTP
        $mail->FromName = 'Ferretería Roberto Cotlear';
        $mail->From = $user_email;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->AddAddress($address_to); // Esta es la dirección a donde enviamos
        $mail->IsHTML(true); // El correo se envía como HTML
        $mail->Subject = 'Recuperar contraseña'; // Este es el titulo del email.
        $mail->Body = '<!DOCTYPE html>'.
        '<html lang="en">'.
        '<head>
            <title>Recuperar contraseña</title>
        </head>'.
        '<body>'.
            '<footer style="background-color: #f8f9fa; padding: 25px 0; margin-top: 25px;">'.
                '<div class="container">'.
                    '<div class="row">'.
                        '<div class="col-md-12">'.
                        '<h1 style="text-align: center;">Ferretería Roberto Cotlear</h1>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</footer>'.
        '<main style="padding: 25px 0; margin-top: 25px;">'.
            '<div class="container">'.
                '<div class="row">'.
                    '<div class="col-md-12">'.
                        '<div class="">'.
                            '<div class="">'.
                            '<h1>Recuperar contraseña</h1>'.
                            '<p>Hola '.$user['name'].' '.$user['lastname'].'.</p>'.
                            '<p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta.</p>'.
                            '<p>Para restablecer tu contraseña, ingresa el siguiente token:'.
                            '<strong>'.$token.'</strong></p>
                            '.
                            '<p>Si tienes alguna pregunta, no dudes en ponerte en contacto con nosotros.</p>'.
                            '<p>Saludos cordiales, Ferretería Roberto Cotlear</p>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</div>'.
        '</main>'. 
        '<header style="background-color: #f8f9fa; padding: 25px 0; margin-top: 25px;">'.
            '<div class="container">'.
            '<div class="row">'.
            '<div class="col-md-12">'.
                '<p style="text-align: center;">Av. Sanchez Cerro 929-633</p>'.
                '<p style="text-align: center;">Teléfono: 969518850</p>'.
                '<p style="text-align: center;">Correo electrónico: ventas@ferreteriacotlear.com</p>'.
                '<p style="text-align: center;">Horario de atención: Lunes a Sábado de 8:00 a.m. a 6:00 p.m.</p>'.
                '<p style="text-align: center;">Domingos de 8:00 a.m. a 1:00 p.m.</p>'.
                '<p style="text-align: center;">Feriados de 8:00 a.m. a 1:00 p.m.</p>'.
            '</div>'.
            '</div>'.
            '</div>'.
        '</header>'.
        '</body>'.
        '</html>';
        $mail->AltBody = 'Este es el mansaje en texto plano para clientes que no admitan HTML';
        $mail->CharSet = 'UTF-8';
        if(!$mail->Send()) {
            $_SESSION['errorMail'] = 'Error al enviar el correo electrónico: '. $mail->ErrorInfo;
            header('Location: ../../app/views/auth/recoverPassword.php');
            exit;
        } else {
            // enviar el idUser con el metodo get
            $_SESSION['idUserToken'] = $idUser;
            header('Location: ../../app/views/auth/verifyToken.php');
            exit;
        }
    }


    
    public function recoverPassword() {
        $user = $this->authModel->getUser($_POST['mail']);
        if($user) {
            $tokenUser = bin2hex(random_bytes(4));
            $token = $this->authModel->createToken($user['idUser'],$tokenUser,'Recuperar contraseña');
            $this->sendMailTokenPasswork($user['idUser'],$user['mail'],$tokenUser);
        } else {
            $_SESSION['errorMail'] = 'El correo electrónico no está registrado';
            header('Location: ../../app/views/auth/recoverPassword.php');
            exit;
        }
    }

    public function resetPassword() {
        $user = $this->authModel->getUserById($_POST['idUser']);
        if($user) {
            if($_POST['password1'] != $_POST['password2']) {
                $_SESSION['errorPassword'] = 'Las contraseñas no coinciden';
                header('Location: ../../app/views/auth/verifyToken.php');
                exit;
            } else {
                $password = password_hash($_POST['password1'],PASSWORD_DEFAULT);
                $_SESSION['successPassword'] = 'Contraseña actualizada correctamente';
                $update = $this->authModel->updatePasswordUser($user['idUser'],$password);
                if($update) {
                    header('Location: ../../app/views/auth/login.php');
                    exit;
                } else {
                    $_SESSION['errorPassword'] = 'Error al actualizar la contraseña';
                    header('Location: ../../app/views/auth/verifyToken.php');
                    exit;
                }
            }
        } else {
            $_SESSION['errorPassword'] = 'El usuario no existe';
            header('Location: ../../app/views/auth/verifyToken.php');
            exit;
        }
    }
}  

?>