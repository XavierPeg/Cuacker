<?php
//Aquest SCRIPT destrueix totes les dades de SESSIÓ de l'usuari, per tant s'utilitza per fer logout.
session_start();
session_destroy();
header("location:login.php");
?>
