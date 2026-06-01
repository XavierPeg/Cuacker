<?php
// Verificar si l'usuari a acceptat o no les cookies.
if (!isset($_REQUEST['politica-cookies']) && !isset($_COOKIE['politica']) && !isset($_COOKIE['politica_reject'])):
?>

<div class="cookies">
    <!-- Titulo -->
    <h2>Cookies</h2>

    <p>Acceptes la nostra <a href="politica-cookies.html" target="_blank">política de Cookies</a>?</p>

    <a href="cookies_script.php?politica-cookies=1">Si, accepto totes les cookies</a>
    <a href="cookies_script.php?politica-cookies=reject">No, declino aquesta política de cookies</a>
</div>
<?php endif; ?>