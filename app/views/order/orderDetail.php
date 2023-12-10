<?php
session_start();
// hora local
date_default_timezone_set('America/Lima');
// proteger est pagina para que no se pueda acceder si no se ha iniciado sesion
if(!isset($_SESSION['idUser'])) {
  header('Location: ../../../public/');
}
require_once('../../../app/controller/OrderController.php');
require_once('../../../app/controller/BuyController.php');
require_once('../../../app/controller/ProductController.php');
require_once('../../../app/controller/CartController.php');
require_once('../../../app/controller/ShipmentController.php');
require_once('../../../app/controller/InfoPageController.php');

$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
$orderController = new OrderController();
$productControlelr = new ProductController();
$buyController = new BuyController();
$cartController = new CartController();
$shipmentController = new ShipmentController();
$infoPageController = new InfoPageController();

$idOrder = isset($_GET['idOrder']) ? $_GET['idOrder'] : null;
$orderDetailsBuyUser = $orderController->getOrderProductsBuyDetails($idOrder);
$buy = $buyController->getBuyUser($idOrder);
$info = $infoPageController->getInformationPage()[0];
$total = $orderDetailsBuyUser[0]['total'];

?>
<!doctype html>
<html lang="en">
<head>
  <title>Subliprint Leo</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/css/main.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqpzipc8i/image/upload/v1702060222/ecommerce/dzrsdoymsbzu225j8e3u.ico" type="image/x-icon">
    <script src="https://www.paypal.com/sdk/js?client-id=<?=PAYPAL_CLIENT_ID?>&currency=USD"></script>
</head>

<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>
<main class="container mb-3">
  <div class="row pt-5">
    <h1 class="col-md-12 text-center pt-4 pb-3 text-truncate" style="background-color:rgba(1, 141, 821, .5); color:white;">
    <?php
      if($buy['stateBuy'] == 'Pagado'):
    ?>
      <i class="bi bi-cart-check"></i>
    <?php
      else:
    ?>
      <i class="bi bi-cart-dash"></i>
    <?php
     endif;
    ?>
    Pedido</h1>
</div>
    <div class="col-md-12">
      <div class="row mb-3 justify-content-between">
        <h5 class="col-md-6 text-truncate">ID Orden: <?=$buy['idBuyUser']?></h5>
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
      </div>
    </div>
<div class="row mb-3 justify-content-between">
  <div class="col-md-9 table-responsive mb-2" style="height:570px;">
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
              <a href="../../../app/views/products/productDetail.php?idProduct=<?=$product['idProduct']?>"
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
<?php
  if($orderDetailsBuyUser != null):
?>
<div class="col-md-3">
  <div class="row border rounded py-3 px-3 mb-2" style="" >
    <form action="../../../app/controller/BuyController.php" method="post">
      <input type="hidden" name="idUser" value="  
      <?php
        if(isset($_SESSION['idUser'])):
          echo $_SESSION['idUser'];
        else:
          echo '0';
        endif;
        ?>
      ">
      <input type="hidden" name="idUser" value="<?=$idOrder?>">
      <h5>Resumen del pedido</h5>
      <hr>
      <div class="row mb-2">
        <div class="col-md-6">
          <h6>Subtotal:</h6>
        </div>
        <div class="col-md-6">
          <h6 class="text-end">S/. <?=number_format($orderDetailsBuyUser[0]['total'],2)?></h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h6>Costo de envío:</h6>
        </div>
        <div class="col-md-6">
          <h6 class="text-end <?=$orderDetailsBuyUser[0]['total']>=99?'text-danger text-decoration-line-through':'text-info';?>">  
            <?php
              if($orderDetailsBuyUser[0]['total'] <= 100):
                $total += 10;
                echo 'S/. 10.00';
              else:
                echo 'S/. 0.00';
              endif;
            ?>
            <!-- S/. 10.00 -->
          </h6>
        </div>
      </div>  
      <hr>
      <div class="row mb-3">
        <div class="col-md-6">
          <h6>Total a pagar en soles:</h6>
        </div>
        <div class="col-md-6">
          <h6 class="text-end">S/. <?=number_format($total,2)?></h6>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <h6>Total a pagar en dolares:</h6>
        </div>
        <div class="col-md-6">
          <h6 class="text-end">
            USD <?=number_format($total / $info['dollarValue'] ,2)?>
          </h6>
        </div>
      </div>
      <hr>
      <?php
        if(isset($_SESSION['idUser'])):
      ?>
        <?php
          if($buy['stateBuy'] != 'Pagado'):
        ?>
          <div id="paypal-button-container"></div>
          <p id="result-message"></p>
        <?php
          else:
        ?>
          <div class="border border-success rounded p-3 mb-3"><h6 class="text-wrap text-success"><i class="bi bi-check2-circle"></i> El pago fue realizado con éxito</h6></div>
        <?php
          endif;
        ?>
      <?php
        endif;
      ?>
    </form>
    <hr>
    <p class="fw-normal">
        <b>*</b> El total a pagar de tu compra sera ejecutada en dolares, el tipo de cambio es de S/. <?=$info['dollarValue']?> por cada dolar.
      </p>
  </div>
<?php
  endif;
?>
</div>
<div class="col-md-4 mb-3">
  <?php
      $shipment = $shipmentController->getShipmentInformationById($buy['lastId']);
      if($shipment != null):
        ?>
        <div class="card">
    <div class="card-header">
      <h5 class="text-secondary text-center">Datos de envío</h5>
    </div>
    <div class="card-body">
      <h6 class="card-title text-wrap">Nombre: 
        <span class="fw-normal">
        <?=$shipment['nameUser']?>
      </span>
      </h6> 
      <h6 class="card-title text-wrap">Apellidos: 
        <span class="fw-normal">
        <?=$shipment['lastnameUser']?>
      </span>
      </h6> 
      <h6 class="card-title text-wrap">Número de contacto: 
        <span class="fw-normal">
        <?=$shipment['phoneContact']?>
      </span>
      </h6>
      <h6 class="card-title text-wrap">Dirección: 
        <span class="fw-normal">
        <?=$shipment['address']?>
      </span>
      </h6> 
      <h6 class="card-title text-wrap">Dirección de referencia: 
        <span class="fw-normal">
        <?=$shipment['reference']?>
      </span>
      </h6> 
       
      <h6 class="card-title">Localidad: 
        <span class="fw-normal">
        <?=$shipment['location']?>
      </span>
      </h6> 
    </div>
    
  </div>
    <?php
      endif;
    ?>
</div>

<div class="col-md mb-3">
    <div class="card" style="height:100%;">
       <div class="card-header">
         <h5 class="text-secondary text-center">Información de contacto</h5>
       </div>
       <div class="card-body">
       <div class="row">
       <div class="col-md-5">
        <div class="card-body">
         <h6 class="card-title"><i class="bi bi-geo-alt"></i> <?=$info['address']?></h6>
          <h6 class="card-title"><i class="bi bi-envelope"></i> <?=$info['email']?></h6>
          <h6 class="card-title"><i class="bi bi-telephone"></i> <?=$info['phone']?></h6>
          <?php
            $day = date('N');
            echo '<h6 class="card-title">Horario de atención de hoy: <span class="fw-normal">';
            switch($day) {
              case 1:
              case 2:
              case 3:
              case 4:
              case 5:
                echo $info['workingHours'];
                break;
              case 6:
              case 7:
                echo $info['holidayHours'];
                break;
            }
            echo '</span></h6>';
          ?>  
          </div>
          <div class="row g-1 gap-1 align-items-center">
            <button class="col-md btn btn-outline-secondary">Revisar</button>
            <button class="col-md btn btn-outline-secondary" style="" id="btnActualizar">
              <i class="bi bi-arrow-clockwise"></i>
            </button>
            <div class="col-md text-center border rounded-end ">
              <h3 class="fs-4" id="tiempo-restante">30</h3>
            </div>
          </div>

        </div>
        <!-- <div class="col-md">
          <div class="container rounded border border-secondary mb-1" style="height:150px;">
            <div id="chat-box">

            </div>
          </div>
            <form id="chat-form" action="" method="post">
              <span class="d-flex gap-1">
                <input type="text"
                class="form-control" placeholder="Mensaje" name="message" id="message" aria-describedby="helpId">
                <button type="" class="btn btn-outline-secondary rounded-circle"><i class="bi bi-send"></i></button>
              </span>
            </form>
        </div> -->
       </div> 
       </div>
    </div>
</div>


  <div class="col-md-12">
    <div class="col-md-12">
      <a href="../../../app/views/order/orders.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver a mis ordenes</a></div>
  </div>
</div>

</main>
  <!-- footer -->
  <?php
    require_once('../../../app/views/layout/footer.php');
  ?>
  <script>
    paypal.Buttons(
    {
        style:{
            shape: 'pill',
            color: 'blue',
            label: 'pay',
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?=number_format($orderDetailsBuyUser[0]['total'] / $info['dollarValue'] ,2)?>,
                    }
                }]
            });
        },
        // Los parametros que se van a enviar al servidor
        // para que se pueda realizar el pago, en este caso, el id del producto, el precio y el id del usuario
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                   document.getElementById('paypal-button-container').innerHTML = '<div class="border border-success rounded p-3 mb-3"><h6 class="text-wrap text-success"><i class="bi bi-check2-circle"></i> El pago fue realizado con éxito</h6></div>';
                  // eliminar algunas clases del elemento con el id stateBuy-Order
                  document.getElementById('stateBuy-Order').classList.remove('border','border-danger','rounded-pill','text-danger','text-center','py-1','px-1');
                  // agregar algunas clases del elemento con el id stateBuy-Order
                  document.getElementById('stateBuy-Order').classList.add('border','border-success','rounded-pill','text-success','text-center','py-1','px-1');
                  // agregar el texto al elemento con el id stateBuy-Order
                  document.getElementById('stateBuy-Order').innerHTML = 'Estado de la orden: Pagado';
                  document.getElementById('result-message').innerHTML = '<h6 class="text-wrap text-success">El pago fue realizado con éxito</h6>';

                console.log(details);
                // Conocer el metodo de pago
                return fetch('../../../app/controller/BuyController.php', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json',
                    },
                    body: JSON.stringify({
                        orderID: <?=json_encode($idOrder)?>,
                    }), // Enviar los datos al servidorq
                }).then(function(res) {
                    return res.json();
                }).then(function(details) {
                    console.log(details);
                }).catch(function(error) {
                    console.log(error);
                });

            });
        },
        onCancel: function (data) {
            document.getElementById('result-message').innerHTML = '<h6 class="text-wrap text-danger">El pago fue cancelado</h6>';
            console.log(data);
        },
    }
).render('#paypal-button-container');
  </script>
  <script src="../../../public/js/temporizador.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>