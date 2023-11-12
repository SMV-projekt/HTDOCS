<?php
include 'database.php';

$dijak = array(); // Initialize an empty array

// Check if session variable is set
if (isset($_SESSION['edit_dijak_id'])) {
    $id_dijaka = $_SESSION['edit_dijak_id'];

    // Fetch dijak details based on the provided id
    $select_sql = "SELECT * FROM dijak WHERE id_dijaka = ?";
    $stmt_select = $conn->prepare($select_sql);
    $stmt_select->bind_param("i", $id_dijaka);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $dijak = $result->fetch_assoc();
    $stmt_select->close();

    // Unset the session variable after fetching the data
    unset($_SESSION['edit_dijak_id']);
}

if (isset($_POST['posodobi_dijaka'])) {
    $id_dijaka = $_POST['id_dijaka'];
    $ime_dijaka = $_POST['ime_dijaka'];
    $priimek_dijaka = $_POST['priimek_dijaka'];
    $email = $_POST['E-mail'];
    $letnik = $_POST['Letnik'];
    $spol = $_POST['Spol'];

    $update_sql = "UPDATE dijak SET ime_dijaka = ?, priimek_dijaka = ?, `E-mail` = ?, Letnik = ?, Spol = ? WHERE id_dijaka = ?";
    
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $ime_dijaka, $priimek_dijaka, $email, $letnik, $spol, $id_dijaka);
    
    if ($stmt->execute()) {
        echo "Dijak uspešno posodobljen!";
    } else {
        echo "Napaka: " . $stmt->error;
    }
}
?>

<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="admin.css" />
    <title>Uredi Dijaka</title>
</head>
<body>
    <h1>UREDITE DIJAKA</h1>

    <form method="post" action="admin_seznam_dijakov.php">
        <input type="submit" name="prikazi_dijake" value="Nazaj na seznam dijakov">
    </form>

    <form method='post' action='admin_uredi_dijaka.php'>
        <input type='hidden' name='id_dijaka' value='<?php echo $dijak['id_dijaka']; ?>'>
        
        <label for='ime_dijaka'>Ime dijaka:</label>
        <input type='text' name='ime_dijaka' value='<?php echo $dijak['ime_dijaka']; ?>' id='ime_dijaka'>
        
        <label for='priimek_dijaka'>Priimek dijaka:</label>
        <input type='text' name='priimek_dijaka' value='<?php echo $dijak['priimek_dijaka']; ?>' id='priimek_dijaka'>
        
        <label for='E-mail'>E-mail:</label>
        <input type='email' name='E-mail' value='<?php echo $dijak['E-mail']; ?>' id='E-mail'>
        
        <label for='Letnik'>Letnik:</label>
        <input type='text' name='Letnik' value='<?php echo $dijak['Letnik']; ?>' id='Letnik'>
        
        <label for='Spol'>Spol:</label>
        <input type='text' name='Spol' value='<?php echo $dijak['Spol']; ?>' id='Spol'>
        
        <input type='submit' name='posodobi_dijaka' value='Posodobi dijaka'>
    </form>
</body>
</html>
