<?php
include 'includes/header.php';
include 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $benutzername = trim($_POST['benutzername']);
    $email = trim($_POST['email']);
    $passwort = password_hash(trim($_POST['passwort']), PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Benutzer (benutzername, email, passwort) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $benutzername, $email, $passwort);

    if ($stmt->execute()) {
        echo "Registrierung erfolgreich!";
    } else {
        echo "Fehler bei der Registrierung: " . $stmt->error;
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
    <title>Register</title>

</head>

<body>


    <form method="post" action="register.php">
        Benutzername: <input type="text" name="benutzername" required><br>
        Email: <input type="email" name="email" required><br>
        Passwort: <input type="password" name="passwort" required><br>
        <input type="submit" value="Registrieren">
    </form>

    <?php include 'includes/footer.php'; ?>

</body>

</html>