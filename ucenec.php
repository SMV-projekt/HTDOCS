<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    $logged_in_email = $_SESSION['email'];

    // Fetch the student's ID based on their email
    $student_id_sql = "SELECT id_dijaka FROM dijak WHERE `E-mail` = ?";
    $stmt = $conn->prepare($student_id_sql);
    $stmt->bind_param("s", $logged_in_email);
    $stmt->execute();
    $stmt->bind_result($student_id);
    $stmt->fetch();
    $stmt->close();

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

    <header>
        
    </header>
    <div class="navigation">
        <a href="prijava.php" class="odjava">Odjava</a>
        <a href="dodaj_predmet.php" class="add-subject-button">Dodaj nov predmet</a>
        <a href="profil.php" class="profil">Profil</a>
    </div>

    <h1>Hej učenec :)</h1>
    <div class="main-div">
        <?php
        while ($row = $result->fetch_assoc()):
        ?>
            <div class="predmet">

                <p><a href="predmet.php?id_predmeta=<?php echo $row['id_predmeta']; ?>"><?php echo $row['naziv_predmeta']; ?></a></p>
            </div>
        <?php
        endwhile;
        ?>
    </div>
</body>
</html>
