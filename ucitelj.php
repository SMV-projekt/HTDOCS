<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    $logged_in_email = $_SESSION['email'];
    
    // Fetch the teacher's ID based on their email
    $teacher_id_sql = "SELECT id_ucitelja FROM ucitelj WHERE `E-mail` = ?";
    $stmt = $conn->prepare($teacher_id_sql);
    $stmt->bind_param("s", $logged_in_email);
    $stmt->execute();
    $stmt->bind_result($teacher_id);
    $stmt->fetch();
    $stmt->close();

    // Fetch subjects assigned to the teacher based on their ID
    $subjects_sql = "SELECT p.id_predmeta, p.naziv_predmeta 
                    FROM predmet p
                    INNER JOIN ucitelj_predmet up ON p.id_predmeta = up.id_predmeta
                    WHERE up.id_ucitelja = ?";
    $stmt = $conn->prepare($subjects_sql);
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    header("Location: prijava.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ucitelj</title>
    <link rel="stylesheet" type="text/css" href="prva_stran_ucitelj.css" />
    <style>
        /* Add this CSS to your stylesheet or in a <style> tag in the head section */
        .subject-container {
            display: flex;
            flex-wrap: wrap;
        }
        .subject {
            width: 23%; /* 4 subjects in a row, accounting for some margin */
            margin: 1%;
            padding: 10px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <a href="prijava.php">Prijava</a>
    <a href="dodaj_predmet.php">Dodaj nov predmet</a>
    
    <h1>Hej učitelj :)</h1>
    <div class="subject-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="subject">
                <p>
                    <a href="predmet.php?id_predmeta=<?php echo $row['id_predmeta']; ?>">
                        <?php echo $row['naziv_predmeta']; ?>
                    </a>
                </p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
