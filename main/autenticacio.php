<!-- PÀGINA DE VALIDACIÓ DE LES DADES D'USUARI -->
<!-- Aquesta pàgina rep les dades d'usuari de "login.php" i comprova que siguin vàlides. -->

<?php
    require 'vendor/autoload.php';
    require("protection.php");

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades
    $coleccioUsuaris = $db->usuaris; // Col·lecció

    if(isset($_POST['email'], $_POST['contrasenya'])){ //Comprovem que les dades rebudes per POST existeixen 

        $email = $_POST['email'];
        $contra = $_POST['contrasenya']; 

        $resultatCorreu = $coleccioUsuaris->findOne(['correu_electronic' => $email]);
        

        // Comprovem que existeix el mail
        if($resultatCorreu){

            // Comprovem que la contrasenya coincideix
            if($contra == $resultatCorreu['contrasenya']){ 

                //Executem SESSIÓ per poder guardar variables de SESSIÓ
                session_start();
                // Creem la variable de sessió del nom d'usuari. 
                $_SESSION['usuari_nom']= $resultatCorreu['nom_usuari'];
                $_SESSION['foto_perfil'] = $resultatCorreu['nom_foto'];

                //Redirigim a l'usuari a la pàgina "sessio.php" per accedir informació que només pot veure ell.
                header("location:sessio.php");  
                exit(); // Add exit after redirection to prevent further code execution
            }
            header("location:login.php?error=2");
            exit(); 
        }
        
       //En cas de no validar-se l'usuari, el redirigim a la pàgina "login.php" perquè pugui fer login novament.
        header("location:login.php?error=1");
        exit(); // Add exit after redirection to prevent further code execution

    }
?>
