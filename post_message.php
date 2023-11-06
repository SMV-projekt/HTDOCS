<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_predmeta'], $_POST['message'])) {
        $id_predmeta = $_POST['id_predmeta'];
        $message = $_POST['message'];

        session_start();
        if (isset($_SESSION['role'])) {
            $id_dijaka = null;
            $id_ucitelj = null;
            
            // Determine whether the user is a teacher or a student and set id_dijaka or id_ucitelj accordingly.
            if ($_SESSION['role'] === 'teacher') {
                $id_ucitelj = $_SESSION['user_id'];
            } else {
                $id_dijaka = $_SESSION['user_id'];
            }

            // Insert the new chat message into the database
            $chat_sql = "INSERT INTO sporocilo (id_dijaka, id_ucitelj, id_predmeta, sporocilo, cas) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($chat_sql);
            $stmt->bind_param("iiis", $id_dijaka, $id_ucitelj, $id_predmeta, $message);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Redirect back to the original page
header("Location: predmet.php?id_predmeta=" . $id_predmeta);
