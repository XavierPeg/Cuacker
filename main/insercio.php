<?php
    require 'vendor/autoload.php';
    require('protection.php');

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades
    $coleccioUsuaris = $db->usuaris; // Col·lecció

    if (isset($_POST['nomUsuari'], $_POST['contrasenya'], $_POST['nom'], $_POST['email'])) {
        
        $nomUsuari = $_POST['nomUsuari'];
        $contra = $_POST['contrasenya'];
        $contraC = $_POST['contrasenyaC'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $dataString = $_POST['dNaixement'];

        if ($contra == $contraC) { // Comprovo que les dues contrasenyas són la mateixa

            $rutaFoto = "uploads/perfil/default.png";

            if (isset($_FILES['fotoPerfil']['name'])) {
                if ((($_FILES["fotoPerfil"]["type"] == "image/jpeg") || ($_FILES["fotoPerfil"]["type"] == "image/png")) && ($_FILES["fotoPerfil"]["size"] < 3000000)) {
                    $data = date("Y-m-dH-i-s");
                    $nomFoto = $_SESSION['usuari_nom'].$data.$_FILES['fotoPerfil']['name'];
                    $nomFoto = strtolower($nomFoto);
                    $rutaFoto = "uploads/perfil/" . $nomFoto;
                    $foto = move_uploaded_file($_FILES["fotoPerfil"]["tmp_name"], $rutaFoto);
                } else {
                    echo "L'arxiu no té el format corresponent o supera la grandària màxima permesa.";
                }
            }
    
    
            // Contar el número de documents que coincideixen amb el nom d'usuari
            $count = $coleccioUsuaris->countDocuments(['nom_usuari' => $nomUsuari]);
            $countCorreu = $coleccioUsuaris->countDocuments(['correu_electronic' => $email]);
    
            if ($count == 0) {
                if ($countCorreu == 0) {
                    $resultat = $coleccioUsuaris->insertOne(['nom_usuari' => $nomUsuari, 
                    'contrasenya' => $contra, 
                    'nom' => $nom, 'correu_electronic'=> $email, 
                    'data_naixement'=> $dataString,
                    'nom_foto'=> $rutaFoto
                    ]);
    
                    if ($resultat) {
                        header('location:login.php');
                    } else {
                        echo'<h2>ERROR PUJANT LES DADES</h2>';
                    }
                }else {
                    header('location:registre.php?error=2');
                }
            } else {
                header('location:registre.php?error=1');
            }
        } else {
            header('location:registre.php?error=20');
        }


        

       
    }
?>