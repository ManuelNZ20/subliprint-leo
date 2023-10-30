<?php
// $url_base = 'http://localhost:3000';
// $url_base = 'http://localhost:8080/roberto-cotlear/public/';
// url base para la navegación
  // $url_base = '../app/views/';
  // $url_base = 'http://localhost:8080/roberto-cotlear/app/views/';
  $url_base = '/roberto-cotlear/app/views/';
?>
<header class="fixed-top">
<nav class="navbar bg-body-tertiary text-lime-50">
  <div class="container">
    <a class="navbar-brand" href="#">Roberto Cotlear</a>
    <div class="d-flex">
          <a class="btn btn-landing-page me-2" type="" href="<?php
            echo $url_base.'auth/login.php'
          ?>">Registrarse</a>
          <button type="button" class="btn position-relative me-3 mt-2 cart-btn">
            <i class="bi bi-cart3"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  0
                <span class="visually-hidden">unread messages</span>
              </span>
            </button>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Roberto Cotlear</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 gap-2">
          <li class="nav-item">
            <a class="nav-link active rounded-pill primary" aria-current="page" href="<?php
            echo '/roberto-cotlear/public/'
            ?>">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="<?php
              echo $url_base.'about/about.php'
            ?>">Sobre nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?php echo $url_base.'products/products.php' ?>">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?php echo $url_base.'about/contact.php' ?>">Contacto</a>
          </li>
          <!-- Botón de carrito de compras -->
          <li class="nav-item">
            <a class="nav-link active rounded-pill  d-flex justify-content-between" aria-current="page" href="<?php echo $url_base.'cart/carts.php' ?> ">Carrito de compras  <span class="badge text-bg-danger">0</span></a>
          </li>
          <!-- Configuración de usuario -->
          <li class="nav-item">
            <a class="nav-link active rounded-pill" aria-current="page" href="
            <?php echo $url_base.'about/contact.php' ?>">Configuración</a>
          </li>
          <li class="nav-item">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dashboard
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?php echo $url_base.'admin/admin.php'?>">Inicio</a></li>
                  <li><a class="dropdown-item" href="
                  <?php echo $url_base.'admin/orders.php'?>
                  ">Pedidos</a></li>
                  <li><a class="dropdown-item" href="
                  <?php echo $url_base.'admin/users.php'?>
                  ">Usuarios</a></li>
                  <li><a class="dropdown-item" href="
                  <?php echo $url_base.'admin/products.php'?>
                  ">Productos</a></li>
                  <li><a class="dropdown-item" href="
                  <?php echo $url_base.'admin/providers.php'?>
                  ">Proveedores</a></li>
                </ul>
              </div>
            <!-- <a class="nav-link active rounded-pill" aria-current="page" href=" -->
            <!-- <?php echo $url_base.'/src/presentation/views/admin/admin.php' ?>">Dashboard</a> -->
          </li>
          <a class="btn background-general me-2 nav-item" type="" href="<?php
            echo $url_base.'/src/presentation/views/auth/login.php'
          ?>">Registrarse</a>

        </ul>
      </div>
    </div>
    </div>
  </div>
</nav>
</header>