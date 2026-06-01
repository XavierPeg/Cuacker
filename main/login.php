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
        require("protection2.php");
        include("header.php");
    ?>
    
    <main>
        <form class="loginForm" action="autenticacio.php" method="post">
            <fieldset>
                <legend>
                    <img src="./css/img/logo.webp" alt="">
                </legend>

                <input class="loginInput" id="loginEmail" type="email" name="email" placeholder="Correu elèctronic" required>
                <input class="loginInput" id="loginContra" type="password" name="contrasenya" placeholder="Contrasenya" required minlength="5" maxlength="30">
                
                <?php
                    // Mostrar misatje d'erre si hi ha un
                    if(isset($_GET['error'])){
                        $error_code = $_GET['error'];
                        switch ($error_code) {
                            case 1:
                                echo "<p class='error-login'>Nom d'usuari incorrecte</p>";    
                                break;
                            case 2:
                                echo "<p class='error-login'>Contrassenya incorrecta</p>";    
                                break;
                            default:
                                break;
                        }
                    }
                ?>

                <input id="submitLogin" type="submit" value="Iniciar sessió">

                <p>Si no disposes d'un compte <a href="registre.php">Enregistra't</a></p>
            </fieldset>
            
            

        </form>
    </main>
</body>