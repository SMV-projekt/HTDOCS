<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_subject'])) {
    $subject_name = $_POST['subject_name'];

    // Insert the new subject into the 'predmet' table
    $sql = "INSERT INTO predmet (naziv_predmeta) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $subject_name);

    if ($stmt->execute()) {
        // Subject creation successful
        header("Location: ucitelj.php");
        exit();
    } else {
        echo "Error creating subject: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ustvari predmet</title>
    <link rel="stylesheet" type="text/css" href="your_css_file.css" />
</head>
<body>
    <h1>Ustvarite nov predmet</h1>
    <!-- Add your subject creation form here -->
    <form method="post" action="dodaj_predmet.php"> <!-- Changed action to "dodaj_predmet.php" -->
        <!-- Your form fields for creating a subject -->
        <input type="text" name="subject_name" placeholder="Ime predmeta" required />
        <!-- Add more fields as needed -->
        <button type="submit" name="create_subject">Ustvari predmet</button> <!-- Added name attribute to the submit button -->
    </form>
    <!-- Other content here -->
</body>
</html>
