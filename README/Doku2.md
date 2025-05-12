### - Schritt 1: Datenbankmodell (ERD) und Einrichtung der Datenbank

    Zunächst definieren wir das Entity-Relationship-Diagramm (ERD) für das Projekt OpusCloudDB. Dieses Diagramm hilft dabei, die Beziehungen zwischen den Tabellen in der Datenbank zu verstehen.

            ERD (Entity-Relationship-Diagramm)
            Das ERD enthält folgende Entitäten (Tabellen):

           - Benutzer

            id: INT, Primary Key, AUTO_INCREMENT
            benutzername: VARCHAR(50), UNIQUE
            email: VARCHAR(100), UNIQUE
            passwort: VARCHAR(255)


           - Musik

            id: INT, Primary Key, AUTO_INCREMENT
            titel: VARCHAR(255)
            pfad: VARCHAR(255)
            benutzer_id: INT, Foreign Key zu Benutzer(id)

           - Playlist

            id: INT, Primary Key, AUTO_INCREMENT
            name: VARCHAR(100)
            benutzer_id: INT, Foreign Key zu Benutzer(id)

           - Playlist_Musik

            playlist_id: INT, Foreign Key zu Playlist(id)
            musik_id: INT, Foreign Key zu Musik(id)

---

---

### SQL zum Erstellen der Datenbank und Tabellen

          CREATE DATABASE OpusCloudDB;

          USE OpusCloudDB;

          CREATE TABLE Benutzer (
          id INT(11) AUTO_INCREMENT PRIMARY KEY,
          benutzername VARCHAR(50) NOT NULL UNIQUE,
          email VARCHAR(100) NOT NULL UNIQUE,
          passwort VARCHAR(255) NOT NULL
          );

          CREATE TABLE Musik (
          id INT(11) AUTO_INCREMENT PRIMARY KEY,
          titel VARCHAR(255) NOT NULL,
          pfad VARCHAR(255) NOT NULL,
          benutzer_id INT(11),
          FOREIGN KEY (benutzer_id) REFERENCES Benutzer(id) ON DELETE CASCADE
          );

          CREATE TABLE Playlist (
          id INT(11) AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(100) NOT NULL,
          benutzer_id INT(11),
          FOREIGN KEY (benutzer_id) REFERENCES Benutzer(id) ON DELETE CASCADE
          );

          CREATE TABLE Playlist_Musik (
          playlist_id INT(11),
          musik_id INT(11),
          FOREIGN KEY (playlist_id) REFERENCES Playlist(id) ON DELETE CASCADE,
          FOREIGN KEY (musik_id) REFERENCES Musik(id) ON DELETE CASCADE
          );

-   ### Schritt 2: Testdaten einfügen
    Füge einige Testdaten in die Datenbank ein, um sie später abrufen zu können.

sql

        INSERT INTO Benutzer (benutzername, email, passwort) VALUES
        ('testuser1', 'test1@example.com', '$2y$10$examplehash1'),
        ('testuser2', 'test2@example.com', '$2y$10$examplehash2');

        INSERT INTO Musik (titel, pfad, benutzer_id) VALUES
        ('Song 1', 'songs/song1.mp3', 1),
        ('Song 2', 'songs/song2.mp3', 1),
        ('Song 3', 'songs/song3.mp3', 2);

        INSERT INTO Playlist (name, benutzer_id) VALUES
        ('Chill Vibes', 1),
        ('Workout Playlist', 2);

        INSERT INTO Playlist_Musik (playlist_id, musik_id) VALUES
        (1, 1),
        (1, 2),
        (2, 3);

-   ### Schritt 3: Projektstruktur und grundlegende Seiten erstellen
    ### Erstelle eine Projektstruktur mit den folgenden Dateien:

---

---

### VerzeichnisStruktur als sher hilfreiche übersicht

    /OpusCloudDB
    │
    ├── index.php
    ├── register.php
    ├── login.php
    ├── profile.php
    ├── upload.php
    ├── playlists.php
    ├── player.php
    ├── includes
    │ ├── header.php
    │ ├── footer.php
    │ └── db_connection.php
    └── styles
    └── style.css

### Baue nun gerade die strucktur auf bis hier hin schon mal:

x - erd
x - sql datenbank verbindung
x - modelle angelegt
x - verzeichnis strucktur aufgebaut
x - musik einegefügt
x - testdaten eingefügt
x - doku ist auf dem laufenden

## an dieser stelle wird es etwas komisch den die php datein ließen sichnnicht richtig lesen ohne html tag drin geseztz zu haben

-   meine annahme hier war das etwas mit dem server oder preview oder anbindung
    war falsch den es wurde mir auch weder ein fehler noch etwas anderes angezeigt
    auch nach dem überprüfen gemeinsam mit daniel lief es nicht...

-   dann hatte ich den gedanken vllt fehlte mir etwas wie npm start zusätzlich
    jedenfalls klappte dies auch nicht aber durch die extension php live server
    hatte sich dieses problem bereinigt den nun wurde anscheinen ein
    entwicklungsserver gestartet der im stande ist es vernünftig auszulesen und
    anzuzeigen

-   nächstes problem upload musik datein lässt sich nicht hochladen und erzeugt
    fatalerror

-   nach langer suche ist mir ein dreher in der musik tabelle aufgefallen und
    ein überschüßiger artist attribut hatte die korrekte übergabe verhindert

-   nach reiflicher suche und überarbeitung der schwachstellen im code führte
    ich eine verbesserung der modelierung durch optimierte das uploadverfahren

-   gelang es mir nun das problem zu lösen: musik uploads zu machen, playlisten zu
    erstellen und korrekte db dateneinträge mithilfe des Frontends zu erstellen.

-   außerdem ist auch eine logoutfunktion enthalten

---

---

## Beispiel für mögliche abfragen:

-   #### 1. Alle Musikdateien anzeigen

    SELECT \* FROM Musikdateien;

-   #### 2. Musikdateien eines bestimmten Benutzers anzeigen

    SELECT \* FROM Musikdateien WHERE BenutzerID = 1;

-   #### 3. Musikdatei nach Titel suchen

    SELECT \* FROM Musikdateien WHERE Titel LIKE '%Song A%';

-   #### 4. Die Anzahl der Musikdateien pro Benutzer anzeigen

    SELECT BenutzerID, COUNT(\*) AS AnzahlMusikdateien
    FROM Musikdateien
    GROUP BY BenutzerID;

---

---

## Erläuterung zu meinem vorgehen logout

-   durch die korrekte übergabe unserer attribute erzielen wir nun
    einen eintrag in db der die geforderten oder notwendigen daten
    speichert in diesem fall ein benutzer anlegt samt name email pw
    dabei wird pw gehasht

-   nun kann der angelegte benutzer zwischen unseren funktionen
    hüpfen => Musik hochladen (create,update), hören (read),
    herunterladen,löschen (delete), playlisten createn... weitere
    kommen

-   die Musiktitel uploads und erstellten playlisten werden
    ebenfalls bei erstellung in die db als eintrag aufgenommen

### Feststellung

-   kein logout und navigation klobig (bigshitindeinklo)

-   playlisten auch löschen und updaten implem.

### lösungsansatz

ich möchte dass der benutzer irgendwie wahrnehmen kann ob er angemeldet ist oder nicht und das er bewusst seine session beenden und wiederaufnehemen kann ohne die integretät seiner letzten sitzung zu gefärden

1.  ich muss eine session und ihre existensberechtigung definieren

2.  $\_SESSION = array();
    dieser array enthält die diversen vorgänge und die wollen wir mithilfe des zugriffes und der leerung der verw. cookies vollziehen möchten, daher greifen wir durch selbigen parameter auf die gewünschten session cookies um diese zu löschen, deutlich erkennbar an der [logout.php] in unserem verzeichnis

3.  sess begin und ende bestimmen und dauer eingrenzen,
    in unserem fall verwenden wir cookies für die session aufrechterha bsp:

// Setzt das Cookie mit einem abgelaufenen Zeitpunkt, um es zu löschen

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );

4. am ende zerstören wir die session um sicherzustellen dass sie nicht mehr verwendet wird

---

---

Alternativ erklärung ausn inet

    Session Starten:

    session_start();: Diese Zeile startet die Session, damit wir auf die Session-Daten zugreifen können, wie z.B. die ID des aktuell angemeldeten Benutzers.
    Session-Variablen Löschen:

    $_SESSION = array();: Hier leeren wir das Session-Array, um alle aktuell gespeicherten Session-Daten zu löschen. Das bedeutet, dass der Benutzer quasi "vergessen" wird, und alle temporären Daten der aktuellen Sitzung entfernt werden.
    Session-Cookie Löschen:

    Die Session verwendet oft Cookies, um die Sitzung des Benutzers zu verfolgen. Wenn ein Cookie verwendet wird, sorgt dieser Abschnitt dafür, dass das Cookie auf dem Benutzergerät gelöscht wird.
    setcookie(session_name(), '', time() - 42000, ...): Diese Funktion setzt das Cookie mit einem abgelaufenen Datum, sodass der Browser es entfernt.
    Session Zerstören:

    session_destroy();: Diese Funktion löscht die Session komplett auf dem Server. Nachdem sie zerstört wurde, kann sie nicht mehr verwendet werden, bis eine neue Session gestartet wird.
    Umleitung nach dem Logout:

    header("Location: index.php");: Nach dem Löschen der Session-Daten wird der Benutzer zur Startseite (index.php) umgeleitet.
    exit();: Dieser Befehl stellt sicher, dass das Skript sofort beendet wird, um zu verhindern, dass nach dem Logout weitere Aktionen durchgeführt werden.

---

---

### die idee von logout link sichtbarkeit

-   zustand: nicht angemeldet = false = register + login

-   zustand: angemeldet = true = profil + logout

ergebnis:

-   scheint irgendwie noch nicht richtig zu funktionieren

    <?php if(isset($_SESSION['benutzer_id'])): ?>

        <a href="profile.php">Profil</a>
        <a href="logout.php">Logout</a>

    <?php else: ?>

        <a href="login.php">Login</a>
        <a href="register.php">Registrieren</a>

    <?php endif; ?>

### BEACHTEN!

-   an dieser stelle habe ich es erstmal umgepopelt damit es geht aber muss verbessert werden

---

---

### Next step

-   in unserem profil soll jedes mal zur begrüßung ein neues zitat erscheinen

1. erstellen von zitaten in einer liste

2. // Zufällige Zitate definieren
   $zitate = [
   "zitat", "zitat", "zitat", "zitat",
   "zitat", "zitat", "zitat", "zitat",
   "zitat", "zitat", "zitat", "zitat",
   "zitat", "zitat", "zitat", "zitat"
   ];

    // Zufälliges Zitat auswählen
    $zufaelliges_zitat = $zitate[array_rand($zitate)];

    - ein zufälliges zitat ist unsere zitatenliste auf welche die methode,
    - methode: wählt 1 listenelement aus der, in der klammer stehenden liste
    - angewendet wurde

    // Benutzerinformationen abrufen
    $benutzer_id = $_SESSION['benutzer_id'];
    $stmt = $conn->prepare("SELECT benutzername, email FROM Benutzer WHERE id = ?");
    $stmt->bind_param("i", $benutzer_id);
    $stmt->execute();
    $stmt->bind_result($benutzername, $email);
    $stmt->fetch();

// Profilinformationen anzeigen

    echo "<h1>Profil von $benutzername</h1>";
    echo "<p>Email: $email</p>";

// Zitat anzeigen

    echo "<blockquote><p>$zufaelliges_zitat</p></blockquote>";

    $stmt->close();
    $conn->close();
    ?>

---

## erfolgreich implem.

---

---

## Wie funktioniert der Code?

Zitatliste:

Die Zitate werden in einem Array ($zitate) gespeichert. Jedes Zitat ist ein Element in diesem Array.
Zufälliges Zitat auswählen:

Die Funktion array_rand($zitate) wählt zufällig einen Schlüssel aus dem Array. Dieser Schlüssel wird dann verwendet, um das entsprechende Zitat aus dem Array abzurufen.
Zitat anzeigen:

Das ausgewählte Zitat wird innerhalb eines <blockquote>-Tags angezeigt, um es optisch hervorzuheben.

-   Zusätzlich zu den Profilinformationen (Benutzername, E-Mail) wird bei
    jedem Laden der Seite ein anderes Zitat angezeigt.

### Vorteile dieser Methode:

    - Einfache Implementierung: Die Zitate sind direkt in der profile.php-Datei definiert und benötigen keine zusätzliche Datenbank oder API.

    - Abwechslung: Bei jedem Aufruf der Profilseite sieht der Benutzer ein neues Zitat, was die Seite dynamischer und interessanter macht.

    - Erweiterbarkeit: Du kannst die Liste der Zitate einfach erweitern oder ändern, indem du das $zitate-Array anpasst.

-   Zusammenfassung:
    Durch die Implementierung des Zitat-Generators erhält die Profilseite eine zusätzliche persönliche Note, die dem Benutzer bei jedem Besuch eine neue Inspiration oder einen neuen Gedanken mit auf den Weg gibt. Der Code ist leicht verständlich und kann einfach erweitert werden, falls du weitere Zitate hinzufügen möchtest.

---

---

## nun beginnen wir unter dem blickpunkt refactoring unseren bisherigen code ein wenig zusammen zu fassen damit man seine musik titel und playlisten in unserem bereich beisammen zu haben

das bedeutet wir werden profile.php ausweiten indem wir die upload.php, player.php und playlists.php in profile.php einfügen und diesen code sorgsam überarbeiten und perfomant abstimmen.
Außerdem werden wir unseren header und footer ein wenig pimpem

---

## Umsetzung:

-   Schritt 1: Grundstruktur der profile.php
    Zuerst erstellen wir eine Struktur für die profile.php, die den Upload, das Erstellen und Verwalten von Playlisten sowie das Abspielen von Musikdateien integriert.

-   Schritt 2: Refactoring des Codes
    Wir integrieren die bestehenden Funktionen für den Upload, das Erstellen von Playlists und den Player in die profile.php.

---

## überarbeitete version unseres profils mit ausführlichem kommentar

## OPTIMIERUNG PROFIL Fehlerhaft durch fehlerhafte statement closing erfordert weitere wartung

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

        // Musikstücke der jeweiligen Playlist abrufen
        $musik_stmt = $conn->prepare("SELECT Musik.titel, Musik.pfad FROM Musik
                                      INNER JOIN PlaylistMusik ON Musik.id = PlaylistMusikmusik_id
                                      WHERE PlaylistMusik.playlist_id = ?
        $musik_stmt->bind_param("i", $playlist_id)
        $musik_stmt->execute();
        $musik_stmt->bind_result($musik_titel, $musik_pfad);

        while ($musik_stmt->fetch()) {
            // Musikstücke innerhalb der Playlist anzeigen und abspielbar machen
            echo "<p>$musik_titel</p>";
            echo "<audio controls>
                    <source src='$musik_pfad' type='audio/mpeg'>
                </audio>";
        }
        $musik_stmt->close(); // Datenbankverbindung für diesen Befehl schließen

        // Option zum Löschen der Playlist anbieten
        echo "<form method='post'>
                <input type='hidden' name='delete_playlist_id' value='$playlist_id'>
                <input type='submit' value='Playlist löschen'>
            </form>";
        echo "</div>";
    }

    $playlists_stmt->close(); // Datenbankverbindung für diesen Befehl schließen
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

    <?php include 'includes/footer.php'; // Footer einbinden ?>

---

---

## Erklärung des Codes:

-   Session-Management und Benutzerüberprüfung:

-   Die session_start() Funktion startet eine neue oder setzt eine vorhandene Session fort, die
    nötig ist, um auf Session-Variablen wie $\_SESSION['benutzer_id'] zuzugreifen.

-   Wenn der Benutzer nicht eingeloggt ist (d.h. die
    benutzer_id-Session-Variable ist nicht gesetzt), wird er auf die Login-Seite weitergeleitet.

-   Profilinformationen abrufen und anzeigen:

-   Mit einem SELECT-Statement werden der Benutzername und die E-Mail-Adresse
    des eingeloggenen Benutzers aus der Datenbank abgerufen und auf der Seite angezeigt.

-   Zitat-Generator:

-   Es wird ein zufälliges Zitat aus einem Array ausgewählt und auf der
    Profilseite angezeigt.

-   Musik-Upload:

-   Beim Hochladen einer Musikdatei wird der Dateiname zusammen mit dem
    Benutzer, der die Datei hochgeladen hat, in der Datenbank gespeichert. Vorher wird die Datei in einen uploads-Ordner verschoben.

-   Playlist-Erstellung:

-   Benutzer können eine neue Playlist erstellen und sofort ein Musikstück
    hinzufügen.

-   Die neue Playlist wird in der Datenbank gespeichert und über eine
    Zwischentabelle (PlaylistMusik) mit den entsprechenden Musikstücken verknüpft.

-   Playlist-Verwaltung:

-   Playlists des Benutzers werden aus der Datenbank abgerufen und auf der
    Profilseite angezeigt.

        Die Musikstücke jeder Playlist werden ebenfalls angezeigt, und die Musikdateien können direkt abgespielt werden.
        Der Benutzer hat die Möglichkeit, eine Playlist zu löschen.

-   Formulare:

-   Formulare werden verwendet, um neue Musikdateien hochzuladen und
    Playlists zu erstellen.

-   Ein Dropdown-Menü ermöglicht es dem Benutzer, bereits hochgeladene
    Musikstücke auszuwählen und einer neuen Playlist hinzuzufügen.

-   Datenbankverbindungen:

-   Nach jeder Datenbankoperation wird die Verbindung mit $stmt->close()
    geschlossen, um Speicher freizugeben und die Sicherheit zu erhöhen.

-   Abschließende Datenbankverbindung:

-   Am Ende der Datei wird die Hauptverbindung zur Datenbank geschlossen, um
    Ressourcen freizugeben.

---

---

## OPTIMIERUNG PROFIL Fehlerhaft durch fehlerhafte statement closing erfordert weitere wartung

---

---

etwas bitter aber wir lassen uns nicht aufhalten durch sowas, wir beschäftigen uns direkt mit einer anderen aufgabe um erfolgsmomente zu erezeugen daher machen wir weiter mit:

## Optimierung Navigation

-   der erstmal schnellste und einfachste weg dies zu erreichen ist es im header ein link zu jeder unserer.php seiten zu generieren um beweglichkeit für developer zu steigern und in der testphase alle daten erreichbar zu gestalten

      <nav>
          <a href="index.php">Home</a>
          <!-- <a href="logout.php">Logout</a> -->

          <?php if (isset($_SESSION['benutzer_id'])): ?>
              <a href="profile.php">Profil</a>
              <a href="profile.php">Profil</a>
          <?php else: ?>
              <a href="login.php">Login</a>
              <a href="logout.php">Logout</a>
              <a href="register.php">Registrieren</a>
              <a href="profile.php">Profil</a>
              <a href="player.php">Musikplayer</a>
              <a href="playlists.php">Playlists</a>
              <a href="upload.php">Musik Hochladen</a>
          <?php endif; ?>

      </nav>

---

---

## am ende ist doch wieder alles anders als gedacht....

und zwar sieht es jetzt in der header.php so aus:

<body>
    <nav>
        <a href="index.php">Home</a>
        <!-- <a href="logout.php">Logout</a> -->

        <?php if (isset($_SESSION['benutzer_id'])): ?>

            <button><a href="profile.php">Profil</a></button>
            <button><a href="login.php">Login</a></button>
            <button><a href="logout.php">Logout</a></button>
            <button><a href="register.php">Registrieren</a></button>
            <button><a href="profile.php">Profil</a></button>
            <button><a href="player.php">Musikplayer</a></button>
            <button><a href="playlists.php">Playlists</a></button>
            <button><a href="upload.php">Musik Hochladen</a></button>



        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="logout.php">Logout</a>
            <a href="register.php">Registrieren</a>
            <a href="profile.php">Profil</a>
            <a href="player.php">Musikplayer</a>
            <a href="playlists.php">Playlists</a>
            <a href="upload.php">Musik Hochladen</a>

        <?php endif; ?>
    </nav>
    <hr>

</body>

-   gemeinsam mit der styles.css haben wir unsere navigation sowohl
    stylisch als auch performance technisch überdurchschnittlich gut gepimpt und haben jetzt eine in meinen augen kleine abglossene anwendung in sich die sowohl perfomant ist als auch ein gewissen style mit sich bringt

-   als nächstes wollte ich eine kennzeichnung für das angemeldet
    sein im profil bereich dies habe ich einfach mit css etwas geschmückt und es so platziert dass man es nur sieht wenn man sich zuvor erfolgreich angemeldet hat

-   On Air zeichen im profilbereich body untergebracht und style
    angefügt (check)

-   und auch hier gibt es gute nachrichten nun funktioniert der
    on air zeichen richtig ein statement zur behebung findet man in dem altenativ folder: headerproblem.php

---

---

## nun schreibe ich hier kurz auf was mir aufgefallen ist dass ich unbedingt beheben muss/will!!

-   musiktitel löschen !!!

-   playlist muss mehr als nur den namen brauchen es muss auch
    undebingt min 1 musiktitel mit der liste verknüpft werden damit sie entsteht oder besser noch sie muss nach der erstellung befüllt werden dann kann ich bisherigen ablauf so beibehalten und nur das befüllen anchträglichzufügen als das ganze neu aufzusetzen

-   playlisten löschen und bearbeiten inform von hinzugüen
    musiktitel ermöglichen

---

---

## Delete funktion in den Musikplayer implementieren

-   Schritte zur Implementierung der Löschfunktion:

-   Hinzufügen eines "Löschen"-Buttons neben jedem Musiktitel: Der Benutzer
    soll neben jedem Titel einen "Löschen"-Button sehen, mit dem er die Datei entfernen kann.

-   Verarbeitung der Löschanforderung: Wenn der Benutzer auf "Löschen"
    klickt, wird die entsprechende Datei sowohl aus der Datenbank als auch vom Server gelöscht.

-   Bestätigung der Löschung: Nach erfolgreicher Löschung soll eine
    Bestätigung angezeigt werden.

---

## erfolgreich implementiert

Erklärung:

### 1. löschanforderungen erfüllen

-   wenn das formular zum löschen abgesendet wird, also durch den klicjk auf
    den löschen button, wird die ID der Musikdatei an das skript übergeben

-   Die Musikdatei wird anhand der ID und der BenutzerID aus der datenbank
    abgerufen, dies stellt sicher, dass nur unsere datei also die des zurzreit angemeldeten users bzw des ausführenden users only

-   wir entfernen die datei komplett indem wir sie sowohl vom Server als
    auch aus der db entfernen

        ('unlink($pfad)')                     // server

        ('DELETE FROM Musik WHERE id = ?')    // datenbank

### 2. musikdateien anzeigen:

-   für jede musikdatei wir ein audio panel element erzeugt und mit einem
    lösch button formular ergänz

-   das formular überträgt die ID der musikdatei, die gelöscht werden soll,
    an das skript, wenn der benutzer den "löschen"-button drückt.

### 3. Bestätigung vor dem Löschen:

-   Ein JavaScript confirm-Dialog wird angezeigt, um den Benutzer zu
    fragen, ob er den Titel wirklich löschen möchte.

---

---

## nun ziemlich das gleche vorgehen für die playlists.php

-   Schritte zur Implementierung:

-   Einfaches Löschen von Playlists: Ein "Löschen"-Button wird neben jeder Playlist
    angezeigt, um diese aus der Datenbank zu entfernen.

-   Erstellen und Verwalten von Playlists: Der Benutzer kann eine Playlist erstellen, ihr
    Musikdateien hinzufügen und diese auch wieder entfernen. Das Löschen von Playlists wird unabhängig von den Musikdateien gehandhabt.

## es klappt wunderbar wir können jetzt wie ich es mir vorgestellt habe:

-   playlisten erstellen und diese werden dann in der datenbank gespeichert unabhängig
    von den beinhalteten musiktiteln damit ich die nicht doppelt speichere daher wird nur die pl gespeichert somit ermögliche ich nämlich eine:

    -   einfache verwaltung zwecks hinzufügen oder entfernen von musiktitel
    -   gewärleiste zugleich die integretät unserer musiktitel

-   test löschung einer bereits angelegten pl hat sehr gut geklappt, samt den sazu
    gehörigen db eintrag

---

## nun benötigen wir eine xtra datei und zwar die manage_playlisten.php

-   Die manage_playlist.php-Datei wird erstellt, um es dem Benutzer zu ermöglichen,
    Musikdateien zu einer Playlist hinzuzufügen und daraus zu entfernen. Diese Seite wird auch eine Übersicht über die aktuell in der Playlist enthaltenen Musikstücke bieten.

## Schritte zur Implementierung:

-   Musik zur Playlist hinzufügen: Der Benutzer kann vorhandene Musikdateien, die er
    hochgeladen hat, zu einer bestimmten Playlist hinzufügen.

-   Musik aus der Playlist entfernen: Der Benutzer kann Musikstücke aus der Playlist
    entfernen, ohne sie aus der Datenbank oder vom Server zu löschen.

## Erklärung des Codes:

-   Playlist-Details abrufen:

-   Zunächst wird die Playlist anhand der playlist_id, die in der URL übergeben wurde,
    aus der Datenbank abgerufen und überprüft, ob sie zum angemeldeten Benutzer gehört.
-   Musik aus der Playlist entfernen:

-   Für jedes Musikstück in der Playlist gibt es einen "Entfernen"-Button, der das
    Musikstück aus der Playlist entfernt, ohne es aus der Datenbank oder vom Server zu löschen.

-   Musik zur Playlist hinzufügen:

-   Der Benutzer kann aus einer Liste aller hochgeladenen Musikstücke auswählen, welche
    noch nicht in der Playlist enthalten sind, und diese hinzufügen.

-   Verfügbare Musik anzeigen:

-   Es wird eine Dropdown-Liste mit allen verfügbaren Musikstücken angezeigt, die der
    Benutzer zur Playlist hinzufügen kann.

-   Zurück zu den Playlists:

-   Ein Link, um zur playlists.php-Seite zurückzukehren.

---

---

### momentane probleme:

-   schlechte visuelle einrückung im frontend manage_playlisten.php

-   immer noch keine einbindung erstellter playlisten samt musik inhalt!!!

### problem behebung

-   li style display flex hinzugefügt um die namen der musiktitel im frontend sichtbar zu
    machen

-   nun werden auch entsprechende datenbank einträge in unserer hilftabelle erstellt

-   es wird erfasst welche musiktitel welcher playlist hinzugefügt worden sind

-   ebenfalls übrige style fehler behoben und ein logo eingefügt

---

### BIS Hier soweit auch Version 2 abgeschlossen

---

wir werden noch die funktion profilbild upload erstellen und dafür brauchen wir eine zusätzlich entitä welche wir benutzer_profilbilder nennen und diese als aller erstes implementieren um dann über html formular das bild hochladen zu können

sql
benutzer_profilbilder

    CREATE TABLE benutzer_profilbilder (
    id INT AUTO_INCREMENT PRIMARY KEY,
    benutzer_id INT NOT NULL,
    bildpfad VARCHAR(255) NOT NULL,
    FOREIGN KEY (benutzer_id) REFERENCES benutzer(id)

);

-   id: Eindeutige ID für jedes Profilbild.

-   benutzer_id: Referenz zum Benutzer.

-   bildpfad: Der Pfad, unter dem das Bild gespeichert ist.

## 2. Profilseite erweitern (profile.php)

-   Wir erweitern das profile.php, damit Benutzer ein Profilbild
    hochladen und es anzeigen können.

<form action="profile.php" method="post" enctype="multipart/form-data">
    <label for="profilbild">Profilbild hochladen:</label><br>
    <input type="file" name="profilbild" id="profilbild"><br><br>
    <input type="submit" name="upload_profilbild" value="Hochladen">
</form>

<?php
// Profilbild anzeigen, falls vorhanden
$benutzer_id = $_SESSION['benutzer_id'];
$query = $db->prepare("SELECT bildpfad FROM benutzer_profilbilder WHERE benutzer_id = ?");
$query->bind_param("i", $benutzer_id);
$query->execute();
$query->bind_result($bildpfad);
if ($query->fetch()) {
    echo "<img src='$bildpfad' alt='Profilbild' style='max-width: 150px;'><br>";
} else {
    echo "Kein Profilbild vorhanden.<br>";
}
$query->close();
?>

---

3. ## Datei-Upload-Handling und Speicherung in der Datenbank
    In der profile.php fügen wir die Logik für den Upload und das Speichern des Bildpfades hinzu.

Backend-Logik:

if (isset($_POST['upload_profilbild']) && isset($\_FILES['profilbild'])) {
$benutzer_id = $_SESSION['benutzer_id'];
$datei = $\_FILES['profilbild'];

    // Überprüfen auf Fehler beim Upload

if ($datei['error'] === 0) {

    // Erlaubte Dateitypen

$erlaubte_dateitypen = ['image/jpeg', 'image/png', 'image/gif'];
        $dateityp = mime_content_type($datei['tmp_name']);

if (in_array($dateityp, $erlaubte_dateitypen)) {
    // Verzeichnis zum Speichern der Bilder
    $verzeichnis = 'uploads/profilbilder/';
    if (!is_dir($verzeichnis)) {
mkdir($verzeichnis, 0777, true);
}

// Einzigartigen Namen für die Datei erstellen
$dateiname = $verzeichnis . uniqid('', true) . "-" . basename($datei['name']);
move_uploaded_file($datei['tmp_name'], $dateiname);

// In die Datenbank speichern
$query = $db->prepare("INSERT INTO benutzer_profilbilder (benutzer_id, bildpfad) VALUES (?, ?) ON DUPLICATE KEY UPDATE bildpfad = VALUES(bildpfad)");
$query->bind_param("is", $benutzer_id, $dateiname);
$query->execute();
$query->close();

        echo "Profilbild erfolgreich hochgeladen!";
    } else {
        echo "Nur JPEG, PNG und GIF-Dateien sind erlaubt.";
    }

    } else {
        echo "Fehler beim Hochladen der Datei.";
    }

}

---

---

## 4. Ordnerstruktur und Dateizugriffsrechte

Stelle sicher, dass der Ordner uploads/profilbilder/ existiert und schreibbar ist (Berechtigungen 0777 oder 0755).
Dies ist erforderlich, um die hochgeladenen Bilder zu speichern.

## 5. Design und Benutzeroberfläche

Das Bild wird im Profil angezeigt, und es gibt eine Möglichkeit, ein neues Bild hochzuladen. Du kannst das Design anpassen, um das Bild an einer bestimmten Stelle anzuzeigen.

## Zusammenfassung

Jetzt können Benutzer ein Profilbild hochladen und anzeigen lassen. Die hochgeladenen Dateien werden sicher gespeichert und die Pfade in der Datenbank referenziert. Wenn du zusätzliche Anpassungen brauchst oder weitere Funktionen hinzufügen möchtest, lass es mich wissen!

---

---

---

---

nach nochmaliger überarbeitung und dem hinweis das profilbild als atribut von Benutzer zu benutzen statt eine tabelle dafür zu erstellen war genau der richttige tipp
dadurch ist es auch sehr viel einfach den code zu verstehen weil nur ein weiteres atribut aufrufe bei abruf der benutzerinfos statt einen komplett neuen speicher befehl zu erstellen vielen dank hier an herr Glomba für den tipp.

kommentare sind an der erforderlihcen stelle bereitgestellt in der profile.php

der neue code:

    // profilbild hochladen

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($\_FILES['profilbild'])) {
$bildname = basename($\_FILES['profilbild']['name']);
$zielpfad = 'uploads/profilbilder/' . $bildname;
    $bildtyp = strtolower(pathinfo($zielpfad, PATHINFO_EXTENSION));

    // bisher erwünschte dateiformate
    $erlaubteFormate = ['jpg', 'jpeg', 'png', 'gif'];
    //wenn sich in dem array erforderliche bildtyp und format befindet dann lade die datei hoch und definiere sie als bündel welches das bild den namen und den pfad enthält und speicher benutzer id + pfad in db
    if (in_array($bildtyp, $erlaubteFormate)) {
        if (move_uploaded_file($_FILES['profilbild']['tmp_name'], $zielpfad)) {
            // Pfad in der Datenbank speichern
            $stmt = $conn->prepare("UPDATE Benutzer SET profilbild = ? WHERE id = ?");
            $stmt->bind_param("si", $zielpfad, $benutzer_id);

            if ($stmt->execute()) {
                echo "Profilbild erfolgreich hochgeladen!";
                // Profilbild-Variable aktualisieren
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

---

zusätzlich benötigte ich ein wenig css für die ausrichtung

.profil-pic {
display: flex;
justify-content: center;
align-items: center;
margin: auto;

        }

        .pp {
            display: flex;
            margin: auto;
        }

das audio tag ist dadadurch dass es html ist ansprechbar und kann mittels css verändert werden und angepasst
