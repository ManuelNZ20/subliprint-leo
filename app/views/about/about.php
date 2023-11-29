<?php
session_start();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../public/';
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
  <div class="container pt-5">
    <div class="card mb-3" style="border:none; background-color:rgba(215, 139, 50, 0.1);">
    <div class="row g-0">
      <div class="col-md-6 p-4">
        <div class="card-body mx-auto p-2  w-75 text-start" >
          <h5 class="card-title fs-3">¿Quienes somos?</h5>
          <p class="card-text text-wrap ">Somos Roberto Cotlear, tu fuente confiable de herramientas y materiales de construcción desde 2010. Nos enorgullece ofrecer a nuestros clientes productos de alta calidad y un servicio excepcional para satisfacer todas sus necesidades de construcción y reparación.</p>
        </div>
      </div>
      <div class="col-md-6">
        <img src="../../../public/img/img-home.png" class="w-100 h-100 img-fluid card-img" alt="image-about" style="">
      </div>
    </div>
    </div>
    <div class="card mb-3 shadow" style="border:none;">
        <div class="card-body row align-items-center">
          <div class="col-md-2 text-center">
            <img  class="" src="../../../public/icons/mission.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col">
            <h5 class="card-title col-md-4" style="color:var(--background-color-components-1);">
              Misión
            </h5>
            <p class="card-subtitle mb-2 text-body-secondary col-md-auto fs-5">Nuestra misión es brindar a nuestros clientes las mejores soluciones para sus proyectos, ya sean pequeños trabajos de bricolaje o proyectos de construcción a gran escala. Nos esforzamos por ofrecer productos confiables y duraderos que faciliten y mejoren la vida de nuestros clientes.</p>
          </div>
        </div>
    </div>
    <div class="card mb-3 shadow" style="border:none;">
        <div class="card-body row align-items-center">
          <div class="col-md-2 text-center">
            <img  class="" src="../../../public/icons/vision.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col">
            <h5 class="card-title col-md-4" style="color:var(--background-color-components-1);">
              Visión
            </h5>
            <p class="card-subtitle mb-2 text-body-secondary col-md-auto fs-5">Ser líderes en el mercado ferretero y de pinturas, ofreciendo un servicio rápido eficiente y de calidad basado en la innovación continua con un equipo de trabajo capacitado, comprometiéndonos a brindar el mejor servicio, siendo los mejores en el mercado.</p>
          </div>
        </div>
    </div>
    <div class="card mb-3 shadow" style="border:none;">
        <div class="card-body row align-items-center">
          <div class="col-md-2 text-center">
            <img  class="" src="../../../public/icons/values.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col">
            <h5 class="card-title col-md-4" style="color:var(--background-color-components-1);">
              Valores
            </h5>
            <p class="card-subtitle mb-2 text-body-secondary col-md-auto fs-5">En la ferretería Roberto Cotlear, valoramos la integridad, la calidad y la satisfacción del cliente. Nos esforzamos por mantener relaciones a largo plazo con nuestros clientes y proveedores, basadas en la confianza y la excelencia en el servicio.</p>
          </div>
        </div>
    </div>
    <div class="card mb-3 shadow" style="border:none;background-color:rgba(203, 146, 81, 0.833);">
        <div class="card-body row align-items-center">
          <div class="col-md-2 text-center">
            <img  class="" src="../../../public/icons/location.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col">
            <h5 class="card-title col-md-4" style="color:white;">
              Ubicación
            </h5>
            <p class="card-subtitle mb-2 text-body-secondary col-md-auto fs-5">Puedes encontrarnos en Av. Sanchez Cerro 629-633, donde nuestro equipo de expertos en ferretería estará encantado de ayudarte a encontrar las herramientas y materiales adecuados para tu próximo proyecto.</p>
          </div>
          <div class="col-md-12 text-center">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.444007127352!2d-80.63016752510295!3d-5.192676394784893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x904a10795a73c181%3A0x8229277bef89b950!2sAv.%20S%C3%A1nchez%20Cerro%20629%2C%20Piura%2020001!5e0!3m2!1ses-419!2spe!4v1699457804434!5m2!1ses-419!2spe" width="800" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="container-fluid w-75 mt-2"></iframe>
          </div>
        </div>
    </div>
    <div class="card mb-3 shadow" style="border:none;">
        <div class="card-body row align-items-center">
          <div class="col-md-2 text-center">
            <img  class="" src="../../../public/icons/values.svg" alt="payment" style="width:90px;">
          </div>
          <div class="col">
            <h5 class="card-title col-md-4" style="color:var(--background-color-components-1);">
              Horario de atención
            </h5>
            <p class="card-subtitle mb-2 text-body-secondary col-md-auto fs-5">En la ferretería Roberto Nuestro horario de atención es de  9:00 A.M  a 7:00 P.M de lunes a viernes, y de 9:00 A.M a 2:00 P.M los sábados.</p>
          </div>
        </div>
    </div>
  </div>
</main>
<!-- footer -->
  <?php
    require_once('../../../app/views/layout/footer.php');
    // require_once '../app/views/layout/header.php';
  ?> 
  <!-- Maps -->
  <script src="../../../public/js/scriptMap.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=iniciarMap"></script>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

