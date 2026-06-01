<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Connexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    $coleccioUsuaris = $db->usuaris;
    $coleccioLikes = $db->likes;
    $coleccioComentaris = $db->comentaris;
    $usuariIniciat = $_SESSION['usuari_nom'];

   //TODO: Hacer que se puedan borrar correctamente desde el perfil

    
    
    $filter = ['nom_usuari' => $usuariIniciat];
    $options = ['sort' => ['data' => -1]];
    $publicacions = $coleccioPublicacions->find($filter, $options);

    foreach ($publicacions as $publicacio) {

        // Comprovar que existeix l'usuari de la publicació
        $usuari = $coleccioUsuaris->findOne(['nom_usuari' => $publicacio['nom_usuari']]);

        if ($usuari) {

            // Comprovar si s'ha donat like o no a la publicació
            $idString = (string)$publicacio['_id'];
            $comprovarLike = $coleccioLikes->findOne([
                "id_pub" => $idString,
                "nom_usuari" => $_SESSION['usuari_nom']
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
                $anyadirText = '<div class="publicacioImg" style="background-image: url(' .$publicacio['nom_foto'].  ')"></div>';
            }
            if (isset($publicacio['text'])) {
                $anyadirFoto = '<div class="publicacioText"> <p>' . $publicacio['text'] . '</p></div>';
            }

             // Contar los comentarios de la publicación
             $comentariosCount = $coleccioComentaris->countDocuments(['id_pub' => $idString]);

            
            // HTML de la publicació
            echo ' 
            <div class="publicacio">
                <div class="publicacioPerfil">
                    <span id="spanDadesPerfilPublicacio">
                        <div class="publicacioFotoPerfil" style="background-image: url(' .$usuari['nom_foto'].  ');"></div>
                        <p class="nom">' . $usuari['nom'] . '</p>
                        <p class="nomUsuari"> @' . $publicacio['nom_usuari'] . '</p>
                    </span>
                    <span id="span_borrar_pub">
                        <form action="borrar_publicacions.php" method="post">
                            <input type="hidden" value="'. $origen .'" name="origen" id="origen">
                            <input type="submit" value="" id="borrar_pub' . $publicacio['_id'] . '"  style="display: none">
                            <input type="hidden" name="id_del" value= "' . $publicacio['_id'] . '">
                        </form>
                        <form action="modificar_publicacions_form.php" method="post">
                            <input type="hidden" value="'. $origen .'" name="origen" id="origen">
                            <input type="submit" value="" id="modificar_pub' . $publicacio['_id'] . '"  style="display: none">
                            <input type="hidden" name="id_update" value= "' . $publicacio['_id'] . '">
                        </form>
                        
                        <label for="modificar_pub' . $publicacio['_id'] . '" style="cursor: pointer;">
                            <i class="fa-solid fa-gears" style="color: #BC4749;"></i>
                        </label>

                        <label for="borrar_pub' . $publicacio['_id'] . '" style="cursor: pointer;">
                            <i class="fa-solid fa-ban" style="color: #bc4749;"></i>
                        </label>
                    
                    </span>
                    
                </div>
                ' . $anyadirText .'
                ' . $anyadirFoto .'
                <div class="publicacioButons">
                    <form class="likesForm" action="likes.php" method="post">
                        <input type="submit" value="hola" id="likeButton' . $publicacio['_id'] . '" class="likeButton" style="display: none">
                        <input type="hidden" name="nom_usuari" value= "' . $_SESSION['usuari_nom'] . '">
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
?>
