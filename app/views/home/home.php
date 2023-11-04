<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
   <div class="row g-0 bg-body-secondary position-relative mt-5 mb-3 rounded ">
      <div class="col-md-6 mb-md-0 p-md-4">
        <img src="img/img-home.png" class="w-100 rounded" alt="landing page img">
      </div>
      <div class="col-md-6 p-4 ps-md-0">
        <h5 class="mt-0">"TODO LO QUE NECESITAS PARA CONSTRUIR TUS SUEÑOS".</h5>
        <p>Explorar los productos de las mejores marcas que tenemos para ofrecerte</p>
        <button class="btn btn-landing-page me-2" type="">Sobre nosotros</button>
        <button type="button" class="btn btn-outline-secondary">Contáctanos</button>
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
   <div class="row row-cols-1 row-cols-md-4 g-4 mb-3">
    <!-- content card -->
    <?php for ($i=0; $i < 8 ; $i++) { ?>
      <div class="col">
    <div class="card h-100">
      <img src="img/img-home-1.png" class="card-img-top h-50" alt="...">
      <div class="card-body">
        <h5 class="card-title col-10 text-truncate">Set de herramientas</h5>
        <p class="card-text text-warning">S/. 19,90</p>
        <button class="btn btn-outline-secondary rounded-circle" type=""><i class="bi bi-bag"></i></button>
      </div>
    </div>
   </div>
  <?php }?>
</div>
 <hr>
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