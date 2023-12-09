<?php
session_start();
require_once('../../../app/controller/ProductController.php');
require_once('../../../app/controller/UserController.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subliprint Leo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../../../public/css/main.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqpzipc8i/image/upload/v1702060222/ecommerce/dzrsdoymsbzu225j8e3u.ico" type="image/x-icon">
</head>
<body>
    <?php
        require_once('../../../app/views/layout/header.php');
    ?>
   <main class="container pt-5">
      <div class="pt-4" style="<?=
        (!isset($_SESSION['idUser']))? 'padding-top:10px':'padding-top:10px'
      ?>">
          <div class="mb-3" style="border:none;">
            <div id="carouselExample" class="carousel slide" style="height:500px;">
  <div class="carousel-inner" style="height:500px;">
    <div class="carousel-item active" style="height:500px;">
      <img src="../../../public/img/tazas.jpeg" class="d-block w-100 h-100 object-fit-fill" alt="...">
    </div>
    <div class="carousel-item" style="height:500px;">
      <img src="../../../public/img/vestido.jpg" class="d-block w-100 object-fit-fill" alt="...">
    </div>
    <div class="carousel-item" style="height:500px;">
      <img src="../../../public/img/carouse1.jpg" class="d-block w-100 object-fit-fill" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
        </div>
      </div>
    <?php
    ?>
    <!-- cards -->
    <div class="row">
      <?php
        include('../../../app/views/layout/cards.php');
        echo cardInformation('../../../app/views/products/products.php','Productos con estampado personalizado','Productos con grandes decoraciones.','../../../app/views/products/products.php','','../../../public/img/tazas.jpeg','Comprar ahora');
        echo cardInformation('../../../app/views/products/products.php','Contamos con varios Productos','Haz click para explorar nuestros productos.','../../../app/views/products/products.php','','../../../public/img/vestido.jpg','Comprar ahora');
      ?>
    </div>
    <div class="p-5 row pt-3 pb-1 mt-3 shadow rounded align-items-center justify-content-between">
      <div class="col-md">
      <h5 class="">
            <img src="../../../public/icons/delivery.svg" alt="payment" style="width:35px;">
            Envío gratis
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Por ordenes mayores a S/. 99 Soles</p>
      </div>
      <div class="col-md">
      <h5 class="">
            <img src="../../../public/icons/payment.svg" alt="payment" style="width:35px;"> 
            Pago seguro
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Pago seguro al 100%</p>
      </div>
      
    </div>
    <h3 class="text-center mt-3 mb-3"><span class="badge"  style="background-color:#007bff;">PRODUCTOS DESTACADOS</span></h3>
    <!--TODO: listar con base de datos al menos 8 productos -->
    <hr>
    <div class="w-100 row justify-content-center gap-3 g-1">
    <!-- content card -->
    <?php
      $productController = new ProductController();
      foreach($productController->getProductsRand() as $product) {
    ?>
      <div class="card p-0 shadow-sm pt-1" style="width: 15rem; border:none;">
        <img src="<?=$product['imgProduct']?>" class="w-100 card-img-top" alt="<?=$product['nameProduct']?>" style="height:200px;object-fit:cover;"
        >
        <div class="card-body" style="height:120px;">
          <h5 class="card-title text-wrap text-truncate" style="height:50px;"><?=$product['nameProduct']?></h5>
          <p class="card-text text-truncate fs-5" style="color:rgba(1, 141, 821, 1);">S/. <?=number_format($product['price'],2)?></p>
        </div>
        <div class="card-body">
          <a href="../../../app/views/products/productDetail.php?idProduct=<?=$product['idProduct']?>" class="btn btn-outline-secondary rounded-circle"><i class="bi bi-bag-plus"></i></a>
        </div>
      </div>
    <?php
      }
    ?>
</div>
 <hr>
</main>
    <?php
        require_once '../../../app/views/layout/footer.php';
    ?>
      <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</body>
</html>