<?php
session_start();
require_once('../../../app/controller/ProductController.php');
require_once('../../../app/controller/CategoryController.php');
$categoryController = new CategoryController();
$productController = new ProductController();
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '../../../app/views/home/home.php';
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
</head>


<body>
  <!-- header -->
  <?php
    require_once('../../../app/views/layout/header.php');  
  ?>

<!-- main -->
<main class="pt-4">
    <div class="container pt-5">
    <div class="row justify-content-between ">
        <h4 class="col"><span class=""><i class="bi bi-box-seam"></i>  Productos <?=count($productController->getProducts()) ?></span></h4>
        <div class="col-md-4">
          <form action="" method="GET">
          <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example" name="filterCategory" id="filterCategory">
                <option value="all" selected>Seleccionar</option>
                <?php
                  foreach($categoryController->getCategoryActive() as $category):
                ?>
                   <option value="<?=$category['idCategory'];?>">
                    <?=$category['nameCategory']?>
                  </option>;
                <?php
                  endforeach;
                ?>
              </select>
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="filter-productCategory">Filtrar</button><!--Filtrar por id category-->
              <button type="submit" class="btn btn-outline-secondary" id="basic-addon1" name="all-product"><i class="bi bi-arrow-clockwise"></i></button>
              </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center gap-2 g-1">
    <!-- content card -->
    <?php
      $productController = new ProductController();
      // $productController->ge
      foreach($productController->getProductsByCategory() as $product) {
    ?>
        <div class="card p-0 shadow-sm pt-1" style="width: 15rem; border:none;">
          <img src="<?=$product['imgProduct']?>" class="w-100 card-img-top" alt="<?=$product['nameProduct']?>" style="height:200px;object-fit:cover;"
            >
          <div class="card-body" style="height:120px;">
            <h5 class="card-title text-wrap text-truncate" style="height:50px;"><?=$product['nameProduct']?></h5>
            <p class="card-text text-truncate fs-5" style="color:rgba(203, 147, 81, 1);">S/. <?=number_format($product['price'],2)?></p>
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

