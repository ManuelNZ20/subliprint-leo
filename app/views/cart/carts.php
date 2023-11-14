<?php
session_start();
require_once('../../../app/controller/CartController.php');

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
<main class="container pt-4 mb-3">
<div class="table-responsive mb-5 mt-5"  style="height:600px;">
    <table class="table table-sm table-hover">
      <thead class="table-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Imagen</th>
        <th scope="col">Precio</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Sub Total</th>
        <th scope="col" colspan="2">Acción</th>
      </tr>
    </thead>
    <tbody id="content" name="content" class="">
      <tr class=" ">
          <th class="align-middle" scope="row">1</th>
          <td class="align-middle">
            <img class="img " src="" alt="imagen" style="border-radius:10px; width:270px;">
          </td>
          <td class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
            Producto A
            </span>
          </td>
          
          <td class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
              100</span>
          </td>
          <td  class="text-truncate align-middle">
            <span class="d-inline-block text-truncate"  style="max-width: 150px;">
            330
            </span>
          </td>
          <td  class="align-middle" >
            <span class="align-middle d-inline-block text-truncate"  style="max-width: 150px;">
            3300
            </span>
          </td>
          <td class="align-middle">
              <a href="../../../app/views/admin/FormProduct.php?id=<?=$product['idProduct']?>&idInventory=<?=$idInventory?>" class="col me-2 btn btn-outline-secondary"><i class="bi bi-info-circle"></i>
            </a>
            </td>
          <td class="align-middle">
            <form action="../../../app/controller/ProductController.php?id=<?=$product['idProduct']?>&idInventory=<?=$idInventory?>" method="POST">
             <button class="col me-2 btn btn-outline-secondary" name="btnDelete" ><i class="bi bi-trash3"></i>
            </button>
            </form>
          </td>
        </tr>

    </tbody>
  </table>
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

