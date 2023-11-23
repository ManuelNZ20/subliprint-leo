<?php
// Proteger ruta

session_start();
// Proteger ruta de acceso directo, solo para usuarios logueados
if(!isset($_SESSION['idUser'])) {
    header('Location: ../../../public/');
}
// guardar la ruta de acceso
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
require_once('../../../app/controller/UserController.php');
require_once('../../../app/controller/OrderController.php');

$userController = new UserController();
$orderController = new OrderController();

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
                <a href="../../../app/views/admin/orders.php" class="btn btn-outline-secondary">
                  <i class="bi bi-three-dots"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <h3 class="fs-4"><?=$orderController->countOrderProducts()?></h3>
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
                <a href="../../../app/views/admin/orders.php" class="btn btn-outline-secondary">
                  <i class="bi bi-three-dots"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <h3 class="fs-4"><?=$orderController->countOrderBuyState()?></h3>
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
            <h3 class="fs-4"><?=number_format($orderController->sumOrderBuyState(),2) ?></h3>
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
    <h4 class="col text-end">N° <?=$orderController->countOrderBuyState()?></h4>
  </div>
  <hr>
  <div class="table-responsive mb-5"  style="height:400px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Cliente</th>
        <th scope="col">Fecha de pedido</th>
        <th scope="col">Monto cobrado</th>
        <th scope="col">Estado

        </th>
        <th class="text-center" colspan="2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
      <?php
          $order = $orderController->listOrderBuyState();
          foreach($order as $o):
      ?>
      <tr>
        <th class="align-middle" scope="row">
          <?=$o['idOrderBuy']?>
        </th>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$o['name']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$o['dateOrder']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$o['total']?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate text-warning" style="max-width: 150px;">
              <i class="bi bi-clock"></i>
              <?=$o['stateOrder']?>
            </span>
        </td>
        <td class="align-middle">
          <a href="../../../app/views/admin/orderDetailAdmin.php?idOrder=<?=$o['idBuyUser']?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-info-circle"></i> Detalles</a>
        </td>
        <td class="aling-middle">
          <form action="../../../app/controller/OrderController.php" method="POST">
                <input type="hidden" name="idBuyUser" value="<?=$o['idBuyUser']?>">
                <button class="col-md-10 me-2 btn btn-outline-success" name="btn-successOrder" ><i class="bi bi-check-circle"></i> Confirmar</button>
            </form>
          </form>
        </td>
      </tr>   
      <?php
         endforeach;
        ?>
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

