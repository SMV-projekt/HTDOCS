<?php
include 'database.php';

session_start();

if (isset($_SESSION['vloga']) && isset($_POST['sporocilo']) && isset($_POST['id_predmeta'])) {
    $sporocilo = $_POST['sporocilo'];
    $id_predmeta = $_POST['id_predmeta'];

    if ($_SESSION['vloga'] === 'ucitelj') {
        // Učitelj pošilja sporočilo
        $id_ucitelja = $_SESSION['id_ucitelja'];

        $sql = "INSERT INTO sporocilo (id_ucitelj, id_predmeta, sporocilo, cas) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $id_ucitelja, $id_predmeta, $sporocilo);
        $stmt->execute();
        $stmt->close();
    } elseif ($_SESSION['vloga'] === 'dijak') {
        // Dijak pošilja sporočilo
        $id_dijaka = $_SESSION['id_dijaka'];

        $sql = "INSERT INTO sporocilo (id_dijaka, id_predmeta, sporocilo, cas) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $id_dijaka, $id_predmeta, $sporocilo);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: predmet.php?id_predmeta=$id_predmeta");
?>