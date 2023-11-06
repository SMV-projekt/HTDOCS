<?php
include 'database.php';

if (isset($_GET['id_predmeta'])) {
    $id_predmeta = $_GET['id_predmeta'];

    $sql_predmet = "SELECT naziv_predmeta FROM predmet WHERE id_predmeta = ?";
    $stmt = $conn->prepare($sql_predmet);
    $stmt->bind_param("i", $id_predmeta);
    $stmt->execute();
    $stmt->bind_result($ime_predmeta);
    $stmt->fetch();
    $stmt->close();

    if (empty($ime_predmeta)) {
        echo "Predmet ni bil najden.";
        exit();
    }
} else {
    echo "Manjka ID predmeta v URL-ju.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Predmet</title>
    <link rel="stylesheet" type="text/css" href="predmet.css" />
</head>
<body>
<div class="navigation">
    <a href="ucitelj.php" class="odjava">Nazaj</a>
    <a href="dodaj_predmet.php" class="odjava">Dodaj nov predmet</a>

    <?php
    session_start();
    if (isset($_SESSION['vloga']) && $_SESSION['vloga'] === 'ucitelj') {
        echo '<a href="dodaj_dijaka_k_predmetu.php?id_predmeta=' . $id_predmeta . '" class="odjava">Dodaj Dijake</a>';
    }
    ?>

    <a href="profil.php" class="profil">Profil</a>
</div>

<div id="glava" class="naziv_predmeta">
    <h1><?php echo $ime_predmeta; ?></h1>
</div>
<div class="sredina">
    <div id="levi_del" class="levi_div">
        <p>1</p>
    </div>

    <div id="glavni_del" class="glavni_div">
        <p>2</p>

        <?php
        // Check if the user is a "ucitelj" and display the form to input text or upload a file
        if (isset($_SESSION['vloga']) && $_SESSION['vloga'] === 'ucitelj') {
            echo '
            <form method="post" action="sporocilo.php" enctype="multipart/form-data">
                <input type="hidden" name="id_predmeta" value="' . $id_predmeta . '">
                <label for="text_input">Vnesite besedilo:</label>
                <input type="text" id="text_input" name="text_input" required>
                <br>
                <label for="file_input">Naložite datoteko:</label>
                <input type="file" id="file_input" name="file_input">
                <button type="submit">Pošlji</button>
            </form>
            ';
        }
        ?>
    </div>

    <div id="desni_del" class="desni_div">
        <h2>Udeleženi</h2>
        <ul>
            <?php
            // Pridobi seznam dijakov, udeleženih v tem predmetu
            $sql_dijaki = "SELECT d.ime_dijaka, d.priimek_dijaka
                          FROM dijak_predmet AS dp
                          LEFT JOIN dijak AS d ON dp.id_dijaka = d.id_dijaka
                          WHERE dp.id_predmeta = ?";
            $stmt = $conn->prepare($sql_dijaki);
            $stmt->bind_param("i", $id_predmeta);
            $stmt->execute();
            $rezultat_dijaki = $stmt->get_result();

            // Pridobi seznam učiteljev, udeleženih v tem predmetu
            $sql_ucitelji = "SELECT u.ime_ucitelja, u.priimek_ucitelja
                            FROM ucitelj_predmet AS up
                            LEFT JOIN ucitelj AS u ON up.id_ucitelja = u.id_ucitelja
                            WHERE up.id_predmeta = ?";
            $stmt = $conn->prepare($sql_ucitelji);
            $stmt->bind_param("i", $id_predmeta);
            $stmt->execute();
            $rezultat_ucitelji = $stmt->get_result();

            // Prikaži najprej učitelje
            while ($vrstica_ucitelji = $rezultat_ucitelji->fetch_assoc()) {
                echo "<li>{$vrstica_ucitelji['ime_ucitelja']} {$vrstica_ucitelji['priimek_ucitelja']} (Učitelj)</li>";
            }

            // Nato prikaži dijake
            while ($vrstica_dijaki = $rezultat_dijaki->fetch_assoc()) {
                echo "<li>{$vrstica_dijaki['ime_dijaka']} {$vrstica_dijaki['priimek_dijaka']} (Dijak)</li>";
            }

            $stmt->close();
            ?>
        </ul>
    </div>
</div>
</body>
</html>
