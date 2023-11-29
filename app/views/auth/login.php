<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../../../app/controller/AuthController.php');
// $_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
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
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqpzipc8i/image/upload/v1701189129/ecommerce/hiu2muzuuzzsykiqljju.ico" type="image/x-icon">
    <style>
      @media(max-width:770px) {
          .img-login {
            display: none;
          }           
      }
    </style>
    
</head>


<body>
<!-- ../../../public/img/500px.jpg -->
<main class="py-5" style="">
<div class="w-100 z-0 top-0 start-0 position-absolute" style="height:300px;position:relative; z-index:1;">
    <img src="https://img.freepik.com/fotos-premium/banner-herramientas-construccion-sobre-fondo-negro-fines-mejora-hogar_176841-18161.jpg" class="w-100 img-fluid object-fit-cover" alt="Imagen de inicio de sesión" style="height:100%;">
</div>

<div class="container rounded mt-5" style="background:white;max-width:500px; position:relative; z-index:2;">
    <div class="row rounded shadow">
          <form class="col-md-12 px-4 py-4" action="../../../app/controller/AuthController.php" method="POST">
          <h2 class="text-center py-2">
            <img src="../../../public/img/logo.png" alt="logo" style="margin-left: auto; margin-right: auto; width: 80px; padding-right:20px;"/>
            ROBERTO COTLEAR
          </h2>
          <?php
            if(isset($_SESSION['successActiveAccount'])):
          ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                   <strong>
                     <?=$_SESSION['successActiveAccount']??''?>
                   </strong>
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="onClickClose()"></button>
                </div>
          <?php
            endif;
          ?>
          <?php
            if(isset($_SESSION['error'])):
          ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <strong>
                 <?=$_SESSION['error']??''?>
               </strong>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php
            endif;
          ?>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="mail" required>
            <label for="floatingInput">Correo electrónico</label>
          </div>
          <div class="form-floating  position-relative mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" maxlength="8" required>
            <label for="floatingPassword">Contraseña</label>
            <!-- Botón para mostrar/ocultar contraseña -->
            <div class="border-none input-group-append position-absolute" style="bottom:10px; right:10px;">
              <span class="btn input-group-text" id="showPasswordToggleBtn">
                <i class="bi bi-eye" id="showPasswordToggleIcon"></i>
              </span>
            </div>
          </div>
          <button class="w-100 btn-lg btn background-general" type="submit" style="" name="btnLogin"><span class="fs-5">Iniciar sesión</span>
          </button>
          </form>
          <div class="col-md-12 px-5">
            <div class="d-flex justify-content-between">
              <a href="<?php
                  unset($_SESSION['error']);
                  if(isset($_SESSION['last_page'])) {
                    if($_SESSION['last_page'] !== '/roberto-cotlear/app/views/auth/login.php') {
                      echo $_SESSION['last_page'];
                    } else {
                      echo '../../../app/views/home/home.php';
                    }
                  } else {
                    echo '../../../app/views/home/home.php';
                  }
                  ?>" class="text-body-secondary text-end link">Volver</a>
              <a href="recoverPassword.php" class="link text-truncate">Olvidaste tu contraseña?</a>
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <script src="../../../public/js/scriptPasswordLogin.js">
    // Función para mostrar u ocultar la contraseña
  </script>
  <script>
function onClickClose() {
  // limpiar las variables session
  <?php
    unset($_SESSION['successActiveAccount']);
    unset($_SESSION['error']);
  ?>
}

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

