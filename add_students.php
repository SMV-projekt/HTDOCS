<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student'])) {
    $selectedStudents = $_POST['student'];

    if (isset($_GET['id_predmeta'])) {
        $id_predmeta = $_GET['id_predmeta'];

        foreach ($selectedStudents as $studentId) {
            $addStudentSql = "INSERT INTO dijak_predmet (id_dijaka, id_predmeta) VALUES (?, ?)";
            $stmt = $conn->prepare($addStudentSql);
            $stmt->bind_param("ii", $studentId, $id_predmeta);

            if ($stmt->execute()) {
                echo "Student with ID $studentId has been added to the subject.";
            } else {
                echo "Error adding student with ID $studentId to the subject: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        echo "Subject ID missing in the URL.";
    }
} else {
    echo "No students selected or invalid request.";
}
?>
