<!-- <?php

        // $car = array("brand"=>"Ford","model"=>"Mustang","year"=>1964);
        // // var_dump($car);

        // // abfargen der values in meinem array
        // echo ($car["model"] . "<br>");
        // echo ($car["year"] . "<br>");

        // // neue values zuweisen
        // $car["year"] = 2022; 

        // // html kann problemlos in unseren echo befehl mit eingebaut werden 
        // echo ("<li>" . $car["year"] ."</li>");
        $vorname = $_POST["fname"];
        $alter = $_POST["age"];
        // echo("Hallo " . $_POST["fname"] . ", du bist " . $_POST["age"] . "Jahre alt.");
        // nun ersetzten $vorname = $_POST["fname"]; mit unsere eigens vergebenen variablenname zur weiteren nutzung 
        // echo("Hallo " . $vorname . ", du bist " . $alter . "Jahre alt.");
        ?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img {
            width: 50%;
        }

        div {
            display: flex;
            justify-content: center;
            width: 100%;
        }
    </style>
</head>

<body>
    <br>

    <?php
    // index.php
    include 'includes/header.php';  ?>

    <h1>Willkommen bei OpusCloud</h1>
    <p>Deine persönliche Musikplattform. Registriere dich oder logge dich ein, um deine Musik zu verwalten.</p>

    <blockquote>Meisterstück Datenbank</blockquote>
    <blockquote>Author: Dimitrij Bakumenko</blockquote>

    <button class="register-button">
        <a href="register.php">Registrieren</a>
    </button>

    ||

    <button class="login-button">
        <a href="login.php">Login</a>
    </button>

    <?php include 'includes/footer.php'; ?>

    <p>
    <div>

        <img src="kakikatzi.jpg" alt="kakikatzi"><br>
    </div>
    </p>

    <div>
        <?php
        echo ("Hallo " . $vorname . ", du bist " . $alter . " Jahre alt.");
        ?>
    </div>

</body>

</html>