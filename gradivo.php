<?php
include 'database.php';

// Check user's role (teacher or student)
session_start();
if (isset($_SESSION['vloga'])) {
    $vloga = $_SESSION['vloga'];
} else {
    // Handle the case when the user is not logged in or their role is not set
}

// Function to delete a file
function deleteFile($fileId, $conn) {
    $sql = "SELECT datoteka FROM gradivo WHERE id_gradiva = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fileToDelete = $row['datoteka'];
        
        // Delete the file from the server
        $targetDirectory = "gradivo/";
        $fileFullPath = $targetDirectory . $fileToDelete;
        
        if (file_exists($fileFullPath)) {
            unlink($fileFullPath);
        }
        
        // Delete the record from the database
        $sql = "DELETE FROM gradivo WHERE id_gradiva = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fileId);
        $stmt->execute();
    }
}

// Function to display uploaded files
function displayUploadedFiles($id_predmeta, $conn, $vloga) {
    $sql = "SELECT id_gradiva, naziv_gradiva, datoteka FROM gradivo WHERE id_predmeta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_predmeta);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li><a href="/Skupinice/HTDOCS/gradivo/' . $row['datoteka'] . '">' . $row['naziv_gradiva'] . '</a>';
        
        // Add delete link for teachers
        if ($vloga === 'ucitelj') {
            echo ' - <a href="gradivo.php?id_predmeta=' . $id_predmeta . '&delete=' . $row['id_gradiva'] . '">Delete</a>';
        }
        
        echo '</li>';
    }
    echo '</ul>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is a teacher (you can add further validation)
    if ($vloga === 'ucitelj') {
        $id_predmeta = $_GET['id_predmeta']; // You should pass this via URL or a hidden field in the form
        $naziv_gradiva = $_POST['naziv_gradiva'];

        $targetDirectory = "gradivo/"; // Use forward slashes
        $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
        $datoteka = basename($_FILES["fileToUpload"]["name"]);

        if (file_exists($targetFile)) {
            echo "File already exists.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                // File uploaded successfully, insert the data into the gradivo table
                $sql = "INSERT INTO gradivo (id_predmeta, naziv_gradiva, datoteka) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $id_predmeta, $naziv_gradiva, $datoteka);

                if ($stmt->execute()) {
                    echo "File uploaded and data inserted into the database.";
                } else {
                    echo "Failed to insert data into the database.";
                }
            } else {
                echo "Failed to upload the file.";
            }
        }
    } else {
        echo "You are not authorized to upload files.";
    }
}

// Handle file deletion
if ($vloga === 'ucitelj' && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $fileId = $_GET['delete'];
    deleteFile($fileId, $conn);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gradivo</title>
    <link rel="stylesheet" type="text/css" href="gradivo.css" />
</head>
<body>
    <h1>Naziv Predmeta</h1> <!-- Replace with the actual title -->

    <?php
    if ($vloga === 'ucitelj') {
        // If the user is a teacher, display the file upload form
        echo '<form action="gradivo.php?id_predmeta=' . $_GET['id_predmeta'] . '" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="text" name="naziv_gradiva" placeholder="Naziv gradiva">
            <input type="submit" value="Upload File" name="submit">
        </form>';
    }
    
    // Display the list of uploaded files for the current predmet
    $id_predmeta = $_GET['id_predmeta'];
    displayUploadedFiles($id_predmeta, $conn, $vloga);
    ?>
</body>
</html>