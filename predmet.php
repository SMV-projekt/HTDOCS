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
    <style>
        div {
            border: 1px solid black;
        }
    </style>
    <div id="glava">
        <h1><?php echo $ime_predmeta; ?></h1>

        <?php
        session_start();
        if (isset($_SESSION['vloga']) && $_SESSION['vloga'] === 'ucitelj') {
            echo '<a href="dijak_predmet.php?id_predmeta=' . $id_predmeta . '">Dodeli dijakom</a>';
        }
        ?>
    </div>

    <div id="levi_del">
    </div>

    <div id="glavni_del">
        <!-- Main content that is not related to the chat -->
    </div>

    <div id="desni_del">
        <h2>Udeleženi</h2>
        <ul>
            <?php
            // Pridobite seznam dijakov in učiteljev, udeleženih v tem predmetu
            $sql_udelezeni = "SELECT u.ime_ucitelja, u.priimek_ucitelja, d.ime_dijaka, d.priimek_dijaka
                              FROM ucitelj_predmet AS up
                              LEFT JOIN ucitelj AS u ON up.id_ucitelja = u.id_ucitelja
                              LEFT JOIN dijak_predmet AS dp ON up.id_predmeta = dp.id_predmeta
                              LEFT JOIN dijak AS d ON dp.id_dijaka = d.id_dijaka
                              WHERE up.id_predmeta = ?";
            $stmt = $conn->prepare($sql_udelezeni);
            $stmt->bind_param("i", $id_predmeta);
            $stmt->execute();
            $rezultat = $stmt->get_result();

            while ($vrstica = $rezultat->fetch_assoc()) {
                if ($vrstica['ime_ucitelja'] != null) {
                    echo "<li>Učitelj: {$vrstica['ime_ucitelja']} {$vrstica['priimek_ucitelja']}</li>";
                }
                if ($vrstica['ime_dijaka'] != null) {
                    echo "<li>{$vrstica['ime_dijaka']} {$vrstica['priimek_dijaka']}</li>";
                }
            }

            $stmt->close();
            ?>
        </ul>
    </div>
</body>
</html>
