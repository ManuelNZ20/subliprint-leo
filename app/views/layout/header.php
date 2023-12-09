<?php
// $url_base = 'http://localhost:3000';
// $url_base = 'http://localhost:8080/roberto-cotlear/public/';
// url base para la navegación
// $url_base = '../app/views/';
// $url_base = 'http://localhost:8080/roberto-cotlear/app/views/';
$url_base = '../../../app/views/';
$url = $_SERVER['REQUEST_URI'];
if($url == '/roberto-cotlear/public/') {
    require_once('../app/controller/UserController.php');
    // require_once('../app/controller/CartController.php');
    require_once('../app/model/CartModel.php');
  }else {
    require_once('../../../app/controller/UserController.php');
    // require_once('../../../app/controller/CartController.php');
    require_once('../../../app/model/CartModel.php');
}

$userController = new UserController();

$idUser = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : -1;
if($idUser != -1) {
  $user = $userController->getUserData($idUser);
}

?>
<header class="fixed-top" >
<nav class="navbar bg-body-tertiary text-lime-50">
<!-- <nav class="navbar navbar-dark bg-dark text-lime-50"> -->
  <div class="container" style="height:50px;">
    <!-- <?=print_r($user)?> -->
    <a class="navbar-brand" href="<?php
      if($user['idTypeUser'] === 2) {
        echo '../../../app/views/admin/admin.php';
      }else {
        echo '../../../app/views/home/home.php';
      }?>">
    <img src="
    <?php
      if($url == '/roberto-cotlear/public/') {
        echo '../public/img/logo.png';
      }else {
        echo '../../../public/img/logo.png';
      }
    ?>
    " alt="logo" style="margin-left: auto; margin-right: auto; width: 45px;"/>
  </a>
    <div class="d-flex">
      <?php
        if(!isset($_SESSION['idUser'])):
      ?>
        <a class="btn btn-landing-page btn-primary m-2 p-2" type="" href="<?= $url_base.'auth/login.php'
        ?>">Iniciar sesión</a>
      <?php
        endif;
      ?>
      <?php
        if(isset($_SESSION['idUser'])):
          if($user['idTypeUser'] !== 2):
      ?>
        <a href="<?= $url_base.'cart/carts.php'?>" class="btn position-relative me-3 mt-2 cart-btn"><i class="bi bi-cart3"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="num_cart">
                  <?=$cartModel->countProducts()?><span class="visually-hidden">unread messages</span></span>
        </a>
      <?php
        endif;
        else:
      ?>
        <a href="<?= $url_base.'cart/carts.php'?>" class="btn position-relative me-3 mt-2 cart-btn"><i class="bi bi-cart3"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="num_cart">
                  <?=$cartModel->countProducts()?><span class="visually-hidden">unread messages</span></span>
        </a>
      <?php
        endif;
      ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" style="height:50px;">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <!-- <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel"> -->
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
        <img src="<?php
          if($url == '/roberto-cotlear/public/') {
            echo '../public/img/logo.png';
          }else {
            echo '../../../public/img/logo.png';
          }
        ?>" alt="logo" style="margin-left: auto; margin-right: auto; width: 50px;"/>Subliprint Leo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 gap-2">
           <!-- Configuración de usuario -->
          <?php
            if(isset($user)):
          ?>
            <li class="nav-item">
              <a class="nav-link active rounded-pill" aria-current="page" href="
              <?= $url_base.'checkout/settingsUser.php' ?>"><i class="bi bi-person-circle"></i> <?=$user['name'];?></a>
            </li>
          <?php
            endif;
          ?>
          <?php
            if(isset($user)):
          ?>
          <?php
            // si el usuario es administrador no se muestra el menú de navegación
            if($user['idTypeUser'] !== 2):
          ?>
            <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?= $url_base.'home/home.php'
            ?>"><i class="bi bi-house"></i> Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?= $url_base.'products/products.php' ?>"><i class="bi bi-backpack"></i> Catalogo Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?= $url_base.'about/contact.php' ?>"><i class="bi bi-envelope-at"></i> Contacto</a>
          </li>
          <!-- Botón de carrito de compras -->
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="<?= $url_base.'cart/carts.php' ?>">
              <i class="bi bi-cart3"></i> <span>Carrito de compras
                <span class="badge text-bg-danger"><?=$cartModel->countProducts()?></span>
              </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?= $url_base.'order/orders.php' ?>"><i class="bi bi-shop"></i> Mis ordenes</a>
          </li>
          <?php
            else: // si el usuario es administrador
          ?>
          <h5 class="offcanvas-title py-2 px-2 text-decoration-underline" id="offcanvasDarkNavbarLabel">Dashboard</h5>
          <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?= $url_base.'admin/admin.php'?>"><i class="bi bi-graph-up"></i> Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?=$url_base.'admin/orders.php'?>"><i class="bi bi-truck"></i> Pedidos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?= $url_base.'admin/users.php'?>"><i class="bi bi-person-rolodex"></i> Usuarios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?= $url_base.'admin/inventory.php'?>"><i class="bi bi-box-seam"></i> Inventario de productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?= $url_base.'admin/providers.php'?>"><i class="bi bi-boxes"></i> Proveedores</a>
          </li>
          <?php
            endif;
          ?>
          <?php
            else:
          ?>
           <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?= $url_base.'home/home.php'
            ?>"><i class="bi bi-house"></i> Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?= $url_base.'products/products.php' ?>"><i class="bi bi-backpack"></i> Catalogo Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?= $url_base.'about/contact.php' ?>"><i class="bi bi-envelope-at"></i> Contacto</a>
          </li>
          <!-- Botón de carrito de compras -->
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="<?= $url_base.'cart/carts.php' ?>">
              <i class="bi bi-cart3"></i> <span>Carrito de compras
                <span class="badge text-bg-danger"><?=$cartModel->countProducts()?></span>
              </span>
            </a>
          </li>
          <?php
            endif; // fin del if de usuario logueado
          ?>
          <?php
            if(isset($user)):
          ?>
            <?php
              if($user['idTypeUser'] === 2):
            ?>
              
            <?php
              endif;
            ?>
          <?php
            endif;
          ?>


          <?php
            if(!isset($_SESSION['idUser'])):
          ?>
          <a class="btn background-general me-2 nav-item" type="" href="<?= $url_base.'auth/login.php'
          ?>">Iniciar sesión</a>
          <?php
            endif;
          ?>
          <?php
            if(isset($_SESSION['idUser'])):
          ?>
              <a href="<?=$url_base.'auth/logout.php'?>" class="btn btn-outline-danger me-2 nav-item">Cerrar sesión</a>
          <?php
            endif;
          ?>
        </ul>
      </div>
    </div>
    </div>
  </div>
</nav>
</header>

