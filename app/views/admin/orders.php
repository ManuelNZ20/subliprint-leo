<?php
// Condicional funciona si el usuario es administrador
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['idUser'])) {
  header('Location: ../../../public/');
}
// guardar la ruta de acceso
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '
../../../app/views/admin/orders.php';
require_once('../../../app/controller/OrderController.php');
$orderController = new OrderController();

?>
<!doctype html>
<html lang="en">

<head>
  <title>Pedidos</title>
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
  <div class="container pt-5">
    <div class="row">
        <div class="col-md-6">
          <form action="" class="" role="search" method="GET">
            <div class="input-group mb-3">
              <input type="search" class="form-control" placeholder="Buscar" aria-label="Search" aria-describedby="basic-addon1" name="term" id="term">
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="search-order">Buscar</button>
            </div>
          </form>
        </div>
        
        <div class="col-md-6 mb-3">
          <form action="" method="get">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
              <input type="radio" class="btn-check" name="stateOrder" id="btnradio1" autocomplete="off" checked value="Aceptado">
              <label class="btn btn-outline-success" for="btnradio1">Aceptado</label>
              <input type="radio" class="btn-check" name="stateOrder" id="btnradio3" autocomplete="off" value="Pendiente">
              <label class="btn btn-outline-warning" for="btnradio3">Pendiente</label>
              <input type="radio" class="btn-check" name="stateOrder" id="btnradio2" autocomplete="off" value="Cancelado">
              <label class="btn btn-outline-danger" for="btnradio2">Cancelado</label>
              <input type="radio" class="btn-check" name="stateOrder" id="btnradio4" autocomplete="off" value="Enviado">
              <label class="btn btn-outline-info" for="btnradio4">Enviado</label>
            </div>
            <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="filter-order">Filtrar</button>
            <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name=""><i class="bi bi-arrow-clockwise"></i></button>
          </form>
        </div>
    </div>
  </div>
  <div class="row justify-content-between mt-3">
    <h4 class="col"><span class=""><i class="bi bi-cart-dash"></i> Pedidos</span></h4>
    <h4 class="col text-end">N° <?=$orderController->countOrderBuy()?></h4>
  </div>
  <hr>
  <?php
    if(!empty($_REQUEST['page'])) { // comprueba si la variable page esta vacia
      $_REQUEST['page'] = $_REQUEST['page']; // si no esta vacia pasa el valor de la variable page a $page
    } else {
      $_REQUEST['page'] = "1"; // si esta vacia el valor de la variable page es 1
    }
    if($_REQUEST['page'] == 1) {
      $previous = "1"; // si la variable page es 1 el valor de previous es 1
    }
    $totalPages = $orderController->countOrderBuy();// cuenta el total de registros
    $registros = 7 ; // cantidad de registros por pagina
    $page = $_REQUEST['page']; // pagina actual
    if(is_numeric($page)) { // comprueba si la pagina es un numero
      $inicio = (($page - 1) * $registros); // toma la pagina actual y la multiplica por la cantidad de registros por pagina
      $totalPages = ceil($totalPages / $registros); // redondea un numero hacia arriba
      // $productPage = $productController->paginationProduct($idInventory,$inicio,$registros); // llama al metodo pagination
      $orderPage = $orderController->paginationOrdersBuy($inicio,$registros); // llama al metodo pagination
      $next = $_REQUEST['page'] + 1; // suma 1 a la pagina actual
      $previous = $_REQUEST['page'] - 1; // resta 1 a la pagina actual
    }else {
      // $productPage = $productController->paginationProduct($idInventory,0,$registros);// muestra la pagina 1
      $orderPage = $orderController->paginationOrdersBuy(0,$registros);// muestra la pagina 1
      $page = ceil($totalPages / $registros);// redondea un numero hacia arriba
    }
  ?>
  <div class="table-responsive mb-5"  style="height:375px;">
    <table class="table table-sm table-hover">
    <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Cliente</th>
        <th scope="col">Fecha de pedido</th>
        <th scope="col">Fecha de envío</th>
        <th scope="col">Monto cobrado</th>
        <th scope="col">Estado</th>
        <th class="text-center" colspan="2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
    <?php
        $order = $orderPage;
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
            <?php
              if($o['dateDelivery'] == null):
            ?>
              <span class="d-inline-block text-truncate" style="max-width: 150px;"> 0000-00-00 00:00:00</span>
            <?php
              else:
            ?>
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$o['dateDelivery']?>
            </span>
            <?php
              endif;?>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?=$o['total']?>
            </span>
        </td>
        <td class="align-middle">
            <?php
              if($o['stateOrder'] == 'Aceptado'):
            ?>
              <span class="d-inline-block text-truncate text-success" style="max-width: 150px;">
              <i class="bi bi-check-circle"></i> <?=$o['stateOrder']?></span>
            <?php
              elseif($o['stateOrder'] == 'Cancelado'):
            ?>
              <span class="d-inline-block text-truncate text-danger" style="max-width: 150px;">
              <i class="bi bi-x-circle"></i> <?=$o['stateOrder']?></span>
              <?php 
              elseif($o['stateOrder'] == 'Enviado'):
              ?>
              <span class="d-inline-block text-truncate text-info" style="max-width: 150px;">
              <i class="bi bi-truck"></i> <?=$o['stateOrder']?></span>
            <?php
             else:
            ?>
              <span class="d-inline-block text-truncate text-warning" style="max-width: 150px;">
              <i class="bi bi-clock"></i> <?=$o['stateOrder']?></span>
            <?php
              endif;
            ?>
        </td>
        <td class="align-middle">
          <a href="../../../app/views/admin/orderDetailAdmin.php?idOrder=<?=$o['idBuyUser']?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-info-circle"></i> Detalles</a>
        </td>
        <td class="aling-middle">
          <?php
            if($o['stateOrder'] != 'Aceptado' AND $o['stateOrder'] != 'Enviado'):
          ?>
          <form action="../../../app/controller/OrderController.php" method="POST">
                <input type="hidden" name="idBuyUser" value="<?=$o['idBuyUser']?>">
                <button class="col-md-10 me-2 btn btn-outline-success" name="btn-successOrder" ><i class="bi bi-check-circle"></i> Confirmar</button>
            </form>
          </form>
          <?php
            endif;
          ?>
        </td>
      </tr>   
      <?php
         endforeach;
        ?>
    </tbody>
  </table>
</div>
<!-- pagination -->
<nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <?php
            if($_REQUEST['page'] == 1) {
              $_REQUEST['page'] = 0;
            } else {
              if($page > 1 ) {
                $previous = $_REQUEST['page'] - 1;
        ?>
              <a class="page-link link-secondary" href="?page=<?=$previous ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
        <?php
              }
            }
        ?>
      </li>
        <?php
          for($i = 1; $i <= $totalPages; $i++) {
            if($page == $i) {
              echo '<li class="page-item"><a class="page-link link-secondary" href="?page='.$i.'">'.$i.'</a></li>';
            } else {
              echo '<li class="page-item"><a class="page-link link-secondary" href="?page='.$i.'">'.$i.'</a></li>';
            }
          }
        ?>
    </ul>
  </nav>
</main>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

