<?php
session_start();
require_once('../../../app/controller/CartController.php');
require_once('../../../app/controller/UserController.php');

$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
$cartController = new CartController();
$userController = new UserController();
$carts = $cartController->getProducts();

if(isset($_SESSION['idUser'])) {
  $user = $userController->getUserData($_SESSION['idUser']);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferretería Roberto Cotlear</title>
    <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>
<main class="container mb-3">
  <div class="mx-auto col-lg-10 pt-5">
        <form id="formulario" class="mt-4 mb-4 p-md-5 border rounded bg-body-tertiary" action="../../../app/controller/BuyController.php" method="POST">
        <input type="hidden" name="cart" value="<?=htmlentities(serialize($carts)) ?>">
        <input type="hidden" name="idUser" value="<?php
        if(isset($_SESSION['idUser'])):
          echo $_SESSION['idUser'];
        else:
          echo 0;
        endif;
          ?>">
        <h2 class="text-center py-2">
              <img src="../../../public/img/logo.png" alt="logo" style="margin-left: auto; margin-right: auto; width: 80px; padding-right:20px;"/>
              Validar datos de la orden
            </h2>
          <div class="row g-3">
            <h2>Datos de personales</h2>
            <hr>
            <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="name" placeholder="Nombres" name="name" value="<?=isset($user['name'])?$user['name']:''?>"
               >
              <label for="name">Nombres</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="last-name" placeholder="Apellidos" name="lastname" value="<?=isset($user['lastname'])?$user['lastname']:''?>">
              <label for="last-name">Apellidos</label>
            </div>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="address" placeholder="Direccion" name="address" value="<?=isset($user['address'])?$user['address']:''?>">
            <label for="address">Dirección</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="reference-address" placeholder="Direccion" name="reference" value="<?=isset($user['reference'])?$user['reference']:''?>">
            <label for="reference-address">Dirección de referencia</label>
          </div>
          
        <div class="col-md-6">
          <div class="form-floating mb-3">
              <select id="inputCity" name="city" class="form-select" aria-label="Floating label select example">
                  <option selected>Selecciona tu región</option>
                  <?php
                    if(isset($user['city'])):
                  ?>
                    <option value="<?=$user['city']?>" selected><?=$user['city']?></option>
                  <?php
                    endif;
                  ?>
                    <option value="Amazonas">Amazonas</option>
                    <option value="Áncash">Áncash</option>
                    <option value="Apurímac">Apurímac</option>
                    <option value="Arequipa">Arequipa</option>
                    <option value="Ayacucho">Ayacucho</option>
                    <option value="Cajamarca">Cajamarca</option>
                    <option value="Callao">Callao</option>
                    <option value="Cusco">Cusco</option>
                    <option value="Huancavelica">Huancavelica</option>
                    <option value="Huánuco">Huánuco</option>
                    <option value="Ica">Ica</option>
                    <option value="Junín">Junín</option>
                    <option value="La Libertad">La Libertad</option>
                    <option value="Lambayeque">Lambayeque</option>
                    <option value="Lima">Lima</option>
                    <option value="Loreto">Loreto</option>
                    <option value="Madre de Dios">Madre de Dios</option>
                    <option value="Moquegua">Moquegua</option>
                    <option value="Pasco">Pasco</option>
                    <option value="Piura">Piura</option>
                    <option value="Puno">Puno</option>
                    <option value="San Martín">San Martín</option>
                    <option value="Tacna">Tacna</option>
                    <option value="Tumbes">Tumbes</option>
                    <option value="Ucayali">Ucayali</option>
              </select>
            <label for="inputCity">Selecciona tu región</label>
          </div> 
        </div>

          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="tel" class="form-control" id="phone" placeholder="Teléfono" pattern="[0-9]{9}" oninput="validarTelefono(this)" name="phone" maxlength="9" value="<?=isset($user['phone'])?$user['phone']:''?>">
              <label for="phone">Teléfono</label>
            </div>
          </div>
          <div id="error-message" class="text-danger"></div>
          </div>
            <button class="w-100 btn-lg btn background-general mb-4" type="submit" style="" name="btn-addOrder">
              <span class="fs-5">Confirmar datos de la orden</span>
            </button>
            <a href="<?='../../../app/views/cart/carts.php'?>"><i class="bi bi-arrow-left"></i>Volver</a>
        </form>
  </div>
</main>
 <!-- footer -->
 <?php
    require_once('../../../app/views/layout/footer.php');
  ?> 
  <script src="../../../public/js/amountProduct.js"></script>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>
</html>