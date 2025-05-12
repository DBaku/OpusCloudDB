<?php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

$benutzer_id = $_SESSION['benutzer_id'];

// neuer abruf befehl der benutzerinformationen inkl profilbild
$stmt = $conn->prepare("SELECT benutzername, email, profilbild FROM Benutzer WHERE id = ?");
$stmt->bind_param("i", $benutzer_id);
$stmt->execute();
$stmt->bind_result($benutzername, $email, $profilbild);
$stmt->fetch();
$stmt->close();

// profilbild hochladen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilbild'])) {
    $bildname = basename($_FILES['profilbild']['name']);
    $zielpfad = 'uploads/profilbilder/' . $bildname;
    $bildtyp = strtolower(pathinfo($zielpfad, PATHINFO_EXTENSION));

    // bisher erwünschte dateiformate
    $erlaubteFormate = ['jpg', 'jpeg', 'png', 'gif'];
    //wenn sich in dem array erforderliche bildtyp und format befindet dann lade die datei hoch und definiere sie als bündel welches das bild den namen und den pfad enthält und speicher benutzer id + pfad in db
    if (in_array($bildtyp, $erlaubteFormate)) {
        if (move_uploaded_file($_FILES['profilbild']['tmp_name'], $zielpfad)) {
            // fad in der datenbank speichern
            $stmt = $conn->prepare("UPDATE Benutzer SET profilbild = ? WHERE id = ?");
            $stmt->bind_param("si", $zielpfad, $benutzer_id);

            if ($stmt->execute()) {
                echo "Profilbild erfolgreich hochgeladen!";
                // profilbild variable aktualisieren
                $profilbild = $zielpfad;
            } else {
                echo "Fehler beim Speichern des Profilbildes in der Datenbank:" . $stmt->error;
            }
        } else {
            echo "Fehler beim Hochladen des Bildes.";
        }
    } else {
        echo "Nur JPG, JPEG, PNG & GIF-Dateien sind erlaubt.";
    }
}

// Zufällige Zitate definieren
$zitate = [
    "Nicht alles was ✋ und 🦶 hat, hat auch ❤️ und 🧠 !",
    "Musik verbindet jegliche Synapse und lässt sie alle tanzen. -Simonsen, Natalia",
    "Habe mir vorgenommen, jeden Abend vor dem Schlafengehen 20 Liegestütze zu machen. Bin schon seit 3 Tagen wach!",
    "Kommas setze, ich, dahin wo sie, gut, aussehen.",
    "Ich applaudiere, weil es vorbei ist – nicht, weil ich es mochte.",
    "Das Leben ist kurz, also iss das Dessert zuerst!",
    "Niemand kann dich ausnutzen, wenn du nutzlos bist. - Dima",
    "Wer im Glashaus sitzt, sollte im Bad das Licht ausmachen.",
    "Ich muss langsam mal nett werden, ich bin nicht ewig hübsch.",
    "Dummheit kennt keine Grenzen, aber sehr viele Leute.",
    "Ich wollte einen Witz über Zeitreisen machen, aber den mochtest du nicht.",
    "Ich hasse Stimmungsschwankungen sind toll.",
    "237% der Menschen übertreiben völlig!",
    "Die Musik drückt das aus, was nicht gesagt werden kann und worüber zu schweigen unmöglich ist. – Victor Hugo",
    "Ohne Musik wäre das Leben ein Irrtum. – Friedrich Nietzsche",
    "Musik ist die stärkste Form der Magie. – Marilyn Manson",
    "Wo die Sprache aufhört, fängt die Musik an. – E.T.A. Hoffmann",
    "Das Beste in der Musik steht nicht in den Noten. – Gustav Mahler",
    "Musik ist die universelle Sprache der Menschheit. – Henry Wadsworth Longfellow",
    "In der Musik liegt die wahre Verbindung zwischen allen Menschen. – Gustav Mahler",
    "Musik ist die Kunst, Zeit hörbar zu machen. – Susanne K. Langer",
    "Musik kann die Welt verändern, weil sie die Menschen verändert. – Bono",
    "Musik ist die einzige Sprache, die man auf der ganzen Welt versteht. – Carl Maria von Weber",
    "Leute verschwinden so wie die Wolken am Himmel, der Teufel singt und unsere köpfe sind am klingeln-DBart",
    "Wir haben genug um die ganze Welt mit Nahrung zu versorgen, doch die guten Präsidenten wurden mal eben ermordet - Dima",

];

// hier wird ein zufälliges zitat random gewählt 
$zufaelliges_zitat = $zitate[array_rand($zitate)];


// profilinformationen anzeigen
echo "<h1>Willkommen in deinem Profil $benutzername</h1>";
echo "<p>Email: $email</p>";

// zitat anzeigen
echo "<blockquote><p>$zufaelliges_zitat</p></blockquote>";

// $conn->close();  // schließen aller statements und verbindung
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>

</head>

<body>

    <!-- Profilbild anzeigen -->
    <?php if ($profilbild): ?>
        <div class="pp">
            <img class='profil-pic' src="<?php echo $profilbild; ?>" alt="Profilbild" style="width:200px; height:200px; border-radius:50%;">
        </div>
    <?php else: ?>
        <p>Kein Profilbild hochgeladen.</p>
    <?php endif; ?>

    <!-- Formular zum Hochladen des Profilbildes -->
    <form method="post" enctype="multipart/form-data">
        Profilbild hochladen: <input type="file" name="profilbild" required><br>
        <input type="submit" value="Hochladen">
    </form>



    <!-- <form action="profile.php" method="post" enctype="multipart/form-data">
        <label for="profilbild">Profilbild hochladen:</label><br>
        <input type="file" name="profilbild" id="profilbild"><br><br>
        <input type="submit" name="upload_profilbild" value="Hochladen">
    </form> -->

    <!-- "On Air"-zeichen anzeigen wenn benutzer eingeloggt ist -->
    <span class="on-air">On Air</span>

    <!-- die links esrtmal ausgeblendet da wir im header alles erreichbar haben  -->
    <!-- | <a href="upload.php">Musik hochladen</a> |
    | <a href="playlists.php">Playlists verwalten</a> |
    | <a href="player.php">Musikplayer</a> |
    | <a href="profile.php">Profil</a> | -->

    <?php include 'includes/footer.php'; ?>
</body>

</html>
