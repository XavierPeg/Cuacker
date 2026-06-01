<?php
    require 'vendor/autoload.php';
    require("protectionToIndex.php");


    $client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexió
    $db = $client->cuacker; // Base de dades
    $coleccioUsuaris = $db->usuaris; // Col·lecció

    $nomUsuari = $_SESSION['usuari_nom'];
    $usuariIniciat = $coleccioUsuaris->findOne(['nom_usuari' => $nomUsuari]);

    $nom = $usuariIniciat['nom'];
    $correu = $usuariIniciat['correu_electronic'];
    $data = $usuariIniciat['data_naixement'];
    $contrasenya = $usuariIniciat['contrasenya'];
    $ruta_foto = $usuariIniciat['nom_foto'];
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustaments</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="./css/img/logo.webp"/>
</head>
<body class="registre">
    <?php
        include("header.php");
    ?>
    
    <main>
        <form class="ajustamentsForm" action="actualitzar.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>
                    <img src="./css/img/logo.webp" alt="">
                </legend>

                <h2>MODIFICAR DADES DEL PERFIL</h2>
                <input type="text" name="nom" placeholder="Nom" value="<?php echo $nom?>" pattern="[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9\- ]+" minlength="3" maxlength="30">
                <input type="date" name="dNaixement" value="<?php echo $data?>">
                <input type="password" name="contrasenya" placeholder="Contrasenya" minlength="5" maxlength="30" value="<?php echo $contrasenya?>">
                <input type="password" name="contrasenyaC" placeholder="Contrasenya" minlength="5" maxlength="30" value="<?php echo $contrasenya?>">
                <span class="pujarImatgePerfilSpan">
                    <label for="inputImatge" class="pujarImatgePerfiBtn">PUJAR IMATGE</label>
                    <input type="file" name="fotoPerfil" id="inputImatge" style="display: none;">
                    <div class="imatgePerfil" id="imatgePerfil" style="background-image: url('<?php echo $ruta_foto; ?>');"></div>
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

                <?php
                    // Mostrar mensaje de error si existe
                    if(isset($_GET['error'])){
                        $error_code = $_GET['error'];
                        switch ($error_code) {
                            case 20:
                                echo '<p class="error-login">Les contrasenyes no coincideixen</p>';
                                break;
                            default:
                                break;
                        }


                        
                    }
                ?>
                <input id="submitAjustament" type="submit" value="Actualitzar">
                                

            </fieldset>

        </form>
    </main>
</body>