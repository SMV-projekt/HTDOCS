<?php
session_start();
include 'database.php';

if (isset($_SESSION['email'])) {
    $logged_in_email = $_SESSION['email'];

    // Fetch the student's ID based on their email
    $student_id_sql = "SELECT id_dijaka FROM dijak WHERE `E-mail` = ?";
    $stmt = $conn->prepare($student_id_sql);
    $stmt->bind_param("s", $logged_in_email);
    $stmt->execute();
    $stmt->bind_result($student_id);
    $stmt->fetch();
    $stmt->close();

    // Fetch subjects assigned to the student based on their ID
    $subjects_sql = "SELECT p.id_predmeta, p.naziv_predmeta 
                    FROM predmet p
                    INNER JOIN dijak_predmet dp ON p.id_predmeta = dp.id_predmeta
                    WHERE dp.id_dijaka = ?";
    $stmt = $conn->prepare($subjects_sql);
    $stmt->bind_param("i", $student_id);
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
<style>
    /* Add this CSS to your "prva_stran_ucitelj.css" file */
    /* ... (other CSS rules) */
    header{
        border: 1px solid black;
    }
    /* Style for the "Prijava" link */
    a {
        text-decoration: none;
        color: black;
        transition: color 0.3s;
    }

    /* Change the color on hover and make it flash */
    a:hover {
        color: red;
        animation: flash 0.9s infinite;
    }

    /* Define the flashing animation */
    @keyframes flash {
        0% { color: green; }
        50% { color: white; }
        100% { color: black; }
    }

    /* Style for the main div */
    .main-div {
        border: 1px solid black;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Style for individual subject divs */
    .predmet {
        border: 1px solid black; /* Add borders to the subject divs */
        margin: 10px;
        padding: 10px;
        text-align: center;
    }
    
</style>

    <meta charset="utf-8" />
    <title>Ucenec</title>
    <link rel="stylesheet" type="text/css" href="prva_stran_ucitelj.css" />
       <style>
        /* Add this CSS to your stylesheet or in a <style> tag in the head section */
        .subject-container {
            display: flex;
            flex-wrap: wrap;
        }
        .subject {
            width: 23%; /* 4 subjects in a row, accounting for some margin */
            margin: 1%;
            padding: 10px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    
    <header>
        <a href="prijava.php">Prijava</a>
    </header>
    
    <h1>Hej učenec :)</h1>
    <div class="main-div">
        <?php
        while ($row = $result->fetch_assoc()):
        ?>
            <div class="predmet">
                
                <p><a href="predmet.php?id_predmeta=<?php echo $row['id_predmeta']; ?>"><?php echo $row['naziv_predmeta']; ?></a></p>
            </div>
        <?php
        endwhile;
        ?>
    </div>
</body>
</html>
