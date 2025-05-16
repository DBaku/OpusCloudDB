<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpusCloud</title>
    <style>
        :root {
            --primary-color: #333;
            --accent-color: #4a90e2;
            --bg-color: bisque;
            --text-color: #333;
            --nav-text: white;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color);
            width: 75%;
            margin: auto;
            padding: 0;
            color: var(--text-color);
        }

        nav {
            background-color: var(--primary-color);
            color: var(--nav-text);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
        }

        .nav-logo img {
            height: 50px;
            width: auto;
            margin-right: 1rem;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        nav a {
            color: var(--nav-text);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: var(--accent-color);
        }

        .nav-button {
            background-color: var(--accent-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .nav-button:hover {
            opacity: 0.9;
        }

        .on-air {
            display: inline-block;
            background-color: #ff4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-weight: bold;
            animation: blink-animation 1.5s steps(5, start) infinite;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }

        .upload-form {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-logo">
            <a href="index.php">
                <img src="source/2024-09-03_12-08.png" alt="OpusCloud Logo">
            </a>
        </div>
        
        <div class="nav-links">
            <a href="index.php">Home</a>
            
            <?php if (isset($_SESSION['benutzer_id'])): ?>
                <a href="profile.php">Profil</a>
                <a href="player.php">Musikplayer</a>
                <a href="playlists.php">Playlists</a>
                <a href="upload.php">Musik hochladen</a>
                <a href="logout.php" class="nav-button">Logout</a>
                <span class="on-air">On Air</span>
            <?php else: ?>
                <a href="login.php" class="nav-button">Login</a>
                <a href="register.php" class="nav-button">Registrieren</a>
            <?php endif; ?>
        </div>
    </nav>
</body
