<?php
session_start();
include 'database.php';

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
echo ' <div class="navigation">
<a href="prijava.php" class="odjava">Odjava</a>

<a href="profil.php">
    <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture">
</a>
</div>';


echo '<h1 style="color: black; text-align: center;">Dodeljene Naloge: ' . $ime_predmeta . '</h1>';

echo '<form method="POST" enctype="multipart/form-data" style="text-align: center;">';
echo '<label for="naziv_naloge" style="display: block; font-weight: bold; margin-top: 10px;">Naziv naloge:</label>';
echo '<input type="text" name="naziv_naloge" required style="width: 100%;background-color:sandybrown; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin: 10px 0;">';

echo '<label for="datoteka" style="display: block; font-weight: bold;">Izberite datoteko:</label>';
echo '<input type="file" name="datoteka" required style="width: 100%;background-color:sandybrown; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin: 10px 0;">';

echo '<label for="Naloga" style="display: block; font-weight: bold;">Opis naloge:</label>';
echo '<textarea name="Naloga" required style="width: 100%;background-color:sandybrown; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin: 10px 0;"></textarea>';

echo '<input type="submit" value="Naloži nalogo" style="background-color: sandybrown; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 20px;">';
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
echo '<h1>Dosedanje dodeljene naloge:</h1>';
while ($row = $result->fetch_assoc()) {
    $id_dodeljene_naloge = $row['id_dodeljene_naloge']; // Get the id_dodeljene_naloge from the result

    echo '<a href="naloga.php?id_predmeta=' . $id_predmeta . '&id_dijaka=' . $id_dijaka . '&id_dodeljene_naloge=' . $id_dodeljene_naloge . '">';
    echo '<div class="naloga" style="padding: 10px; margin: 10px;">';
    echo '<h2 class="datoteke">' . $row['naziv_naloge'] . '</h2>';
    echo '</div>';

    // Close the anchor element
    echo '</a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="gradivo.css" />

<head>
   
</head>
<body>
    
</body>
</html>
