<?php
include 'database.php';

// Preveri, ali je bil kliknjen gumb "Dodaj učitelja"
if (isset($_POST['dodaj_ucitelja'])) {
    // Obdelava dodajanja novega učitelja (npr. vstavljanje v bazo podatkov)
    $ime_ucitelja = mysqli_real_escape_string($conn, $_POST['ime_ucitelja']);
    $priimek_ucitelja = mysqli_real_escape_string($conn, $_POST['priimek_ucitelja']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $geslo = mysqli_real_escape_string($conn, $_POST['geslo']);

    // Validacija in čiščenje podatkov...

    $vstavi_sql = "INSERT INTO ucitelj (ime_ucitelja, priimek_ucitelja, `E-mail`, Geslo)
                  VALUES ('$ime_ucitelja', '$priimek_ucitelja', '$email', '$geslo')";

    if (mysqli_query($conn, $vstavi_sql)) {
        echo "<p>Nov učitelj je bil uspešno dodan.</p>";
    } else {
        echo "<p>Napaka pri dodajanju učitelja: " . mysqli_error($conn) . "</p>";
    }
}

// Preveri, ali je bil kliknjen gumb "Odstrani učitelja"
if (isset($_POST['odstrani_ucitelja'])) {
    $id_ucitelja_za_odstranitev = $_POST['id_ucitelja'];

    // Najprej odstranite učitelja iz tabele "ucitelj_predmet"
    $izbrisi_ucitelj_predmet_sql = "DELETE FROM ucitelj_predmet WHERE id_ucitelja = $id_ucitelja_za_odstranitev";
    
    if (mysqli_query($conn, $izbrisi_ucitelj_predmet_sql)) {
        // Učitelj je bil odstranjen iz "ucitelj_predmet"
        // Sedaj lahko odstranite učitelja iz glavne tabele "ucitelj"
        $izbrisi_sql = "DELETE FROM ucitelj WHERE id_ucitelja = $id_ucitelja_za_odstranitev";
        if (mysqli_query($conn, $izbrisi_sql)) {
            echo "<p>Učitelj s številko $id_ucitelja_za_odstranitev je bil odstranjen.</p>";
        } else {
            echo "<p>Napaka pri odstranjevanju učitelja iz tabele 'ucitelj': " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Napaka pri odstranjevanju učitelja iz tabele 'ucitelj_predmet': " . mysqli_error($conn) . "</p>";
    }
}

// Preveri, ali je bil kliknjen gumb "Uredi učitelja"
if (isset($_POST['uredi_ucitelja'])) {
    $id_ucitelja_za_urejanje = $_POST['id_ucitelja'];
    
    // Pridobi podrobnosti učitelja za urejanje
    $sql_uredi_ucitelja = "SELECT ime_ucitelja, priimek_ucitelja, `E-mail` FROM ucitelj WHERE id_ucitelja = $id_ucitelja_za_urejanje";
    $rezultat_uredi_ucitelja = mysqli_query($conn, $sql_uredi_ucitelja);
    
    if ($rezultat_uredi_ucitelja && $podatki_uredi_ucitelja = mysqli_fetch_assoc($rezultat_uredi_ucitelja)) {
        echo '<h2>Uredi učitelja</h2>';
        echo '<form method="post" action="admin_seznam_uciteljev.php">';
        echo '<input type="hidden" name="id_ucitelja" value="' . $id_ucitelja_za_urejanje . '">';
        echo '<label for="uredi_ime_ucitelja">Ime učitelja:</label>';
        echo '<input type="text" name="uredi_ime_ucitelja" value="' . $podatki_uredi_ucitelja['ime_ucitelja'] . '"><br>';
        echo '<label for="uredi_priimek_ucitelja">Priimek učitelja:</label>';
        echo '<input type="text" name="uredi_priimek_ucitelja" value="' . $podatki_uredi_ucitelja['priimek_ucitelja'] . '"><br>';
        echo '<label for="uredi_email">E-mail:</label>';
        echo '<input type="email" name="uredi_email" value="' . $podatki_uredi_ucitelja['E-mail'] . '"><br>';
        echo '<input type="submit" name="shrani_uredenega_ucitelja" value="Shrani">';
        echo '</form>';
    }
}

// Preveri, ali je bil kliknjen gumb "Shrani urejenega učitelja"
if (isset($_POST['shrani_uredenega_ucitelja'])) {
    $id_ucitelja_za_urejanje = $_POST['id_ucitelja'];
    $uredi_ime_ucitelja = mysqli_real_escape_string($conn, $_POST['uredi_ime_ucitelja']);
    $uredi_priimek_ucitelja = mysqli_real_escape_string($conn, $_POST['uredi_priimek_ucitelja']);
    $uredi_email = mysqli_real_escape_string($conn, $_POST['uredi_email']);
    
    $posodobi_sql = "UPDATE ucitelj 
                  SET ime_ucitelja = '$uredi_ime_ucitelja', priimek_ucitelja = '$uredi_priimek_ucitelja', `E-mail` = '$uredi_email' 
                  WHERE id_ucitelja = $id_ucitelja_za_urejanje";

    if (mysqli_query($conn, $posodobi_sql)) {
        echo "<p>Učitelj s številko $id_ucitelja_za_urejanje je bil posodobljen.</p>";
    } else {
        echo "<p>Napaka pri posodabljanju učitelja: " . mysqli_error($conn) . "</p>";
    }
}

// Pridobi in prikaži seznam učiteljev
$sql = "SELECT id_ucitelja, ime_ucitelja, priimek_ucitelja, `E-mail` FROM ucitelj";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Poizvedba ni uspela: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Seznam učiteljev</title>
    <link rel="stylesheet" type="text/css" href="admin.css" />
</head>
<body>
    <h1>SEZNAM UČITELJEV</h1>
    <form method="post" action="admin.php">
        <input type="submit" name="prikazi_ucitelje" value="Nazaj">
    </form>

    <button onclick="toggleDodajUciteljaSekcijo()">Dodaj učitelja</button>

    <div id="sekcija_za_dodajanje_ucitelja" style="display: none;">
        <h2>Dodaj novega učitelja</h2>
        <form method="post" action="admin_seznam_uciteljev.php">
            <label for="ime_ucitelja">Ime učitelja:</label>
            <input type="text" name="ime_ucitelja" id="ime_ucitelja">
            <label for="priimek_ucitelja">Priimek učitelja:</label>
            <input type="text" name="priimek_ucitelja" id="priimek_ucitelja">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email">
            <label for="geslo">Geslo:</label>
            <input type="password" name="geslo" id="geslo">
            <input type="submit" name="dodaj_ucitelja" value="Dodaj">
        </form>
    </div>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Email</th>
            <th>Odstrani</th>
            <th>Uredi</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id_ucitelja'] . '</td>';
            echo '<td>' . $row['ime_ucitelja'] . '</td>';
            echo '<td>' . $row['priimek_ucitelja'] . '</td>';
            echo '<td>' . $row['E-mail'] . '</td>';
            echo '<td>
                    <form method="post" action="admin_seznam_uciteljev.php">
                        <input type="hidden" name="id_ucitelja" value="' . $row['id_ucitelja'] . '">
                        <input type="submit" name="odstrani_ucitelja" value="Odstrani">
                    </form>
                </td>';
            echo '<td>
            <form method="post" action="admin_seznam_uciteljev.php">
                        <input type="hidden" name="id_ucitelja" value="' . $row['id_ucitelja'] . '">
                        <input type="submit" name="uredi_ucitelja" value="Uredi">
                    </form>
                    </td>';
            echo '</tr>';
        }
        ?>
    </table>

    <script>
        function toggleDodajUciteljaSekcijo() {
            const sekcijaZaDodajanjeUcitelja = document.getElementById('sekcija_za_dodajanje_ucitelja');
            if (sekcijaZaDodajanjeUcitelja.style.display === 'none' || sekcijaZaDodajanjeUcitelja.style.display === '') {
                sekcijaZaDodajanjeUcitelja.style.display = 'block';
            } else {
                sekcijaZaDodajanjeUcitelja.style.display = 'none';
            }
        }
    </script>
</body>
</html>
