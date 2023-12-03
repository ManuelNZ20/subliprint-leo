<?php
require_once('../../../app/controller/InfoPageController.php');
$controllerInfoPage = new InfoPageController();
$data = $controllerInfoPage->getInformationPage()[0];
?>
<!-- incluye todo lo que tiene que ver con navegación -->
<footer class="bg-dark text-light p-5 bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4 class="border-bottom border-4 border-bottom-title">Información de contacto</h4>
                <p><i class="bi bi-geo-alt"></i> <?=$data['address']?></p>
                <p class="text-truncate"><i class="bi bi-envelope"></i> <?=$data['email']?></p>
                <p><i class="bi bi-telephone"></i> <?=$data['phone']?></p>
            </div>
            <div class="col-md-2">
                <h4 class="border-bottom border-4 border-bottom-title">Enlaces útiles</h4>
                <ul class="list-unstyled ">
                    <li class="mb-3"><a href="<?=$url_base.'home/home.php' ?>" class="text-white text-decoration-none">Inicio</a></li>
                    <li class="mb-3"><a href="<?=$url_base.'about/about.php'?>" class="text-white text-decoration-none">Acerca de nosotros</a></li>
                    <li class="mb-3"><a href="<?=$url_base.'products/products.php' ?>" class="text-white text-decoration-none">Productos</a></li>
                    <li class="mb-3"><a href="<?=$url_base.'about/contact.php' ?>" class="text-white text-decoration-none">Contacto</a></li>
                </ul>
            </div>
            <div class="col-md-6">
            <div class="card border-light h-100">
                <div class="card-header">¿Quienes somos?</div>
                <div class="card-body">
                    Roberto Cotlear es una ferretería Piurana que cuenta con años de experiencia brindándole los mejores productos de las mejores marcas.
                  </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="container">
    <div class="container">
        <div class="row gap-2">
            <h6 href="" class="col-md"><i class="bi bi-building-check"></i> <?=$data['name']?></h6>
            <a href="https://www.google.com/maps?ll=-5.192676,-80.627593&z=16&t=m&hl=es-419&gl=PE&mapclient=embed&q=Av.+S%C3%A1nchez+Cerro+629+Piura+20001" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;"><i class="bi bi-geo-alt"></i></a>
            <a href="" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;"><i class="bi bi-telephone"></i></a>
        
        </div>
        
    </div>
</footer>