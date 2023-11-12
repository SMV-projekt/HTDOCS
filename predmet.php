<?php
session_start();
include 'database.php';

if (isset($_GET['id_predmeta'])) {
    $id_predmeta = $_GET['id_predmeta'];

    if (isset($_SESSION['id_dijaka'])) {
        $id_dijaka = $_SESSION['id_dijaka'];
    } else {
        echo "Manjka ID dijaka v seji."; 
        exit();
    }

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
    <style>









</style>
    <div class="navigation">
        <a href="ucenec.php" class="odjava">Nazaj</a>
        <?php
       
        if (isset($_SESSION['vloga']) && $_SESSION['vloga'] === 'ucitelj') {
            echo '<a href="dodaj_dijaka_k_predmetu.php?id_predmeta=' . $id_predmeta . '" class="odjava">Dodaj Dijake</a>';
        }
        ?>
        <a href="profil.php" class="odjava">Profil</a>
    </div>

    <div id="glava" class="naziv_predmeta">
        <h1><?php echo $ime_predmeta; ?></h1>
    </div>

    <div class="sredina">
        <a href="gradivo.php?id_predmeta=<?php echo $id_predmeta; ?>" class="predmet">Gradivo</a>
    </div>

    <div class="sredina">
        <a href="dodeljene_naloge.php?id_predmeta=<?php echo $id_predmeta; ?>&id_dijaka=<?php echo $id_dijaka; ?>" class="predmet">Dodeljene naloge</a>
    </div>

    <div id="desni_del" class="desni_div">
        <h2>Udeleženi</h2>
        <ul>
            <?php
            $sql_dijaki = "SELECT d.ime_dijaka, d.priimek_dijaka
                          FROM dijak_predmet AS dp
                          LEFT JOIN dijak AS d ON dp.id_dijaka = d.id_dijaka
                          WHERE dp.id_predmeta = ?";
            $stmt = $conn->prepare($sql_dijaki);
            $stmt->bind_param("i", $id_predmeta);
            $stmt->execute();
            $rezultat_dijaki = $stmt->get_result();

            $sql_ucitelji = "SELECT u.ime_ucitelja, u.priimek_ucitelja
                            FROM ucitelj_predmet AS up
                            LEFT JOIN ucitelj AS u ON up.id_ucitelja = u.id_ucitelja
                            WHERE up.id_predmeta = ?";
            $stmt = $conn->prepare($sql_ucitelji);
            $stmt->bind_param("i", $id_predmeta);
            $stmt->execute();
            $rezultat_ucitelji = $stmt->get_result();

            while ($vrstica_ucitelji = $rezultat_ucitelji->fetch_assoc()) {
                echo "<li>{$vrstica_ucitelji['ime_ucitelja']} {$vrstica_ucitelji['priimek_ucitelja']} (Učitelj)</li>";
            }

            while ($vrstica_dijaki = $rezultat_dijaki->fetch_assoc()) {
                echo "<li>{$vrstica_dijaki['ime_dijaka']} {$vrstica_dijaki['priimek_dijaka']} (Dijak)</li>";
            }

            $stmt->close();
            ?>
        </ul>
    </div>
</body>
</html>
