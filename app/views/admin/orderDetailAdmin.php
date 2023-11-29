<?php
session_start();
// proteger est pagina para que no se pueda acceder si no se ha iniciado sesion
if(!isset($_SESSION['idUser'])) {
  header('Location: ../../../public/');
}
require_once('../../../app/controller/OrderController.php');
require_once('../../../app/controller/BuyController.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../app/views/admin/orders.php';

$orderController = new OrderController();
$buyController = new BuyController();

$idOrder = isset($_GET['idOrder']) ? $_GET['idOrder'] : null;
$orderDetailsBuyUser = $orderController->getOrderProductsBuyDetails($idOrder);
$buy = $buyController->getBuyUser($idOrder);
?>
<!doctype html>
<html lang="en">
<head>
  <title>Ferretería roberto cotlear</title>
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
<main class="container mb-3">
  <div class="row pt-5">
    <h1 class="col-md-12 text-center pt-4 pb-3 text-truncate" style="background-color:var(--about-1);color:white;"><i class="bi bi-cart-dash"></i> Pedido <?=$idOrder?></h1>
</div>
    <div class="col-md-12">
      <div class="row mb-1 justify-content-between gap-1">
        <h5 class="col-md-4 text-truncate">ID Orden: <?=$buy['idBuyUser']?></h5>
        <?php
          if($buy['stateBuy'] == 'Pagado'):
        ?>
            <h5 id="stateBuy-Order" class="col-md-3 text-truncate border border-success rounded-pill text-success text-center py-1 px-1">Estado de la orden: <?=$buy['stateBuy']?></h5>
        <?php
          else:
        ?>
            <h5 id="stateBuy-Order" class="col-md-3 text-truncate border border-danger rounded-pill text-danger text-center py-1 px-1">Estado de la orden: <?=$buy['stateBuy']?></h5>
        <?php
          endif;
        ?>

        <?php
          if($orderDetailsBuyUser[0]['stateOrder'] == 'Enviado'):
        ?>
            <h5 id="stateSend-Order" class="col-md-3 text-truncate border border-info rounded-pill text-info text-center py-1 px-1">Estado de envío: <?=$orderDetailsBuyUser[0]['stateOrder']?></h5>
        <?php
          elseif($orderDetailsBuyUser[0]['stateOrder'] == 'Cancelado'):
        ?>
            <h5 id="stateSend-Order" class="col-md-3 text-truncate border border-danger rounded-pill text-danger text-center py-1 px-1">Estado de envío: <?=$orderDetailsBuyUser[0]['stateOrder']?></h5>
        <?php
          elseif($orderDetailsBuyUser[0]['stateOrder'] == 'Pendiente'):
        ?>
            <h5 id="stateSend-Order" class="col-md-3 text-truncate border border-warning rounded-pill text-warning text-center py-1 px-1">Estado de envío: <?=$orderDetailsBuyUser[0]['stateOrder']?></h5>
        <?php
          // pedido recibido(Aceptado)
          elseif($orderDetailsBuyUser[0]['stateOrder'] == 'Aceptado'):
        ?>
        <h5 id="stateSend-Order" class="col-md-3 text-truncate border border-success rounded-pill text-success text-center py-1 px-1">Estado de envío: <?=$orderDetailsBuyUser[0]['stateOrder']?></h5>
        <?php
          endif;
        ?>
            

      </div>
    </div>
    <div class="container border-secondary-subtle rounded-4 mb-3" style="
    background-color:rgba(203, 147, 81, 0.2);
    ">
  <div class="row">
    <h4 class="text-start rounded-top-4 p-2 " style="background-color:rgba(203, 147, 81, 0.2);">Datos de envío</h1>
    <div class="col-md-6">
      <h6>Nombres: <span class="fw-light"><?=$orderDetailsBuyUser[0]['name']?></span></h6>
    </div>
    <div class="col-md-6">
      <h6>Apellidos: <span class="fw-light"><?=$orderDetailsBuyUser[0]['lastname']?></span></h6>
    </div>
    <div class="col-md-12">
      <h6>Correo electronico: <span class="fw-light"><?=$orderDetailsBuyUser[0]['mail']?></span></h6>
    </div>
    <div class="col-md-6">
      <h6>Número de contacto: <span class="fw-light"><?=$orderDetailsBuyUser[0]['phone']?></span></h6>
    </div>
    <div class="col-md-6">
      <h6>Ciudad: <span class="fw-light"><?=$orderDetailsBuyUser[0]['city']?></span></h6>
    </div>
    <div class="col-md-6">
      <h6>Dirección: <span class="fw-light"><?=$orderDetailsBuyUser[0]['address']?></span></h6>
    </div>
    <div class="col-md-6">
      <h6>Dirección de referencia: <span class="fw-light"><?=$orderDetailsBuyUser[0]['reference']?></span></h6>
    </div>
    
  </div>
</div>

<div class="row mb-3 justify-content-between">
  <div class="col-md-12 table-responsive mb-2" style="height:450px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Imagen</th>
        <th scope="col">Nombre</th>
        <th scope="col">Precio</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Sub Total</th>
        <th scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="" >
      <?php
        if($orderDetailsBuyUser == null) {
          echo '<tr><td colspan="8" class="text-center">
            <h5 class="text-secondary py-3">No hay productos en el carrito</h5>
          </td></tr>';
        } else {
        foreach($orderDetailsBuyUser as $product):
      ?>
      <tr class="">
          <th class="align-middle" scope="row"><?=$product['idProduct']?></th>
          <td class="align-middle">
            <img class="img" src="<?=$product['imgProduct']?>" alt="<?=$product['description']?>" style="border-radius:10px; width:120px; height:120px;">
          </td>
          <td class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
              <?=$product['nameProduct']?>
            </span>
          </td>
          
          <td class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
              <?=$product['priceProduct']?></span>
          </td>
          <td  class="text-truncate align-middle">
              <input class="align-middle m-2 fs-5 d-inline-flex focus-ring py-1 px-2  text-decoration-none border rounded-2" type="text" id="contadorInput<?=$product['idProduct']?>" value="<?=$product['amountProduct']?>" style="width:60px; text-align:center;" name="amount" readonly>
          </td>
          <td  class="align-middle" >
            <span class="align-middle d-inline-block text-truncate"  style="max-width: 150px;">
            <?=$product['priceProduct']*$product['amountProduct']?>
            </span>
          </td>
          <td class="align-middle">
              <a href="../../../app/views/admin/FormProduct.php?id=<?=$product['idProduct']?>"
              class="col me-2 btn btn-outline-secondary"><i class="bi bi-info-circle"></i>
              </a>
            </td>
        </tr>
        <?php
            endforeach;
          }
        ?>
    </tbody>
  </table>
</div>
<div class="col-md-12">
          <div class="row justify-content-between align-items-center">
            <a href="<?='../../../app/views/admin/orders.php';
            ?>" class="col-md-2 btn btn-outline-secondary mb-2"><i class="bi bi-arrow-left"></i> Volver</a>
            <form action="../../../app/controller/OrderController.php" method="POST" class="col-md-auto mb-2">
                <input type="hidden" name="idBuyUser" value="<?=$idOrder?>">
                <div class="row gap-1">
                  <button class="col-md-auto mt-2 btn btn-outline-success" name="btn-successOrder" ><i class="bi bi-check-circle"></i> Confirmar</button>
                  <button class="col-md-auto mt-2 btn btn-outline-danger" name="btn-cancelOrder" ><i class="bi bi-x-circle"></i> Cancelar</button>
                  <!-- Boton de enviar -->
                  <button class="col-md-auto mt-2 btn btn-outline-info" name="btn-sendOrder" ><i class="bi bi-truck"></i> Enviar</button>
                  
                </div>

            </form>
            </div>
</div>
</div>

</main>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>