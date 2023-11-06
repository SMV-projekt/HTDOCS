<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="profil.css" />
</head>
<body>
<div class="navigation">
        <a href="ucitelj.php" class="odjava">Nazaj</a>
        
        
    </div>
    <?php
    session_start();
    include 'database.php';

    if (isset($_SESSION['email'])) {
        $logged_in_email = $_SESSION['email'];

        // Check if the logged-in user is a student (dijak) or a teacher (ucitelj)
        $user_type = "";

        $student_check_sql = "SELECT id_dijaka FROM dijak WHERE `E-mail` = ?";
        $stmt = $conn->prepare($student_check_sql);
        $stmt->bind_param("s", $logged_in_email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $user_type = "dijak";
            $stmt->bind_result($student_id);
            $stmt->fetch();
        } else {
            $teacher_check_sql = "SELECT id_ucitelja FROM ucitelj WHERE `E-mail` = ?";
            $stmt = $conn->prepare($teacher_check_sql);
            $stmt->bind_param("s", $logged_in_email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $user_type = "ucitelj";
                $stmt->bind_result($teacher_id);
                $stmt->fetch();
            }
        }

        $stmt->close();

        if ($user_type === "dijak") {
            // If the user is a student
            $fetch_user_data_sql = "SELECT * FROM dijak WHERE `E-mail` = ?";
            $stmt = $conn->prepare($fetch_user_data_sql);
            $stmt->bind_param("s", $logged_in_email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_data = $result->fetch_assoc();
        } elseif ($user_type === "ucitelj") {
            // If the user is a teacher
            $fetch_user_data_sql = "SELECT * FROM ucitelj WHERE `E-mail` = ?";
            $stmt = $conn->prepare($fetch_user_data_sql);
            $stmt->bind_param("s", $logged_in_email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_data = $result->fetch_assoc();
        }

        $stmt->close();
    } else {
        header("Location: prijava.php");
        exit();
    }

    // Handle the form submission
    if (isset($_POST['update_profile'])) {
        // Sanitize and update the user's information
        $new_ime = filter_input(INPUT_POST, 'ime', FILTER_SANITIZE_STRING);
        $new_priimek = filter_input(INPUT_POST, 'priimek', FILTER_SANITIZE_STRING);
        $new_geslo = password_hash($_POST['geslo'], PASSWORD_DEFAULT);
        $new_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if ($user_type === "dijak") {
            $new_letnik = filter_input(INPUT_POST, 'letnik', FILTER_SANITIZE_NUMBER_INT);
            $new_razred = filter_input(INPUT_POST, 'razred', FILTER_SANITIZE_STRING);
            $new_spol = filter_input(INPUT_POST, 'spol', FILTER_SANITIZE_STRING);
            $new_oddelek = filter_input(INPUT_POST, 'oddelek', FILTER_SANITIZE_STRING);

            $update_user_sql = "UPDATE dijak SET ime_dijaka = ?, priimek_dijaka = ?, `E-mail` = ?, Geslo = ?, Letnik = ?, Razred = ?, Spol = ?, Oddelek = ? WHERE `id_dijaka` = ?";
            $stmt = $conn->prepare($update_user_sql);
            $stmt->bind_param("ssssissi", $new_ime, $new_priimek, $new_email, $new_geslo, $new_letnik, $new_razred, $new_spol, $new_oddelek, $student_id);
        } elseif ($user_type === "ucitelj") {
            $update_user_sql = "UPDATE ucitelj SET ime_ucitelja = ?, priimek_ucitelja = ?, `E-mail` = ?, Geslo = ? WHERE `id_ucitelja` = ?";
            $stmt = $conn->prepare($update_user_sql);
            $stmt->bind_param("ssssi", $new_ime, $new_priimek, $new_email, $new_geslo, $teacher_id);
        }

        if ($stmt->execute()) {
            // Update successful
            header("Location: profil.php");
            exit();
        } else {
            // Update failed
            echo "Napaka pri posodabljanju profila.";
        }

        $stmt->close();
    }
    ?>
 <?php
    $uporabnikId = ($user_type === "dijak") ? $student_id : $teacher_id;
    $uporabnikovaPotSlike = "";

    if ($user_type === "dijak") {
        $poizvedba = "SELECT Profilna_slika FROM dijak WHERE id_dijaka = ?";
    } elseif ($user_type === "ucitelj") {
        $poizvedba = "SELECT Profilna_slika FROM ucitelj WHERE id_ucitelja = ?";
    }

    $stmt = $conn->prepare($poizvedba);
    $stmt->bind_param("i", $uporabnikId);
    $stmt->execute();
    $stmt->bind_result($uporabnikovaPotSlike);
    $stmt->fetch();
    $stmt->close();

    echo '<h2>Vaša Profilna Slika</h2>';
    
    if ($uporabnikovaPotSlike) {
        echo '<img src="' . $uporabnikovaPotSlike . '" alt="Profilna Slika" class="profilna_slika">';
    } else {
        echo 'Profilna slika ni na voljo.';
    }

    $conn->close();
    ?>
    <h1>Vaši osebni podatki: </h1>
    
    <!-- Display the name or enable editing based on user interaction -->
    <?php if (isset($_POST['edit_profile'])): ?>
        <form method="post" action="profil.php">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime" value="<?php echo $user_data['ime_dijaka'] ?? $user_data['ime_ucitelja']; ?>"><br>
            
            <label for="priimek">Priimek:</label>
            <input type="text" id="priimek" name="priimek" value="<?php echo $user_data['priimek_dijaka'] ?? $user_data['priimek_ucitelja']; ?>"><br>

            <label for="email">E-pošta:</label>
            <input type="email" id="email" name="email" value="<?php echo $logged_in_email; ?>"><br>

            <label for="geslo">Novo geslo (zapusti prazno, če ne želiš spremeniti):</label>
            <input type="password" id="geslo" name="geslo"><br>

            <?php if ($user_type === "dijak"): ?>
                <label for="letnik">Letnik:</label>
                <input type="number" id="letnik" name="letnik" value="<?php echo $user_data['Letnik']; ?>"><br>
                
                <label for="razred">Razred:</label>
                <input type="text" id="razred" name="razred" value="<?php echo $user_data['Razred']; ?>"><br>
                
                <label for="spol">Spol:</label>
                <input type="text" id="spol" name="spol" value="<?php echo $user_data['Spol']; ?>"><br>
                
                <label for="oddelek">Oddelek:</label>
                <input type="text" id="oddelek" name="oddelek" value="<?php echo $user_data['Oddelek']; ?>"><br>

                
            <?php endif; ?>

            <input type="submit" name="update_profile" value="Shrani spremembe">
        </form>
    <?php else: ?>
        <div class="osebni_podatki">
        <p>Ime: <?php echo $user_data['ime_dijaka'] ?? $user_data['ime_ucitelja']; ?></p>
        <p>Priimek: <?php echo $user_data['priimek_dijaka'] ?? $user_data['priimek_ucitelja']; ?></p>

        <p>E-pošta: <?php echo $logged_in_email; ?></p>
        
    </div>
        <form method="post" action="profil.php" class="a">
            <button type="submit" name="edit_profile">Uredi profil</button>
        </form>
        
    <?php endif; ?>

    
    <h2>Naloži profilno sliko</h2>
<form action="profilna_slika.php" method="post" enctype="multipart/form-data">
    <label for="profilna_slika">Izberite sliko:</label>
    <input type="file" name="profilna_slika" accept="image/*">
    <input type="submit" value="Naloži Profilno Sliko">
</form>
</body>
</html>
