<?php
session_start();
include 'database.php';

if (!isset($_SESSION['vloga'])) {
    header("Location: skupinice.php");
    exit();
}

$vloga = $_SESSION['vloga'];

echo '<div class="navigation">
        <a href="prijava.php" class="odjava">Odjava</a>
    </div>';

if (isset($_GET['id_predmeta']) && isset($_GET['id_dodeljene_naloge'])) {
    $id_predmeta = $_GET['id_predmeta'];
    $id_dodeljene_naloge = $_GET['id_dodeljene_naloge'];
} else {
    echo "Manjkata ID predmeta ali ID naloge v URL-ju.";
    exit();
}

$sql_naloga = "SELECT naziv_naloge, datoteka, Naloga FROM dodeljene_naloge WHERE id_predmeta = ? AND id_dodeljene_naloge = ?";
$stmt = $conn->prepare($sql_naloga);
$stmt->bind_param("ii", $id_predmeta, $id_dodeljene_naloge);
$stmt->execute();
$stmt->bind_result($naziv_naloge, $datoteka, $Naloga);
$stmt->fetch();
$stmt->close();

if (empty($naziv_naloge)) {
    echo "Naloga ni bila najdena.";
    exit();
}

if ($vloga === 'dijak') {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["student_datoteka"])) {
        $target_dir = "oddane_naloge/";
        $target_file = $target_dir . basename($_FILES["student_datoteka"]["name"]);

        if (move_uploaded_file($_FILES["student_datoteka"]["tmp_name"], $target_file)) {
            $sql_insert = "INSERT INTO oddane_naloge (datoteka, id_dodeljene_naloge, id_dijaka, stanje) VALUES (?, ?, ?, 'oddano')";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("sii", $target_file, $id_dodeljene_naloge, $_SESSION['id_dijaka']);

            if ($stmt->execute()) {
                echo "Naloga je bila uspešno oddana.";
            } else {
                echo "Napaka pri oddajanju naloge.";
            }

            $stmt->close();
        } else {
            echo "Napaka pri nalaganju datoteke.";
        }
    }

    echo '<div class="naloga">';
    echo '<h1>Naziv naloge: ' . $naziv_naloge . '</h1>';
    echo '<p>Navodila: ' . $Naloga . '</p>';
    echo '<a href="/Skupinice/HTDOCS/dodeljene_naloge/' . $datoteka . '"" style="background-color:sandybrown;color:black;padding:5px;">Prenesi nalogo</a>';
    echo '<form method="POST" enctype="multipart/form-data">';
    echo '</div>';
    echo '<div class="nalogaa">';
    echo '<label for="student_datoteka">Oddaj nalogo: </label>';
    echo '<input type="file" name="student_datoteka" required>';
    echo '<br>';
    echo '<input type="submit" value="Oddaj nalogo" style="margin-top:20px;">';
    echo '</form>';
    echo '</div>';
    
} else {
    echo '<h1>' . $naziv_naloge . '</h1>';
    echo '<p>' . $Naloga . '</p>';

    $sql_students = "SELECT d.priimek_dijaka, d.ime_dijaka, o.datoteka 
                    FROM oddane_naloge o
                    INNER JOIN dijak d ON o.id_dijaka = d.id_dijaka
                    WHERE o.stanje = 'oddano' AND o.id_dodeljene_naloge = ?";
    $stmt = $conn->prepare($sql_students);
    $stmt->bind_param("i", $id_dodeljene_naloge);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        
        echo '<h2>Oddane naloge:</h2>';
while ($row = $result->fetch_assoc()) {
    echo '<p><a href="' . $row['datoteka'] . '">' . $row['priimek_dijaka'] . ' ' . $row['ime_dijaka'] . ' (' . $row['datoteka'] . ')</a></p>';
}

    } else {
        echo '<p>Noben dijak še ni oddal naloge.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="zacetna.css" />

<head>
</head>
<body>
    
</body>
</html>
