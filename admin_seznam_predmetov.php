<link rel="stylesheet" type="text/css" href="admin.css" />

<?php
include 'database.php';

// Preveri, ali je bil kliknjen gumb "odstrani_predmet"
if (isset($_POST['odstrani_predmet'])) {
    // Pridobi ID predmeta za odstranitev
    $id_predmeta_za_odstranitev = $_POST['id_predmeta'];

    // Najprej izbriši vse povezave iz tabele ucitelj_predmet
    $izbrisi_povezave_sql = "DELETE FROM ucitelj_predmet WHERE id_predmeta = $id_predmeta_za_odstranitev";
    if ($conn->query($izbrisi_povezave_sql) === TRUE) {
        // Nato lahko varno izbrišete predmet iz tabele predmet
        $izbrisi_sql = "DELETE FROM predmet WHERE id_predmeta = $id_predmeta_za_odstranitev";
        if ($conn->query($izbrisi_sql) === TRUE) {
            echo "<p>Predmet s številko $id_predmeta_za_odstranitev je bil uspešno odstranjen.</p>";
        } else {
            echo "<p>Napaka pri odstranjevanju predmeta: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Napaka pri odstranjevanju povezav učitelja in predmeta: " . $conn->error . "</p>";
    }
}

// Preveri, ali je bil kliknjen gumb "dodeli_ucitelja"
if (isset($_POST['dodeli_ucitelja'])) {
    // Obdelava dodelitve učitelja predmetu
    $id_predmeta_za_dodelitev = $_POST['id_predmeta'];
    $id_ucitelja = $_POST['id_ucitelja'];
    
    // Preveri, ali je izbran veljaven učitelj
    if ($id_ucitelja == 0) {
        echo "<p>Izberite veljavnega učitelja za dodelitev.</p>";
    } else {
        // Preveri, ali je dodelitev že obstajala
        $preveri_dodelitev_sql = "SELECT * FROM ucitelj_predmet WHERE id_ucitelja = $id_ucitelja AND id_predmeta = $id_predmeta_za_dodelitev";
        $rezultat_preveri_dodelitev = $conn->query($preveri_dodelitev_sql);
        
        if ($rezultat_preveri_dodelitev->num_rows == 0) {
            // Dodelitev ne obstaja, vstavi novo dodelitev
            $vstavi_dodelitev_sql = "INSERT INTO ucitelj_predmet (id_ucitelja, id_predmeta) VALUES ($id_ucitelja, $id_predmeta_za_dodelitev)";
            if ($conn->query($vstavi_dodelitev_sql) === TRUE) {
                echo "<p>Učitelj je dodeljen predmetu s številko $id_predmeta_za_dodelitev.</p>";
            } else {
                echo "<p>Napaka pri dodeljevanju učitelja predmetu: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Učitelj je že dodeljen predmetu s številko $id_predmeta_za_dodelitev.</p>";
        }
    }
}

// Preveri, ali je bil kliknjen gumb "dodaj_predmet"
if (isset($_POST['dodaj_predmet'])) {
    // Obdelava dodajanja novega predmeta tukaj (npr. vstavljanje v bazo podatkov)
    $naziv_predmeta = $_POST['naziv_predmeta'];

    // Vstavi nov predmet v bazo podatkov (zamenjaj s svojim dejanskim SQL)
    $vstavi_sql = "INSERT INTO predmet (naziv_predmeta) VALUES ('$naziv_predmeta')";
    if ($conn->query($vstavi_sql) === TRUE) {
        echo "<p>Nov predmet je bil uspešno dodan.</p>";
    } else {
        echo "<p>Napaka pri dodajanju predmeta: " . $conn->error . "</p>";
    }
}

// Pridobi in prikaži seznam predmetov
$sql = "SELECT id_predmeta, naziv_predmeta FROM predmet";
$rezultat = $conn->query($sql);

echo "<html>
<head>
    <meta charset='utf-8' />
    <title>Seznam predmetov</title>
</head>
<body>
    <h1>SEZNAM PREDMETOV</h1>
    <form method='post' action='admin.php'>
        <input type='submit' name='prikazi_predmete' value='Nazaj'>
    </form>

    <button onclick='toggleDodajPredmetSekcijo()'>Dodaj predmet</button>

    <div id='dodaj_predmet_sekcija' style='display: none;'>
        <h2>Dodaj nov predmet</h2>
        <form method='post' action='admin_seznam_predmetov.php'>
            <label for='naziv_predmeta'>Naziv predmeta:</label>
            <input type='text' name='naziv_predmeta' id='naziv_predmeta'>
            <input type='submit' name='dodaj_predmet' value='Dodaj'>
        </form>
    </div>

    <table border='1'>
        <tr>
            <th>ID</th>
            <th>Naziv predmeta</th>
            <th>Ukrep</th>
            <th>Dodeli učitelja</th>
        </tr>";

        while ($vrstica = $rezultat->fetch_assoc()) {
            echo "<tr>
                    <td>" . $vrstica['id_predmeta'] . "</td>
                    <td>" . $vrstica['naziv_predmeta'] . "</td>
                    <td>
                        <form method='post' action='admin_seznam_predmetov.php'>
                            <input type='hidden' name='id_predmeta' value='" . $vrstica['id_predmeta'] . "'>
                            <input type='submit' name='odstrani_predmet' value='Odstrani'>
                        </form>
                        <form method='post' action='admin_seznam_predmetov.php'>
                            <input type='hidden' name='uredi_id_predmeta' value='" . $vrstica['id_predmeta'] . "'> <!-- Shranite ID predmeta za urejanje -->
                            <input type='submit' name='uredi_predmet' value='Uredi'>
                        </form>
                    </td>
                    <td>";
        
            // Preveri, ali je učitelj dodeljen predmetu
            $sql_dodelitev_ucitelja = "SELECT ucitelj.id_ucitelja, ucitelj.ime_ucitelja, ucitelj.priimek_ucitelja FROM ucitelj
                                      INNER JOIN ucitelj_predmet ON ucitelj.id_ucitelja = ucitelj_predmet.id_ucitelja
                                      WHERE ucitelj_predmet.id_predmeta = " . $vrstica['id_predmeta'];
        
            $rezultat_dodelitve_ucitelja = $conn->query($sql_dodelitev_ucitelja);
        
            if ($rezultat_dodelitve_ucitelja->num_rows > 0) {
                // Učitelj je dodeljen, prikaži podatke o učitelju
                $vrstica_ucitelja = $rezultat_dodelitve_ucitelja->fetch_assoc();
                echo "Učitelj: " . $vrstica_ucitelja['ime_ucitelja'] . " " . $vrstica_ucitelja['priimek_ucitelja'];
            } else {
                // Učitelj ni dodeljen
                echo "Predmet nima dodeljenega učitelja";
            }
        
            // Prikaz obrazca za dodelitev učitelja
            echo "<form method='post' action='admin_seznam_predmetov.php'>
                    <input type='hidden' name='id_predmeta' value='" . $vrstica['id_predmeta'] . "'>
                    <select name='id_ucitelja'>
                        <option value='0'>Izberite učitelja</option>";
        
            // Pridobite seznam vseh učiteljev iz baze
            $sql_ucitelja = "SELECT ucitelj.id_ucitelja, ucitelj.ime_ucitelja, ucitelj.priimek_ucitelja FROM ucitelj";
            $rezultat_ucitelja = $conn->query($sql_ucitelja);
            while ($vrstica_ucitelja = $rezultat_ucitelja->fetch_assoc()) {
                echo "<option value='" . $vrstica_ucitelja['id_ucitelja'] . "'>" . $vrstica_ucitelja['ime_ucitelja'] . " " . $vrstica_ucitelja['priimek_ucitelja'] . "</option>";
            }
        
            echo "</select>
                    <input type='submit' name='dodeli_ucitelja' value='Dodeli učitelja'>
                </form>
            </td>
        </tr>";
        }
        

// Prikaz obrazca za urejanje predmeta
if (isset($_POST['uredi_predmet']) && $_POST['uredi_id_predmeta'] == $vrstica['id_predmeta']) {
    echo "<tr>
        <td colspan='2'>
            <form method='post' action='admin_seznam_predmetov.php'>
                <input type='hidden' name='id_predmeta' value='" . $vrstica['id_predmeta'] . "'>
                <label for='uredi_naziv_predmeta'>Uredi naziv predmeta:</label>
                <input type='text' name='uredi_naziv_predmeta' value='" . $vrstica['naziv_predmeta'] . "'>
                <input type='submit' name='shrani_urejen_predmet' value='Shrani'>
            </form>
        </td>
    </tr>";
}

echo "</table>
</body>
</html>";

// Obdelava urejanja in shranjevanja urejenega predmeta
if (isset($_POST['shrani_urejen_predmet'])) {
    $id_predmeta_za_urejanje = $_POST['id_predmeta'];
    $uredi_naziv_predmeta = $_POST['uredi_naziv_predmeta'];
    
    // Posodobi predmet v bazi podatkov
    $sql_posodobi = "UPDATE predmet SET naziv_predmeta = '$uredi_naziv_predmeta' WHERE id_predmeta = $id_predmeta_za_urejanje";
    if ($conn->query($sql_posodobi) === TRUE) {
        echo "<p>Predmet s številko $id_predmeta_za_urejanje je bil posodobljen.</p>";
        
        // Samodejno osveži stran po posodobitvi predmeta
        echo "<script>window.location = 'admin_seznam_predmetov.php';</script>";
    } else {
        echo "<p>Napaka pri posodabljanju predmeta: " . $conn->error . "</p>";
    }
}

echo "<script>
function toggleDodajPredmetSekcijo() {
    const dodajPredmetSekcija = document.getElementById('dodaj_predmet_sekcija');
    if (dodajPredmetSekcija.style.display === 'none' || dodajPredmetSekcija.style.display === '') {
        dodajPredmetSekcija.style.display = 'block';
    } else {
        dodajPredmetSekcija.style.display = 'none';
    }
}
</script>";
?>
