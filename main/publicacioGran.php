<?php
    require 'vendor/autoload.php';
    require("protection.php");

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Connexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    $coleccioUsuaris = $db->usuaris;
    $coleccioLikes = $db->likes;


    $id = $_GET['id_pub'];
    $idConverted = new MongoDB\BSON\ObjectId($id);

    $publicacio = $coleccioPublicacions->findOne(["_id" => $idConverted,]);
    $usuari = $coleccioUsuaris->findOne(['nom_usuari' => $publicacio['nom_usuari']]);

    $anyadirFoto = '';
    $anyadirText = '';

    if (isset($publicacio['nom_foto'])) {
        $anyadirFoto = '<div class="publicacioImg" style="background-image: url(' .$publicacio['nom_foto'].  ')"></div>';
    }
    if (isset($publicacio['text'])) {
        $anyadirText = '<div class="publicacioText"> <p>' . $publicacio['text'] . '</p></div>';
    }

    // Comprovar si s'ha donat like o no a la publicació
    if(isset($_SESSION['usuari_nom'])){
        $usuariSessio = $_SESSION['usuari_nom']; 
     } else {
         $usuariSessio = '';
     }
     $idString = (string)$publicacio['_id'];
     $comprovarLike = $coleccioLikes->findOne([
         "id_pub" => $idString,
         "nom_usuari" => $usuariSessio
     ]);

     $likeIcon = '';

     if (!$comprovarLike) {
         $likeIcon = '<i class="fa-regular fa-heart" style="color: #bc4749;"></i>';
     } else {
         $likeIcon = '<i class="fa-solid fa-heart" style="color: #bc4749;"></i>';
     }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="./css/img/logo.webp"/>
</head>
<body class="home">
    <?php include("header.php");?>
    <main>
        <div class="buit"></div>
        <section class="timeLine" id="publicacioGran1">
            <div class="timeLinePosts" id="timeLineComentaris">
                <div class="publicacio" id="publicacioGran2">
                    <div id="publicacioGeneral" class="publicacioPerfil">
                        <div class="publicacioFotoPerfil" style="background-image: url(<?php echo $usuari['nom_foto']?>);"></div>
                        <p class="nom"><?php echo $usuari['nom']?></p>
                        <p class="nomUsuari"> @<?php echo $usuari['nom_usuari']?></p>
                    </div>
                    <?php 
                        echo $anyadirFoto;
                        echo '<br>';
                        echo $anyadirText;
                    ?>
                    
                    <div class="publicacioButons">
                    </div>

                </div>

                <form class="comentariForm" action="comentar.php" method="post">
                    <textarea name="comentari" id="comentari" placeholder="Fes un comentari" require></textarea>
                    <input type="hidden" name="id_pub" value="<?php echo $id?>">
                    <input type="hidden" name="usuari" value="<?php echo $_SESSION['usuari_nom']?>">
                    <input class="submitComentari" type="submit" value="Comentar">
                </form>
                <div class="comentaris1">
                    <div class="comentaris2">
                        <?php include('comentaris.php');?> 
                    </div>
                </div>
                
                    
            </div>
            
        </section>

        
        <div class="buit"></div>
    </main>
    
</body>
</html>