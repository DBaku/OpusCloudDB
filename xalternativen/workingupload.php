<?php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['musik'])) {
    $titel = $_POST['titel'];
    $benutzer_id = $_SESSION['benutzer_id'];
    $pfad = "uploads/" . basename($_FILES['musik']['name']);

    if (move_uploaded_file($_FILES['musik']['tmp_name'], $pfad)) {
        $stmt = $conn->prepare("INSERT INTO Musik (titel, pfad, benutzer_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $titel, $pfad, $benutzer_id);

        if ($stmt->execute()) {
            echo "Musik hochgeladen!";
        } else {
            echo "Fehler beim Hochladen: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Fehler beim Hochladen der Datei.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload</title>
    <style>
        body {
            background-color: bisque;
            width: 50%;
            margin: auto;
        }
    </style>
</head>

<body>


    <form method="post" enctype="multipart/form-data">
        Titel: <input type="text" name="titel" required><br>
        Datei: <input type="file" name="musik" required><br>
        <input type="submit" value="Hochladen">
    </form>

    <?php include 'includes/footer.php'; ?>

</body>

</html>