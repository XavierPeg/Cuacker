<?php
    session_start();

    if(isset($_SESSION['usuari_nom'])){
        header("location:sessio.php");
    }
?>