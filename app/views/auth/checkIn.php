<?php session_start();?>
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
<div class="container col-xl-10 col-xxl-8 px-4">
    <div class="row align-items-center g-lg-5">
      <div class="col-lg-5 align-top text-lg-start">
        <h3 class="fs-3 fw-bold mb-3">"¡Bienvenido a la Ferretería Roberto Cotlear!"</h3>
        <p class="col-lg-12 fs-5">Estamos encantados de que hayas decidido unirte a nuestra comunidad. Al registrarte en nuestra aplicación, tendrás acceso a una amplia gama de productos y servicios que te ayudarán en tus proyectos de construcción y reparación.</p>
      </div>
      <div class="mx-auto col-lg-7">
        <form class="p-4 p-md-5 border rounded bg-body-tertiary" action="../../../app/controller/AuthController.php" method="POST">
          <h3>Registrarse</h3>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" placeholder="Nombres" name="name">
              <label for="floatingInput">Nombres</label>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" placeholder="Apellidos" name="lastname">
              <label for="floatingInput">Apellidos</label>
            </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="Direccion" name="address">
            <label for="floatingInput">Dirección</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="Direccion" name="reference" >
            <label for="floatingInput">Dirección de referencia</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="Direccion" name="city" >
            <label for="floatingInput">Ciudad</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="mail">
            <label for="floatingInput">Correo electrónico</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="Teléfono" name="phone" >
            <label for="floatingInput">Teléfono</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
            <label for="floatingPassword">Contraseña</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="confirmPassword">
            <label for="floatingPassword">Confirmar contraseña</label>
          </div>
            <button class="w-100 btn-lg btn background-general" type="submit" style="" name="btnRegister">
              <span class="fs-5">Iniciar sesión</span>
            </button>
        </form>
      </div>
    </div>
  </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

