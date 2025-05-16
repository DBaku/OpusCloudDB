<?php<?php
include 'includes/header.php';
include 'includes/db_connection.php';
session_start();

if (!isset($_SESSION['benutzer_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['musik'])) {
    $titel = trim($_POST['titel']);
    $benutzer_id = $_SESSION['benutzer_id'];
    $upload_dir = "uploads/";
    $dateiname = basename($_FILES['musik']['name']);
    $pfad = $upload_dir . $dateiname;
    $upload_ok = 1;
    $dateityp = strtolower(pathinfo($pfad, PATHINFO_EXTENSION));

    // Check if file already exists for this user
    $check_stmt = $conn->prepare("SELECT id FROM Musik WHERE pfad = ? AND benutzer_id = ?");
    $check_stmt->bind_param("si", $pfad, $benutzer_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        echo "<div class='error'>Du hast diese Datei bereits hochgeladen.</div>";
        $upload_ok = 0;
    }
    $check_stmt->close();

    // Check file type
    $zugelassene_dateitypen = ['mp3', 'wav', 'ogg'];
    if (!in_array($dateityp, $zugelassene_dateitypen)) {
        echo "<div class='error'>Nur MP3, WAV und OGG-Dateien sind erlaubt.</div>";
        $upload_ok = 0;
    }

    // Check file size (10MB max)
    if ($_FILES['musik']['size'] > 10000000) {
        echo "<div class='error'>Die Datei ist zu groß (maximal 10MB).</div>";
        $upload_ok = 0;
    }

    if ($upload_ok && move_uploaded_file($_FILES['musik']['tmp_name'], $pfad)) {
        $stmt = $conn->prepare("INSERT INTO Musik (titel, pfad, benutzer_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $titel, $pfad, $benutzer_id);

        if ($stmt->execute()) {
            echo "<div class='success'>Musik erfolgreich hochgeladen!</div>";
        } else {
            echo "<div class='error'>Fehler beim Hochladen: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else if ($upload_ok) {
        echo "<div class='error'>Fehler beim Hochladen der Datei.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musik hochladen - OpusCloud</title>
    <style>
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data" class="upload-form">
        <h2>Musik hochladen</h2>
        <div class="form-info">
            <p>Erlaubte Dateitypen: MP3, WAV, OGG</p>
            <p>Maximale Dateigröße: 10MB</p>
        </div>
        
        <div class="form-group">
            <label for="titel">Titel:</label>
            <input type="text" name="titel" id="titel" required>
        </div>
        
        <div class="form-group">
            <label for="musik">Musikdatei:</label>
            <input type="file" name="musik" id="musik" required accept=".mp3,.wav,.ogg">
        </div>
        
        <button type="submit">Hochladen</button>
    </form>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
