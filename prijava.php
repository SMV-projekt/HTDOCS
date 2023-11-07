<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $geslo = $_POST['password'];

    if (empty($email) || empty($geslo)) {
        $error_message = "Please fill in both email and password fields.";
    } else {
        if ($email === 'admin@admin' && $geslo === 'admin') {
            
            $_SESSION['email'] = $email;
            $_SESSION['vloga'] = 'admin'; 
            $_SESSION['ime_dijaka'] = 'Admin'; 
            header("Location: admin.php");
            exit();
        } else {
            $sql = "SELECT * FROM ucitelj WHERE `E-mail` = ? AND `Geslo` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $geslo);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $_SESSION['email'] = $email;
                $_SESSION['vloga'] = 'ucitelj'; 
                $_SESSION['ime_dijaka'] = $row['ime_ucitelja'];
                header("Location: ucitelj.php");
                exit();
            } else {
                $sql = "SELECT * FROM dijak WHERE `E-mail` = ? AND `Geslo` = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $geslo);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $_SESSION['email'] = $email;
                    $_SESSION['vloga'] = 'dijak'; 
                    $_SESSION['ime_dijaka'] = $row['ime_dijaka'];
                    header("Location: ucenec.php");
                    exit();
                } else {
                    $error_message = "Invalid email or password. Please try again.";
                }
            }
        }
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
    <p>Nimate računa? <a href="registracija.php">Registracija</a></p>

    <?php
    if (isset($_SESSION['email'])) {
        echo '<p>Prijavljen</p>';
    } elseif (isset($error_message)) {
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
