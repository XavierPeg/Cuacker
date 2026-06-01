<?php
//Amb el require requerim que s'executi l'SCRIPT "protection.php" dins la pàgina "compte.php". L'SCRIPT protection.php comprova que la sessió estigui executada i per tant que l'usuari pugui veure aquesta pàgina privada. En cas que la SESSIÓ no estigui executada, l'SCRIPT el redigirà a "exemple_session.php" perquè faci LOGIN novament. 

    require("protection.php");
    require 'vendor/autoload.php';

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades
    $coleccioUsuaris = $db->usuaris; // Col·lecció
    $coleccioPublicacions = $db->publicacions;
    $nomUsuariIniciat = $_SESSION['usuari_nom'];
    $usuariIniciat = $coleccioUsuaris->findOne(['nom_usuari' => $nomUsuariIniciat]);

    $countPublicacions = $coleccioPublicacions->countDocuments(['nom_usuari' => $nomUsuariIniciat]);

    $origen = "perfil.php";
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="./css/img/logo.webp"/>
</head>
<body class="perfil">
    <header>
        <nav id="navPerfil">
            <a href="sessio.php">
                <div class="logo">
                
                </div>
            </a>

            <a id="ajustamentsLink" href="ajustaments.php">
                <div class="ajustamentsButton">
                    <i class="fa-solid fa-gears" id="ajustamentsIcon" style="color: #BC4749;"></i>
                </div>
            </a>
        </nav>        
    </header>

    <main>
        <section class="dadesPerfil">
            <div class="fotoPerfil" style="background-image: url('<?php echo $usuariIniciat['nom_foto'];?>')">

            </div>
            <h3 class="nomUsuariPerfil">@<?php echo $nomUsuariIniciat?></h3>
            <h2 class="nomPerfil"><?php echo $usuariIniciat['nom']?></h2>
            <p><?php echo $usuariIniciat['correu_electronic']?></p>
            <p><?php echo $usuariIniciat['data_naixement']?></p>
            <span>
                <h3>Posts</h2>
                <p><?php echo $countPublicacions?></p>
            </span>
            <a id="tancarSessio" href="logout.php">Tancar sessió</a>
        </section>
        <section class="postsPerfil">
            <div class="barraLateralPosts">
                <?php include('publicacionsPropies.php') ?>
            </div>
        </section>
    </main>

</body>