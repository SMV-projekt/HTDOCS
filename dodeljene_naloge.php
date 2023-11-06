<?php
session_start();
include 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['vloga'])) {
    header("Location: skupinice.php"); // Redirect to the login page if not logged in
    exit();
}

// Get the user's role
$vloga = $_SESSION['vloga'];

// Get the subject and student ID from the URL
if (isset($_GET['id_predmeta'])) {
    $id_predmeta = $_GET['id_predmeta'];

    // Retrieve the subject name
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

// Check if the user's role is a teacher before displaying the form
if ($vloga === 'ucitelj') {
    // Check if the form for uploading tasks is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["naziv_naloge"]) && isset($_FILES["datoteka"])) {
        // Handle form submission to upload a task

        // You can add code here to validate and process the form data, and insert it into the database.

        // Example: Insert the uploaded file into the database
        $naziv_naloge = $_POST["naziv_naloge"];
        $datoteka = $_FILES["datoteka"]["name"];
        $Naloga = $_POST["Naloga"];

        // Perform database insertion here
        $sql_insert = "INSERT INTO dodeljene_naloge (id_predmeta, naziv_naloge, datoteka, Naloga) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("isss", $id_predmeta, $naziv_naloge, $datoteka, $Naloga);

        if ($stmt->execute()) {
            // File upload logic
            $target_dir = "dodeljene_naloge/"; // Specify the directory where files will be stored
            $target_file = $target_dir . basename($_FILES["datoteka"]["name"]);
            move_uploaded_file($_FILES["datoteka"]["tmp_name"], $target_file);
        }

        $stmt->close();
    }

    // Display the form for uploading tasks
    echo '<h1>' . $ime_predmeta . '</h1>';
    echo '<a href="dodeljene_naloge.php?id_predmeta=' . $id_predmeta . '" class="dodaj-nalogo">Nazaj</a>';

    // Display the form for uploading tasks
    echo '<form method="POST" enctype="multipart/form-data">';
    echo '<label for="naziv_naloge">Naziv naloge:</label>';
    echo '<input type="text" name="naziv_naloge" required>';
    echo '<br>';
    echo '<label for="datoteka">Izberite datoteko:</label>';
    echo '<input type="file" name="datoteka" required>';
    echo '<br>';
    echo '<label for="Naloga">Opis naloge:</label>';
    echo '<textarea name="Naloga" required></textarea>';
    echo '<br>';
    echo '<input type="submit" value="Naloži nalogo">';
    echo '</form>';
}

// Display the list of assigned tasks for this subject
$sql_naloge = "SELECT id_dodeljene_naloge, naziv_naloge, datoteka, Naloga FROM dodeljene_naloge WHERE id_predmeta = ?";
$stmt = $conn->prepare($sql_naloge);
$stmt->bind_param("i", $id_predmeta);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if (isset($_GET['id_dijaka'])) {
    $id_dijaka = $_GET['id_dijaka'];
}

// Loop through and display tasks
// Assuming you have $id_dijaka defined, you can include it in the link's URL
while ($row = $result->fetch_assoc()) {
    $id_dodeljene_naloge = $row['id_dodeljene_naloge']; // Get the id_dodeljene_naloge from the result

    // Create an anchor element that links to naloga.php with id_predmeta, id_dijaka, and id_dodeljene_naloge in the query string
    echo '<a href="naloga.php?id_predmeta=' . $id_predmeta . '&id_dijaka=' . $id_dijaka . '&id_dodeljene_naloge=' . $id_dodeljene_naloge . '">';

    // Display task information within a div
    echo '<div class="naloga" style="border: 1px solid black; padding: 10px; margin: 10px;">';
    echo '<h2>' . $row['naziv_naloge'] . '</h2>';
    echo '</div>';

    // Close the anchor element
    echo '</a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   
</head>
<body>
    
</body>
</html>
