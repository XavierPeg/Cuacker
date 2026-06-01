<?php
// Amb el require requerim que s'executi l'SCRIPT "protection.php". 
// L'SCRIPT protection.php comprova que la sessió estigui executada i per tant que l'usuari pugui veure aquesta pàgina privada. En cas que la SESSIÓ no estigui executada, l'SCRIPT el redigirà a "index.php" perquè faci LOGIN novament. 

require("protectionToIndex.php");

require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades
    $coleccioUsuaris = $db->usuaris; // Col·lecció
    $coleccioPublicacions = $db->publicacions;
    $nomUsuariIniciat = $_SESSION['usuari_nom'];
    $usuariIniciat = $coleccioUsuaris->findOne(['nom_usuari' => $nomUsuariIniciat]);

    $origen = "sessio.php";
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="./css/img/logo.webp"/>
</head>
<body class="home">
    <header>
        <nav>
            <a href="sessio.php">
                <div class="logo"></div>
            </a>
            <form action="" method="post" class="buscadorForm">
                <input type="text" name="buscador" id="buscador" placeholder="Cerca ">
                <button type="submit" id="buscadorSubmit"><i class="fa-solid fa-magnifying-glass" id="lupa"></i></button>
            </form>
        </nav>        
    </header>
    <main>
        <div class="buit"></div>
        <section class="timeLine">
            <div class="timeLineTitol">
                <h1>Publicacions</h1>
            </div>
            <div class="timeLinePosts">
                <?php
                    include("publicacions.php")
                ?>
            </div>          
        </section>

        <section class="barraLateral" id="barraLateralSessio">
            <div class="barraLateralPerfil">
                <span>
                    <input type="checkbox" name="publicar" id="publicarCheck" class="publicarCheck">
                    <label class="publicarLabel" for="publicarCheck">Publicar <i class="fa-solid fa-plus"></i></label>
                    <div class="divPublicar">
                        <form action="pujarPublicacio.php" method="post" enctype="multipart/form-data">
                            <textarea name="textPublicacio" id="textPublicació" placeholder="Escriu..."></textarea>
                            <input type="hidden" name="nombre_usuario" value="">
                            <span>
                                <input type="file" name="pujarImatge" id="pujarImatge" style="display:none">
                                <label for="pujarImatge"><i class="fa-regular fa-image" id="publicarImatge" style="color: #bc4e47;"></i></label>
                                <button id="publicarPostButton" type="submit">Publicar</button>
                            </span>
                        </form>
                    </div>
                </span>
                
                
                <a href="perfil.php">
                    <div class="publicacioFotoPerfil" style="background-image: url('<?php echo $usuariIniciat['nom_foto'];?>')"></div>
                </a>
            </div>
            <div class="barraLateralPosts">
                <?php
                    include("publicacionsPropies.php");
                ?>
            </div>
        </section>

        
        <div class="buit"></div>
    </main>
    
</body>
</html>