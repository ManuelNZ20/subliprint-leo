<?php
require_once('../../../app/controller/UserController.php');
$userController = new UserController();
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <title>Roberto Cotlear</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/css/main.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqpzipc8i/image/upload/v1702060222/ecommerce/dzrsdoymsbzu225j8e3u.ico" type="image/x-icon">
</head>

<body>
  <!-- header -->
  <?php
     require_once('../../../app/views/layout/header.php');
  ?>   
<!-- main -->
<main class="container pt-5">
<div class="container" style="padding-top:40px;">
    <div class="row">
        <div class="col-md-6">
          <form action="" class="" role="search" method="GET">
            <div class="input-group">
              <input type="search" class="form-control" placeholder="Buscar por nombres" aria-label="Search" aria-describedby="basic-addon1" name="term" id="term">
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="search-user">Buscar</button>
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="all-user"><i class="bi bi-arrow-clockwise"></i></button>
            </div>
          </form>
        </div>
    </div>
    <div class="row justify-content-between mt-4">
    <h4 class="col"><span class=""><i class="bi bi-people"></i> Usuarios</span></h4>
    <h4 class="col text-end">N° <?=$userController->countUser();?></h4>
  </div>
  <?php
    if(isset($_SESSION['messageUser'])):
  ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><?=$_SESSION['messageUser']?></strong> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php
    unset($_SESSION['messageUser']);
    endif;
  ?>
  <hr>
    <div class="table-responsive mb-5"  style="height:500px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombres</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Dirección</th>
        <th scope="col">Referencia</th>
        <th scope="col">Correo</th>
        <th scope="col">Teléfono</th>
        <th class="text-center" colspan="1" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
      <?php
          foreach($userController->searchUser() as $value):
      ?>
      <tr>
        <th class="align-middle" scope="row">
          <?=$value['idUser']?>
        </th>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$value['name']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$value['lastname']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$value['address']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$value['reference']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$value['mail']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$value['phone']?>
            </span>
        </td>
        <td class="">
          <form action="../../../app/controller/UserController.php" method="POST">
          <input type="hidden" name="idUser" value="<?=$value['idUser']?>">
          <select class="form-select" aria-label="Default select example"  name="typeUser">
            <?php
              if($value['idTypeUser'] == 1):
            ?>
                <option value="1" selected>Cliente</option>
                <option value="2">Administrador</option>
                <?php
              else:
                ?>
                <option value="1">Cliente</option>
                <option value="2" selected>Administrador</option>
            <?php
              endif;
            ?>
          </select>
            <button class="col me-2 btn btn-outline-success" name="btnConfirm" ><i class="bi bi-check-circle"></i> Confirmar
          </button>
          </form>
        </td>
      </tr>
      <?php
          endforeach;
      ?> 
    </tbody>
  </table>
</div>
  </div>
</main>
<!-- footer -->
<!-- include('../../../presentation/templates/footer.php'); -->
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

