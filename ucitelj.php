<?php
session_start();
include 'database.php';

if (!isset($_SESSION['email'])) {
    header("Location: skupinice.php");
    exit();
}

$logged_in_email = $_SESSION['email'];
$user_type = "";

$student_check_sql = "SELECT id_dijaka FROM dijak WHERE `E-mail` = ?";
$stmt = $conn->prepare($student_check_sql);
$stmt->bind_param("s", $logged_in_email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $user_type = "student";
} else {
    $teacher_check_sql = "SELECT id_ucitelja FROM ucitelj WHERE `E-mail` = ?";
    $stmt = $conn->prepare($teacher_check_sql);
    $stmt->bind_param("s", $logged_in_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $user_type = "teacher";
    }
}

$stmt->close();

if ($user_type === "teacher") {
    $teacher_id_sql = "SELECT id_ucitelja FROM ucitelj WHERE `E-mail` = ?";
    $stmt = $conn->prepare($teacher_id_sql);
    $stmt->bind_param("s", $logged_in_email);
    $stmt->execute();
    $stmt->bind_result($teacher_id);
    $stmt->fetch();
    $stmt->close();

    $subjects_sql = "SELECT p.id_predmeta, p.naziv_predmeta 
                    FROM predmet p
                    INNER JOIN ucitelj_predmet up ON p.id_predmeta = up.id_predmeta
                    WHERE up.id_ucitelja = ?";
    $stmt = $conn->prepare($subjects_sql);
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    header("Location: skupinice.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ucitelj</title>
    <link rel="stylesheet" type="text/css" href="zacetna.css" />
    
</head>
<body>
    <div class="navigation">
        <a href="prijava.php" class="odjava">Odjava</a>
        <a href="dodaj_predmet.php" class="add-subject-button">Dodaj nov predmet</a>
        <a href="profil.php" class="profil">Profil</a>
    </div>
    
    
    
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="sredina">
    <a href="predmet.php?id_predmeta=<?php echo $row['id_predmeta']; ?>" class="predmet">
        <?php echo $row['naziv_predmeta']; ?>
    </a>
</div>
        <?php endwhile; ?>
    
</body>
</html>
