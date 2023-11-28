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
require_once('../../../app/controller/ProductController.php');
require_once('../../../app/controller/BuyController.php');

$userController = new UserController();
$orderController = new OrderController();
$productController = new ProductController();
$buyController = new BuyController();
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
  
  <!-- Contenedor para el gráfico -->
  <div class="row g-2">
    <div class="col-md-6">
      <canvas class="w-100 h-100" id="miGrafico1"></canvas>
    </div>
    <div class="col-md-6">
      <canvas class="w-100 h-100" id="miGrafico2"></canvas>
    </div>
    <div class="col-md-6">
      <canvas class="w-100 h-100" id="miGrafico3"></canvas>
    </div>
    <div class="col-md-6">
      <canvas class="w-100 h-100" id="miGrafico4"></canvas>
    </div>
    <div class="col-md-12">
      <canvas class="w-100 h-100" id="miGrafico5"></canvas>
    </div>
  </div>

  <hr>
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
<!-- Incluye Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // obtener datos para formar un grafico que muestre el total de ordenes por estado
  var datos1 = {
    labels: [
     "Aceptados",
     "Pendientes"
    ],
    datasets: [{
      label: "Total de pedidos por estado",
      // color general segun este #cb9351
      backgroundColor: "rgba(203, 147, 81, 0.2)",
      // color de la linea
      borderColor: "rgba(203, 147, 81, 1)",
      borderWidth: 5,
      data: [
        <?php
          $order = $orderController->listOrderBuyStateChart();
          foreach($order as $o):
        ?>
          <?=$o?>,
        <?php
          endforeach;
        ?>
      ],
    }]
  };

  var datos2 = {
    labels: [
      "Cliente",
      "Administrador",
    ],
    datasets: [{
      label: "Usuarios por tipo",
      // color general segun este #cb9351
      backgroundColor: "rgba(203, 147, 81, 0.2)",
      // color de la linea
      borderColor: "rgba(203, 147, 81, 1)",
      borderWidth: 5,
      data: [
        <?php
       $user = $userController-> listUserTypeChart();
        foreach($user as $u):
      ?>
        "<?=$u?>",
      <?php
        endforeach;
      ?>
      ],
    }]
  };

  var datos3 = {
    labels: [
      <?php
        $product = $productController->listProductsCategoryChart();
        foreach($product as $p):
      ?>
        "<?=$p['nameCategory']?>",
      <?php
        endforeach;
      ?>
    ],
    datasets: [{
      label: "Productos por categoria",
      // color general segun este #cb9351
      backgroundColor: [
        // Color rosa
        "rgba(255, 99, 132, 0.2)",
        // Color rojo
        "rgba(255, 99, 132, 0.2)",
        // Color azul
        "rgba(54, 162, 235, 0.2)",
        // Color amarillo
        "rgba(255, 206, 86, 0.2)",
        // Color naranja
        "rgba(255, 159, 64, 0.2)",
        // Color morado
        "rgba(153, 102, 255, 0.2)",
        // Color verde
        "rgba(75, 192, 192, 0.2)",
        // Color gris
        "rgba(201, 203, 207, 0.2)",
      ],
      // color de la linea
      borderColor: "rgba(203, 147, 81, 1)",
      data: [
        <?php
          $product = $productController->listProductsCategoryChart();
          foreach($product as $p):
        ?>
          <?=$p['total']?>,
        <?php
          endforeach;
        ?>
      ],
    }]
  }

  var datos4 = {
    labels: [
      <?php
        $buy = $buyController->listOrdersBuyByMonth();
        foreach($buy as $b):
      ?>
        "<?=$b['monthName']?>",
      <?php
        endforeach;
      ?>
    ],
    datasets: [{
      label: "Pedidos por mes",
      // color general segun este #cb9351
      backgroundColor: "rgba(203, 147, 81, 0.2)",
      // color de la linea
      borderColor: "rgba(203, 147, 81, 1)",
      data: [
        <?php
          $buy = $buyController->listOrdersBuyByMonth();
          foreach($buy as $b):
        ?>
          <?=$b['total']?>,
        <?php
          endforeach;
        ?>
      ],
    }]
  }

  var datos5 = {
    labels: [
      <?php
        $orders = $orderController->listOrderBuyWeekChart();
        foreach($orders as $o):
      ?>
        "<?=$o['dayOfWeek']?>",
      <?php
        endforeach;
      ?>
    ],
    datasets: [{
      label: "Ganacias por semana",
      // color general segun este #cb9351
      backgroundColor: "rgba(203, 147, 81, 0.2)",
      // color de la linea
      borderColor: "rgba(203, 147, 81, 1)",
      data: [
        <?php
          $orders = $orderController->listOrderBuyWeekChart();
          foreach($orders as $o):
        ?>
          <?=$o['total']?>,
        <?php
          endforeach;
        ?>
      ],
    }]
  }

  // Configuración del gráfico
  var opciones = {
    scales: {
      y: {
        beginAtZero: true,
      },
    }
  };
  // Configuracion para el diagrama de torta
  var optionsPie = {
    responsive: true,
    maintainAspectRatio: false,
    title: {
        display: true,
        text: 'Productos por categoría', // Puedes cambiar el texto según tus necesidades
        fontSize: 18
    },
  };

  // Configuración para el diagrama en line
  var optionsLine = {
    responsive: true,
    maintainAspectRatio: false,
    title: {
        display: true,
        text: 'Pedidos por mes', // Puedes cambiar el texto según tus necesidades
        fontSize: 18
    },
  };

  // Obtén el contexto del lienzo
  var ctx1 = document.getElementById('miGrafico1').getContext('2d');
  var ctx2 = document.getElementById('miGrafico2').getContext('2d');
  var ctx3 = document.getElementById('miGrafico3').getContext('2d');
  var ctx4 = document.getElementById('miGrafico4').getContext('2d');
  var ctx5 = document.getElementById('miGrafico5').getContext('2d');
  // Crea el gráfico
  var miGrafico = new Chart(ctx1, {
    type: 'bar',
    data: datos1,
    options: opciones
  });
  var miGrafico = new Chart(ctx2, {
    type: 'bar',
    data: datos2,
    options: opciones
  });
  var miGrafico = new Chart(ctx3, {
    type: 'pie',
    data: datos3,
    options: optionsPie
  });
  var miGrafico = new Chart(ctx4, {
    type: 'line',
    data: datos4,
    options: optionsLine
  });
  var miGrafico = new Chart(ctx5, {
    type: 'line',
    data: datos5,
    options: optionsLine
  });
</script>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="../../../public/js/temporizador.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

