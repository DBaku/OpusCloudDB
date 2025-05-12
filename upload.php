<?php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

// Prüfe, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['musik'])) {
    $titel = trim($_POST['titel']);
    $benutzer_id = $_SESSION['benutzer_id'];
    $upload_dir = "uploads/";
    $dateiname = basename($_FILES['musik']['name']);
    $pfad = $upload_dir . $dateiname;
    $upload_ok = 1;
    $dateityp = strtolower(pathinfo($pfad, PATHINFO_EXTENSION));

    // Überprüfe, ob der Dateityp zulässig ist (z.B. mp3, wav)
    $zugelassene_dateitypen = ['mp3', 'wav', 'ogg'];
    if (!in_array($dateityp, $zugelassene_dateitypen)) {
        echo "Nur MP3, WAV und OGG-Dateien sind erlaubt.";
        $upload_ok = 0;
    }

    // Überprüfe, ob die Datei schon existiert
    if (file_exists($pfad)) {
        echo "Die Datei existiert bereits.";
        $upload_ok = 0;
    }

    // Überprüfe die Dateigröße (z.B. maximal 10 MB)
    if ($_FILES['musik']['size'] > 10000000) {
        echo "Die Datei ist zu groß.";
        $upload_ok = 0;
    }

    // Versuche die Datei hochzuladen, wenn alles in Ordnung ist
    if ($upload_ok && move_uploaded_file($_FILES['musik']['tmp_name'], $pfad)) {
        $stmt = $conn->prepare("INSERT INTO Musik (titel, pfad, benutzer_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $titel, $pfad, $benutzer_id);

        if ($stmt->execute()) {
            echo "Musik erfolgreich hochgeladen!";
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

<form method="post" enctype="multipart/form-data">

    <blockquote>zugelassene_dateitypen = 'mp3', 'wav', 'ogg'</blockquote>
    <!-- <p>wähle einen Namen für dein Track und füge die gewünschte datei hinzu.
        Durch klicken auf den Hochladen-Button speicherst du deinen Track in der Datenbank ab und kannst jederzeit über den Reiter 'Musikplayer' diese dann abspielen uvm... Enjoy !
    </p> -->


    <label aria-placeholder="here Titel einfügen" for="titel">Titel:</label>
    <input type="text" name="titel" id="titel" required><br>
    <label for="musik">Datei:</label>
    <input type="file" name="musik" id="musik" required><br>
    <input type="submit" value="Hochladen">
</form>

<?php include 'includes/footer.php'; ?>