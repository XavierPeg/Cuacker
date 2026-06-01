<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Connexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    $coleccioUsuaris = $db->usuaris;
    $coleccioLikes = $db->likes;
    $coleccioComentaris = $db->comentaris;

    $filter = [];
    $options = ['sort' => ['data' => -1]];

    if (isset($_POST['buscador'])) {
        $criteri_busqueda = $_POST['buscador'];
        $filter = ['text' => ['$regex' => $criteri_busqueda, '$options' => 'i']]; // Cerca insensible a majúscules i minúscules
    }

    $publicacions = $coleccioPublicacions->find($filter, $options);

    foreach ($publicacions as $publicacio) {
        // Comprovar que existeix l'usuari de la publicació
        $usuari = $coleccioUsuaris->findOne(['nom_usuari' => $publicacio['nom_usuari']]);

        if ($usuari) {
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

            // Comprovar si hi ha una foto o text o ambdós a la publicació
            $anyadirFoto = '';
            $anyadirText = '';

            if (isset($publicacio['nom_foto'])) {
                $anyadirFoto = '<div class="publicacioImg" style="background-image: url(' .$publicacio['nom_foto'].  ')"></div>';
            }
            if (isset($publicacio['text'])) {
                $anyadirText = '<div class="publicacioText"> <p>' . $publicacio['text'] . '</p></div>';
            }
            
             // Contar los comentarios de la publicación
             $comentariosCount = $coleccioComentaris->countDocuments(['id_pub' => $idString]);


            // HTML de la publicació
            echo ' 
            <div class="publicacio">
                <div id="publicacioGeneral" class="publicacioPerfil">
                    <div class="publicacioFotoPerfil" style="background-image: url(' .$usuari['nom_foto'].  ');"></div>
                    <p class="nom">' . $usuari['nom'] . '</p>
                    <p class="nomUsuari"> @' . $publicacio['nom_usuari'] . '</p>
                </div>
                ' . $anyadirFoto .'
                ' . $anyadirText .'
                <div class="publicacioButons">
                    <form class="likesForm" action="likes.php" method="post">
                        <input type="submit" value="hola" id="likeButton' . $publicacio['_id'] . '" class="likeButton" style="display: none">
                        <input type="hidden" name="nom_usuari" value= "' . $usuariSessio . '">
                        <input type="hidden" name="id_pub" value= "' . $publicacio['_id'] . '">
                        <label for="likeButton' . $publicacio['_id'] . '" style="cursor: pointer;">
                            ' . $likeIcon . '
                            ' . $publicacio['likes'] . '
                        </label>
                    </form>
                    <a href="publicacioGran.php?id_pub=' . urlencode($publicacio["_id"]) . '" style="margin-left: 20px;">
                        <i class="fa-regular fa-message" style="color: #bc4749;"></i>
                    </a>
                    '. $comentariosCount .'
                    
                </div>
            </div>
            ';
        }  
    }

