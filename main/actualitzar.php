<?php
    require 'vendor/autoload.php';
    require("protection.php");

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades
    $coleccioUsuaris = $db->usuaris; // Col·lecció
    $usuariIniciat = $coleccioUsuaris->findOne(['nom_usuari' => $_SESSION['usuari_nom']]);
    if (isset($_POST['contrasenya'], $_POST['nom'])) {
        
        $nomUsuari = $_SESSION['usuari_nom'];
        $contra = $_POST['contrasenya'];
        $contraC = $_POST['contrasenyaC'];
        $nom = $_POST['nom'];
        $dataString = $_POST['dNaixement'];
        $rutaFoto = $usuariIniciat['nom_foto'];

        if ($contra == $contraC) { // Comprovo que les dues contrasenyas són la mateixa


            if (isset($_FILES['fotoPerfil']['name'])) {
                if ((($_FILES["fotoPerfil"]["type"] == "image/jpeg") || ($_FILES["fotoPerfil"]["type"] == "image/png")) && ($_FILES["fotoPerfil"]["size"] < 3000000)) {
                    $data = date("Y-m-dH-i-s");
                    $nomFoto = $_SESSION['usuari_nom'].$data.$_FILES['fotoPerfil']['name'];
                    $nomFoto = strtolower($nomFoto);
                    $rutaFoto = "uploads/perfil/" . $nomFoto;
                    $foto = move_uploaded_file($_FILES["fotoPerfil"]["tmp_name"], $rutaFoto);
                }
            }
    
            $resultat = $coleccioUsuaris->updateOne(
                ['nom_usuari' => $nomUsuari],
                ['$set' => [
                    'nom' => $nom,
                    'data_naixement' => $dataString,
                    'contrasenya' => $contra,
                    'nom_foto' => $rutaFoto
                ]]
            );

            if ($resultat) {
                header('location:perfil.php');
            } else {
                echo'<h2>ERROR PUJANT LES DADES</h2>';
            }
               
            
        } else {
            header('location:ajustaments.php?error=20');
        }


        

       
    }
?>