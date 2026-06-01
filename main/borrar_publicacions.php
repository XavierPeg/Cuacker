<?php
    require 'vendor/autoload.php';
    require("protection.php");

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Connexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció
    $coleccioUsuaris = $db->usuaris;
    $coleccioLikes = $db->likes;
    $origen = $_POST['origen'];

    if (isset($_POST["id_del"])) {
        if (isset($_POST["id_del"])) {
            $id_del = $_POST["id_del"]; 
            $idConverted = new MongoDB\BSON\ObjectId($id_del);
            $coleccioPublicacions->deleteOne(['_id' => $idConverted]);
        }

        header("location:$origen");     
    }