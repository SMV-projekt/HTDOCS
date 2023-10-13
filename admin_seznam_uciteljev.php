<?php
include 'database.php';

// Check if the "add_teacher" button was clicked
if (isset($_POST['add_teacher'])) {
    // Handle the addition of a new teacher here (e.g., insert into the database)
    $ime_ucitelja = mysqli_real_escape_string($conn, $_POST['ime_ucitelja']);
    $priimek_ucitelja = mysqli_real_escape_string($conn, $_POST['priimek_ucitelja']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $geslo = mysqli_real_escape_string($conn, $_POST['geslo']);

    // Validate and sanitize data here...

    $insert_sql = "INSERT INTO ucitelj (ime_ucitelja, priimek_ucitelja, `E-mail`, Geslo)
                  VALUES ('$ime_ucitelja', '$priimek_ucitelja', '$email', '$geslo')";

    if (mysqli_query($conn, $insert_sql)) {
        echo "<p>New teacher added successfully.</p>";
    } else {
        echo "<p>Error adding teacher: " . mysqli_error($conn) . "</p>";
    }
}

// Check if the "remove_teacher" button was clicked
if (isset($_POST['remove_teacher'])) {
    $teacher_id_to_remove = $_POST['teacher_id'];
    $delete_sql = "DELETE FROM ucitelj WHERE id_ucitelja = $teacher_id_to_remove";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<p>Teacher with ID $teacher_id_to_remove has been removed.</p>";
    } else {
        echo "<p>Error removing teacher: " . mysqli_error($conn) . "</p>";
    }
}

// Check if the "edit_teacher" button was clicked
if (isset($_POST['edit_teacher'])) {
    $teacher_id_to_edit = $_POST['teacher_id'];
    
    // Retrieve teacher details for editing
    $edit_teacher_sql = "SELECT ime_ucitelja, priimek_ucitelja, `E-mail` FROM ucitelj WHERE id_ucitelja = $teacher_id_to_edit";
    $edit_teacher_result = mysqli_query($conn, $edit_teacher_sql);
    
    if ($edit_teacher_result && $edit_teacher_data = mysqli_fetch_assoc($edit_teacher_result)) {
        echo '<h2>Edit Teacher</h2>';
        echo '<form method="post" action="admin_seznam_uciteljev.php">';
        echo '<input type="hidden" name="teacher_id" value="' . $teacher_id_to_edit . '">';
        echo '<label for="edited_ime_ucitelja">Ime učitelja:</label>';
        echo '<input type="text" name="edited_ime_ucitelja" value="' . $edit_teacher_data['ime_ucitelja'] . '"><br>';
        echo '<label for="edited_priimek_ucitelja">Priimek učitelja:</label>';
        echo '<input type="text" name="edited_priimek_ucitelja" value="' . $edit_teacher_data['priimek_ucitelja'] . '"><br>';
        echo '<label for="edited_email">E-mail:</label>';
        echo '<input type="email" name="edited_email" value="' . $edit_teacher_data['E-mail'] . '"><br>';
        echo '<input type="submit" name="save_edited_teacher" value="Save">';
        echo '</form>';
    }
}

// Check if the "save_edited_teacher" button was clicked
if (isset($_POST['save_edited_teacher'])) {
    $teacher_id_to_edit = $_POST['teacher_id'];
    $edited_ime_ucitelja = mysqli_real_escape_string($conn, $_POST['edited_ime_ucitelja']);
    $edited_priimek_ucitelja = mysqli_real_escape_string($conn, $_POST['edited_priimek_ucitelja']);
    $edited_email = mysqli_real_escape_string($conn, $_POST['edited_email']);
    
    $update_sql = "UPDATE ucitelj 
                  SET ime_ucitelja = '$edited_ime_ucitelja', priimek_ucitelja = '$edited_priimek_ucitelja', `E-mail` = '$edited_email' 
                  WHERE id_ucitelja = $teacher_id_to_edit";

    if (mysqli_query($conn, $update_sql)) {
        echo "<p>Teacher with ID $teacher_id_to_edit has been updated.</p>";
    } else {
        echo "<p>Error updating teacher: " . mysqli_error($conn) . "</p>";
    }
}

// Fetch and display the list of teachers
$sql = "SELECT id_ucitelja, ime_ucitelja, priimek_ucitelja, `E-mail` FROM ucitelj";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Seznam učiteljev</title>
    <link rel="stylesheet" type="text/css" href="admin.css" />
</head>
<body>
    <h1>SEZNAM UČITELJEV</h1>
    <form method="post" action="admin.php">
        <input type="submit" name="show_ucitelji" value="Nazaj">
    </form>

    <button onclick="toggleAddTeacherSection()">Add Teacher</button>

    <div id="add_teacher_section" style="display: none;">
        <h2>Add New Teacher</h2>
        <form method="post" action="admin_seznam_uciteljev.php">
            <label for="ime_ucitelja">Ime učitelja:</label>
            <input type="text" name="ime_ucitelja" id="ime_ucitelja">
            <label for="priimek_ucitelja">Priimek učitelja:</label>
            <input type="text" name="priimek_ucitelja" id="priimek_ucitelja">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email">
            <label for="geslo">Geslo:</label>
            <input type="password" name="geslo" id="geslo">
            <input type="submit" name="add_teacher" value="Add">
        </form>
    </div>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id_ucitelja'] . '</td>';
            echo '<td>' . $row['ime_ucitelja'] . '</td>';
            echo '<td>' . $row['priimek_ucitelja'] . '</td>';
            echo '<td>' . $row['E-mail'] . '</td>';
            echo '<td>
                    <form method="post" action="admin_seznam_uciteljev.php">
                        <input type="hidden" name="teacher_id" value="' . $row['id_ucitelja'] . '">
                        <input type="submit" name="remove_teacher" value="Remove">
                    </form>
                    <form method="post" action="admin_seznam_uciteljev.php">
                        <input type="hidden" name="teacher_id" value="' . $row['id_ucitelja'] . '">
                        <input type="submit" name="edit_teacher" value="Edit">
                    </form>
                </td>';
            echo '</tr>';
        }
        ?>
    </table>

    <script>
        function toggleAddTeacherSection() {
            const addTeacherSection = document.getElementById('add_teacher_section');
            if (addTeacherSection.style.display === 'none' || addTeacherSection.style.display === '') {
                addTeacherSection.style.display = 'block';
            } else {
                addTeacherSection.style.display = 'none';
            }
        }
    </script>
</body>
</html>

