<?php
session_start();
include 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['vloga'])) {
    header("Location: skupinice.php"); // Redirect to the login page if not logged in
    exit();
}

// Get the user's role and task ID from the URL
$vloga = $_SESSION['vloga'];

if (isset($_GET['id_predmeta']) && isset($_GET['id_dodeljene_naloge'])) {
    $id_predmeta = $_GET['id_predmeta'];
    $id_dodeljene_naloge = $_GET['id_dodeljene_naloge'];
} else {
    echo "Manjkata ID predmeta ali ID naloge v URL-ju.";
    exit();
}

// Retrieve task information
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

// If the user is a student, provide a form to upload the task file
if ($vloga === 'dijak') {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["student_datoteka"])) {
        // Handle form submission to upload a task

        // Example: Validate the uploaded file
        $target_dir = "oddane_naloge/"; // Specify the directory where files will be stored
        $target_file = $target_dir . basename($_FILES["student_datoteka"]["name"]);

        if (move_uploaded_file($_FILES["student_datoteka"]["tmp_name"], $target_file)) {
            // File upload was successful

            // Insert the uploaded file into the database
            $sql_insert = "INSERT INTO oddane_naloge (datoteka, id_dodeljene_naloge, id_dijaka) VALUES (?, ?, ?)";
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

    // Display task information and the form to upload the task
    echo '<h1>' . $naziv_naloge . '</h1>';
    echo '<p>' . $Naloga . '</p>';
    echo '<form method="POST" enctype="multipart/form-data">';
    echo '<label for="student_datoteka">Izberite datoteko:</label>';
    echo '<input type="file" name="student_datoteka" required>';
    echo '<br>';
    echo '<input type="submit" value="Oddaj nalogo">';
    echo '</form>';
} else {
    // Display task information for teachers or other roles
    echo '<h1>' . $naziv_naloge . '</h1>';
    echo '<p>' . $Naloga . '</p>';
}

// Provide a link for all users to download the task
echo '<a href="/Skupinice/HTDOCS/dodeljene_naloge/' . $datoteka . '" class="download-link">Prenesi nalogo</a>';

// Add additional content or formatting as needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content goes here -->
</head>
<body>
    <!-- Body content goes here -->
</body>
</html>
