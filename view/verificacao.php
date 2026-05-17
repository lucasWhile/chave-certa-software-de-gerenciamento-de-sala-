<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['msg'] = "O login expirou, faça login novamente.";
    
    header("Location: ../../view/usuario/login_usuario.php");
    exit();
}

?>