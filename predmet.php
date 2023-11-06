<?php
session_start();
include 'database.php';

if (isset($_GET['id_predmeta'])) {
    $id_predmeta = $_GET['id_predmeta'];

    // Retrieve id_dijaka from the session
    if (isset($_SESSION['id_dijaka'])) {
        $id_dijaka = $_SESSION['id_dijaka'];
    } else {
        echo "Manjka ID dijaka v seji."; // Handle the case when id_dijaka is not set in the session
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
        /* Reset some default styles */
body, h1, h2, p {
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

h1 {
    font-size: 24px;
    margin: 10px 0;
}

p {
    font-size: 16px;
    line-height: 1.5;
    margin: 10px 0;
}

a.download-link {
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    margin: 10px 0;
    transition: background-color 0.3s;
}

a.download-link:hover {
    background-color: #0056b3;
}

form {
    margin-top: 20px;
}

label {
    font-size: 16px;
    display: block;
    margin: 10px 0;
}

input[type="file"] {
    margin: 10px 0;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Add a class for form inputs */
.input-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 10px 0;
    font-size: 16px;
}

/* Add a class for buttons */
.button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #0056b3;
}

/* Additional custom styles go here */
</style>
    <div class="navigation">
        <a href="ucitelj.php" class="odjava">Nazaj</a>
        <?php
       
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
        <a href="gradivo.php?id_predmeta=<?php echo $id_predmeta; ?>" class="predmet">Gradivo</a>
    </div>

    <div class="sredina">
        <a href="dodeljene_naloge.php?id_predmeta=<?php echo $id_predmeta; ?>&id_dijaka=<?php echo $id_dijaka; ?>" class="predmet">Dodeljene naloge</a>
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
</body>
</html>
