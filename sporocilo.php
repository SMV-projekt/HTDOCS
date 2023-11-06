<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is a student or a teacher (You might need to adapt this logic)
    session_start();
    if (isset($_SESSION['vloga']) && $_SESSION['vloga'] === 'ucitelj') {
        $isTeacher = true;
    } else {
        $isTeacher = false;
    }

    $id_predmeta = $_POST['id_predmeta'];
    $sporocilo = $_POST['sporocilo'];

    if ($isTeacher) {
        // Teacher is sending a message
        $id_ucitelja = $_SESSION['id_uporabnika'];
        
        $sql = "INSERT INTO sporocilo_ucitelj (id_predmeta, id_ucitelja, sporocilo, cas) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $id_predmeta, $id_ucitelja, $sporocilo);
        $stmt->execute();
        $stmt->close();
    } else {
        // Student is sending a message
        $id_dijaka = $_SESSION['id_uporabnika'];
        
        $sql = "INSERT INTO sporocilo_dijak (id_predmeta, id_dijaka, sporocilo, cas) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $id_predmeta, $id_dijaka, $sporocilo);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect back to the predmet.php page
header("Location: predmet.php?id_predmeta=$id_predmeta");
exit();
?>
