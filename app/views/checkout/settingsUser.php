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
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqpzipc8i/image/upload/v1701189129/ecommerce/hiu2muzuuzzsykiqljju.ico" type="image/x-icon">
</head>


<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>
<!-- main -->
<main class="container pt-4">
  <div class="container pt-5 pb-3">
    <form action="../../../app/controller/UserController.php" method="post">
        <div class="row">
          <div class="col-md-6 rounded mb-3">
            <h5 class="text-secondary">Información de tu cuenta</h5>
            <?php
              if(isset($_SESSION['messageSettingUser'])):
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong><?=$_SESSION['messageSettingUser']?></strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
              unset($_SESSION['messageSettingUser']);
              endif;
            ?>
                <div class="row justify-content-between">
                    <h6 class="col-md-auto">ID: <?=$idUser?></h6>
                    <h6 class="col-md-auto">Tipo de usuario: <span class="fw-light"><?=$userController->getNameTypeUser($idUser)['nameTypeUser']?></span></h6>
                </div>
                <input type="hidden" name="idUser" value="<?=$idUser?>">
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
                  <input type="text" class="form-control" id="phoneUser" placeholder="Teléfono" name="phoneUser" pattern="[0-9]{9}" oninput="validarTelefono(this)"  value="<?=isset($user['phone'])?$user['phone']:''?>" maxlength="9">
                </div>
              <div class="mb-2">
                <label for="emailUser" class="form-label">Email</label>
                <input type="email" class="form-control" id="emailUser" placeholder="name@example.com" name="emailUser" value="<?=isset($user['mail'])?$user['mail']:''?>">
              </div>
              <div class="mb-2">
                <label for="cityUser" class="form-label">Distrito de Piura</label>
                <!-- <textarea class="form-control" id="cityUser" rows="3" cols="1" style="resize:none;"><?=isset($user['city'])?$user['city']:''?></textarea> -->
                <select class="form-select" aria-label="Default select example" name="cityUser" id="cityUser">
                  <option value="Piura" <?=isset($user['city']) && $user['city'] == 'Piura' ? 'selected':''?>>Piura</option>
                  <option value="Castilla" <?=isset($user['city']) && $user['city'] == 'Castilla' ? 'selected':''?>>Castilla</option>
                  <option value="Catacaos" <?=isset($user['city']) && $user['city'] == 'Catacaos' ? 'selected':''?>>Catacaos</option>
                  <option value="Cura Mori" <?=isset($user['city']) && $user['city'] == 'Cura Mori' ? 'selected':''?>>Cura Mori</option>
                  <option value="El Tallan" <?=isset($user['city']) && $user['city'] == 'El Tallan' ? 'selected':''?>>El Tallan</option>
                  <option value="La Arena" <?=isset($user['city']) && $user['city'] == 'La Arena' ? 'selected':''?>>La Arena</option>
                  <option value="La Unión" <?=isset($user['city']) && $user['city'] == 'La Unión' ? 'selected':''?>>La Unión</option>
                  <option value="Las Lomas" <?=isset($user['city']) && $user['city'] == 'Las Lomas' ? 'selected':''?>>Las Lomas</option>
                  <option value="Tambo Grande" <?=isset($user['city']) && $user['city'] == 'Tambo Grande' ? 'selected':''?>>Tambo Grande</option>
                  <option value="Veintiséis de Octubre" <?=isset($user['city']) && $user['city'] == 'Veintiséis de Octubre' ? 'selected':''?>>Veintiséis de Octubre</option>
                </select>

              </div>
              <button type="submit" class="btn background-general mb-2" style="width:150px;" name="btn-updateUser">Modificar</button>
              <a href="../../../app/views/auth/verifyToken.php?mailUser=<?=isset($user['mail'])?$user['mail']:''?>" class="btn btn-outline-secondary mb-2" style="width:183px;">Modificar constraseña</a>
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
  <script>
function validarTelefono(input) {
    // Eliminar caracteres no numéricos
    input.value = input.value.replace(/\D/g, '');
}
</script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../../public/js/scriptPassword.js"></script>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

