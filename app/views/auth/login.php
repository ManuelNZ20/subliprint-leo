<?php
require_once('../../../app/controller/AuthController.php');
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
    <style>
      @media(max-width:770px) {
          .img-login {
            display: none;
          }           
      }
    </style>
    
</head>


<body>
<main class="py-5" style="height:100vh;">
<div class="container py-5" style="">
    <div class="row rounded shadow">
        <div class="col-md-4 p-0">
            <img src="../../../public/img/500px.jpg" class="w-100 h-100 img-fluid rounded-start img-login" alt="Imagen de inicio de sesión" style="">
        </div>
        <div class="col-md-8">
          <form class="p-4 py-2 p-md-5" action="" method="POST">
              <h3>Roberto Cotlear</h3>
              <?php
              require_once('../../../app/controller/AuthController.php');
            ?>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="mail">
            <label for="floatingInput">Correo electrónico</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
            <label for="floatingPassword">Contraseña</label>
          </div>
            <button class="w-100 btn-lg btn background-general" type="submit" style="" name="btnLogin">
              <span class="fs-5">Iniciar sesión</span>
            </button>
          </form>
          <div class="">
          <div class=" row justify-content-between">
            <a href="<?=$_SESSION['last_page']?>" class="col-md-3 text-body-secondary text-end link">Volver</a>
            <a href="" class="link col-md-4">Olvidaste tu contraseña?</a>
          </div>
          </div>
          <div class="p-5 pt-0">
          <hr>
            <a href="checkIn.php" class="w-100 btn-lg btn btn-outline-secondary" style="">Registrarse</a>
          </div>
        </div>
    </div>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

