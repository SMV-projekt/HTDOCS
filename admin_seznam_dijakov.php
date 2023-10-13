<?php
include 'database.php';

// Check if the "Remove" button was clicked
if (isset($_POST['remove_student'])) {
    // Get the student ID to remove
    $student_id_to_remove = $_POST['student_id'];

    // Perform the removal logic here (e.g., using SQL DELETE statement)
    $delete_sql = "DELETE FROM dijak WHERE id_dijaka = $student_id_to_remove";
   
}

// Check if the "add_student" button was clicked
if (isset($_POST['add_student'])) {
    // Handle the addition of a new student here (e.g., insert into the database)
    // You can access the form values using $_POST
    // Be sure to validate and sanitize user input before inserting it into the database.
    $ime_dijaka = $_POST['ime_dijaka'];
    $priimek_dijaka = $_POST['priimek_dijaka'];
    $email = $_POST['email'];
    $letnik = $_POST['letnik'];
    $razred = $_POST['razred'];
    $spol = $_POST['spol'];
    $oddelek = $_POST['oddelek'];

    // Insert the new student into the database (replace with your actual SQL)
    $insert_sql = "INSERT INTO dijak (ime_dijaka, priimek_dijaka, `E-mail`, Letnik, Razred, Spol, Oddelek) 
    VALUES ('$ime_dijaka', '$priimek_dijaka', '$email', '$letnik', '$razred', '$spol', '$oddelek')";

    
}

// Fetch and display the list of students
$sql = "SELECT id_dijaka, ime_dijaka, priimek_dijaka, `E-mail`, Letnik, Razred, Spol, Oddelek FROM dijak";
$result = $conn->query($sql);
?>

<html>
<head>
    <meta charset="utf-8" />
    <title>Seznam Dijakov</title>
</head>
<body>
    <h1>SEZNAM DIJAKOV</h1>
    <form method="post" action="admin.php">
        <input type="submit" name="show_dijaki" value="Nazaj">
    </form>

    <button onclick="toggleAddStudentSection()">Add Student</button>

    <div id="add_student_section" style="display: none;">
        <h2>Add New Student</h2>
        <form method="post" action="admin_seznam_dijakov.php">
            <label for="ime_dijaka">Ime dijaka:</label>
            <input type="text" name="ime_dijaka" id="ime_dijaka">

            <label for="priimek_dijaka">Priimek dijaka:</label>
            <input type="text" name="priimek_dijaka" id="priimek_dijaka">

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email">

            <label for="letnik">Letnik:</label>
            <input type="text" name="letnik" id="letnik">

            <label for="razred">Razred:</label>
            <input type="text" name="razred" id="razred">


            <label for="spol">Spol:</label>
            <input type="text" name="spol" id="spol">

            <label for="oddelek">Oddelek:</label>
            <input type="text" name="oddelek" id="oddelek">

            <input type="submit" name="add_student" value="Add">
        </form>
    </div>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ime</th>
            <th>Priimek</th>
            <th>E-mail</th>
            <th>Letnik</th>
            <th>Razred</th>
            <th>Spol</th>
            <th>Oddelek</th>
            <th>Action</th>
        </tr>
        
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['id_dijaka'] . "</td>
                <td>" . $row['ime_dijaka'] . "</td>
                <td>" . $row['priimek_dijaka'] . "</td>
                <td>" . $row['E-mail'] . "</td>
                <td>" . $row['Letnik'] . "</td>
                <td>" . $row['Razred'] . "</td>
                <td>" . $row['Spol'] . "</td>
                <td>" . $row['Oddelek'] . "</td>
                <td>
                    <form method='post' action='admin_seznam_dijakov.php'>
                        <input type='hidden' name='student_id' value='" . $row['id_dijaka'] . "'>
                        <input type='submit' name='remove_student' value='Remove'>
                    </form>
                </td>
            </tr>";
        }
        ?>
    </table>

    <script>
        function toggleAddStudentSection() {
            const addStudentSection = document.getElementById('add_student_section');
            if (addStudentSection.style.display === 'none' || addStudentSection.style.display === '') {
                addStudentSection.style.display = 'block';
            } else {
                addStudentSection.style.display = 'none';
            }
        }
    </script>
</body>
</html>
