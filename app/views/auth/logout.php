<?php
    session_start();
    session_unset();
    session_destroy();
    session_commit(); // para que se destruya la sesión
    header('Location: ../../../public/');
?>