
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
</head>


<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>   
<!-- main -->
<main class="container pt-4 pb-4">
    <?php
      include '../../../app/controller/ProviderController.php';
      $provider = new ProviderController();
      $id = 0;
    ?>
    <div class="container pt-5">
      <div class="row">
        <div class="col mb-2">
          <form action="" class="" role="search" method="GET">
            <div class="input-group mb-3">
              <input type="search" class="form-control" placeholder="Nombre del proveedor" aria-label="Search" aria-describedby="basic-addon1" name="term" id="term">
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="search-provider">Buscar</button>
            
            </div>
          </form>
        </div>
        <div class="col-md-auto mb-2">
          <form action="" method="GET">
          <div class="input-group mb-3">
              <select class="form-select" aria-label="Default select example" name="filter" id="filter">
                <option value="all" selected>Seleccionar</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
              </select>
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="filter-provider">Filtrar</button>
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="all-provider"><i class="bi bi-arrow-clockwise"></i></button>
            </div>
            </form>
        </div>
        <div class="col col-lg-2 mb-2">
            <a class="btn btn-outline-secondary"  href="../../../app/views/admin/FormProvider.php">
                    Crear Proveedor
            </a>
        </div>
  </div>
  </div>
  <br>
  <div class="row justify-content-between">
    <h4 class="col-2 "><span class="">Proveedores</span></h4>
    <h4 class="col-2">N° <?=  count($provider->getProvider())?></h4>
  </div>
  <hr>
  <div class="table-responsive"  style="height:500px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Estado</th>
        <th scope="col">Teléfono</th>
        <th scope="col">Dirección</th>
        <th scope="col">Registro</th>
        <th scope="col">Descripción</th>
        <th colspan="2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
    <?php
      foreach($provider->searchProvider() as $value) {
        ?>
          <tr>
            <th scope="row"><?= $value['idProvider']?></th>
            <td class="text-truncate"><?= $value['name']?></td>
            <td class="text-truncate"><?= $value['state']?></td>
            <td class="text-truncate"><?= $value['phone']?></td>
            <td class="text-truncate"><?= $value['address']?></td>
            <td class="text-truncate"><?= $value['email']?></td>
            <td class="text-truncate"><?= $value['dateRegister']?></td>
            <td class="">
                <a class="col me-2 btn btn-outline-secondary" href="../../../app/views/admin/FormProvider.php?id=<?=$value['idProvider']?>" ><i class="bi bi-pencil" >
              </i> Editar
              </a>
            </td>
              <td class="">
                <a href="../../../app/controller/ProviderController.php?id=<?= $value['idProvider'] ?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-trash3"></i> Eliminar</a>
              </td>
          </tr>
              <?php
            }
            ?>
            
    </tbody>
  </table>
  </div>
  <?php
    if(!empty($_REQUEST['page'])) {
      $_REQUEST['page'] = $_REQUEST['page'];
    } else {
      $_REQUEST['page'] = "1";
    }
    if($_REQUEST['page'] == 1) {
      $previous = "1";
    }
    $totalPages = count($provider->getProvider());
    
  ?>
</main>
<!-- Script -->
  <!-- Bootstrap JavaScript Libraries -->  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

