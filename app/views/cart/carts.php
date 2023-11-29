<?php
session_start();
require_once('../../../app/controller/CartController.php');
require_once('../../../app/controller/OrderController.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
$cartController = new CartController();
$cart = $cartController->getProducts();
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
    <h1 class="col-md-12 text-center pt-4 pb-3 text-truncate" style="background-color:var(--about-1);color:white;"><i class="bi bi-cart4"></i> Carrito de compras</h1>
  </div>
  <div class="row mb-3 justify-content-between">
  <div class="<?php
    if($cart != null):
      echo 'col-md-9';
    else:
      echo 'col-md-12';
    endif;
  ?> table-responsive mb-2" style="height:360px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Imagen</th>
        <th scope="col">Nombre</th>
        <th scope="col">Precio</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Sub Total</th>
        <th scope="col" colspan="2">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="" >
      <?php
        if($cart == null) {
          echo '<tr><td colspan="8" class="text-center">
            <h5 class="text-secondary py-3">No hay productos en el carrito</h5>
          </td></tr>';
        } else {
        foreach($cart as $product):
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
              <?=$product['price']?></span>
          </td>
          <td  class="text-truncate align-middle">
            <form action="../../../app/model/CartModel.php" method="post">
              <input type="hidden" name="idProduct" value="<?=$product['idProduct']?>">
              <button type="button" class="btn btn-outline-secondary" onclick="incrementar('<?=$product['idProduct']?>')"><i class="bi bi-plus-lg"></i></button>
              <input class="align-middle m-2 fs-5 d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2" type="text" id="contadorInput<?=$product['idProduct']?>" value="<?=$product['amount']?>" style="width:60px; text-align:center;" name="amount" readonly>
              <button type="button" class="btn btn-outline-secondary" onclick="decrementar('<?=$product['idProduct']?>')"> <i class="bi bi-dash-lg"></i></button>
              <button type="submit"  class="align-middle btn background-general" name="btn-updateCart">
                <i class="bi bi-arrow-clockwise"></i>
              </button>
            </form>
          </td>
          <td  class="align-middle" >
            <span class="align-middle d-inline-block text-truncate"  style="max-width: 150px;">
            <?=$product['subtotal']?>
            </span>
          </td>
          <td class="align-middle">
              <a href="../../../app/views/products/productDetail.php?idProduct=<?=$product['idProduct']?>&amountProduct=<?=$product['amount']?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-info-circle"></i>
            </a>
            </td>
          <td class="align-middle">
            <form action="../../../app/model/CartModel.php" method="POST">
            <input type="hidden" name="idProduct" value="<?=$product['idProduct']?>">
             <button type="submit"class="col me-2 btn btn-outline-secondary" name="btn-deleteProduct" ><i class="bi bi-trash3"></i>
            </button>
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
<?php
  if($cart != null):
?>
<div class="col-md-3">
  <div class="row border rounded py-3 px-3 mb-2" style="" >
    <!-- <form action="../../../app/controller/BuyController.php" method="post"> -->
    <form action="../../../app/views/order/validateOrder.php" method="post">
      <!-- se envian los datos del carrito de compras -->
      <input type="hidden" name="cart" value="<?=htmlentities(serialize($cart)) ?>">
      <input type="hidden" name="idUser" value="<?php
        if(isset($_SESSION['idUser'])):
          echo $_SESSION['idUser'];
        else:
          echo 0;
        endif;
          ?>">
      <h5>Resumen del pedido</h5>
      <hr>
      <div class="row mb-2">
        <div class="col-md-6">
          <h6>Subtotal:</h6>
        </div>
        <div class="col-md-6">
          <h6 class="text-end">S/. <?=number_format($cartController->getSubtotal(),2)?></h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h6>Costo de envío:</h6>
        </div>
        <div class="col-md-6">
          <h6 class="text-end text-danger text-decoration-line-through">S/. 10.00</h6>
        </div>
      </div>  
      <hr>
      <div class="row mb-3">
        <div class="col-md-6">
          <h6>Total a pagar:</h6>
        </div>
        <div class="col-md-6">
          <h6 class="text-end">S/. <?=number_format($cartController->getSubtotal(),2)?></h6>
        </div>
      </div>
      <hr>
      <?php
        if(isset($_SESSION['idUser'])):
      ?>
          <button type="submit" class="btn background-general col-md-12" name="btn-addOrder"><i class="bi bi-credit-card"></i> Confirmar orden</button>
      <?php
        else:
      ?>
          <a href="../../../app/views/auth/login.php" class="btn background-general col-md-12"><i class="bi bi-credit-card"></i> Confirmar pago</a>
      <?php
        endif;
      ?>
    </form>
  </div>
<?php
  endif; // end if($cart != null):
?>
</div>
  <div class="col-md">
      <form class="col-md-12 mb-2" action="../../../app/model/CartModel.php" method="post">
        <?php
          if($cart != null):
        ?>
        <button type="submit"class="btn btn-outline-danger" name="btn-clearCart"><i class="bi bi-trash3"></i> Vaciar</button>
        <?php
          endif;
        ?>
      </form>
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