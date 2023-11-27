<?php
require_once('../../../app/controller/AuthController.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/css/main.css">
    <style>
      @media(max-width:770px) {
          .img-login {
            display: none;
          }           
      }
    </style>
   
</head>

<body>
<main class="py-5" style="">
<div class="w-100 z-0 top-0 start-0 position-absolute" style="height:300px;position:relative; z-index:1;">
    <img src="https://img.freepik.com/fotos-premium/banner-herramientas-construccion-sobre-fondo-negro-fines-mejora-hogar_176841-18161.jpg" class="w-100 img-fluid object-fit-cover" alt="Imagen de inicio de sesión" style="height:100%;">
</div>

<div class="container rounded mt-5" style="background:white;max-width:500px; position:relative; z-index:2;">
    <div class="row rounded shadow">
          <form class="col-md-12 px-4 py-4" action="../../../app/controller/AuthController.php" method="POST">
          <h2 class="text-center py-2">
              <img src="../../../public/img/logo.png" alt="logo" style="margin-left: auto; margin-right: auto; width: 80px; padding-right:20px;"/>
              ROBERTO COTLEAR</h2>
        <div class="shadow-sm p-3 mb-3 bg-body-tertiary rounded" style="color:var(--bs-secondary-color);">
            <strong>¿Olvidaste tu contraseña?</strong><br> "Ingresa tu dirección de correo electrónico a continuación te enviaremos un token a tu bandeja de entrada para corroborar tus datos para que puedas restablecer tu contraseña de forma segura.
            <br>
            Por favor, verifica tu bandeja de entrada, incluida la carpeta de correo no deseado."
            <?php
                if(isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                } else             
                if(isset($_SESSION['errorMail'])) {
                    echo $_SESSION['errorMail'];
                }
            ?>
        </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="mail" required>
            <label for="floatingInput">Correo electrónico</label>
          </div>
          <button class="w-100 btn-lg btn background-general" type="submit" style="" name="btnRecoverPassword"><span class="fs-5">Solicitar Token</span>
          </button>
          </form>
          <div class="col-md-12 px-5">
            <div class="d-flex justify-content-between">
              <a href="<?php
                unset($_SESSION['errorMail']);
                unset($_SESSION['success']);
                unset($_SESSION['error']);
                unset($_SESSION['errorToken']);
                unset($_SESSION['errorPassword']);
                unset($_SESSION['errorConfirmPassword']);
                echo $_SESSION['last_page']??'login.php';
              ?>" class="text-body-secondary text-end link">Volver</a>
            </div>
          </div>
          <div class="p-4 pt-0">
          <hr>
            <a href="checkIn.php" class="w-100 btn-lg btn btn-outline-secondary" style="">Registrarse</a>
        </div>
        </div>
    </div>
  </main>
  <?php
    require_once('../../../app/views/layout/footer.php');
    // require_once '../app/views/layout/header.php';
  ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

