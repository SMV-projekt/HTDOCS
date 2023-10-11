<?php
include 'database.php';

// Perform a query to fetch all teachers except the 'Geslo' field
$sql = "SELECT id_ucitelja, ime_ucitelja, priimek_ucitelja, `E-mail` FROM ucitelj";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
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
        <input type="submit" name="show_ucitelji" value="Nazaj">
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Email</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id_ucitelja'] . '</td>';
            echo '<td>' . $row['ime_ucitelja'] . '</td>';
            echo '<td>' . $row['priimek_ucitelja'] . '</td>';
            echo '<td>' . $row['E-mail'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>
