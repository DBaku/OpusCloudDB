<?php
// manage_playlist.php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

$benutzer_id = $_SESSION['benutzer_id'];

if (!isset($_GET['playlist_id'])) {
    echo "<p>Playlist nicht gefunden.</p>";
    exit;
}

$playlist_id = $_GET['playlist_id'];

// playlist details abrufen
$stmt = $conn->prepare("SELECT name FROM Playlist WHERE id = ? AND benutzer_id = ?");
$stmt->bind_param("ii", $playlist_id, $benutzer_id);
$stmt->execute();
$stmt->bind_result($playlist_name);
$stmt->fetch();
$stmt->close();

// wenn es keine playlisten gibt
if (!$playlist_name) {
    echo "<p>Playlist nicht gefunden oder Zugriff verweigert.</p>";
    exit;
}

echo "<h1>Playlist verwalten: $playlist_name</h1>";

// musiktitel entfernen aus der playlist
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_music_id'])) {
    $musik_id = $_POST['remove_music_id'];

    $remove_stmt = $conn->prepare("DELETE FROM Playlist_Musik WHERE playlist_id = ? AND musik_id = ?");
    $remove_stmt->bind_param("ii", $playlist_id, $musik_id);

    if ($remove_stmt->execute()) {
        echo "<p>Musikstück erfolgreich aus der Playlist entfernt.</p>";
    } else {
        echo "<p>Fehler beim Entfernen des Musikstücks: " . $remove_stmt->error . "</p>";
    }

    $remove_stmt->close();
}

// musiktitel zur playlist hinzufügen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_music_id'])) {
    $musik_id = $_POST['add_music_id'];

    // Überprüfen ob das Musiktitel bereits in der playlist ist
    $check_stmt = $conn->prepare("SELECT * FROM Playlist_Musik WHERE playlist_id = ? AND musik_id = ?");
    $check_stmt->bind_param("ii", $playlist_id, $musik_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<p>Musikstück ist bereits in der Playlist.</p>";
    } else {
        $add_stmt = $conn->prepare("INSERT INTO Playlist_Musik (playlist_id, musik_id) VALUES (?, ?)");
        $add_stmt->bind_param("ii", $playlist_id, $musik_id);

        if ($add_stmt->execute()) {
            echo "<p>Musikstück erfolgreich zur Playlist hinzugefügt.</p>";
        } else {
            echo "<p>Fehler beim Hinzufügen des Musikstücks: " . $add_stmt->error . "</p>";
        }

        $add_stmt->close();
    }

    $check_stmt->close();
}

// uploads/ musiktitel in der playlist anzeigen
$musik_in_playlist_stmt = $conn->prepare("
    SELECT Musik.id, Musik.titel
    FROM Musik
    JOIN Playlist_Musik ON Musik.id = Playlist_Musik.musik_id
    WHERE Playlist_Musik.playlist_id = ?
");
$musik_in_playlist_stmt->bind_param("i", $playlist_id);
$musik_in_playlist_stmt->execute();
$musik_in_playlist_stmt->bind_result($musik_id, $musik_titel);

echo "<h2>Musik in dieser Playlist</h2>";
echo "<ul>";

while ($musik_in_playlist_stmt->fetch()) {
    echo "<li style='display:flex;'>$musik_titel 
            <form method='post' style='display:inline;'>
                <input type='hidden' name='remove_music_id' value='$musik_id'>
                <input type='submit' value='Entfernen'>
            </form>
        </li>";
}

echo "</ul>";
$musik_in_playlist_stmt->close();

// Alle bisherigen uploads/musiktitel des benutzers anzeigen, die noch nicht in der playlist sind
$musik_stmt = $conn->prepare("
    SELECT id, titel 
    FROM Musik 
    WHERE benutzer_id = ? AND id NOT IN (
        SELECT musik_id FROM Playlist_Musik WHERE playlist_id = ?
    )
");
$musik_stmt->bind_param("ii", $benutzer_id, $playlist_id);
$musik_stmt->execute();
$musik_stmt->bind_result($musik_id, $musik_titel);

echo "<h2>Verfügbare Musikstücke hinzufügen</h2>";
echo "<form method='post'>";
echo "<select name='add_music_id'>";

while ($musik_stmt->fetch()) {
    echo "<option value='$musik_id'>$musik_titel</option>";
}

echo "</select>";
echo "<input type='submit' value='Hinzufügen'>";
echo "</form>";

$musik_stmt->close();
$conn->close();
?>

<a href="playlists.php">Zurück zu den Playlists</a>

<?php include 'includes/footer.php'; ?>