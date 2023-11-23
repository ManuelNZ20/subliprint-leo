<?php
session_start();
require_once('../../../app/controller/ProductController.php');
require_once('../../../app/controller/CategoryController.php');
$categoryController = new CategoryController();
$productController = new ProductController();
$id = isset($_GET['idProduct']) ? $_GET['idProduct'] : '';
$amount = isset($_GET['amountProduct']) ? $_GET['amountProduct'] : 1;
$product = $productController->getProductByIdInventoryByProduct($id);
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
    <div class="pt-5 container">
        <div class="row g-3">
            <div class="col-md-12">
                <h3 class="text-center">Detalles del producto</h3>
            </div>
            <div class="col-md-5">
                <img class="img-fluid rounded w-100" style="height:350px;"src="<?=$product['imgProduct']?>" alt="">
            </div>
            <div class="col-md-7">
                <h4 class="text-wrap">
                    <?=$product['nameProduct']?>
                </h4>
                <p class="fs-2">
                    S/. <?=number_format($product['price'],2)?>
                </p>
                <hr>
                <p class="text-wrap text-truncate">
               <?=$product['description']?>
                </p>
                <div class="col-md-12 mt-3">
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Marca: </h6>
                        </div>
                        <div class="col-md-2">
                            <h6 class="text-secondary"><?=$product['brand']?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Código de producto: </h6>
                        </div>
                        <div class="col-md-2">
                            <h6 class="text-secondary"><?=$product['idProduct']?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="text-truncate">Disponibilidad:</h6>
                        </div>
                        <div class="col-md-2">
                            <h6 class="text-secondary">
                                <?php
                                    if($product['amountInit'] > 0) {
                                        echo 'En stock';
                                    } else {
                                        echo 'Agotado';
                                    }?>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="row g-2">
                        <div class="col-md">
                            <form action="../../../app/model/CartModel.php" method="post">
                                <input type="hidden" name="idProduct" value="<?=$product['idProduct']?>">
                                <button type="button" class="btn btn-outline-secondary" onclick="incrementar('<?=$product['idProduct']?>')"><i class="bi bi-plus-lg"></i></button>
                                <input class="align-middle m-2 fs-4 d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2" type="text" id="contadorInput<?=$product['idProduct']?>" value="<?=$amount?>" style="width:80px; text-align:center;" name="amount" readonly>
                                <button type="button" class="btn btn-outline-secondary" onclick="decrementar('<?=$product['idProduct']?>')"> <i class="bi bi-dash-lg"></i></button>
                            </div>
                            <div class="col-md">
                                <button type="submit"  class="btn background-general mb-2" onclick="" name="btn-addCart">
                                    Agregar al carrito
                                </button>
                                <a href="products.php" class="btn btn-outline-secondary mb-2">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-3">
    <h3 class="text-center mt-3 mb-3"><span class="badge"  style="background-color:var(--background-color-components-1);">PRODUCTOS DESTACADOS</span></h3>
    <!--TODO: listar con base de datos al menos 8 productos -->
    <hr>
    <div class="w-100 row justify-content-center gap-3 g-1">
    <!-- content card -->
    <?php
      foreach($productController->getProductsRand() as $product) {
    ?>
        <div class="card p-0 shadow-sm pt-1" style="width: 15rem; border:none;">
          <img src="<?=$product['imgProduct']?>" class="w-100 card-img-top" alt="<?=$product['nameProduct']?>" style="height:200px;object-fit:cover;"
            >
          <div class="card-body" style="height:120px;">
            <h5 class="card-title text-wrap text-truncate" style="height:50px;"><?=$product['nameProduct']?></h5>
            <p class="card-text text-truncate fs-5" style="color:rgba(203, 147, 81, 1);">S/. <?=number_format($product['price'],2)?></p>
          </div>
          <div class="card-body">
                <a class="btn btn-outline-secondary rounded-circle" href="?idProduct=<?=$product['idProduct']?>" name="idProduct">
                <i class="bi bi-bag-plus"></i>
                </a>
          </div>
        </div>
    <?php
      }
    ?>
    </div>
    </div>

</main>
  <!-- footer --> 
  <?php
    require_once('../../../app/views/layout/footer.php');
  ?> 
  <script src="../../../public/js/amountProduct.js"></script>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

