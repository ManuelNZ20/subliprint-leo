
<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
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
  <div class="container pt-5">
    <div class="row">
        <div class="col-md-6">
          <form action="" class="" role="search" method="GET">
          <input type="hidden" name="idInventory" value="<?=$idInventory; ?>">
            <div class="input-group mb-3">
              <input type="search" class="form-control" placeholder="Buscar" aria-label="Search" aria-describedby="basic-addon1" name="term" id="term">
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="search-product">Buscar</button>
            </div>
            <div class="input-group mb-3">
              <select class="form-select" aria-label="Default select example" name="filter" id="filter">
                <option value="all" selected>Seleccionar</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
              </select>
            </div>

          </form>
        </div>
        
        <div class="col-md-6 mb-3">
          <form action="" method="get">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
              <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
              <label class="btn btn-outline-success" for="btnradio1">Aceptados</label>
              <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
              <label class="btn btn-outline-danger" for="btnradio2">Rechazados</label>
              <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
              <label class="btn btn-outline-warning" for="btnradio3">Pendientes</label>
            </div>
            <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="filter-provider">Filtrar</button>
            <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name=""><i class="bi bi-arrow-clockwise"></i></button>
          </form>
        </div>
    </div>
  </div>
  <div class="row justify-content-between mt-3">
    <h4 class="col"><span class=""><i class="bi bi-cart-dash"></i> Pedidos pendientes</span></h4>
    <h4 class="col text-end">N° <?= "1"?></h4>
  </div>
  <hr>
  <div class="table-responsive mb-5"  style="">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre del clientes</th>
        <th scope="col">Fecha de pedido</th>
        <th scope="col">Método de pago</th>
        <th scope="col">Monto cobrado</th>
        <th scope="col">Estado pendiente</th>
        <th class="text-center" colspan="2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
      <tr>
        <th class="align-middle" scope="row">
          1
        </th>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="align-middle">
            <span class="d-inline-block text-truncate" style="max-width: 150px;">
              <?="value['name']"?>
            </span>
        </td>
        <td class="">
          <a href="../../../app/views/admin/FormProvider.php?id=<?=$value['idProvider']?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-info-circle"></i> Detalles</a>
        </td>
        <td class="">
          <form action="../../../app/controller/ProviderController.php?id=<?= $value['idProvider'] ?>" method="POST">
            <button class="col me-2 btn btn-outline-success" name="btnDelete" ><i class="bi bi-check-circle"></i> Confirmar
          </button>
          </form>
        <!-- ../../../app/views/admin/FormProvider.php -->
        </td>
      </tr>   
    </tbody>
  </table>
</div>


  
  
    

</main>
<!-- footer -->
<!-- include('../../../presentation/templates/footer.php'); -->
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

