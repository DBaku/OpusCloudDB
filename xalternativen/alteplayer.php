<?php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

$benutzer_id = $_SESSION['benutzer_id'];

$musik_stmt = $conn->prepare("SELECT id, titel, pfad FROM Musik WHERE benutzer_id = ?");
$musik_stmt->bind_param("i", $benutzer_id);
$musik_stmt->execute();
$musik_stmt->bind_result($musik_id, $titel, $pfad);

echo "<h1>Musikplayer</h1>";

while ($musik_stmt->fetch()) {

    echo "<p>$titel</p>";

    echo "<audio controls>
            <source src='$pfad' type='audio/mpeg'>
            </audio>";
}

$musik_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music-Player</title>

</head>

<body>

    <br>
    <?php include 'includes/footer.php'; ?>

</body>

</html>