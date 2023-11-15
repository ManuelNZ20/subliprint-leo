<?php
session_start();
print_r(session_id());
print_r($_SESSION['cart']);
require_once('../app/controller/ProductController.php');
require_once('../app/controller/UserController.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roberto Cotlear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <?php
        require_once('../app/views/layout/header.php');
    ?>
   <main class="container pt-5">
      <div class="pt-4" style="<?=
        (!isset($_SESSION['idUser']))? 'padding-top:10px':'padding-top:10px'
      ?>">
          <div class="mb-3" style="border:none; background-color:rgba(215, 139, 50, 0.1);">
            <div class="row g-0">
              <div class="col-md-6">
                <img src="img/img-home.png" class="w-100 h-100 img-fluid card-img" alt="image-about" style="">
              </div>
          <div class="col-md-6 p-4">
            <div class="card-body mx-auto p-2  w-75 text-start" >
              <h5 class="card-title fs-3">"TODO LO QUE NECESITAS PARA CONSTRUIR TUS SUEÑOS".</h5>
              <p class="card-text text-wrap ">Explorar los productos de las mejores marcas que tenemos para ofrecerte</p>
              <a href="<?="../app/views/about/about.php"?>" class="btn background-general  mb-2">Sobre nosotros</a>
             <a href="<?="../app/views/about/contact.php"?>" class="btn btn-outline-secondary mb-2">Contáctanos</a>
            </div>
          </div>
        </div>
      </div>
      </div>
    <?php
    ?>
    <!-- cards -->
    <div class="row">
      <?php
        include('../app/views/layout/cards.php');
        echo cardInformation('../app/views/products/products.php','Nuevos Productos para arreglar','Herramientas innovadoras para proyectos modernos.','../app/views/products/products.php','','img/tools-construction-1.png','Comprar ahora');
        echo cardInformation('../app/views/products/products.php','Contamos con varios Productos','Haz click para explorar nuestros productos.','../app/views/products/products.php','','img/tools-construction-2.png','Comprar ahora');
      ?>
    </div>
    <div class="p-5 row pt-3 pb-1 mt-3 shadow rounded align-items-center justify-content-between">
      <div class="col-md">
      <h5 class="">
            <img src="icons/engineering.svg" alt="payment" style="width:35px;">
            Asesoramiento técnico
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Te ayudamos a seleccionar las mejores herramientas para tus proyectos</p>
      </div>
      
      <div class="col-md">
      <h5 class="">
            <img src="icons/delivery.svg" alt="payment" style="width:35px;">
            Envío gratis
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Por ordenes mayores a S/. 99</p>
      </div>
      <div class="col-md">
      <h5 class="">
            <img src="icons/payment.svg" alt="payment" style="width:35px;"> 
            Pago seguro
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Pago seguro al 100%</p>
      </div>
      
    </div>
    <h3 class="text-center mt-3 mb-3"><span class="badge"  style="background-color:var(--background-color-components-1);">PRODUCTOS DESTACADOS</span></h3>
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
          <p class="card-text text-truncate fs-5" style="color:rgba(203, 147, 81, 1);">S/. <?=number_format($product['price'],2)?></p>
        </div>
        <div class="card-body">
          <a href="../app/views/products/productDetail.php?idProduct=<?=$product['idProduct']?>" class="btn btn-outline-secondary rounded-circle"><i class="bi bi-bag-plus"></i></a>
        </div>
      </div>
    <?php
      }
    ?>
</div>
 <hr>
 <div class="row text-center align-items-center p-4" style="border:none;background-color:rgba(203, 146, 81, 0.3);">
          <div class="col-md-12">
            <h2 class="text-center p-2 fs-3 text-secondary">Trabajamos con grandes marcas</h2>
          </div>
          <div class="col mb-2">
            <img  class="" src="icons/bosh.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="icons/philips.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="icons/caterpillar.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="icons/stanley.svg" alt="payment" style="width:90px;">
          </div>
    </div>
</main>
    <?php
        require_once '../app/views/layout/footer.php';
    ?>
      <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</body>
</html>