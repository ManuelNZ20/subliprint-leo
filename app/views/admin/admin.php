<?php
require_once('../../../app/controller/UserController.php');
$userController = new UserController();

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
</head>


<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?> 
<!-- main -->
<main class="container pt-4">
  <div class="container mt-5" style="padding-top:10px;">
    <div class="row gap-2">
      <div class="card col-md-3">
        <div class="row pt-3 mb-2">
          <div class="col-md mb-2">
            <span class="border border-dark-subtle rounded" style="padding:12px;">
              <i class="bi bi-cart fs-4"></i>
            </span>
          </div>
          <div class="col-md-10 mb-2 mt-2">
            <div class="row gap-2 align-items-center justify-content-between">
              <h5 class="col-md-auto text-secondary text-start">Total de pedidos</h5>
              <div class="col-1">
                <a href="" class="btn btn-outline-secondary">
                  <i class="bi bi-three-dots"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <h3 class="fs-4">500</h3>
          </div>
        </div>
      </div>
      <div class="card col-md-3">
        <div class="row pt-3 mb-2">
          <div class="col-md mb-2">
            <span class="border border-dark-subtle rounded" style="padding:12px;">
            <i class="bi bi-cart-dash fs-4"></i>
            </span>
          </div>
          <div class="col-md-10 mb-2 mt-2">
            <div class="row gap-2 align-items-center justify-content-between">
              <h5 class="col-md-auto text-secondary text-start">Pedidos pendientes</h5>
              <div class="col-1">
                <a href="" class="btn btn-outline-secondary">
                  <i class="bi bi-three-dots"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <h3 class="fs-4">500</h3>
          </div>
        </div>
      </div>
      <div class="card col-md-3">
        <div class="row pt-3 mb-2">
          <div class="col-md mb-2">
            <span class="border border-dark-subtle rounded" style="padding:12px;">
            <i class="bi bi-cash-stack fs-4"></i>
            </span>
          </div>
          <div class="col-md-10 mb-2 mt-2">
            <div class="row gap-2 align-items-center justify-content-between">
              <h5 class="col-md-auto text-secondary text-start">Total de ganancias</h5>
              <div class="col-1">
                <a href="" class="btn btn-outline-secondary">
                  <i class="bi bi-three-dots"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <h3 class="fs-4">800,00</h3>
          </div>
        </div>
      </div>
      <div class="card col-md">
        <div class="row pt-3 mb-2">
          <div class="col-md mb-2 text-center">
            <button class="btn btn-outline-secondary" style="padding:12px;" id="btnActualizar">
            <i class="bi bi-arrow-clockwise fs-4"></i>
            </button>
          </div>
          <div class="col-md-12 mb-2 mt-2 text-center">
              <h6 class="text-secondary">Actualizar</h6>
          </div>
          <div class="col-md-12 text-center">
            <h3 class="fs-4" id="tiempo-restante">
             30
            </h3>
         
          </div>
        </div>
      </div>

      <div class="card col-md-3">
        <div class="row pt-3 mb-2">
          <div class="col-md mb-2">
            <span class="border border-dark-subtle rounded" style="padding:12px;">
            <i class="bi bi-people fs-4"></i>
            </span>
          </div>
          <div class="col-md-10 mb-2 mt-2">
            <div class="row gap-2 align-items-center justify-content-between">
              <h5 class="col-md-auto text-secondary text-start">Total de clientes</h5>
              <div class="col-1">
                <a href="<?="users.php";?>" class="btn btn-outline-secondary">
                  <i class="bi bi-three-dots"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <h3 class="fs-4"><?=$userController->countUser();?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row justify-content-between mt-5">
    <h4 class="col"><span class=""><i class="bi bi-cart-dash"></i> Pedidos pendientes</span></h4>
    <h4 class="col text-end">N° <?= "1"?></h4>
  </div>
  <hr>
  <div class="table-responsive mb-5"  style="">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre del clientes</th>
        <th scope="col">Fecha de pedido</th>
        <th scope="col">Método de pago</th>
        <th scope="col">Monto cobrado</th>
        <th scope="col">Estado pendiente</th>
        <th class="text-center" colspan="2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
      <tr>
        <th class="align-middle" scope="row">
          1
        </th>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="">
          <a href="../../../app/views/admin/FormProvider.php?id=<?=$value['idProvider']?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-info-circle"></i> Detalles</a>
        </td>
        <td class="">
          <form action="../../../app/controller/ProviderController.php?id=<?= $value['idProvider'] ?>" method="POST">
            <button class="col me-2 btn btn-outline-success" name="btnDelete" ><i class="bi bi-check-circle"></i> Confirmar
          </button>
          </form>
        <!-- ../../../app/views/admin/FormProvider.php -->
        </td>
      </tr>   
    </tbody>
  </table>
</div>
</main>
<!-- footer -->
<!-- include('../../../presentation/templates/footer.php'); -->
  <!-- Bootstrap JavaScript Libraries -->
  <script src="../../../public/js/temporizador.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

