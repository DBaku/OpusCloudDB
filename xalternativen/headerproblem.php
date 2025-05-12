includes/header.php (Header)
php
Code kopieren
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpusCloud</title>
    <style>
        /* Dein CSS-Stil hier */
        body {
            font-family: Arial, sans-serif;
            background-color: bisque;
            width: 75%;
            margin: auto;
            padding: 0;
            color: #333;
        }

        nav {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 75%;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        audio {
            display: block;
            margin: 20px auto;
        }

        /* Stil für das "On Air"-Zeichen */
        .on-air {
            display: inline-block;
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            animation: blink-animation 1.5s steps(5, start) infinite;
        }


        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
    </style>
    </style>
</head>

<body>
    <nav>
        <a href="index.php">Home</a>

        <?php if (isset($_SESSION['benutzer_id'])): ?>
            <!-- Benutzer ist eingeloggt -->
            <button><a href="profile.php">Profil</a></button>
            <button><a href="logout.php">Logout</a></button>
            <button><a href="player.php">Musikplayer</a></button>
            <button><a href="playlists.php">Playlists</a></button>
            <button><a href="upload.php">Musik Hochladen</a></button>
            <!-- On Air Zeichen -->
            <span class="on-air">On Air</span>
        <?php else: ?>
            <!-- Benutzer ist nicht eingeloggt -->
            <a href="login.php">Login</a>
            <a href="register.php">Registrieren</a>
        <?php endif; ?>

        <!-- 
        hier entsteht ein problem welches ich einfach nicht behoben bekomme und nicht verstehe warum nicht!
        ich habe bereits versucht es sohl oben als unten einzusetzen oder es in html body zu wickeln aber nichts klappt deshalb habe ich den on air zeiger im profilbody gesteckt um halbwegs den sinn davon zu erfüllen aber ist schwierig zusätzlich kommt dass ich nicht hinkrieg die animation verknüpft zu bekommen weil es soll ja blinken 
        genau jetzt komme ich auf die idee ein link sheet einzusetzten oder den stylecode nochmal in der jeweiligen datei zu überprüfen ! 
        -->
        <!-- 
        FETTES HIGH FIVE AN MICH SELBST
        genau wie geschildert lag es an der fehlenden einbindung 
        nun gehts !!!
        yeah :)
        -->
    </nav>
    <hr>
</body>

</html>