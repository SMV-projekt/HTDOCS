<?php
include 'database.php';

// Preveri, če je obrazec oddan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pridobi izbrane dijake iz obrazca
    if (isset($_POST['dijak']) && is_array($_POST['dijak'])) {
        foreach ($_POST['dijak'] as $dijakId) {
            // Vstavi ID dijaka in predmeta v tabelo dijak_predmet
            $sql_insert = "INSERT INTO dijak_predmet (id_dijaka, id_predmeta) VALUES (?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("ii", $dijakId, $_POST['id_predmeta']); // Uporabi ID predmeta
            $stmt->execute();
            $stmt->close();
        }

        echo "Dijaki so bili dodani k predmetu.";
    } else {
        echo "Noben dijak ni bil izbran.";
    }

    // Preusmeri nazaj na predmet.php
    if (isset($_POST['id_predmeta'])) {
        $id_predmeta = $_POST['id_predmeta'];
        header("Location: predmet.php?id_predmeta=$id_predmeta");
        exit();
    }
}

// Pridobi seznam dijakov iz baze
$sql_dijaki = "SELECT id_dijaka, ime_dijaka, priimek_dijaka FROM dijak";
$result_dijaki = $conn->query($sql_dijaki);

// Pridobi ID predmeta iz poizvedbenih parametrov
$id_predmeta = $_GET['id_predmeta'];

// Preveri, ali je uporabnik "ucitelj" in prikaži gumb
session_start();
if (!isset($_SESSION['vloga']) || $_SESSION['vloga'] !== 'ucitelj') {
    echo "Nimate dostopa do te strani.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Dodaj dijaka k predmetu</title>
    <link rel="stylesheet" type="text/css" href="predmet.css" />
</head>
<body>
<div class="navigation">
    <a href="prijava.php" class="odjava">Odjava</a>
    <a href="dodaj_predmet.php" class="add-subject-button">Dodaj nov predmet</a>
    <a href="profil.php" class="profil">Profil</a>
</div>

<div id="glava" class="naziv_predmeta">
    <h1>Dodaj dijaka k predmetu</h1>
</div>

<div class="sredina">
    <form method="post">
        <input type="hidden" name="id_predmeta" value="<?php echo $id_predmeta; ?>">
        <h2>Izberi dijake za dodajanje</h2>
        <?php
        if ($result_dijaki->num_rows > 0) {
            while ($row = $result_dijaki->fetch_assoc()) {
                echo '<label><input type="checkbox" name="dijak[]" value="' . $row['id_dijaka'] . '"> ' . $row['ime_dijaka'] . ' ' . $row['priimek_dijaka'] . '</label><br>';
            }
        } else {
            echo "Ni najdenih dijakov.";
        }
        ?>
        <br>
        <input type="submit" value="Dodaj izbrane dijake">
    </form>
</div>
</body>
</html>
