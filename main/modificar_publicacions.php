<?php
    require 'vendor/autoload.php';
    require("protection.php");

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Connexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    $coleccioUsuaris = $db->usuaris;
    $coleccioLikes = $db->likes;
    $origen = $_POST['origen'];
    $nouText = $_POST['nouText'];
    $id = $_POST['id'];

    if (isset($_FILES['fotoPerfil']['name'])) {
        if ((($_FILES["fotoPerfil"]["type"] == "image/jpeg") || ($_FILES["fotoPerfil"]["type"] == "image/png")) && ($_FILES["fotoPerfil"]["size"] < 3000000)) {
            $data = date("Y-m-dH-i-s");
            $nomFoto = $_SESSION['usuari_nom'].$data.$_FILES['fotoPerfil']['name'];
            $nomFoto = strtolower($nomFoto);
            $rutaFoto = "uploads/publicades/" . $nomFoto;
            $foto = move_uploaded_file($_FILES["fotoPerfil"]["tmp_name"], $rutaFoto);
        }
    }


    $idConverted = new MongoDB\BSON\ObjectId($id);

        
    $coleccioPublicacions->updateOne(['_id' => $idConverted], ['$set' => ['text' => $nouText,
    'nom_foto' => $rutaFoto
    ]]);

        header("location:$origen");     
    