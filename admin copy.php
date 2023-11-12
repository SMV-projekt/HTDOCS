<?php
include 'database.php';

// Handle "Dijaki" button click
if (isset($_POST['show_dijaki'])) {
    $sql = "SELECT id_dijaka, ime_dijaka, priimek_dijaka, `E-mail`, Letnik, Razred, Spol, Oddelek FROM dijak";
    $result = $conn->query($sql);

    echo "<html>
<head>
    <meta charset='utf-8' />
    <title>Seznam Dijakov</title>
    <link rel='stylesheet' type='text/css' href='admin.css' />
</head>
<body>
    <h1>SEZNAM DIJAKOV</h1>
    <form method='post' action='admin.php'>
        <input type='submit' name='show_dijaki' value='Dijaki'>
    </form>";

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Priimek</th>
                    <th>E-mail</th>
                    <th>Letnik</th>
                    <th>Razred</th>
                    <th>Spol</th>
                    <th>Oddelek</th>
                </tr>";

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
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No records found.";
    }

    echo "</body>
</html>";
}
?>

<!DOCTYPE html>
<html>


</html>
