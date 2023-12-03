<?php
session_start();
require_once('../../../app/controller/ProductController.php');
require_once('../../../app/controller/UserController.php');
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
?>
<!doctype html>
<html lang="en">

<head>
  <title>Ferretería roberto cotlear</title>
  <!-- Required meta tags -->
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

<!-- main -->
<main class="container pt-4 mb-3">
  <div class="container pt-5 pb-3">
    
    <div class="row">
      <div class="col-md-4 p-4 rounded mb-3"  style="background-color:rgba(215, 139, 50, 0.1);">
        <h4>Información de contacto</h4>
        <p>Contacte con nosotros para cualquier consulta o comentario que tenga. Nos encantaría saber de usted.</p>
        <div class="row align-items-center">
          <div class="col-md-2 mb-4">
            <img class="" src="../../../public/icons/location-contact.svg" alt="Ubicación" style="width:25px;">
          </div>
          <div class="col-md-8">
            <p class="text-wrap text-truncate">Dirección: Av. Sanchez  Cerro 929-633</p>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-md-2 mb-4">
            <img class="" src="../../../public/icons/phone.svg" alt="Telefono de contact" style="width:25px;">
          </div>
          <div class="col-md-8">
            <p>969518850</p>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-md-2 mb-4">
            <img class="" src="../../../public/icons/message.svg" alt="Correo" style="width:25px;">
          </div>
          <div class="col-md-8">
            <p class="text-wrap text-truncate">ventas@ferreteriacotlear.com</p>
          </div>
        </div>
      </div>
      <div class="col-md-8 mb-3">
      <h1 class="text-center fs-3">Contactate con nosotros</h1>
        <?php
          if(isset($_SESSION['messageSendMail'])) {
        ?>
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $_SESSION['messageSendMail']?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php
          unset($_SESSION['messageSendMail']);
          }
        ?>
        <form action="../../../app/controller/AuthController.php" method="POST">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="mail" required>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Mensaje</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="5" style="resize:none;" name="subject" required></textarea>
          </div>
          <button type="submit "class="col-4 btn btn-landing-page mb-2" name="btnSendMailContact">Enviar</button>
        </form>
      </div>
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
          <a href="../../../app/views/products/productDetail.php?idProduct=<?=$product['idProduct']?>" class="btn btn-outline-secondary rounded-circle"><i class="bi bi-bag-plus"></i></a>
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
            <img  class="" src="../../../public/icons/bosh.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="../../../public/icons/philips.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="../../../public/icons/caterpillar.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col mb-2">
            <img  class="" src="../../../public/icons/stanley.svg" alt="payment" style="width:90px;">
          </div>
  </div>
</main>
<!-- footer -->
  <?php
    require_once('../../../app/views/layout/footer.php');
    // require_once '../app/views/layout/header.php';
  ?> 
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

