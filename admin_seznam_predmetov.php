<?php
include 'database.php';

// Check if the "Remove" button was clicked
if (isset($_POST['remove_subject'])) {
    // Get the subject ID to remove
    $subject_id_to_remove = $_POST['subject_id'];

    // Perform the removal logic here (e.g., using SQL DELETE statement)
    $delete_sql = "DELETE FROM predmet WHERE id_predmeta = $subject_id_to_remove";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p>Subject with ID $subject_id_to_remove has been removed.</p>";
    } else {
        echo "<p>Error removing subject: " . $conn->error . "</p>";
    }
}

// Check if the "add_subject" button was clicked
if (isset($_POST['add_subject'])) {
    // Handle the addition of a new subject here (e.g., insert into the database)
    // You can access the form values using $_POST
    // Be sure to validate and sanitize user input before inserting it into the database.
    $naziv_predmeta = $_POST['naziv_predmeta'];

    // Insert the new subject into the database (replace with your actual SQL)
    $insert_sql = "INSERT INTO predmet (naziv_predmeta) VALUES ('$naziv_predmeta')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "<p>New subject added successfully.</p>";
    } else {
        echo "<p>Error adding subject: " . $conn->error . "</p>";
    }
}

// Fetch and display the list of subjects
$sql = "SELECT id_predmeta, naziv_predmeta FROM predmet";
$result = $conn->query($sql);

echo "<html>
<head>
    <meta charset='utf-8' />
    <title>Seznam Predmetov</title>
</head>
<body>
    <h1>SEZNAM PREDMETOV</h1>
    <form method='post' action='admin.php'>
        <input type='submit' name='show_predmeti' value='Nazaj'>
    </form>

    <button onclick='toggleAddSubjectSection()'>Add Subject</button>

    <div id='add_subject_section' style='display: none;'>
        <h2>Add New Subject</h2>
        <form method='post' action='admin_seznam_predmetov.php'>
            <label for='naziv_predmeta'>Naziv predmeta:</label>
            <input type='text' name='naziv_predmeta' id='naziv_predmeta'>
            <input type='submit' name='add_subject' value='Add'>
        </form>
    </div>

    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Naziv predmeta</th>
            <th>Action</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row['id_predmeta'] . "</td>
            <td>" . $row['naziv_predmeta'] . "</td>
            <td>
                <form method='post' action='admin_seznam_predmetov.php'>
                    <input type='hidden' name='subject_id' value='" . $row['id_predmeta'] . "'>
                    <input type='submit' name='remove_subject' value='Remove'>
                </form>
                <form method='post' action='admin_seznam_predmetov.php'>
                    <input type='hidden' name='edit_subject_id' value='" . $row['id_predmeta'] . "'> <!-- Store the subject ID to be edited -->
                    <input type='submit' name='edit_subject' value='Edit'>
                </form>
            </td>
        </tr>";

    // Display the edit form for the subject
    if (isset($_POST['edit_subject']) && $_POST['edit_subject_id'] == $row['id_predmeta']) {
        echo "<tr>
            <td colspan='2'>
                <form method='post' action='admin_seznam_predmetov.php'>
                    <input type='hidden' name='subject_id' value='" . $row['id_predmeta'] . "'>
                    <label for='edited_naziv_predmeta'>Edited Naziv predmeta:</label>
                    <input type='text' name='edited_naziv_predmeta' value='" . $row['naziv_predmeta'] . "'>
                    <input type='submit' name='save_edited_subject' value='Save'>
                </form>
            </td>
        </tr>";
    }
}

echo "</table>
</body>
</html>";

// Process editing and saving edited subject
if (isset($_POST['save_edited_subject'])) {
    $subject_id_to_edit = $_POST['subject_id'];
    $edited_naziv_predmeta = $_POST['edited_naziv_predmeta'];
    
    // Update the subject in the database
    $update_sql = "UPDATE predmet SET naziv_predmeta = '$edited_naziv_predmeta' WHERE id_predmeta = $subject_id_to_edit";
    if ($conn->query($update_sql) === TRUE) {
        echo "<p>Subject with ID $subject_id_to_edit has been updated.</p>";
        
        // Automatically refresh the page after updating the subject
        echo "<script>window.location = 'admin_seznam_predmetov.php';</script>";
    } else {
        echo "<p>Error updating subject: " . $conn->error . "</p>";
    }
}

echo "<script>
function toggleAddSubjectSection() {
    const addSubjectSection = document.getElementById('add_subject_section');
    if (addSubjectSection.style.display === 'none' || addSubjectSection.style.display === '') {
        addSubjectSection.style.display = 'block';
    } else {
        addSubjectSection.style.display = 'none';
    }
}
</script>";
?>
