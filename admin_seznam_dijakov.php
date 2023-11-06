<?php
include 'database.php';

// Handle adding a new student
if (isset($_POST['dodaj_dijaka'])) {
    $ime_dijaka = mysqli_real_escape_string($conn, $_POST['ime_dijaka']);
    $priimek_dijaka = mysqli_real_escape_string($conn, $_POST['priimek_dijaka']);
    $email = mysqli_real_escape_string($conn, $_POST['E-mail']);
    $letnik = mysqli_real_escape_string($conn, $_POST['Letnik']);
    $razred = mysqli_real_escape_string($conn, $_POST['Razred']);
    $spol = mysqli_real_escape_string($conn, $_POST['Spol']);
    $oddelek = mysqli_real_escape_string($conn, $_POST['Oddelek']);

    $insert_sql = "INSERT INTO dijak (ime_dijaka, priimek_dijaka, `E-mail`, Letnik, Razred, Spol, Oddelek) 
    VALUES ('$ime_dijaka', '$priimek_dijaka', '$email', '$letnik', '$razred', '$spol', '$oddelek')";

    if (mysqli_query($conn, $insert_sql)) {
        echo "<p>Nov dijak je bil uspešno dodan.</p>";
    } else {
        echo "<p>Napaka pri dodajanju dijaka: " . mysqli_error($conn) . "</p>";
    }
}

// Handle removing a student
if (isset($_POST['odstrani_dijaka'])) {
    $id_dijaka_za_odstranitev = $_POST['id_dijaka'];

    $delete_sql = "DELETE FROM dijak WHERE id_dijaka = $id_dijaka_za_odstranitev";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<p>Dijak s številko $id_dijaka_za_odstranitev je bil odstranjen.</p>";
    } else {
        echo "<p>Napaka pri odstranjevanju dijaka: " . mysqli_error($conn) . "</p>";
    }
}

// Handle editing a student
if (isset($_POST['uredi_dijaka'])) {
    $id_dijaka = $_POST['id_dijaka'];
    $ime_dijaka = mysqli_real_escape_string($conn, $_POST['ime_dijaka']);
    $priimek_dijaka = mysqli_real_escape_string($conn, $_POST['priimek_dijaka']);
    $email = mysqli_real_escape_string($conn, $_POST['E-mail']);
    $letnik = mysqli_real_escape_string($conn, $_POST['Letnik']);
    $razred = mysqli_real_escape_string($conn, $_POST['Razred']);
    $spol = mysqli_real_escape_string($conn, $_POST['Spol']);
    $oddelek = mysqli_real_escape_string($conn, $_POST['Oddelek']);

    $update_sql = "UPDATE dijak SET ime_dijaka = '$ime_dijaka', priimek_dijaka = '$priimek_dijaka', `E-mail` = '$email', Letnik = '$letnik', Razred = '$razred', Spol = '$spol', Oddelek = '$oddelek' WHERE id_dijaka = $id_dijaka";

    if (mysqli_query($conn, $update_sql)) {
        echo "<p>Dijak s številko $id_dijaka je bil uspešno posodobljen.</p>";
    } else {
        echo "<p>Napaka pri urejanju dijaka: " . mysqli_error($conn) . "</p>";
    }
}

$sql = "SELECT id_dijaka, ime_dijaka, priimek_dijaka, `E-mail`, Letnik, Razred, Spol, Oddelek FROM dijak";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="admin.css" />
    <title>Seznam Dijakov</title>
</head>
<body>
    <h1>SEZNAM DIJAKOV</h1>
    
    <form method="post" action="admin_seznam_dijakov.php">
        <button type="submit" name="dodaj_dijaka">Dodaj novega dijaka</button>
    </form>

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
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<form method="post" action="admin_seznam_dijakov.php">';
            echo '<tr>';
            echo '<td>' . $row['id_dijaka'] . '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka']])) {
                echo '<input type="text" name="ime_dijaka" value="' . $row['ime_dijaka'] . '">';
            } else {
                echo $row['ime_dijaka'];
            }
            echo '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka'])) {
                echo '<input type="text" name="priimek_dijaka" value="' . $row['priimek_dijaka'] . '">';
            } else {
                echo $row['priimek_dijaka'];
            }
            echo '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka'])) {
                echo '<input type="text" name="E-mail" value="' . $row['E-mail'] . '">';
            } else {
                echo $row['E-mail'];
            }
            echo '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka'])) {
                echo '<input type="text" name="Letnik" value="' . $row['Letnik'] . '">';
            } else {
                echo $row['Letnik'];
            }
            echo '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka'])) {
                echo '<input type="text" name="Razred" value="' . $row['Razred'] . '">';
            } else {
                echo $row['Razred'];
            }
            echo '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka'])) {
                echo '<input type="text" name="Spol" value="' . $row['Spol'] . '">';
            } else {
                echo $row['Spol'];
            }
            echo '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka'])) {
                echo '<input type="text" name="Oddelek" value="' . $row['Oddelek'] . '">';
            } else {
                echo $row['Oddelek'];
            }
            echo '</td>';
            echo '<td>';
            if (isset($_POST['edit_' . $row['id_dijaka'])) {
                echo '<button type="submit" name="uredi_dijaka" value="' . $row['id_dijaka'] . '">Shrani</button>';
            } else {
                echo '<button type="submit" name="edit_' . $row['id_dijaka'] . '">Uredi</button>';
            }
            echo '</td>';
            echo '<td>';
            echo '<button type="submit" name="odstrani_dijaka" value="' . $row['id_dijaka'] . '">Odstrani</button>';
            echo '</td>';
            echo '</tr>';
            echo '</form>';
        }
        ?>
    </table>
</body>
</html>
