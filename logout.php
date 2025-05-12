<?php
// starten der Session, um auf die Session-Daten zuzugreifen
session_start();

// alle Session-Variablen löschen
$_SESSION = array(); // Leert das Session-Array, was alle Session-Daten löscht

// wenn die Session mit Cookies verwendet wird, das Session-Cookie löschen
if (ini_get("session.use_cookies")) {
    // Holt die Cookie-Parameter, um sie für das Löschen zu verwenden
    $params = session_get_cookie_params();

    // setzt das Cookie mit einem abgelaufenen Zeitpunkt, um es zu löschen
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// zerstören der Session, um sicherzustellen, dass sie nicht mehr benutzt werden kann
session_destroy(); // Entfernt die Session-Daten auf dem Server

// umleitung zur Startseite nach erfolgreichem Logout
header("Location: index.php"); // Leitet den Benutzer zur Startseite weiter
exit(); // Beendet das Skript, um sicherzustellen, dass keine weiteren Operationen ausgeführt werden