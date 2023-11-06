<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    $logged_in_email = $_SESSION['email'];

    // Fetch the teacher's ID based on their email
    $teacher_id_sql = "SELECT id_ucitelja FROM ucitelj WHERE `E-mail` = ?";
    $stmt = $conn->prepare($teacher_id_sql);
    $stmt->bind_param("s", $logged_in_email);
    $stmt->execute();
    $stmt->bind_result($teacher_id);
    $stmt->fetch();
    $stmt->close();
} else {
    header("Location: prijava.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_subject'])) {
    $subject_name = $_POST['subject_name'];

    // Insert the new subject into the 'predmet' table
    $sql = "INSERT INTO predmet (naziv_predmeta) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $subject_name);

    if ($stmt->execute()) {
        // Subject creation successful
        $new_subject_id = $stmt->insert_id; // Get the ID of the newly created subject

        // Check if the teacher exists in the ucitelj table
        if ($teacher_id) {
            // Teacher exists, proceed with subject insertion
            $ucitelj_predmet_sql = "INSERT INTO ucitelj_predmet (id_ucitelja, id_predmeta) VALUES (?, ?)";
            $stmt_ucitelj_predmet = $conn->prepare($ucitelj_predmet_sql);
            $stmt_ucitelj_predmet->bind_param("ii", $teacher_id, $new_subject_id);

            if ($stmt_ucitelj_predmet->execute()) {
                // Successfully added the subject to ucitelj_predmet
                header("Location: ucitelj.php");
                exit();
            } else {
                echo "Error adding the subject to ucitelj_predmet: " . $stmt_ucitelj_predmet->error;
            }
        } else {
            echo "Teacher with ID $teacher_id does not exist in the ucitelj table.";
        }
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
<style>
    body
    {
        background-color:beige;
    }

    h1
    {
        text-align:center;
    }

    form
    {
        text-align:center;
    }
    button{
        background-color:sandybrown;
    }
    button:hover{
        background-color:#ff6a00;
    }
    </style>
<body>
    <h1>Ustvarite nov predmet</h1>
    <a href=ucitelj.php><button>Nazaj</button><a>
    <form method="post" action="dodaj_predmet.php">
        <input type="text" name="subject_name" placeholder="Naziv predmeta" required />
        <button type="submit" name="create_subject">Ustvari</button>
    </form>
</body>
</html>
