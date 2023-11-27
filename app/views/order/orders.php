<?php
session_start();
// Proteger ruta de acceso directo, solo para usuarios logueados
if(!isset($_SESSION['idUser'])) {
    header('Location: ../../../public/');
}
require_once('../../../app/controller/ProductController.php');
// require_once('../../../app/controller/OrderController.php');
require_once('../../../app/controller/BuyController.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
// $orderController = new OrderController();
$buyController = new BuyController();
$productControlelr = new ProductController();

$idUser = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : null;
// $order = $orderController->getOrdersUser($idUser);
$buy = $buyController->getBuyUserDetails($idUser);
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
</head>


<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>
<!-- main -->
<main class="container mb-3">
  <div class="row pt-5">
    <h1 class="col-md-12 text-center pt-4 pb-3 text-truncate" style="background-color:var(--about-1);color:white;"><i class="bi bi-shop"></i>  Mi lista de ordenes</h1>
   
  <div class="col-md-12 table-responsive" style="height:360px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Fecha Pedido</th>
        <th scope="col">Estado de la orden</th>
        <th scope="col">Estado de envío de la orden</th>
        <th scope="col">Fecha Pagado</th>
        <th scope="col" colspan="2">Acciones</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="" >
      <?php
        if($buy == null) {
          echo '<tr><td colspan="8" class="text-center">
            <h5 class="text-secondary py-3">No hay ordenes registradas</h5>
          </td></tr>';
        } else {
          foreach($buy as $b):
      ?>
            <tr>
                <td><?=$b['idBuyUser']?></td>
                <td><?=$b['dateOrder']?></td>
                <td><?=$b['stateBuy']?></td>
                <td>
                  <?=$b['stateOrder']?></td>
                <td>
                  <?=$b['dateBuy']?>
                </td>
                <td>
                    <a href="orderDetail.php?idOrder=<?=$b['idBuyUser']?>" class="icon-link icon-link-hover" style="--bs-link-hover-color-rgb: 25, 135, 84;">Ver detalles <i class="bi bi-arrow-right-short"></i></a>
                </td>
                <td>
                    <form action="../../../app/controller/BuyController.php" method="post">
                        <input type="hidden" name="idBuyUser" value="<?=$b['idBuyUser']?>">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" name="btn-deleteOrder"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php
           endforeach;
        }
        ?>
    </tbody>
  </table>
</div>
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