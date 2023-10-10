<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['Email'];
    $ime_dijaka = $_POST['ime_dijaka'];
    $priimek_dijaka = $_POST['priimek_dijaka'];
    $geslo = $_POST['Geslo'];
    $letnik = $_POST['Letnik'];
    $spol = $_POST['Spol'];

   
    if (empty($email) || empty($ime_dijaka) || empty($priimek_dijaka) || empty($geslo) || empty($letnik) || empty($spol)) {
        echo "Please fill in all the fields.";
    } else {
        
        $hashedPassword = password_hash($geslo, PASSWORD_DEFAULT);

        
        $sql = "SELECT * FROM dijak WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "User already exists!";
        } else {
            
            $sql = "INSERT INTO dijak (ime_dijaka, priimek_dijaka, Email, Geslo, Letnik, Spol)
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


mysqli_close($conn);
?>
