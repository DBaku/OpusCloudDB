<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpusCloud</title>
    <!-- <link rel="stylesheet" href="styles/style.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: bisque;
            width: 75%;
            margin: auto;
            padding: 0;
            color: #333;
        }

        audio {
            background-color: #333;
            border: 2px, solid, white;
        }

        nav {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        nav img {
            height: 50px;
            /* Höhe des Logos im Header */
            width: auto;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        footer {
            text-align: center;
            align-items: center;
            padding: 5px;
            background-color: #333;
            color: white;
            /* position: fixed; */
            bottom: 0;
            height: auto;
            width: 90%;
            margin: auto;
            display: block;
            justify-content: center;
        }

        footer img {
            height: 30px;
            /* Höhe des Logos im Footer */
            width: auto;
            margin: 0;
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

        .profil-pic {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;

        }

        .pp {
            display: flex;
            margin: auto;
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
            border: #333, 1px, solid;
            animation: blink-animation 1.5s steps(5, start) infinite;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
    </style>
</head>

<body>
    <nav>
        <!-- Logo im Header -->
        <a href="index.php"><img src="source/2024-09-03_12-08.png" alt="OpusCloud Logo"></a>
        <div>
            <a href="index.php">Home</a>

            <?php if (isset($_SESSION['benutzer_id'])): ?>
                <button><a href="profile.php">Profil</a></button>
                <button><a href="login.php">Login</a></button>
                <button><a href="logout.php">Logout</a></button>
                <button><a href="register.php">Registrieren</a></button>
                <button><a href="player.php">Musikplayer</a></button>
                <button><a href="playlists.php">Playlists</a></button>
                <button><a href="upload.php">Musik Hochladen</a></button>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="logout.php">Logout</a>
                <a href="register.php">Registrieren</a>
                <a href="profile.php">Profil</a>
                <a href="player.php">Musikplayer</a>
                <a href="playlists.php">Playlists</a>
                <a href="upload.php">Musik Hochladen</a>
            <?php endif; ?>
        </div>
    </nav>
    <hr>

</body>

</html>