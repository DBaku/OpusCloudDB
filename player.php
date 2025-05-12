<?php
// player.php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

$benutzer_id = $_SESSION['benutzer_id'];

// Löschanforderung verarbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $musik_id = $_POST['delete_id'];

    // Den Pfad zur Musikdatei aus der Datenbank abrufen
    $stmt = $conn->prepare("SELECT pfad FROM Musik WHERE id = ? AND benutzer_id = ?");
    $stmt->bind_param("ii", $musik_id, $benutzer_id);
    $stmt->execute();
    $stmt->bind_result($pfad);
    $stmt->fetch();
    $stmt->close();

    if ($pfad) {
        // Musikdatei vom Server löschen
        if (unlink($pfad)) {
            // Musikdatei aus der Datenbank löschen
            $stmt = $conn->prepare("DELETE FROM Musik WHERE id = ? AND benutzer_id = ?");
            $stmt->bind_param("ii", $musik_id, $benutzer_id);
            if ($stmt->execute()) {
                echo "<p>Musiktitel wurde erfolgreich gelöscht.</p>";
            } else {
                echo "<p>Fehler beim Löschen des Musiktitels aus der Datenbank: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Fehler beim Löschen der Datei vom Server.</p>";
        }
    } else {
        echo "<p>Musiktitel nicht gefunden.</p>";
    }
}

// Alle Musikdateien des Benutzers abrufen
$stmt = $conn->prepare("SELECT id, titel, pfad FROM Musik WHERE benutzer_id = ?");
$stmt->bind_param("i", $benutzer_id);
$stmt->execute();
$stmt->bind_result($musik_id, $titel, $pfad);

echo "<h1>Musikplayer</h1>";

// Musikdateien anzeigen
while ($stmt->fetch()) {
    echo "<p>$titel</p>";
    echo "<audio controls>
            <source src='$pfad' type='audio/mpeg'>
        </audio>";

    // Formular zum Löschen der Musikdatei
    echo "<form method='post' onsubmit='return confirm(\"Möchten Sie diesen Musiktitel wirklich löschen?\");'>
            <input type='hidden' name='delete_id' value='$musik_id'>
            <input type='submit' value='Löschen'>
        </form>";
}

$stmt->close();
$conn->close();

include 'includes/footer.php';
