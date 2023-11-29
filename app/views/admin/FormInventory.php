<?php
session_start();
    require_once('../../../app/controller/ProviderController.php');
    $providerController = new ProviderController();
    date_default_timezone_set('America/Lima');
    $id = 0;
    $dateRegister = date('Y-m-d');
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
<main class="container pt-4 mb-4">
    <div class="container pt-5">
      <div class="row align-items-center">
        <div class="col mb-2">
            <div class="row align-items-center">
                <div class="col-auto"> <i class="bi bi-pencil" >
              </i></div>
                <h4 class="col-6 col-sm-3">Inventario</h4>
            </div>
        </div>
        <div class="col-md-auto mb-2">
            <div class="row">
                <h4 class="col-auto">ID:</h4>
                <h4 class="col-auto"><?= "Nuevo";
                    ?>
                </h4>
            </div>
        </div>
        <div class="col-md-auto mb-2">
            <div class="row">
                <h4 class="col-auto">Fecha de registro:</h4>
                <h4 class="col-auto"><?= $dateRegister;
                    ?>
                </h4>
            </div>
        </div>
  </div>
  <hr>
  </div>
  <form class="row g-3" action="../../../app/controller/InventoryController.php" method="POST">
  <div class="col-md-12">
    <?php
        if(isset($_SESSION['messageInventory'])){
    ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $_SESSION['messageInventory'];?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        unset($_SESSION['messageInventory']);
        }
    ?>
  <label for="noteInventory" class="form-label">Nota</label>
  <textarea class="form-control" id="noteInventory" name="noteInventory" rows="3" cols="4" style="resize:none;" required><?=($id>0)?$description:''; ?></textarea>
  </div>
  <div class="col-md">
    <label for="dateProvider" class="form-label">Fecha de registro</label>
    <input type="date" class="form-control" id="dateProvider" name="dateInventory" value="" required>
  </div>
  <div class="col-md">
    <label for="stateProvider" class="form-label">Estado</label>
    <select class="form-select" aria-label="Default select example" name="idProvider" id="idProvider" required>
        <option value="all">Seleccionar</option>
        <?php
            foreach ($providerController->getProvider() as $state) {
        ?>
                <option value="<?=$state['idProvider']?>"><?=$state['name']?></option>
        <?php
            }
        ?>
    </select>
  </div>
  
  <div class="col-12 text-end">
    <button id="btnInventory" class="col-3 btn btn-outline-secondary"  name="btnInventory" value="Crear">
    <i class="bi bi-floppy"></i> Crear
    </button>
    <a class="col-3 btn btn-outline-secondary"  href="../../../app/views/admin/inventory.php">
    <i class="bi bi-arrow-left-circle"></i> Cerrar
    </a>
  </div>
</form>
  
</main>
<!-- Script -->
  <!-- Bootstrap JavaScript Libraries -->  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

