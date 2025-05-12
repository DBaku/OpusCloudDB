<?php

// hier ist unsere datenbankverbindung samt benötigter daten 
// und dem querystring und übergabeparameter
// zuletzt verwendeter zeichensatz

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OpusCloudDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$conn->set_charset("utf8");
