<?php
    require 'vendor/autoload.php';
    
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Connexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    $coleccioUsuaris = $db->usuaris;
    $coleccioComentaris = $db->comentaris;

    $filter = ['id_pub' => $id];
    $options = ['sort' => ['data' => -1]];
    


    $comentaris = $coleccioComentaris->find($filter, $options);
    

    foreach ($comentaris as $comentari) {
        $usuari = $coleccioUsuaris->findOne(["nom_usuari" => $comentari['user']]);
            
            // HTML de la publicació
            echo ' 
            <div  class="publicacio" id="comentaris">
                <div id="publicacioGeneral" class="publicacioPerfil">
                    <div class="publicacioFotoPerfil" style="background-image: url(' .$usuari['nom_foto'].  ');"></div>
                    <p class="nom">' . $usuari['nom'] . '</p>
                    <p class="nomUsuari"> @' . $usuari['nom_usuari'] . '</p>
                </div>
                <div class="publicacioText"> <p>' . $comentari['text'] . '</p></div>
            </div>
            ';
        }

