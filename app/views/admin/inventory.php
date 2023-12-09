<?php
session_start();
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
    <link rel="shortcut icon" href="https://res.cloudinary.com/dqpzipc8i/image/upload/v1702060222/ecommerce/dzrsdoymsbzu225j8e3u.ico" type="image/x-icon">
</head>
<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>   
<!-- main -->
<main class="container pt-4">
  <?php
      require_once('../../../app/controller/InventoryController.php');
      require_once('../../../app/controller/ProviderController.php');
      $provider = new ProviderController();
      $inventoryController = new InventoryController();
      $id = 0;
    ?>
  <div class="container pt-5">
    <div class="row ">
    <div class="col mb-2">
          <form action="" class="" role="search" method="GET">
            <div class="input-group">
              <input type="date" class="form-control" placeholder="Fecha de inventario" aria-label="Search" aria-describedby="basic-addon1" name="date" id="date">
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="search-inventory">Buscar</button>
            </div>
          </form>
        </div>
        <div class="col-md-auto mb-2">
          <form action="" method="GET">
          <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name=""><i class="bi bi-arrow-clockwise"></i></button>
          </form>
        </div>
        <div class="col-md-2 mb-2">
            <a class="btn btn-outline-secondary w-100"  href="../../../app/views/admin/FormInventory.php"><i class="bi bi-journal-plus"></i> Crear Inventario </a>
        </div>
    </div>
  </div>
  <br>
  <div class="row justify-content-between">
    <h4 class="col"><span class="">Inventarios</span></h4>
    <h4 class="col text-end"><i class="bi bi-box"></i> N° <?=$inventoryController->countInventory()?></h4>
  </div>
  <?php
    if(isset($_SESSION['messageInventory'])) {
  ?>

  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <?= $_SESSION['messageInventory']?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php
      unset($_SESSION['messageInventory']);
    }
  ?>

  <hr>
  <!-- table products -->
  <?php
  if(!empty($_REQUEST['page'])) { // comprueba si la variable page esta vacia
    $_REQUEST['page'] = $_REQUEST['page']; // si no esta vacia pasa el valor de la variable page a $page
  } else {
    $_REQUEST['page'] = "1"; // si esta vacia el valor de la variable page es 1
  }
  if($_REQUEST['page'] == 1) {
    $previous = "1"; // si la variable page es 1 el valor de previous es 1
  }
  $totalPages = $inventoryController->countInventory();// cuenta el total de registros
  $registros = 8 -1 ; // cantidad de registros por pagina menos 1
  $page = $_REQUEST['page']; // pagina actual
  if(is_numeric($page)) { // comprueba si la pagina es un numero
    $inicio = (($page - 1) * $registros); // toma la pagina actual y la multiplica por la cantidad de registros por pagina
    $totalPages = ceil($totalPages / $registros); // redondea un numero hacia arriba
    $inventoryPage = $inventoryController->paginationInventory($inicio, $registros); // llama al metodo pagination
    $next = $_REQUEST['page'] + 1; // suma 1 a la pagina actual
    $previous = $_REQUEST['page'] - 1; // resta 1 a la pagina actual
  }else {
    $inventoryPage = $inventoryController-> paginationInventory(0, $registros);// muestra la pagina 1
    $page = ceil($totalPages / $registros);// redondea un numero hacia arriba
  }
?>
  <div class="table-responsive mb-5"  style="">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th class="col-2" scope="col">ID</th>
        <th class="col-3" scope="col">Nota</th>
        <th class="col" scope="col">Fecha de creación</th>
        <th class="col-2" scope="col">Proveedor</th>
        <th class="text-center" colspan="2" class="col-2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
      <?php
        foreach ($inventoryPage as $value) {
      ?>
        <tr class=" ">
            <th class="align-middle" scope="row">
              <?= $value['idInventory']?>
            </th>
            <td class="align-middle">
              <span class="d-inline-block text-truncate" style="max-width: 150px;">
                <?= $value['note']?>
              </span>
            </td>          
            <td class="align-middle">
              <span class="d-inline-block text-truncate" style="max-width: 150px;">
                <?= $value['dateInventory']?>
              </span>
            </td>          
            <td class="align-middle">
              <span class="d-inline-block text-truncate" style="max-width: 150px;">
                <?= $value['name']?>
              </span>
            </td>
            <td>
              <a class="col me-2 btn btn-outline-secondary" href="../../../app/views/admin/products.php?idInventory=<?= $value['idInventory'] ?>" name="btnExam"><i class="bi bi-info-circle"></i> Detalles</a>
            </td>
            <td class="">
              <form action="../../../app/controller/InventoryController.php?id=<?= $value['idInventory'] ?>" method="POST">
                <button class="col me-2 btn btn-outline-secondary" name="btnDelete" ><i class="bi bi-trash3"></i> Eliminar
              </button>
              </form>
            </td>
        </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
  </div>

  <!-- pagination -->
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <?php
            if($_REQUEST['page'] == 1) {
              $_REQUEST['page'] = 0;
            } else {
              if($page > 1 ) {
                $previous = $_REQUEST['page'] - 1;
        ?>
              <a class="page-link link-secondary" href="?page=<?=$previous ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
        <?php
              }
            }
        ?>
      </li>
        <?php
          for($i = 1; $i <= $totalPages; $i++) {
            if($page == $i) {
              echo '<li class="page-item"><a class="page-link link-secondary" href="?page='.$i.'">'.$i.'</a></li>';
            } else {
              echo '<li class="page-item"><a class="page-link link-secondary" href="?page='.$i.'">'.$i.'</a></li>';
            }
          }
        ?>
    </ul>
  </nav>

</main>
<!-- footer -->
<!-- include('../../../presentation/templates/footer.php'); -->
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

