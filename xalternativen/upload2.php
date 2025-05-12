<?php
session_start();
if (!isset($_SESSION['BenutzerID'])) {
    die("Bitte zuerst anmelden!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["musikdatei"])) {
    $benutzerID = $_SESSION['BenutzerID'];
    $titel = $_POST['titel'];
    $dateipfad = "uploads/" . basename($_FILES["musikdatei"]["name"]);

    if (move_uploaded_file($_FILES["musikdatei"]["tmp_name"], $dateipfad)) {
        $conn = new mysqli("localhost", "root", "", "OpusCloudDB");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO Musikdateien (BenutzerID, Titel, Dateipfad) VALUES ('$benutzerID', '$titel', '$dateipfad')";
        if ($conn->query($sql) === TRUE) {
            echo "Datei erfolgreich hochgeladen!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Fehler beim Hochladen der Datei.";
    }
}
?>

<form method="post" enctype="multipart/form-data" action="upload.php">
    Titel: <input type="text" name="titel"><br>
    Musikdatei: <input type="file" name="musikdatei"><br>
    <input type="submit" value="Hochladen">
</form>