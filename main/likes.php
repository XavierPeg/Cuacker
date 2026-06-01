<?php
    require 'vendor/autoload.php';
    require('protectionToLogin.php');    

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    $coleccioLikes = $db->likes;



    if ($_POST['nom_usuari'] != '') {
        if (isset($_POST['nom_usuari'], $_POST['id_pub'])) {
            // Agafem les dades donades al donar like
            $nom = $_POST['nom_usuari'];
            $id = $_POST['id_pub'];
            $idConverted = new MongoDB\BSON\ObjectId($id); // Convertir la cadena de text a ObjectId
    
    
            // Verificar si el nostre usuari ha donat like a aquesta publicacio
            $comprovarLike = $coleccioLikes->findOne([
                "id_pub" => $id,
                "nom_usuari" => $nom
            ]);
    
    
            // Si no ha donat like introduirem el like a la bbdd
            if (!$comprovarLike) {
                $coleccioPublicacions->updateOne(
                    ["_id" => $idConverted],
                    ['$inc' => ["likes" => 1]]
                );
            
            
               $coleccioLikes->insertOne(
                    ["id_pub" => $id
                    ,"nom_usuari" => $nom]
                );
    
            // En cas de que l'usuari ya hagi donat like a la publicació s'eliminará. 
            } else if ($comprovarLike) {
                $coleccioPublicacions->updateOne(
                    ["_id" => $idConverted],
                    ['$inc' => ["likes" => -1]]
                );
            
            
                $coleccioLikes->deleteOne(
                    ["id_pub" => $id
                    ,"nom_usuari" => $nom]
                );
            }
        }
        header('location:sessio.php');
    } else {
        header('location:login.php');
    }

    
    
