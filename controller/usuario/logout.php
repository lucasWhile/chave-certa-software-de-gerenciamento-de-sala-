<?php
session_start();
session_destroy();

header("Location: ../../view/usuario/login_usuario.php");

?>