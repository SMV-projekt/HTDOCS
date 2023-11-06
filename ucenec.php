<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    $logged_in_email = $_SESSION['email'];

    // Fetch the student's data, including the profile picture path and id_dijaka
    $student_data_sql = "SELECT id_dijaka, Profilna_slika FROM dijak WHERE `E-mail` = ?";
    $stmt = $conn->prepare($student_data_sql);
    $stmt->bind_param("s", $logged_in_email);
    $stmt->execute();
    $stmt->bind_result($student_id, $profile_picture_path);
    $stmt->fetch();
    $stmt->close();

    $_SESSION['id_dijaka'] = $student_id; // Store id_dijaka in the session

    // Fetch subjects assigned to the student based on their ID
    $subjects_sql = "SELECT p.id_predmeta, p.naziv_predmeta 
                    FROM predmet p
                    INNER JOIN dijak_predmet dp ON p.id_predmeta = dp.id_predmeta
                    WHERE dp.id_dijaka = ?";
    $stmt = $conn->prepare($subjects_sql);
    $stmt->bind_param("i", $student_id);
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
    <title>Ucenec</title>
    <link rel="stylesheet" type="text/css" href="zacetna.css" />
</head>
<body>
    <header></header>
    <div class="navigation">
        <a href="prijava.php" class="odjava">Odjava</a>
        <a href="dodaj_predmet.php" class="add-subject-button">Dodaj nov predmet</a>
        <a href="profil.php" class="profil">
            <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture">
        </a>
    </div>

    <div class="main-div">
        <?php
        while ($row = $result->fetch_assoc()):
        ?>
        <div class="sredina">
            <a href="predmet.php?id_predmeta=<?php echo $row['id_predmeta']; ?>" class="predmet">
                <?php echo $row['naziv_predmeta']; ?>
            </a>
        </div>
        <?php
        endwhile;
        ?>
    </div>
</body>
</html>
