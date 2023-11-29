<?php 
session_start();
// hora local
date_default_timezone_set('America/Lima');
?>
<!doctype html>
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
<main class="py-5" style="">
    <div class="w-100 z-0 top-0 start-0 position-absolute" style="height:300px;position:relative; z-index:1;">
        <img src="https://img.freepik.com/fotos-premium/banner-herramientas-construccion-sobre-fondo-negro-fines-mejora-hogar_176841-18161.jpg" class="w-100 img-fluid object-fit-cover" alt="Imagen de inicio de sesión" style="height:100%;">
    </div>
<div class="container col-xl-10 col-xxl-8 px-4"  style="position:relative; z-index:2;">
    <div class="row align-items-center g-lg-5">
      <div class="col-lg-12 align-top text-lg-start px-4 rounded" style="background:white;">
        <h3 class="fs-2 fw-bold">"¡Bienvenido a la Ferretería Roberto Cotlear!"</h3>
        <p class="col-lg-12 fs-5 fw-light">Estamos encantados de que hayas decidido unirte a nuestra comunidad. Al registrarte en nuestra aplicación, tendrás acceso a una amplia gama de productos y servicios que te ayudarán en tus proyectos de construcción y reparación.</p>
      </div>
      <div class="mx-auto col-lg-10">
        <form id="formulario" class="p-4 p-md-5 border rounded bg-body-tertiary" action="../../../app/controller/AuthController.php" method="POST">
        <h2 class="text-center py-2">
              <img src="../../../public/img/logo.png" alt="logo" style="margin-left: auto; margin-right: auto; width: 80px; padding-right:20px;"/>
              REGISTRARSE
            </h2>
            <?php
              if(isset($_POST['messageCreateUser'])):
                ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <strong>Nota: </strong> <?= $_POST['messageCreateUser'] ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                unset($_POST['messageCreateUser']);
              endif;
            ?>

          <div class="row g-3">
            <h2>Datos de personales</h2>
            <hr>
            <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="name" placeholder="Nombres" name="name" required >
              <label for="name">Nombres</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="last-name" placeholder="Apellidos" name="lastname" required >
              <label for="last-name">Apellidos</label>
            </div>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="address" placeholder="Direccion" name="address" required >
            <label for="address">Dirección</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="reference-address" placeholder="Direccion" name="reference"  required >
            <label for="reference-address">Dirección de referencia</label>
          </div>
          
        <div class="col-md-6">
          <div class="form-floating mb-3">
              <select id="inputCity" name="city" class="form-select" aria-label="Floating label select example" required>
                  <option value="" selected>Selecciona tu distrito</option>
                  <option value="Piura">Piura</option>
                  <option value="Castilla">Castilla</option>
                  <option value="Catacaos">Catacaos</option>
                  <option value="Cura Mori">Cura Mori</option>
                  <option value="El Tallán">El Tallán</option>
                  <option value="La Arena">La Arena</option>
                  <option value="La Unión">La Unión</option>
                  <option value="Las Lomas">Las Lomas</option>
                  <option value="Tambogrande">Tambogrande</option>
                  <option value="Veintiséis de Octubre">Veintiséis de Octubre</option>
              </select>
            <label for="inputCity">Selecciona tu distrito</label>
          </div> 
        </div>

          <div class="col-md-6">

            <div class="form-floating mb-3">
              <input type="tel" class="form-control" id="phone" placeholder="Teléfono" pattern="[0-9]{9}" oninput="validarTelefono(this)" name="phone" maxlength="9" required>
              <label for="phone">Teléfono</label>
            </div>
          </div>

          <div class="col-md-12">
          
          <h3>Datos de cuenta</h3>
          <hr>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="mail" required>
            <label for="floatingInput">Correo electrónico</label>
          </div>
  </div>
  <div class="col-md-6">
    <div class="form-floating  position-relative mb-3">
      <input type="password" class="form-control" id="floatingPassword1" placeholder="Password" name="password1" maxlength="8" required>
            <label for="floatingPassword">Contraseña</label>
            <!-- Botón para mostrar/ocultar contraseña -->
            <div class="border-none input-group-append position-absolute" style="bottom:10px; right:10px;">
              <span class="btn input-group-text" id="showPasswordToggleBtn1">
                <i class="bi bi-eye" id="showPasswordToggleIcon1"></i>
              </span>
            </div>
          </div>
          
        </div>
          <div class="col-md-6">
          <div class="form-floating  position-relative mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password2" maxlength="8" required>
            <label for="floatingPassword">Confirmar Contraseña</label>
            <!-- Botón para mostrar/ocultar contraseña -->
            <div class="border-none input-group-append position-absolute" style="bottom:10px; right:10px;">
              <span class="btn input-group-text" id="showPasswordToggleBtn">
                <i class="bi bi-eye" id="showPasswordToggleIcon"></i>
              </span>
            </div>
          </div>

          </div>
          <div id="error-message" class="text-danger"></div>
          </div>
            <button class="w-100 btn-lg btn background-general mb-4" type="submit" style="" name="btnRegister">
              <span class="fs-5">Continuar</span>
            </button>
            <a href="login.php"><i class="bi bi-arrow-left"></i>Volver</a>
        </form>
      </div>
    </div>
  </div>

</main>
<?php
    require_once('../../../app/views/layout/footer.php');
  ?> 

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
function validarTelefono(input) {
    // Eliminar caracteres no numéricos
    input.value = input.value.replace(/\D/g, '');
}
</script>
<script src="../../../public/js/scriptPasswordLogin.js"></script>
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

