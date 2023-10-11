<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    $logged_in_email = $_SESSION['email'];
    $sql = "SELECT p.naziv_predmeta FROM predmet p";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    header("Location: prijava.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ucitelj</title>
    <link rel="stylesheet" type="text/css" href="prva_stran_ucitelj.css" />
</head>
<body>
    <a href="prijava.html">Prijava</a>
    <a href="dodaj_predmet.php">Dodaj nov predmet</a>
    
    <h1>Hej učitelj :)</h1>
    <table border="0">
        <tr>
            <td>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <p><?php echo $row['naziv_predmeta']; ?></p>
                <?php endwhile; ?>
            </td>
        </tr>
    </table>
</body>
</html>
