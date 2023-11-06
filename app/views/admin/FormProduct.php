<?php
date_default_timezone_set('America/Lima');
// TODO: Cambiar el controllador y revisar detalles
require_once('../../../app/controller/ProductController.php');
require_once('../../../app/controller/CategoryController.php');

$controller = new ProductController();
$categoryController = new CategoryController();

if(isset( $_GET['id'] )){
  $edit = true;
  $id = $_GET['id'];
} else {
  $edit = false;
  $id = $controller->createIdUUID();
  $dateRegister = date('d-m-y');
  $state = 'all';
  $imgUrl = 'all';
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
<main class="container pt-4 mb-4">
    <div class="container pt-5">
      <div class="row align-items-center">
        <div class="col mb-2">
            <div class="row align-items-center">
                <div class="col-auto"> <i class="bi bi-pencil" >
              </i></div>
                <h4 class="col-6 col-sm-3">Productos</h4>
            </div>
        </div>
        <div class="col-md-auto mb-2">
            <div class="row">
                <h4 class="col-auto">ID:</h4>
                <h4 class="col-auto"><?=$id?>
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
  <form class="row g-3" action="../../../app/controller/ProviderController.php?id=<?=($edit===true)?$id:''; ?>" method="POST">
  <!--  Nombre -->
  <div class="col-md-6">
      <label for="nameProduct" class="form-label">Nombre del producto</label>
      <input type="text" class="form-control" id="nameProduct" name="nameProduct" value="<?= ($edit===true)?$name:'';?>" required>
    </div>
   <!--  Categoría -->
  <div class="col-md-3">
    <label for="amountProduct" class="form-label">Cantidad</label>
    <input type="email" class="form-control" id="amountProduct" name="amountProduct" value="<?= ($edit===true)?$amount:'';?>" required>
  </div>
  
  <div class="col-md-3">
    <label for="priceProduct" class="form-label">Precio</label>
    <input type="text" class="form-control" id="priceProduct" name="priceProduct" value="<?= ($edit===true)?$price:'';?>" required>
  </div>
  <div class="col-md-3">
    <label for="brandProduct" class="form-label">Marca</label>
    <input type="text" class="form-control" id="brandProduct" name="brandProduct" value="<?= ($edit===true)?$brand:'';?>" required>
  </div>
  <div class="col-md-3">
    <label for="unitProduct" class="form-label">Unidad de medida</label>
    <input type="text" class="form-control" id="unitProduct" name="unitProduct" value="<?= ($edit===true)?$unit:'';?>" required>
  </div>
    <!--  Estado -->
    <div class="col-md-3">
        <label for="statusProduct" class="form-label">Estado</label>
        <select class="form-select" aria-label="Default select example" name="statusProduct" id="statusProduct" required>
            <option value="activo" <?= ($state=='activo')? 'selected':'';?>>Activo</option>
            <option value="inactivo" <?= ($state=='inactivo')? 'selected':'';?>>Inactivo</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="categoryProduct" class="form-label">Categoría</label>
        <select class="form-select" aria-label="Default select example" name="categoryProduct" id="categoryProduct" required>
            <option value="all" <?php if($state=='all') echo 'selected';?>>Seleccionar</option>
            <?php
              foreach ($categoryController->getCategory() as $state) {
            ?>
                    <option value="<?=$state['idCategory']?>"><?=$state['nameCategory']?></option>
            <?php
              }
            ?>
        </select>
    </div>
      <!--  Descripción -->
  <div class="col-md-12">
  <label for="descriptionProduct" class="form-label">Descripción</label>
  <textarea class="form-control" id="descriptionProduct" name="descriptionProduct" rows="3" cols="4" style="resize:none;" required><?=($edit===true)?$description:''; ?></textarea>
  </div>
  <!-- selected -->
    <div class="col-md-12">
        <h4 class="text-start">Imagen</h4>
        <input class="form-control mb-2" type="file" id="imageInput" name="imgProduct" accept="image/*" multiple>
        <div class="container mt-2 pt-4 pb-2" style="height:180px; background-color:var(--bs-tertiary-bg);">
            <img id="imgShow" class="img-fluid float-start rounded mx-auto d-block" src="<?=($edit===true)?$imgUrl:''?>" alt=""  style="width: 16rem; display:<?=($edit===true)?"block":"none;"?>">
        </div>
    <hr>
    </div>
    <div class="col-md-8">
    </div>
  <!-- buttons -->
  <div class="col-12 text-end">
    <button id="btnProvider" class="col-3 btn btn-outline-secondary"  name="btnProvider" value="<?= ($id!=0)?'Guardar':'Crear'; ?>">
    <i class="bi bi-floppy"></i> <?php
            if($id!=0) {
                echo "Guardar";
            }else {
                echo "Crear";
            }
            ?>
    </button>
    <a class="col-3 btn btn-outline-secondary"  href="../../../app/views/admin/products.php">
    <i class="bi bi-arrow-left-circle"></i> Cerrar
    </a>
  </div>
</form>
</main>
  <!-- permite cargar la biblioteca jQuery en tu página web.-->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    const imagenInput = document.getElementById('imageInput'); // Seleccione el campo de entrada de archivos
    const imagenMostrada = document.getElementById('imgShow');// Seleccione la imagen mostrada
    imagenInput.addEventListener('change', function() { // Escuche los cambios en el campo de entrada de archivos
    const file = imagenInput.files[0]; // Obtenga el archivo seleccionado en el campo de entrada de archivos
      if (file) {
          const reader = new FileReader(); // Inicializar FileReader API
          reader.onload = function(e) { // Cuando se cargue el archivo, se ejecutará esta función
              imagenMostrada.src = e.target.result; // Establece el atributo src de la imagen en la ruta del archivo
          };
          reader.readAsDataURL(file);
      }
    });
  </script>
  <!-- Bootstrap JavaScript Libraries -->  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>

