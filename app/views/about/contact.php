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
</head>


<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>

<!-- main -->
<main class="container pt-4 mb-3">
  <div class="container pt-5 pb-3">
    <h1 class="text-center fs-3">Contactate con nosotros</h1>
    <div class="row">
      <div class="col-md-4 p-4 rounded"  style="background-color:rgba(215, 139, 50, 0.1);">
        <h4>Información de contacto</h4>
        <p>Contacte con nosotros para cualquier consulta o comentario que tenga. Nos encantaría saber de usted.</p>
        <div class="row align-items-center">
          <div class="col-md-2 mb-4">
            <img class="w-50" src="../../../public/icons/location-contact.svg" alt="Ubicación">
          </div>
          <div class="col-md-8">
            <p>Dirección: Av. Sanchez  Cerro 929-633</p>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-md-2 mb-4">
            <img class="w-50" src="../../../public/icons/phone.svg" alt="Telefono de contact">
          </div>
          <div class="col-md-8">
            <p>969518850</p>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-md-2 mb-4">
            <img class="w-50" src="../../../public/icons/message.svg" alt="Correo">
          </div>
          <div class="col-md-8">
            <p>ventas@ferreteriacotlear.com</p>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <form action="">

          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Mensaje</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly></textarea>
          </div>
          <button type="submit "class="col-4 btn btn-landing-page mb-2">Enviar</button>
        </form>
      </div>
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

