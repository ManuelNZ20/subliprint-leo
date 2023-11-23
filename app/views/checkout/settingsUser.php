<?php
session_start();
require_once('../../../app/controller/UserController.php');
$idUser = $_SESSION['idUser'];
$userController = new UserController();
$user = $userController->getUserData($idUser);
?>
<!doctype html>
<html lang="en">

<head>
  <title>Ferretería roberto cotlear</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<!-- main -->
<main class="container pt-4">
  <div class="container pt-5 pb-3">
    <form action="
    " method="post">
        <div class="row">
          <div class="col-md-6 rounded mb-3">
            <h5 class="text-secondary">Información de tu cuenta</h5>
                <div class="row justify-content-between">
                    <h6 class="col-md-auto">ID: <?=$idUser?></h6>
                    <h6 class="col-md-auto"><?=$userController->getNameTypeUser($idUser)['nameTypeUser']?></h6>
                </div>
                <div class="mb-2">
                  <label for="nameUser" class="form-label">Nombres</label>
                  <input type="text" class="form-control" id="nameUser" placeholder="Nombres" name="nameUser" value="<?=isset($user['name']) ? $user['name']:'';?>">
                </div>
                <div class="mb-2">
                  <label for="lastnameUser" class="form-label">Apellidos</label>
                  <input type="text" class="form-control" id="lastnameUser" placeholder="Apellidos" name="lastnameUser" value="<?=
                 isset($user['lastname']) ? $user['lastname']:'';?>">
                </div>
                <div class="mb-2">
                  <label for="addressUser" class="form-label">Dirección</label>
                  <input type="text" class="form-control" id="addressUser" placeholder="Dirección" name="addressUser" value="<?=isset($user['address'])?$user['address']:''?>">
                </div>
          </div>
          <div class="col-md-6 mb-3">
          <div class="mb-2">
                  <label for="addressReference" class="form-label">Referencia</label>
                  <input type="text" class="form-control" id="addressReference" placeholder="Referencia" name="addressReference" value="<?=isset($user['reference'])?$user['reference']:''?>">
                </div>
                
           <div class="mb-2">
                  <label for="phoneUser" class="form-label">Teléfono</label>
                  <input type="text" class="form-control" id="phoneUser" placeholder="Teléfono" name="phoneUser" value="<?=isset($user['phone'])?$user['phone']:''?>">
                </div>

              <div class="mb-2">
                <label for="emailUser" class="form-label">Email</label>
                <input type="email" class="form-control" id="emailUser" placeholder="name@example.com" name="emailUser" value="<?=isset($user['mail'])?$user['mail']:''?>">
              </div>
              <div class="mb-2">
                <label for="cityUser" class="form-label">Ciudad</label>
                <textarea class="form-control" id="cityUser" rows="3" cols="1" style="resize:none;"><?=isset($user['city'])?$user['city']:''?></textarea>
              </div>
              <button type="submit "class="btn background-general mb-2" style="width:150px;">Modificar</button>
              <a href="#" class="btn btn-outline-secondary mb-2" style="width:183px;">Modificar constraseña</a>
            </div>
        </div>
    </form>
  </div>
  
  <div class="row text-center align-items-center p-4" style="border:none;background-color:rgba(203, 146, 81, 0.3);">
          <div class="col-md-12">
            <h2 class="text-center p-2 fs-3 text-secondary">Trabajamos con grandes marcas</h2>
          </div>
          <div class="col mb-2">
            <img  class="" src="../../../public/icons/bosh.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="../../../public/icons/philips.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="../../../public/icons/caterpillar.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="../../../public/icons/stanley.svg" alt="payment" style="width:90px;">
          </div>
  </div>
</main>
<!-- footer -->
  <?php
    require_once('../../../app/views/layout/footer.php');
    // require_once '../app/views/layout/header.php';
  ?> 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../../public/js/scriptPassword.js"></script>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

