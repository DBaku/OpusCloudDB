## Hey Willkommen OpusCloud UI/ OpusCloudDB

# Webanwendung mit DB Einbindung für Musik

mit hilfe:

## PHP, MySQL, VSC

-   heute versuche ich eine soundcloud ähnliche anwendung zu erstellen in
    der erstmal nur

## ¯¯̿̿¯̿̿'̿̿̿̿̿̿̿'̿̿'̿̿̿̿̿'̿̿̿)͇̿̿)̿̿̿̿ '̿̿̿̿̿̿\̵͇̿̿\=(•̪̀●́)=o/̵͇̿̿/'̿̿ ̿ ̿̿

#### (x) = erledigt

#### |check| => wird / wurde bei der Umsetzung beachtet / eingehalten

#### (-) = noch nicht bearbeitet

(x) - passendes vollständiges ERD

(x) - einrichtung datenbank und der dazugehörigen modelle

(x) - Testdaten einfügen und testen durch 2 abrufe pro tabelle

(x) - allgemeine page und navigation implem. um auf registrierung u log-in geleitet werden

(x) - eine person eine registrierung sicher und schnell
durchführen kann
( also user anlegen + DBeintrag erstellen bzw user in db speichenr)

(x) - einen profilbereich anlegen

(x) - musik titel upload oberfläche gestalten

(x) - musik player eigenschaften simple nachstellen ( play, <,stop, > )

(x) - playlist erstellung

(x) - speichern der musik in Datenbank sowie abrufen

### EXTRA:

## Dokumentation

-   x (check) NICHT PERFEKT !!! ABER ! nachvollziehbare dokumentation für
    dich und
    andere => protokolliere dein vorgehen so gut wie möglich in einer Doku.md

-   x (check) Github verwenden und dabei versuchen möglichst viele commits
    anzulegen um schneller im umgang zu werden

-   x (check) Versuchen commits partiel und inhaltlich an die entstehung
    der
    anwendung zu halten um beste dokumentation daraus zu ziehen

## Evolution Version 2

-(x) logout funktion !!!

-(x) Optimierung der Navigation => alle views erreichbar für user & dev
gestalten

-   x Refactoring zb ist es möglich profilbereich und bereits
    hochgeladene Musik/Pl zu
    verknüpfen

(tried and failed)
=> - bisher gelang es nicht erfolgreich dies zu tun weil der code in
dem moment dann einfach zu unübersichtlich ist für mich und ich zu sehr damit beschäftigt bin zu verstehn wo ich mich befinde, die fortschritte habe ich in xbsxprofile.php geschoben um später eventuell daran anknüpfen zu können.. aber ich will mich jetzt nicht davon aufhalten lassen will

-(x) nach login soll der benutzer in sein profil geleitet werden

-(x) der benutzer soll permanent angezeigt bekommen dass er angemeldet ist

-(x) header und footer etwas optisch abheben

-(x) erstelle ein simples Frontend mittels html, php und css welches eine
welcome view, reg.+log-in view und eine profilview beinhaltet

-(x)- außerdem soll der user ein profilbild hochladen können welches dann auch in db
gespeichert wird, lege dafür ebenfalls eine geeignete Tabelle in der DB an und
schränke/grenze die upload bedingungen ein...

(x) Playlisten verwaltung verbessern = Playlist-löschen und add track to playlist imp

(x) Musikplayer verwaltung verbessern => löschen von musiktiteln imp

(x) stilvolle style/design erstellung aller anzeigeseiten abstimmen

(x) Optional ein Look für den player erstellen

## EXtra Extra

(-)- überlege ausgiebig ob sich sinnvoll nutzbar folgendes impl. lässt und

!!! begründe deine entscheidung durch jeweils 2 Stichpunkte!! keine sätze!!!

(-) - ja dies führt vllt zu einer eventuellen umstruckturierung einiger
tabellen dh sorgfältig überlegen!

(-) - erd erweiterung ins diagramm einfügen und markieren 'V2'

(-) - Freundschaft zu anderen oder follower prinzip

(-) - folgend daraus wird freigeschltet/zusätzlich impl. 'Privat-Nachrichten-austausch'

(-) - fähigkeit etwas öffentlich zu Posten zb einen beitrag,Musiktitel oder kommentar/

(-) - like auf genannten Post/...

### als Hilfestellung steht zur Verfügung:

## TWP - MicroCOCO - & - Elkiosco

### 4. Datenabfrage (DQL) Befehlsliste und beispiele

-   SELECT: Wählt Daten aus einer oder mehreren Tabellen
    aus.

    Grundlegende Abfrage:

        SELECT spalte1, spalte2,
        FROM tabellenname;

-   Mit Bedingung:

        SELECT spalte1, spalte2,
        FROM tabellenname
        WHERE bedingung;

-   Mit Gruppierung:

        SELECT spalte1, COUNT(\*)
        FROM tabellenname
        GROUP BY spalte1;

-   Mit Sortierung:

        SELECT spalte1, spalte2, ...
        FROM tabellenname ORDER BY spalte1ASC|DESC;

    JOIN: Kombiniert Daten aus mehreren Tabellen.

-   INNER JOIN:

        SELECT t1.spalte1, t2.spalte2
        FROM tabelle1 t1
        INNER JOIN tabelle2 t2 ON t1.spalte = t2.spalte;

-   LEFT JOIN:

        SELECT t1.spalte1, t2.spalte2
        FROM tabelle1 t1
        LEFT JOIN tabelle2 t2 ON t1.spalte = t2.spalte;

-   RIGHT JOIN:

        SELECT t1.spalte1, t2.spalte2
        FROM tabelle1 t1
        RIGHT JOIN tabelle2 t2 ON t1.spalte = t2.spalte;

-   FULL JOIN:

        SELECT t1.spalte1, t2.spalte2
        FROM tabelle1 t1
        FULL OUTER JOIN tabelle2 t2 ON t1.spalte = t2.spalte;

---

---

-   ein beispiel aus TWD/MicroCOCO

## bsp. Abfragen

### Schritt 4.1: Alle Mitarbeiter und ihre zugehörigen Abteilungen anzeigen

    SELECT Mitarbeiter.Nachname, Abteilung.Name AS Abteilung
    FROM Mitarbeiter
    JOIN Abteilung ON Mitarbeiter.AbteilungID = Abteilung.AbteilungID;

### bsp: Projekte, an denen jeder Mitarbeiter arbeitet

    SELECT Mitarbeiter.Nachname, Projekt.Name AS Projekt, Projekt.Thema
    FROM Mitarbeiter
    JOIN Mitarbeiter_Projekt ON Mitarbeiter.MitarbeiterID = Mitarbeiter_Projekt.MitarbeiterID
    JOIN Projekt ON Mitarbeiter_Projekt.ProjektID = Projekt.ProjektID;

### bsp nach abteilung anzeigen

        SELECT Vorname, Nachname
        FROM Mitarbeiter
        WHERE AbteilungsID = (SELECT AbteilungsID FROM Abteilung WHERE Name = 'Sektion-9');

        oder

        SELECT Vorname, Nachname
        FROM Mitarbeiter
        WHERE AbteilungsID = (SELECT AbteilungsID FROM Abteilung WHERE Name = 'Entwicklung');

---

---

## BenutzerID
