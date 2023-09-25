<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $ime_dijaka = $_POST['ime_dijaka'];
    $priimek_dijaka = $_POST['priimek_dijaka'];
    $geslo = $_POST['geslo'];
    $letnik = $_POST['letnik'];
    $spol = $_POST['spol'];

    // Validate the form data
    if (empty($email) || empty($ime_dijaka) || empty($priimek_dijaka) || empty($geslo) || empty($letnik) || empty($spol)) {
        echo "Please fill in all the fields.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($geslo, PASSWORD_DEFAULT);

        // Check if the user already exists
        $sql = "SELECT * FROM dijak WHERE `E-mail` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "User already exists!";
        } else {
            // Insert the user into the dijak table
            $sql = "INSERT INTO dijak (ime_dijaka, priimek_dijaka, `E-mail`, geslo, letnik, spol)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $ime_dijaka, $priimek_dijaka, $email, $hashedPassword, $letnik, $spol);

            if ($stmt->execute()) {
                echo "User created successfully!";
            } else {
                echo "Error creating user: " . $stmt->error;
            }
        }
    }
} else {
    exit('Invalid request!');
}

// Close the database connection
mysqli_close($conn);
?>
