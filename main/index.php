<?php
    require('protection2.php');
    
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="./css/img/logo.webp"/>
</head>
<?php
    include("cookies_form.php");
?>
<body class="home">
    <header>
        <nav>
            <a href="index.php">
                <div class="logo">
                
                </div>
            </a>
            <form action="" method="post" class="buscadorForm">
                <input type="text" name="buscador" id="buscador" placeholder="Cerca ">
                <button type="submit" id="buscadorSubmit"><i class="fa-solid fa-magnifying-glass" id="lupa"></i></button>
            </form>
        </nav>        
    </header>
    <main>
        <div class="buit"></div>
        <section class="timeLine">
            <div class="timeLineTitol">
                <h1>Publicacions</h1>
            </div>
            <div class="timeLinePosts">
                <?php
                    include("publicacions.php")
                ?>
            </div>
        </section>

        <section class="barraLateral">
            <div class="barraLateralPerfil">
                
                
    
                
            </div>
            <div class="barraLateralPostsIndex">
                <div class="iniciSesio">
                    <span><a href="login.php">Inicia sesió</a></span>
                    <span><p>O</p></span>
                    <span><a href="registre.php">Enregistra't</a></span>                  
                </div>
            </div>
        </section>
        
        <div class="buit"></div>
    </main>
    
</body>
</html>