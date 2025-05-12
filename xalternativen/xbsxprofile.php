<?php
// Header und Datenbankverbindung einbinden
include 'includes/header.php';
include 'includes/db_connection.php';

// Session starten, um auf Session-Variablen zuzugreifen
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
// Wenn nicht, wird er zur Login-Seite weitergeleitet
if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

// Benutzer-ID aus der Session holen
$benutzer_id = $_SESSION['benutzer_id'];

// Profilinformationen aus der Datenbank abrufen
$stmt = $conn->prepare("SELECT benutzername, email FROM Benutzer WHERE id = ?");
$stmt->bind_param("i", $benutzer_id);
$stmt->execute();
$stmt->bind_result($benutzername, $email);
$stmt->fetch();
$stmt->close(); // Datenbankverbindung für diesen Befehl schließen

// Profilinformationen anzeigen
echo "<h1>Profil von $benutzername</h1>";
echo "<p>Email: $email</p>";

// Zitat-Generator - Funktion wie zuvor beschrieben
$zitate = [
    "Musik ist die Sprache der Seele.",
    "Wo die Worte aufhören, beginnt die Musik.",
    "Ein Leben ohne Musik ist wie eine Reise ohne Ziel.",
    "Musik kann die Welt verändern, weil sie Menschen verändern kann."
];
$zufallszitat = $zitate[array_rand($zitate)];
echo "<p><em>$zufallszitat</em></p>";

// Musik-Upload-Logik
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['musik'])) {
    // Titel des Musikstücks und Pfad zur Datei festlegen
    $titel = $_POST['titel'];
    $pfad = "uploads/" . basename($_FILES['musik']['name']);

    // Datei auf den Server hochladen und in den Ordner "uploads" verschieben
    if (move_uploaded_file($_FILES['musik']['tmp_name'], $pfad)) {
        // Musikdetails in der Datenbank speichern
        $stmt = $conn->prepare("INSERT INTO Musik (titel, pfad, benutzer_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $titel, $pfad, $benutzer_id);
        if ($stmt->execute()) {
            echo "Musik hochgeladen!";
        } else {
            echo "Fehler beim Hochladen: " . $stmt->error;
        }
        $stmt->close(); // Datenbankverbindung für diesen Befehl schließen
    } else {
        echo "Fehler beim Hochladen der Datei.";
    }
}

// Playlist-Erstellung und Verwaltung
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['playlist_name'])) {
    // Name der neuen Playlist und ID des ersten Musikstücks
    $playlist_name = $_POST['playlist_name'];
    $musik_id = $_POST['musik_id'];

    // Neue Playlist in der Datenbank erstellen
    $stmt = $conn->prepare("INSERT INTO Playlist (name, benutzer_id) VALUES (?, ?)");
    $stmt->bind_param("si", $playlist_name, $benutzer_id);

    if ($stmt->execute()) {
        $playlist_id = $stmt->insert_id; // ID der erstellten Playlist abrufen
        $stmt->close(); // Datenbankverbindung für diesen Befehl schließen

        // Ersten Track zur Playlist hinzufügen
        $stmt = $conn->prepare("INSERT INTO PlaylistMusik (playlist_id, musik_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $playlist_id, $musik_id);
        $stmt->execute();
        echo "Playlist erstellt und Musik hinzugefügt!";
        $stmt->close(); // Datenbankverbindung für diesen Befehl schließen
    } else {
        echo "Fehler beim Erstellen der Playlist: " . $stmt->error;
    }
}

// Playlist löschen
if (isset($_POST['delete_playlist_id'])) {
    // ID der zu löschenden Playlist
    $playlist_id = $_POST['delete_playlist_id'];

    // Playlist aus der Datenbank löschen
    $stmt = $conn->prepare("DELETE FROM Playlist WHERE id = ? AND benutzer_id = ?");
    $stmt->bind_param("ii", $playlist_id, $benutzer_id);
    if ($stmt->execute()) {
        echo "Playlist gelöscht!";
    } else {
        echo "Fehler beim Löschen der Playlist: " . $stmt->error;
    }
    $stmt->close(); // Datenbankverbindung für diesen Befehl schließen
}

// Playlists des Benutzers abrufen und anzeigen
$playlists_stmt = $conn->prepare("SELECT id, name FROM Playlist WHERE benutzer_id = ?");
$playlists_stmt->bind_param("i", $benutzer_id);
$playlists_stmt->execute();
$playlists_stmt->bind_result($playlist_id, $playlist_name);

echo "<h2>Deine Playlists</h2>";

while ($playlists_stmt->fetch()) {
    echo "<div>";
    echo "<h3>$playlist_name</h3>";



    // Option zum Löschen der Playlist anbieten
    echo "<form method='post'>
            <input type='hidden' name='delete_playlist_id' value='$playlist_id'>
            <input type='submit' value='Playlist löschen'>
        </form>";
    echo "</div>";
}

$playlists_stmt->close(); // Hauptdatenbankverbindung für dieses Statement schließen
$conn->close(); // Hauptdatenbankverbindung schließen
?>

<!-- Abschnitt zum Hochladen neuer Musik -->
<h2>Neue Musik hochladen</h2>
<form method="post" enctype="multipart/form-data">
    Titel: <input type="text" name="titel" required><br>
    Datei: <input type="file" name="musik" required><br>
    <input type="submit" value="Hochladen">
</form>

<!-- Abschnitt zum Erstellen einer neuen Playlist -->
<h2>Neue Playlist erstellen</h2>
<form method="post">
    Playlist Name: <input type="text" name="playlist_name" required><br>
    <!-- Auswahlmenü, um vorhandene Musikstücke zur Playlist hinzuzufügen -->
    <select name="musik_id">
        <?php
        // Musikstücke des Benutzers aus der Datenbank abrufen
        $musik_select_stmt = $conn->prepare("SELECT id, titel FROM Musik WHERE benutzer_id = ?");
        $musik_select_stmt->bind_param("i", $benutzer_id);
        $musik_select_stmt->execute();
        $musik_select_stmt->bind_result($musik_id, $musik_titel);

        // Optionen für das Auswahlmenü dynamisch erstellen
        while ($musik_select_stmt->fetch()) {
            echo "<option value='$musik_id'>$musik_titel</option>";
        }
        $musik_select_stmt->close(); // Datenbankverbindung für diesen Befehl schließen
        ?>
    </select><br>
    <input type="submit" value="Playlist erstellen">
</form>

<?php include 'includes/footer.php'; // Footer einbinden 
?>