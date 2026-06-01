<?php
    require 'vendor/autoload.php';
    require("protection.php");

    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Connexió
    $db = $client->cuacker; // Base de dades
    $coleccioPublicacions = $db->publicacions; // Col·lecció

    $origen = $_POST['origen'];
    $id = $_POST['id_update'];
    $idConverted = new MongoDB\BSON\ObjectId($id);
    $publicacio = $coleccioPublicacions->findOne(['_id' => $idConverted]);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="./css/img/logo.webp"/>
</head>
<body class="login">
    <?php
        include("header.php");
    ?>
    
    <main>
        <form class="loginForm" action="modificar_publicacions.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>
                    <img src="./css/img/logo.webp" alt="">
                </legend>

                <input type="hidden" value="<?php echo $origen?>" name="origen" id="origen">
                <input type="hidden" name="id" value="<?php echo $id?>">
                <textarea name="nouText" id="modificarPublicacioText" placeholder="Nou text..." ><?php echo $publicacio['text']?></textarea>
                <span class="pujarImatgePerfilSpan">
                    <label for="inputImatge" class="pujarImatgePerfiBtn">PUJAR IMATGE</label>
                    <input type="file" name="fotoPerfil" id="inputImatge" style="display: none;">
                    <div class="imatgePerfil" id="imatgePerfil" style="background-image: url('<?php echo $publicacio['nom_foto']; ?>');"></div>
                </span>
                
                <script>
                    // Obtener referencia al input de carga de imagen
                    const inputImatge = document.getElementById('inputImatge');
                    // Obtener referencia al div donde se mostrará la imagen
                    const divImatgePerfil = document.getElementById('imatgePerfil');
                
                    // Agregar un controlador de eventos para el cambio de la imagen
                    inputImatge.addEventListener('change', function(event) {
                        // Obtener el archivo cargado
                        const file = event.target.files[0];
                        
                        // Verificar si se cargó un archivo
                        if (file) {
                            // Crear un objeto URL para la imagen cargada
                            const imageUrl = URL.createObjectURL(file);
                            // Establecer la imagen como fondo del div
                            divImatgePerfil.style.backgroundImage = `url('${imageUrl}')`;
                        }
                    });
                </script>

                <input id="submitLogin" type="submit" value="Actualitza">
            </fieldset>
            
            

        </form>
    </main>
</body>