<?php
include 'database.php';

session_start();
if (isset($_SESSION['vloga'])) {
    $vloga = $_SESSION['vloga'];
} else {
}
if (isset($_GET['id_predmeta'])) {
    $id_predmeta = $_GET['id_predmeta'];
}

$sql_predmet = "SELECT naziv_predmeta FROM predmet WHERE id_predmeta = ?";
$stmt = $conn->prepare($sql_predmet);
$stmt->bind_param("i", $id_predmeta);
$stmt->execute();
$stmt->bind_result($ime_predmeta);
$stmt->fetch();
$stmt->close();

function deleteFile($fileId, $conn) {
    $sql = "SELECT datoteka FROM gradivo WHERE id_gradiva = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fileToDelete = $row['datoteka'];
        
        $targetDirectory = "gradivo/";
        $fileFullPath = $targetDirectory . $fileToDelete;
        
        if (file_exists($fileFullPath)) {
            unlink($fileFullPath);
        }
        
        $sql = "DELETE FROM gradivo WHERE id_gradiva = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fileId);
        $stmt->execute();
    }
}

function displayUploadedFiles($id_predmeta, $conn, $vloga) {
    $sql = "SELECT id_gradiva, naziv_gradiva, datoteka FROM gradivo WHERE id_predmeta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_predmeta);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<a class="interactive-file" href="/Skupinice/HTDOCS/gradivo/' . $row['datoteka'] . '">';
        echo '<div class="datoteke">';
        echo $row['naziv_gradiva'];

        if ($vloga === 'ucitelj') {
            echo '<span class="delete-link"><a href="gradivo.php?id_predmeta=' . $id_predmeta . '&delete=' . $row['id_gradiva'] . '">Delete</a></span>';
        }

        echo '</div>';
        echo '</a>';
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
<div class="navigation">
        <a href="prijava.php" class="odjava">Odjava</a>
        
        <a href="profil.php">
            <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture">
        </a>
    </div>
<h1>Gradivo za predmet: <?php echo $ime_predmeta; ?></h1>
    <?php
    if ($vloga === 'ucitelj') {
        echo '<form action="gradivo.php?id_predmeta=' . $_GET['id_predmeta'] . '" method="post" enctype="multipart/form-data" class="form-container">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="text" name="naziv_gradiva" placeholder="Naziv gradiva">
            <input type="submit" value="Upload File" name="submit">
        </form>';
    }
    
    $id_predmeta = $_GET['id_predmeta'];
    ?>
    <div class="">
    <?php
    displayUploadedFiles($id_predmeta, $conn, $vloga);
    ?>
</div>
    
</body>
</html>
