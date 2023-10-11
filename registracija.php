<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $ime_dijaka = $_POST['ime_dijaka'];
    $priimek_dijaka = $_POST['priimek_dijaka'];
    $geslo = $_POST['geslo'];
    $letnik = $_POST['letnik'];
    $spol = $_POST['spol'];

    if (empty($email) || empty($ime_dijaka) || empty($priimek_dijaka) || empty($geslo) || empty($letnik) || empty($spol)) {
        echo "Please fill in all the fields.";
    } else {

        $sql = "SELECT * FROM dijak WHERE `E-mail` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "User already exists!";
        } else {
            $sql = "INSERT INTO dijak (ime_dijaka, priimek_dijaka, `E-mail`, geslo, letnik, spol)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $ime_dijaka, $priimek_dijaka, $email, $geslo, $letnik, $spol);

            if ($stmt->execute()) {
                // Registration successful, redirect to prijava.php with a success message
                header("Location: prijava.php?success=registration_successful");
                exit();
            } else {
                echo "Error creating user: " . $stmt->error;
            }
        }
    }
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Registracija</title>
        <link rel="stylesheet" type="text/css" href="registracija.css" />
        <script type="text/javascript">
            window.onload = function () {
                document.SignUp.SignUpBtn.disabled = true;

                document.SignUp.addEventListener("change", () => {
                    document.getElementById('SignUpBtn').disabled = !checkSignUp()
                });
            }

            function checkSignUp() {
                if (document.SignUp.email.value == '') return false;
                if (document.SignUp.ime_dijaka.value == '') return false;
                if (document.SignUp.priimek_dijaka.value == '') return false;
                if (document.SignUp.geslo.value == '') return false;

                return true;
            }
        </script>
    </head>
    <body>
        <header></header>
        <h1>Registracija</h1>
        <p>Že imate račun? <a href="prijava.php">Prijava</a></p>
        <form name="SignUp" id="registracija" action="registracija.php" method="post">
            <input type="email" name="email" id="email" placeholder="Email" required /><br />
            <input type="text" name="ime_dijaka" id="ime_dijaka" placeholder="Ime" required /><br />
            <input type="text" name="priimek_dijaka" id="priimek_dijaka" placeholder="Priimek" required /><br />
            <input type="password" name="geslo" id="geslo" placeholder="Geslo" required /><br />
            <label for="letnik">Letnik:</label>
            <select name="letnik" id="letnik">
                <option value="1">1. letnik</option>
                <option value="2">2. letnik</option>
                <option value="3">3. letnik</option>
                <option value="4">4. letnik</option>
            </select><br />
            <label for="spol">Spol:</label>
            <select name="spol" id="spol" required>
                <option value="">Izberite spol</option>
                <option value="M">Moški</option>
                <option value="Ž">Ženski</option>
            </select><br />
            <button type="submit" id="SignUpBtn">Registracija</button>
        </form>
    </body>
    </html>
    <?php
}

mysqli_close($conn);
?>
