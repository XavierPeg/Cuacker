<?php


if(isset($_REQUEST['politica-cookies'])) {
    // Si accepta la política aquesta dura un any
    if ($_REQUEST['politica-cookies'] == '1') {
        // Calculamos la caducidad, en este caso un año
        $caducidad = time() + (60 * 60 * 24 * 365);
        // creem cookie
        setcookie('politica', '1', $caducidad);
    } elseif ($_REQUEST['politica-cookies'] == 'reject') {
        // Si rechaza la cookie fem una cookie que només duri un hora per que no torni a sortir el missatge
        setcookie('politica_reject', '1', time() + (60 * 60 * 1)); // Caduca en una hora
    }
}
header("location:index.php")
?>