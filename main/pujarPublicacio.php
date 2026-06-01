<?php
    require 'vendor/autoload.php';
    require("protection.php");
    
    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades 
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    

   

    
    // Comprovem que no s'ha envíat un post vuit
    if ($_POST['textPublicacio'] != '' || $_FILES['pujarImatge']['name'] != '') {
        // Data actual en format PHP
        $data_mal = new DateTime();
        $data_actual = new MongoDB\BSON\UTCDateTime($data_mal->getTimestamp() * 1000);
        
        // Subim la imatge a la carpeta corresponent
        if ( $_FILES['pujarImatge']['name'] != '') {
            if ((($_FILES["pujarImatge"]["type"] == "image/jpeg") || ($_FILES["pujarImatge"]["type"] == "image/png")) && ($_FILES["pujarImatge"]["size"] < 3000000)) {
                $data = date("Y-m-dH-i-s");
                $nomFoto = $_SESSION['usuari_nom'].$data.$_FILES['pujarImatge']['name'];
                $nomFoto = strtolower($nomFoto);
                $rutaFoto = "uploads/publicades/" . $nomFoto;
                $foto = move_uploaded_file($_FILES["pujarImatge"]["tmp_name"], $rutaFoto);
            } else {
                echo "L'arxiu no té el format corresponent o supera la grandària màxima permesa.";
            }
        }

        // Si hi ha imatge y text
        if ($_FILES['pujarImatge']['name'] != '' && $_POST['textPublicacio'] != '') {
            $resultat = $coleccioPublicacions->insertOne(['nom_usuari' => $_SESSION['usuari_nom'], 
            'text' => $_POST['textPublicacio'], 
            'nom_foto' => $rutaFoto,
            'likes' => 0,
            'data' => $data_actual
            ]);
    
            if ($resultat) {
                header('location:sessio.php');
            } else {
                echo'<h2>ERROR PUJANT la publicació</h2>';
            }

          // Si només hi ha una imatge
        } elseif ($_FILES['pujarImatge']['name'] != '' && $_POST['textPublicacio'] == '') {
            $resultat = $coleccioPublicacions->insertOne(['nom_usuari' => $_SESSION['usuari_nom'], 
            'nom_foto' => $rutaFoto,
            'likes' => 0,
            'data' => $data_actual
            ]);
    
            if ($resultat) {
                header('location:sessio.php');
            } else {
                echo'<h2>ERROR PUJANT la publicació</h2>';
            }

          // Si només hi ha text
        } elseif ($_POST['textPublicacio'] != '') {
            $resultat = $coleccioPublicacions->insertOne(['nom_usuari' => $_SESSION['usuari_nom'], 
            'text' => $_POST['textPublicacio'], 
            'likes' => 0,
            'data' => $data_actual
            ]);
    
            if ($resultat) {
                header('location:sessio.php');
            } else {
                echo'<h2>ERROR PUJANT la publicació</h2>';
            }
        } 
    } else {
        header('location:sessio.php?error=10');
    }

    