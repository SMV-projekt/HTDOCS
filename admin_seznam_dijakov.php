<?php
include 'database.php';

if (isset($_POST['odstrani_dijaka'])) {
    $id_dijaka_za_odstranitev = $_POST['id_dijaka'];

    $delete_sql = "DELETE FROM dijak WHERE id_dijaka = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id_dijaka_za_odstranitev);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['dodaj_dijaka'])) {
    $ime_dijaka = $_POST['ime_dijaka'];
    $priimek_dijaka = $_POST['priimek_dijaka'];
    $email = $_POST['E-mail'];
    $letnik = $_POST['Letnik'];
    $razred = $_POST['Razred'];
    $spol = $_POST['Spol'];
    $oddelek = $_POST['Oddelek'];
    $geslo = $_POST['Geslo'];

    $insert_sql = "INSERT INTO dijak (ime_dijaka, priimek_dijaka, `E-mail`, Letnik, Razred, Spol, Oddelek, Geslo) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssssssss", $ime_dijaka, $priimek_dijaka, $email, $letnik, $razred, $spol, $oddelek, $geslo);
    
    if ($stmt->execute()) {
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$sql = "SELECT id_dijaka, ime_dijaka, priimek_dijaka, `E-mail`, Letnik, Razred, Spol, Oddelek FROM dijak";
$result = $conn->query($sql);
?>

<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="admin.css" />
    <title>Seznam Dijakov</title>
</head>
<body>
    <h1>SEZNAM DIJAKOV</h1>
    <form method="post" action="admin.php">
        <input type="submit" name="prikazi_dijake" value="Nazaj">
    </form>

    <button onclick="toggleDodajDijakaSekcijo()">Dodaj novega dijaka</button>

    <div id="dodaj_dijaka_sekcija" style="display: none;">
        <h2>Dodaj novega dijaka</h2>
        <form method="post" action="admin_seznam_dijakov.php">
            <label for="ime_dijaka">Ime dijaka:</label>
            <input type="text" name="ime_dijaka" id="ime_dijaka">

            <label for="priimek_dijaka">Priimek dijaka:</label>
            <input type="text" name="priimek_dijaka" id="priimek_dijaka">

            <label for="E-mail">E-mail:</label>
            <input type="email" name="E-mail" id="E-mail">

            <label for="Letnik">Letnik:</label>
            <input type="text" name="Letnik" id="Letnik">

            <label for="Razred">Razred:</label>
            <input type="text" name="Razred" id="Razred">

            <label for="Spol">Spol:</label>
            <input type="text" name="Spol" id="Spol">

            <label for="Oddelek">Oddelek:</label>
            <input type="text" name="Oddelek" id="Oddelek">

            <label for="Geslo">Geslo:</label>
            <input type="password" name="Geslo" id="Geslo">

            <input type="submit" name="dodaj_dijaka" value="Dodaj">
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
        <th>Uredi dijaka</th>
        <th>Odstrani dijaka</th>
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
                <button onclick=\"toggleUrediDijakaForm(" . $row['id_dijaka'] . ")\">Uredi</button>
            </td>
            <td>
                <form method='post' action='admin_seznam_dijakov.php'>
                    <input type='hidden' name='id_dijaka' value='" . $row['id_dijaka'] . "'>
                    <input type='submit' name='odstrani_dijaka' value='Odstrani'>
                </form>
            </td>
        </tr>";

        // Dodaj obrazec za urejanje
        echo "<tr>
            <td colspan='8'></td>
            <td>
                <div id='uredi_dijaka_form_" . $row['id_dijaka'] . "' style='display: none;'>
                <h2>Uredi dijaka</h2>
                <form method='post' action='admin_seznam_dijakov.php'>
                <input type='hidden' name='id_dijaka' value='" . $row['id_dijaka'] . "'>";
        echo "<label for='ime_dijaka'>Ime dijaka:</label>";
        echo "<input type='text' name='ime_dijaka' value='" . $row['ime_dijaka'] . "' id='ime_dijaka'>";
        echo "<label for='priimek_dijaka'>Priimek dijaka:</label>";
        echo "<input type='text' name='priimek_dijaka' value='" . $row['priimek_dijaka'] . "' id='priimek_dijaka'>";
        echo "<label for='E-mail'>E-mail:</label>";
        echo "<input type='email' name='E-mail' value='" . $row['E-mail'] . "' id='E-mail'>";
        echo "<label for='Letnik'>Letnik:</label>";
        echo "<input type='text' name='Letnik' value='" . $row['Letnik'] . "' id='Letnik'>";
        echo "<label for='Razred'>Razred:</label>";
        echo "<input type='text' name='Razred' value='" . $row['Razred'] . "' id='Razred'>";
        echo "<label for='Spol'>Spol:</label>";
        echo "<input type='text' name='Spol' value='" . $row['Spol'] . "' id='Spol'>";
        echo "<label for='Oddelek'>Oddelek:</label>";
        echo "<input type='text' name='Oddelek' value='" . $row['Oddelek'] . "' id='Oddelek'>";
        echo "<input type='submit' name='uredi_dijaka' value='Uredi'>";
        echo "</form>";
        echo "</div>
            </td>
        </tr>";
    }
    ?>
</table>

    
    <?php
    // Dodaj obrazec za urejanje
    while ($row = $result->fetch_assoc()) {
        echo "<div id='uredi_dijaka_form_" . $row['id_dijaka'] . "' style='display: none;'>";
        echo "<h2>Uredi dijaka</h2>";
        echo "<form method='post' action='admin_seznam_dijakov.php'>";
        echo "<input type='hidden' name='id_dijaka' value='" . $row['id_dijaka'] . "'>";
        echo "<label for='ime_dijaka'>Ime dijaka:</label>";
        echo "<input type='text' name='ime_dijaka' value='" . $row['ime_dijaka'] . "' id='ime_dijaka'>";
        echo "<label for='priimek_dijaka'>Priimek dijaka:</label>";
        echo "<input type='text' name='priimek_dijaka' value='" . $row['priimek_dijaka'] . "' id='priimek_dijaka'>";
        echo "<label for='E-mail'>E-mail:</label>";
        echo "<input type='email' name='E-mail' value='" . $row['E-mail'] . "' id='E-mail'>";
        echo "<label for='Letnik'>Letnik:</label>";
        echo "<input type='text' name='Letnik' value='" . $row['Letnik'] . "' id='Letnik'>";
        echo "<label for='Razred'>Razred:</label>";
        echo "<input type='text' name='Razred' value='" . $row['Razred'] . "' id='Razred'>";
        echo "<label for='Spol'>Spol:</label>";
        echo "<input type='text' name='Spol' value='" . $row['Spol'] . "' id='Spol'>";
        echo "<label for='Oddelek'>Oddelek:</label>";
        echo "<input type='text' name='Oddelek' value='" . $row['Oddelek'] . "' id='Oddelek'>";
        echo "<input type='submit' name='uredi_dijaka' value='Uredi'>";
        echo "</form>";
        echo "</div>";
    }
    ?>

<script>
    function toggleDodajDijakaSekcijo() {
        const dodajDijakaSekcija = document.getElementById('dodaj_dijaka_sekcija');
        if (dodajDijakaSekcija.style.display === 'none' || dodajDijakaSekcija.style.display === '') {
            dodajDijakaSekcija.style.display = 'block';
        } else {
            dodajDijakaSekcija.style.display = 'none';
        }
    }

    function toggleUrediDijakaForm(dijakId) {
        const urediDijakaForm = document.getElementById('uredi_dijaka_form_' + dijakId);
        if (urediDijakaForm.style.display === 'none' || urediDijakaForm.style.display === '') {
            urediDijakaForm.style.display = 'block';
        } else {
            urediDijakaForm.style.display = 'none';
        }
    }
</script>
</body>
</html>
