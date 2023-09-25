<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $geslo = $_POST['password']; // Change 'geslo' to 'password'

    // Validate the form data
    if (empty($email) || empty($geslo)) {
        $error_message = "Please fill in both email and password fields.";
    } else {
        // Connect to the database (replace with your database connection code)
        $db_server = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'skupinice';

        $connection = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Query the database to check if the user exists
        $sql = "SELECT * FROM dijak WHERE `E-mail` = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($geslo, $row['geslo'])) {
                $_SESSION['email'] = $email;
                $_SESSION['ime_dijaka'] = $row['ime_dijaka'];
                // You can store other user information in the session as needed

                header("Location: welcome.php"); // Redirect to a welcome page
                exit();
            } else {
                $error_message = "Invalid password. Please try again.";
            }
        } else {
            $error_message = "User with this email does not exist.";
        }

        mysqli_close($connection);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Prijava</title>
    <link rel="stylesheet" type="text/css" href="registracija.css" />
</head>
<body>
    <header></header>
    <h1>Prijava</h1>
    <p>Nimate računa? <a href="registracija.html">Registracija</a></p>

    <?php
    if (isset($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
    ?>

<form name="Login" id="login" action="prijava.php" method="post">
    <input type="email" name="email" id="email" placeholder="Email" required /><br />
    <input type="password" name="password" id="password" placeholder="Geslo" required /><br />
    <button type="submit">Prijava</button>
</form>
</body>
</html>
