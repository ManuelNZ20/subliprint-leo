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
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqpzipc8i/image/upload/v1702060222/ecommerce/dzrsdoymsbzu225j8e3u.ico" type="image/x-icon">
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
      <div class="col-md-4 p-4 rounded mb-3"  style=" background-color:rgba(1, 141, 821, .1);">
        <h4>Información de contacto</h4>
        <p>Enviamos 2 a 3 opciones del diseño para la aprobación del cliente, una vez aprobado por el cliente, se ejecuta el trabajo y se envía fotos.Listo el producto, el producto se procede a cancelar el 50% restante y se entrega.También hacemos servicios de delivery, consulte precios.</p>
        <div class="row align-items-center">
        <a href="https://api.whatsapp.com/send?phone=%2B51981518655&data=ARD5bJFSxbZgBdTmUov3bmSnlKBli-ZJBjJxhzGlK2CYT3Oa51nnJ4CIROFUJevltehGqJP-06zgSwpeuy_bEuHtDMR4NfiO2Qo3u4wfZvRQEA-bxVvxFXTNZQJwyloCOFOo3lBsKz5QXXsbK3t8PLeczQ&source=FB_Page&app=facebook&entry_point=page_cta&fbclid=IwAR3uUucuj4XFwz-NMhbY0CH2CFJt4ckl0jlGWNz1-0ieFnqrn-kCzFd-Pkw" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.facebook.com/profile.php?id=100084859817775&mibextid=ZbWKwL&_rdc=2&_rdr" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/subliprint_leo/?igshid=OGQ5ZDc2ODk2ZA%3D%3D" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://www.tiktok.com/@subliprint_leo?_t=8hkG2iqs4MI&_r=1" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" fill="#6c757d"/></svg></a>
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
  <h3 class="text-center mt-3 mb-3"><span class="badge" style="background-color:#007bff;">PRODUCTOS DESTACADOS</span></h3>
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

