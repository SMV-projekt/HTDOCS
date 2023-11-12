<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_students'])) {
    $id_predmeta = $_POST['id_predmeta'];
    $selected_students = $_POST['students'];

    // Iterate through selected students and assign them
    foreach ($selected_students as $id_dijaka) {
        // Check if the student is already assigned to the subject
        $assignment_check_sql = "SELECT * FROM dijak_predmet WHERE id_dijaka = ? AND id_predmeta = ?";
        $stmt = $conn->prepare($assignment_check_sql);
        $stmt->bind_param("ii", $id_dijaka, $id_predmeta);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            // The student is not assigned, proceed to assign them
            $insert_assignment_sql = "INSERT INTO dijak_predmet (id_dijaka, id_predmeta) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_assignment_sql);
            $stmt->bind_param("ii", $id_dijaka, $id_predmeta);

            if ($stmt->execute()) {
                echo "Students assigned to the subject successfully.";
            } else {
                echo "Error assigning students: " . $stmt->error;
            }
        } else {
            echo "Some students are already assigned to the subject.";
        }
    }
}

// Retrieve the id_predmeta from the URL
if (isset($_GET['id_predmeta'])) {
    $id_predmeta = $_GET['id_predmeta'];

    // Fetch the subject name for display
    $subject_sql = "SELECT naziv_predmeta FROM predmet WHERE id_predmeta = ?";
    $stmt = $conn->prepare($subject_sql);
    $stmt->bind_param("i", $id_predmeta);
    $stmt->execute();
    $stmt->bind_result($subject_name);
    $stmt->fetch();
    $stmt->close();

    if (empty($subject_name)) {
        echo "Subject not found.";
        exit();
    }
} else {
    echo "Subject ID is missing from the URL.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Assign Students</title>
    <link rel="stylesheet" type="text/css" href="your_css_file.css" />
</head>
<body>
    <!-- Display subject name -->
    <h1>Assign Students to "<?php echo $subject_name; ?>"</h1>

    <form method="post" action="dijak_predmet.php">
        <input type="hidden" name="id_predmeta" value="<?php echo $id_predmeta; ?>">
        <label for="students">Select students:</label>
        <?php
        $students_sql = "SELECT id_dijaka, ime_dijaka, priimek_dijaka FROM dijak";
        $students_result = $conn->query($students_sql);

        while ($student_row = $students_result->fetch_assoc()) {
            echo '<input type="checkbox" name="students[]" value="' . $student_row['id_dijaka'] . '">';
            echo $student_row['ime_dijaka'] . ' ' . $student_row['priimek_dijaka'] . '<br>';
        }
        ?>
        <button type="submit" name="assign_students">Assign Selected Students</button>
    </form>
</body>
</html>
