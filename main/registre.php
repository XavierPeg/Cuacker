<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/jpg" href="./css/img/logo.webp"/>
</head>
<body class="registre">
    <?php
        require("protection2.php");
        include("header.php");
    ?> 
    <main>
        <form class="registreForm" action="insercio.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>
                    <img src="./css/img/logo.webp" alt="">
                </legend>

                <input type="text" name="nom" placeholder="Nom" required pattern="[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9\- ]+" minlength="3" maxlength="30">
                <input type="email" name="email" placeholder="Correu elèctronic" required>
                <input type="date" name="dNaixement" required>
                
                <hr size="1px" color="black">

                <input type="text" name="nomUsuari" placeholder="Nom d'usuari" required pattern="[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9\- ]+" minlength="3" maxlength="20">
                <input type="password" name="contrasenya" placeholder="Contrasenya" required minlength="5" maxlength="30">
                <input type="password" name="contrasenyaC" placeholder="Comprovar contrasenya" minlength="5" maxlength="30">
                <span class="pujarImatgePerfilSpan">
                    <label for="inputImatge" class="pujarImatgePerfiBtn">PUJAR IMATGE</label>
                    <input type="file" name="fotoPerfil" id="inputImatge" style="display: none;">
                    <div class="imatgePerfil" id="imatgePerfil"></div>
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

                <span class="terminisCheck"><input type="checkbox" name="Terminis" required><p>Acceptes els terminis d'usuari?</p></span>

                <?php
                    // Mostrar mensaje de error si existe
                    if(isset($_GET['error'])){
                        $error_code = $_GET['error'];
                        switch ($error_code) {
                            case 1:
                                echo "<p class='error-login'>Aquest nom d'usuari ja està registrat</p>";    
                                break;
                            case 2:
                                echo '<p class="error-login">Aquest correu ja està registrat</p>';
                                break;
                            case 20:
                                echo '<p class="error-login">Les contrasenyes no coincideixen</p>';
                                break;
                            default:
                                break;
                        }


                        
                    }
                ?>


                <input id="submitLogin" type="submit" value="Acceptar">
                
                <p>Si ja tens un compte <a href="login.php">Inicia Sesió</a></p>
            </fieldset>

        </form>
    </main>
</body>