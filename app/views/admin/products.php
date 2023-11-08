<?php
  require_once('../../../app/controller/ProductController.php');
  require_once('../../../app/controller/CategoryController.php');

  if(isset($_GET['idInventory'])) {
    $idInventory = $_GET['idInventory'];
  } else {
    $idInventory = 0;
  }
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
</head>
<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');
  ?>   
<!-- main -->
<main class="container pt-4 pb-4">
  <?php
      $category = new CategoryController();
      $productController = new ProductController();
      $id = 0;
    ?>
  <div class="container pt-5">
    <div class="row ">
      <div class="col-md-auto mb-2">
        <a href="../../../app/views/admin/inventory.php" class="btn btn-outline-secondary w-100 row"><i class="bi bi-arrow-left"></i> <b>Volver</b></a>
      </div>
       <div class="col mb-2">
          <form action="" class="" role="search" method="GET">
            <div class="input-group mb-3">
              <input type="search" class="form-control" placeholder="Nombre del producto" aria-label="Search" aria-describedby="basic-addon1" name="term" id="term">
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="search-provider">Buscar</button>
            </div>
          </form>
        </div>
        <div class="col-md-4 mb-2">
          <form action="" method="GET">
            <!-- Campo oculto para idInventory -->
          <input type="hidden" name="idInventory" value="<?=$idInventory; ?>">
          <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example" name="filterCategory" id="filterCategory">
                <option value="all" selected>Seleccionar</option>
                <?php
                foreach($category->getCategory() as $category) {
                  if($category['statusCategory'] == 'activo') {
                  }
                  echo '<option value="'.$category['idCategory'].'">'.$category['nameCategory'].'</option>';
                }
                ?>
              </select>
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="filter-category">Filtrar</button>
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="all-product"><i class="bi bi-arrow-clockwise"></i></button>
              </div>
            </form>
        </div>
        <div class="col-md-2 mb-2">
            <a class="btn btn-outline-secondary w-100"  href="../../../app/views/admin/FormProduct.php<?='?idInventory='.$idInventory?>" ><i class="bi bi-box-seam"></i> Crear Producto
            </a>
        </div>
    </div>
  </div>
  <br>
  <div class="row justify-content-between">
    <h4 class="col-md-2 text-truncate"><span class=" align-middle"><i class="bi bi-box-seam"></i> Productos</span></h4>
    <h4 class="col-md-2 text-truncate"><span class="align-middle"><i class="bi bi-box"></i> Inventario <?= $idInventory ?></span></h4>
    <h4 class="col text-end"><span class="align-middle">N° <?=$productController->countProducts($idInventory)?></span>
    </h4>
  </div>
  <hr>
  <!-- table products -->
  <div class="table-responsive mb-5"  style="height:600px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Imagen</th>
        <th scope="col">Precio</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Categoría</th>
        <th scope="col">Estado</th>
        <th class="text-center"colspan="2" scope="col">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
      <?php
        foreach( $productController->getProductsByIdInventory($idInventory) as $product ) {
      ?>
        <tr class=" ">
          <th class="align-middle" scope="row"><?=$product['idProduct']?></th>
          <td class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
            <?=$product['nameProduct']?>
            </span>
          </td>
          <td class="align-middle">
            <img class="img " src="<?=$product['imgProduct']?>" alt="imagen" style="border-radius:10px; width:270px;">
          </td>
          <td class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
              <?=$product['price']?></span>
          </td>
          <td  class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
              <?=$product['amountInit']?></span>
          </td>
          <td  class="align-middle" >
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
              <?=$product['nameCategory']?>
            </span>
          </td>
          <td  class="text-truncate align-middle text-success">
            <i class="bi bi-circle"></i> <?=$product['statusProduct']?>
          </td>
          <td class="align-middle">
              <a href="../../../app/views/admin/FormProduct.php?id=<?=$product['idProduct']?>&idInventory=<?=$idInventory?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-pencil" >
              </i> Editar</a>
            </td>
          <td class="align-middle">
            <form action="../../../app/controller/ProductController.php?id=<?=$product['idProduct']?>&idInventory=<?=$idInventory?>" method="POST">
             <button class="col me-2 btn btn-outline-secondary" name="btnDelete" ><i class="bi bi-trash3"></i> Eliminar
            </button>
            </form>
          <!-- ../../../app/views/admin/FormProvider.php -->
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
            // if($_REQUEST['page'] == 1) {
            //   $_REQUEST['page'] = 0;
            // } else {
            //   if($page > 1 ) {
            //     $previous = $_REQUEST['page'] - 1;
        ?>
              <a class="page-link link-secondary" href="?page=<?=$previous ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
        <?php
            //   }
            // }
        ?>
      </li>
        <?php
          // for($i = 1; $i <= $totalPages; $i++) {
          //   if($page == $i) {
          //     echo '<li class="page-item"><a class="page-link link-secondary" href="?page='.$i.'">'.$i.'</a></li>';
          //   } else {
          //     echo '<li class="page-item"><a class="page-link link-secondary" href="?page='.$i.'">'.$i.'</a></li>';
          //   }
          // }
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

