## Server starten

    - sudo /opt/lampp/lampp start

    ---

### aufgabe 1.

-   erstellen eines ERD zu beginn ::
    dabei auf m-n beziehg. achten notfalls auflösen

---

---

### ERD:

-   Benutzer:
    BenutzerID, Benutzername, Passwort, Email

    jeder Beutzer kann viele Musikdateien hochladen und viele Playlists erstellen

-   Musikdateien:
    MusikID, BenutzerID, Titel, Dateipfad, Hochladedatum

    eine Musikdatei kann in mehreren Playlists enthalten sein

-   Playlists:
    PlaylistID, BenutzerID, Name

    eine Playlist kann mehrere Musikdateien enthalten

-   Playlist_Musikdateien:
    PlaylistID, MusikID

    stellt eine verbindung zwischen Playlist und Musikdatein her,

    #### !!Problem!!

    zwischen Playlist und Musikdateien besteht eine Many to Many bezieh. die wir vermeiden möchten dafür benutzen wir den Primary Key auch als Foreign Key und referenzieren damit auf uns selbst..

    d.h. => wir nutzen die PK auch als FK um damit eine eindeutige zuordnung von verwendeten Musikdateien in erstellten Playlisten stattfinden kann

---

---

### aufg 2.

Nachdem wir das erd fertig gestellt haben und die typen benannt haben

sollte die Datenbank anbindung vorgenommen werden indem myphpadmin.net/ localhost über den browser bedient wird.

-   nun kann man entscheiden ob wir das integrierte tasteninterface nutzen welches schon bereitgestellt ist oder nutzen sql befehle

-   absolut richtig wir nutzen die tasten nur wenn wir keine andere wahl haben oder es als gegenprobe genutzt wrd um befehls funktionalität zu prüfen und korrigieren falls notwendig.

!! TWP & ElKiosco sind hier als hilfe zur orientierung u inspiration nutzbar !!

---

---

### erstellen einer DB:

myphpadmin im browser geöffnet nun eine neue DB erstellen

dafür oben im headreiter SQL anklicken und folgende befehle zur erstellung verwenden
[Befehlsliste] [/opt/lampp/htdocs/mywebsite/OpusCloudDB/README/SQL-Syntaxen.pdf]

---

### Datenbank erstellen

    CREATE DATABASE OpusCloud;
    USE OpusCloud;

### Benutzer anlegen

hier verwende ich NOT NULL = darf nicht leer bleiben um damit ein required zu erzwingen und es dem Benutzer nicht zu ermöglichen sich zu registrieren ohne dabei alle von uns gewünschten informationen zu hinterlassen.

Das UNIQUE kennzeichnet ein atribut als notwending einzigartig um eintritt in db zu bekommen

    - als nächstes playlist oder musikdatein warum, weil wir den PrimarayKey BenutzerID bereits angelegt
    haben und wir ihn in beiden tabellen als fokey einfügen werden

### Wahl fiel auf Playlist

    CREATE TABLE Benutzer (
    BenutzerID INT AUTO_INCREMENT PRIMARY KEY,
    Benutzername VARCHAR(50) NOT NULL,
    Passwort VARCHAR(100)  NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL
    );

    - erfolgreich !


    CREATE TABLE Playlists (
    PlaylistID INT AUTO_INCREMENT PRIMARY KEY,
    BenutzerID INT,
    Name VARCHAR(100),
    FOREIGN KEY (BenutzerID) REFERENCES Benutzer(BenutzerID)
    );


    CREATE TABLE Musikdateien (
    MusikID INT AUTO_INCREMENT PRIMARY KEY,
    BenutzerID INT,
    Titel VARCHAR(100),
    Dateipfad VARCHAR(255),
    Hochladedatum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BenutzerID) REFERENCES Benutzer(BenutzerID)
    );

### zuletzt dann Playlist_Musikdateien

-   aufgrund der beiden benötigten FK und den hier nnotwendigen selbstverweiss
    zuletzt unsere hilfstabelle:

        CREATE TABLE Playlist_Musikdateien (
        PlaylistID INT,
        MusikID INT,
        PRIMARY KEY (PlaylistID, MusikID),
        FOREIGN KEY (PlaylistID) REFERENCES Playlists(PlaylistID),
        FOREIGN KEY (MusikID) REFERENCES Musikdateien(MusikID)
        );

bis hier hin erfolgreich!

aufgabe 3. durchführung und voherige vorbereitung zwecks code analyse mit bestehenden codes

-   extra : was knnast du erkennen wenn du dir den code anschaust was kannst du im
    vergleich separatieren und
-   fallen dir merkmale oder ähnliches auf das etwas hervorheben soll oder tut
-   teste den code verstehe den code ändere den code
-   begründe deine umgestaltung oder erstellung oder was auch immer aber begründe es!

bsp: php code für register.php

1. Überprüfung der Anfrage-Methode

//<?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $benutzername = $_POST['benutzername'];
        $email = $_POST['email'];
        $passwort = password_hash($_POST['passwort'],
        PASSWORD_DEFAULT);

     $conn = new mysqli("localhost", "root", "", "OpusCloud");
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
    }

     $sql = "INSERT INTO Benutzer (Benutzername, Passwort, Email) VALUES ('$benutzername', '$passwort', '$email')";
     if ($conn->query($sql) === TRUE) {

        //wenn hier die sqlquery alle geforderten attribute entgegen gereicht bekommt valuirt sie es als true und
        speichert ihn in die db

         echo "Registrierung erfolgreich!";                 // erfolg
     } else {
         echo "Error: " . $sql . "<br>" . $conn->error;     // misserfolg
     }

     $conn->close();                                        // verbindung schließen

}

Warum wir das machen: POST-Anfragen werden üblicherweise verwendet, um Formulardaten sicher zum Server zu senden. Es ist wichtig, dies zu überprüfen, damit das Skript nur dann ausgeführt wird, wenn Daten tatsächlich von einem Formular gesendet wurden. Auf diese Weise verhindern wir, dass das Skript ungewollt ausgeführt wird, z.B. wenn eine GET-Anfrage erfolgt.

Best Practice: In modernen Webanwendungen ist es eine gute Praxis, sicherzustellen, dass nur POST-Anfragen zur Änderung von Daten auf dem Server verwendet werden, da POST im Gegensatz zu GET keine Daten in der URL überträgt, was sicherer ist.

-   wir ermögllichen jetzt einem user einen account anzulegen bzw eine registrierung durchzuführen dafür brauchen wir ien wenig php code um eine minimale strucktur aufzubauen

---

---

### Im moment arbeite ich noch an den abfragen dafür bereite ich gerade

### einige testdaten vor zum hard-coden jedoch aber schon die funktionellen

### abfragen bereit

----------- 2 weitere entitys einfügen --------------!!!!

## testdaten zum abfragen

-   INSERT INTO Playlist (Name) VALUES ('Country'), ('Rap');
-   INSERT INTO Musikdatein (Titel) VALUES ('wake me up'), ('lose yourself');

weitere testdaten:

#### 1. Benutzer:

    INSERT INTO Benutzer (Benutzername, Passwort, Email) VALUES
    ('Dima', '987654321', 'dima@me.com'),
    ('Timo', 'Humbolt', 'timo@expert.com'),
    ('Wurst', 'Wasser', 'mundet@exoder.com');

#### 2. PLaylists:

    INSERT INTO Playlist (name, benutzer_id) VALUES

('Chill Vibes', 1),
('Rap', 2),
('Schnapp sie dir!', 1),
('Workout Playlist', 1);

#### 3. Musikdateien:

    INSERT INTO Musikdateien (BenutzerID, Titel, Dateipfad) VALUES
    (1, 5, 'lose yourself', '/path/to/songA.mp3'),
    (1, 4 'forget about dim', '/path/to/songA.mp3'),
    (1, 3 'dilema', '/path/to/songA.mp3'),
    (1, 2 'song A', '/path/to/songA.mp3'),
    (2, 1 'song B', '/path/to/songB.mp3'),
    (3, 2 'song C', '/path/to/songC.mp3');

#### 4. Playlist_Musikdateien

    INSERT INTO Playlist_Musikdateien (PlaylistID, MusikID) VALUES
    (1, 1),
    (1, 2),
    (2, 2),
    (5, 3);
    (4, 3);
    (3, 5);

---

---

### Abfragen unserer Daten

    SELECT Benutzername, Email
     FROM Benutzer
     WHERE MusikID = (SELECT MusikID FROM Musikdatein WHERE Titel = 'Rap');

-   Hier sind einige SQL-Abfragen, um die Daten zu überprüfen und zu nutzen:

-   Alle Benutzer anzeigen

        SELECT \* FROM Benutzer;

-   Alle Playlists eines Benutzers anzeigen

        SELECT \* FROM Playlists WHERE BenutzerID = 1;

-   Alle Musikdateien in einer bestimmten Playlist anzeigen

          SELECT Musikdateien.Titel, Musikdateien.Dateipfad
          FROM Playlist_Musikdateien
          JOIN Musikdateien ON Playlist_Musikdateien.MusikID = Musikdateien.MusikID
          WHERE Playlist_Musikdateien.PlaylistID = 1;

---

---

### Um die Funktionalität zu erweitern, könnten wir folgende Entitäten hinzufügen:

## Wechsel bitte auf Doku2.md. vielen dank
