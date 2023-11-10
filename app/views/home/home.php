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
        require_once '../app/views/layout/header.php';
    ?>
   <main class="container pt-4 ">
      <div class="pt-5">
          <div class="mb-3" style="border:none; background-color:rgba(215, 139, 50, 0.1);">
            <div class="row g-0">
              <div class="col-md-6">
                <img src="img/img-home.png" class="w-100 h-100 img-fluid card-img" alt="image-about" style="">
              </div>
          <div class="col-md-6 p-4">
            <div class="card-body mx-auto p-2  w-75 text-start" >
              <h5 class="card-title fs-3">"TODO LO QUE NECESITAS PARA CONSTRUIR TUS SUEÑOS".</h5>
              <p class="card-text text-wrap ">Explorar los productos de las mejores marcas que tenemos para ofrecerte</p>
              <a href="<?="../app/views/about/about.php"?>" class="btn btn-landing-page mb-2">Sobre nosotros</a>
            <a href="#" class="btn btn-outline-secondary mb-2">Contáctanos</a>
            </div>
          </div>
        </div>
      </div>
      </div>
  
    <!-- cards -->
    <div class="row">
      <?php
        include('../app/views/layout/cards.php');
        echo cardInformation('','Nuevos Productos para arreglar','Herramientas innovadoras para proyectos modernos.','url','','img/tools-construction-1.png','Comprar ahora');
        echo cardInformation('','Contamos con varios Productos','Haz click para explorar nuestros productos.','url','','img/tools-construction-2.png','Comprar ahora');
        // include '../config/database.php'; conexión e
      ?>
    </div>
    <div class="card-group mt-3 shadow-sm rounded">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">
            <img src="icons/engineering.svg" alt="payment" style="width:35px;">
            Asesoramiento técnico
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Te ayudamos a seleccionar las mejores herramientas para tus proyectos</p>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">
            <img src="icons/delivery.svg" alt="payment" style="width:35px;">
            Asesoramiento técnico
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Te ayudamos a seleccionar las mejores herramientas para tus proyectos</p>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">
            <img src="icons/payment.svg" alt="payment" style="width:35px;">
            Asesoramiento técnico
          </h5>
          <p class="card-subtitle mb-2 text-body-secondary">Te ayudamos a seleccionar las mejores herramientas para tus proyectos.
          </p>
        </div>
      </div>
    </div>
    <h3 class="text-center mt-3 mb-3"><span class="badge"  style="background-color:var(--background-color-components-1);">PRODUCTOS DESTACADOS</span></h3>
    <hr>
   <!--TODO: listar con base de datos al menos 8 productos -->
   <div class="row row-cols-1 row-cols-md-4 g-5 mb-3 p-3">
    <!-- content card -->
    <?php for ($i=0; $i < 8 ; $i++) { ?>
      <div class="col-md-3">
        <div class="card w-100">
          <img src="img/img-home-1.png" class="card-img-top" alt="...">
          <div class="card-body p-3">
            <h5 class="card-title col-10 text-truncate">Set de herramientas</h5>
            <p class="card-text text-warning">S/. 19,90</p>
            <button class="btn btn-outline-secondary rounded-circle" type=""><i class="bi bi-bag"></i></button>
          </div>
        </div>
   </div>
  <?php }?>
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