<?php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $passwort = trim($_POST['passwort']);

    $stmt = $conn->prepare("SELECT id, passwort FROM Benutzer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hash);

    if ($stmt->num_rows == 1 && $stmt->fetch()) {
        if (password_verify($passwort, $hash)) {
            $_SESSION['benutzer_id'] = $id;
            header("Location: profile.php");
            exit;
        } else {
            echo "Falsches Passwort!";
        }
    } else {
        echo "Benutzer nicht gefunden!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
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
    </style>
</head>

<body>




    <form method="post" action="login.php">
        Email: <input type="email" name="email" required><br>
        Passwort: <input type="password" name="passwort" required><br>
        <input type="submit" value="Login">
    </form>

    <?php include 'includes/footer.php'; ?>



</body>

</html>