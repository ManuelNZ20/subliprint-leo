<?php
date_default_timezone_set('America/Lima');
require_once('../../../app/controller/AuthController.php');

?>
<!doctype html>
<html lang="en">

<head>
  <title>Subliprint Leo</title>
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
     <script>
    // Función para validar el contenido del campo de entrada
    function validarInput(event) {
      var inputValue = event.key;

      // Permitir solo números (0-9) o letras (a-zA-Z)
      var regex = /^[0-9a-zA-Z]+$/;
      if (!regex.test(inputValue)) {
        event.preventDefault();
      }
    }
  </script>
    
</head>


<body>
<!-- ../../../public/img/500px.jpg -->
<main class="py-5" style="">
<div class="w-100 z-0 top-0 start-0 position-absolute" style="height:300px;position:relative; z-index:1;">
    <img src="https://img.freepik.com/fotos-premium/banner-herramientas-construccion-sobre-fondo-negro-fines-mejora-hogar_176841-18161.jpg" class="w-100 img-fluid object-fit-cover" alt="Imagen de inicio de sesión" style="height:100%;">
</div>

<div class="container rounded mt-5" style="background:white;max-width:500px; position:relative; z-index:2;">
    <div class="row rounded shadow pb-4">
          <form class="col-md-12 px-4 py-4" action="../../../app/controller/TokenController.php" method="POST">
          <input type="hidden" name="idUserToken" value="<?php
                  if(isset($_SESSION['idUserToken'])) {
                    echo $_SESSION['idUserToken'];
                  }
                ?>">
          <h2 class="text-center py-2">
              <img src="../../../public/img/logo.png" alt="logo" style="margin-left: auto; margin-right: auto; width: 80px; padding-right:20px;"/>
              ROBERTO COTLEAR</h2>
              <div class="shadow-sm p-3 mb-3 bg-body-tertiary rounded" style="color:var(--bs-secondary-color);">
                "Por favor, verifica tu bandeja de entrada, incluida la carpeta de correo no deseado."
                <br>
                "Ingrese el token requerido para reestablecer su contraseña".
            <?php
                if(isset($_SESSION['errorToken'])) {
                  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['errorToken'].'</div>';
                }
            ?>
        </div>
          <div class="row g-3 mb-3">
            <div class="col-md" style="width:50px;">
              <input id="token-1" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-1" onkeypress="validarInput(event)" required>
            </div>
            <div class="col-md" style="width:50px;">
              <input id="token-2" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-2" onkeypress="validarInput(event)" required>
            </div>
            <div class="col-md" style="width:50px;">
              <input id="token-3" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-3" onkeypress="validarInput(event)" required>
            </div>
            <div class="col-md" style="width:50px;">
              <input id="token-4" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-4" onkeypress="validarInput(event)" required>
            </div>
            <div class="col-md" style="width:50px;">
              <input id="token-5" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-5" onkeypress="validarInput(event)" required>
            </div>
            <div class="col-md" style="width:50px;">
              <input id="token-6" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-6" onkeypress="validarInput(event)" required>
            </div>
            <div class="col-md" style="width:50px;">
              <input id="token-7" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-7" onkeypress="validarInput(event)" required>
            </div>
            <div class="col-md" style="width:50px;">
              <input id="token-8" type="text" class="form-control token-input" placeholder="" maxlength="1"  name="token-8" onkeypress="validarInput(event)" required>
            </div>
          </div>
          <button class="w-100 btn-lg btn background-general" type="submit" style="" name="btnVerifyToken"><span class="fs-5">Confirmar Token</span>
          </button>
          </form>
          <div class="col-md-12 px-5">
            <div class="d-flex justify-content-between">
              <a href="login.php" class="text-body-secondary text-end link">Cancelar</a>
            </div>
          </div>
        </div>
  </main>
  <?php
    require_once('../../../app/views/layout/footer.php');
    // require_once '../app/views/layout/header.php';
  ?> 
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    $('.token-input').on('input', function () {
      var $this = $(this);

      // Obtener el valor actual del campo
      var currentValue = $this.val();

      // Si hay al menos un caracter, pasar al siguiente campo
      if (currentValue.length > 0) {
        // Obtener el índice del campo actual
        var currentIndex = $('.token-input').index($this);

        // Pasar al siguiente campo si no es el último
        if (currentIndex < $('.token-input').length - 1) {
          $('.token-input').eq(currentIndex + 1).focus();
        }
      }
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

