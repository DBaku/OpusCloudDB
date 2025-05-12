<?php include 'includes/header.php'; ?>
<?php
include 'includes/db_connection.php';
session_start();

//prüfen ob benutzer angemeldet ist ansonsten erst anmelden dafür zum login leiten 
if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}
// session ist möglich einem benutzer zu zuordnen
$benutzer_id = $_SESSION['benutzer_id'];

//  neue playlist erstellen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['playlist_name'])) {
    $name = trim($_POST['playlist_name']);

    $stmt = $conn->prepare("INSERT INTO Playlist (name, benutzer_id) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $benutzer_id);

    if ($stmt->execute()) {
        echo "<p>Playlist wurde erfolgreich erstellt.</p>";
    } else {
        echo "<p>Fehler beim Erstellen der Playlist: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// alle playlisten anzeigen
$playlists_stmt = $conn->prepare("SELECT id, name FROM Playlist WHERE benutzer_id = ?");
$playlists_stmt->bind_param("i", $benutzer_id);
$playlists_stmt->execute();
$playlists_stmt->bind_result($playlist_id, $playlist_name);

echo "<h1>Deine Playlists</h1>";

// playlists anzeigen und optionen zum verwalten bieten
while ($playlists_stmt->fetch()) {
    echo "<p>$playlist_name</p>";

    // formular zum #löschen der playlist
    echo "<form method='post' onsubmit='return confirm(\"Möchten Sie diese Playlist wirklich löschen?\");'>
            <input type='hidden' name='delete_playlist_id' value='$playlist_id'>
            <input type='submit' value='Playlist löschen'>
        </form>";

    // link zum verwalten der musik in der playlist
    echo "<a href='manage_playlist.php?playlist_id=$playlist_id'>Musik in dieser Playlist verwalten</a>";
}

// löschanforderung verarbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_playlist_id'])) {
    $playlist_id = $_POST['delete_playlist_id'];

    // lösche nur die playlist aus der datenbank
    $stmt = $conn->prepare("DELETE FROM Playlist WHERE id = ? AND benutzer_id = ?");
    $stmt->bind_param("ii", $playlist_id, $benutzer_id);

    if ($stmt->execute()) {
        echo "<p>Playlist wurde erfolgreich gelöscht.</p>";
    } else {
        echo "<p>Fehler beim Löschen der Playlist: " . $stmt->error . "</p>";
    }

    $stmt->close();
}


$playlists_stmt->close();
$conn->close();
?>

<!-- formular zur die erstellung eienr playlist -->
<h2>erstell dir eine Playlist</h2>
<form method="post">
    Playlist Name: <input type="text" name="playlist_name" required><br>
    <input type="submit" value="Playlist erstellen">
</form>

<?php include 'includes/footer.php'; ?>