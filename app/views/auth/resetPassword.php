<?php
require_once('../../../app/controller/AuthController.php');
$idUser = isset($_GET['idUser']) ? $_GET['idUser'] : null;
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#formulario').submit(function(event) {
        const password1 = $('#floatingPassword1').val();
        const password2 = $('#floatingPassword').val();

        if (password1 !== password2) {
          // Mostrar un mensaje de error
          $('#error-message').text('Las contraseñas no coinciden. Por favor, verifíquelas.');
          event.preventDefault(); // Evitar que el formulario se envíe
        } else {
          // Limpiar el mensaje de error si las contraseñas coinciden
          $('#error-message').text('');
        }
      });
    });
  </script>
</head>


<body>
<!-- ../../../public/img/500px.jpg -->
<main class="py-5" style="">
<div class="w-100 z-0 top-0 start-0 position-absolute" style="height:300px;position:relative; z-index:1;">
    <img src="https://img.freepik.com/fotos-premium/banner-herramientas-construccion-sobre-fondo-negro-fines-mejora-hogar_176841-18161.jpg" class="w-100 img-fluid object-fit-cover" alt="Imagen de inicio de sesión" style="height:100%;">
</div>

<div class="container rounded mt-5" style="background:white;max-width:500px; position:relative; z-index:2;">
    <div class="row rounded shadow">
          <form id="formulario" class="col-md-12 px-4 py-4" action="../../../app/controller/AuthController.php" method="POST">
          <input type="hidden" name="idUser" value="<?=$idUser?>">
            <h2 class="text-center py-2">
              <img src="../../../public/img/logo.png" alt="logo" style="margin-left: auto; margin-right: auto; width: 80px; padding-right:20px;"/>
              ROBERTO COTLEAR</h2>
              <div class="shadow-sm p-3 mb-3 bg-body-tertiary rounded" style="color:var(--bs-secondary-color);">
                "Ingrese su nueva contraseña"
        </div>

          <div class="form-floating  position-relative mb-3">
            <input type="password" class="form-control" id="floatingPassword1" placeholder="Password" name="password1" maxlength="8">
            <label for="floatingPassword">Contraseña</label>
            <!-- Botón para mostrar/ocultar contraseña -->
            <div class="border-none input-group-append position-absolute" style="bottom:10px; right:10px;">
              <span class="btn input-group-text" id="showPasswordToggleBtn1">
                <i class="bi bi-eye" id="showPasswordToggleIcon1"></i>
              </span>
            </div>
          </div>
          
          <div class="form-floating  position-relative mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password2" maxlength="8">
            <label for="floatingPassword">Confirmar Contraseña</label>
            <!-- Botón para mostrar/ocultar contraseña -->
            <div class="border-none input-group-append position-absolute" style="bottom:10px; right:10px;">
              <span class="btn input-group-text" id="showPasswordToggleBtn">
                <i class="bi bi-eye" id="showPasswordToggleIcon"></i>
              </span>
            </div>
          </div>
          
          <div id="error-message" class="text-danger"></div>
          <?php
            if(isset($_SESSION['errorPassword'])) {
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['errorPassword'].'</div>';
            }

            if(isset($_SESSION['successPassword'])) {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$_SESSION['successPassword'].'</div>';
            }
          ?>
          <button class="w-100 btn-lg btn background-general" type="submit" style="" name="btnResetPassword"><span class="fs-5">Reestablece contraseña</span>
          </button>
          </form>
          <div class="col-md-12 px-5 pb-4">
            <div class="d-flex justify-content-between">
              <a href="<?php
                    unset($_SESSION['error']);
                    unset($_SESSION['errorToken']);
                    unset($_SESSION['errorPassword']);
                    unset($_SESSION['successPassword']);
                    echo '/roberto-cotlear/app/views/auth/login.php';
                  ?>" class="text-body-secondary text-danger text-end link">Cancelar</a>
            </div>
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
    
$(document).ready(function() {
    $('#showPasswordToggleBtn1').click(function() {
        const passwordField = $('#floatingPassword1');
        const passwordFieldType = passwordField.attr('type');
        // Si el tipo de campo de contraseña es un campo de contraseña, cambie a texto
        if (passwordFieldType === 'password') {
          passwordField.attr('type', 'text');
        //   limpiar showPasswordToggleIcon 
        $('#showPasswordToggleIcon1').removeClass('bi bi-eye');
        $('#showPasswordToggleIcon1').addClass('bi bi-eye-slash');
        
      } else {
        passwordField.attr('type', 'password');
        $('#showPasswordToggleIcon1').addClass('bi bi-eye');
        $('#showPasswordToggleIcon1').removeClass('bi bi-eye-slash');
        }
      });
    });

  </script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

