<?php
require_once('../../../app/controller/InfoPageController.php');
$controllerInfoPage = new InfoPageController();
$data = $controllerInfoPage->getInformationPage()[0];
?>
<!-- incluye todo lo que tiene que ver con navegación -->
<footer class="bg-dark text-light p-5 bottom-0">
    <hr class="container">
    <div class="container">
        <div class="row gap-2">
            <h6 href="" class="col-md"><i class="bi bi-building-check"></i> <?=$data['name']?></h6>
            <a href="https://api.whatsapp.com/send?phone=%2B51981518655&data=ARD5bJFSxbZgBdTmUov3bmSnlKBli-ZJBjJxhzGlK2CYT3Oa51nnJ4CIROFUJevltehGqJP-06zgSwpeuy_bEuHtDMR4NfiO2Qo3u4wfZvRQEA-bxVvxFXTNZQJwyloCOFOo3lBsKz5QXXsbK3t8PLeczQ&source=FB_Page&app=facebook&entry_point=page_cta&fbclid=IwAR3uUucuj4XFwz-NMhbY0CH2CFJt4ckl0jlGWNz1-0ieFnqrn-kCzFd-Pkw" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.facebook.com/profile.php?id=100084859817775&mibextid=ZbWKwL&_rdc=2&_rdr" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/subliprint_leo/?igshid=OGQ5ZDc2ODk2ZA%3D%3D" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://www.tiktok.com/@subliprint_leo?_t=8hkG2iqs4MI&_r=1" class="link-offset-2 link-underline link-underline-opacity-0 link-secondary text-center align-items-center col-md-1 text-truncate" style="width:40px;" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" fill="#6c757d"/></svg></a>
        
        </div>
        
    </div>
</footer>