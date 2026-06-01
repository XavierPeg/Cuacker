<?php
    require 'vendor/autoload.php';
    require("protectionToLogin.php");
    
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades 
    $coleccioComentaris = $db->comentaris; // Col·lecció 

    if ($_POST['comentari'] != '') {
        $resultat = $coleccioComentaris->insertOne([ 
            'text' => $_POST['comentari'], 
            'id_pub' => $_POST['id_pub'],
            'user' => $_POST['usuari']
            ]);
        
            if ($resultat) {
                $id_pub = urlencode($_POST["id_pub"]);
                header("Location: publicacioGran.php?id_pub=$id_pub");
                exit();
            } else {
                echo '<h2>ERROR comentant</h2>';
            }
    } else {
        $id_pub = urlencode($_POST["id_pub"]);
        header("Location: publicacioGran.php?id_pub=$id_pub");
    }


    
    