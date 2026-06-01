<?php
//L'SCRIPT protection.php comprova que la sessió no estigui executada i per tant que l'usuari no pugui veure páginas generiques o d'inici de sessió en cas de tenir la sessió iniciada. 
// En cas que la SESSIÓ estigui executada, l'SCRIPT el redigirà a "sessio.php". 

session_start();

if(!isset($_SESSION['usuari_nom'])){
    header("location:login.php");
    exit();
}
?>
