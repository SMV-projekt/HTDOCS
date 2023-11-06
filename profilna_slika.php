<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Nalaganje Profilne Slike</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $datoteka = $_FILES["profilna_slika"];
        if ($datoteka) {
            $mapaZaNalaganje = "profilna_slika/";
            $imeDatoteke = basename($datoteka["name"]);
            $ciljnaDatoteka = $mapaZaNalaganje . $imeDatoteke;

            if (move_uploaded_file($datoteka["tmp_name"], $ciljnaDatoteka)) {
                // Uspešno naloženo; posodobitev podatkovne baze
                session_start();
                if (isset($_SESSION['email'])) {
                    $logged_in_email = $_SESSION['email'];
                    include 'database.php'; // Prepričajte se, da vključite povezavo do podatkovne baze

                    // Pridobitev ID trenutno prijavljenega uporabnika iz podatkovne baze
                    $user_id = 0;
                    $user_type = "";

                    $student_check_sql = "SELECT id_dijaka FROM dijak WHERE `E-mail` = ?";
                    $stmt = $conn->prepare($student_check_sql);
                    $stmt->bind_param("s", $logged_in_email);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $user_type = "dijak";
                        $stmt->bind_result($user_id);
                        $stmt->fetch();
                    } else {
                        $teacher_check_sql = "SELECT id_ucitelja FROM ucitelj WHERE `E-mail` = ?";
                        $stmt = $conn->prepare($teacher_check_sql);
                        $stmt->bind_param("s", $logged_in_email);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            $user_type = "ucitelj";
                            $stmt->bind_result($user_id);
                            $stmt->fetch();
                        }
                    }

                    $stmt->close();

                    // Posodobitev stolpca s profilno sliko v podatkovni bazi
                    if ($user_type === "dijak") {
                        $update_user_sql = "UPDATE dijak SET Profilna_slika = ? WHERE id_dijaka = ?";
                    } elseif ($user_type === "ucitelj") {
                        $update_user_sql = "UPDATE ucitelj SET Profilna_slika = ? WHERE id_ucitelja = ?";
                    }

                    $stmt = $conn->prepare($update_user_sql);
                    $stmt->bind_param("si", $ciljnaDatoteka, $user_id);

                    if ($stmt->execute()) {
                        $stmt->close();
                        $conn->close();
                        header("Location: profil.php"); // Redirect back to profil.php
                        exit();
                    } else {
                        echo "Napaka pri posodabljanju podatkovne baze.";
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    echo "Napaka: Uporabnik ni prijavljen.";
                }
            } else {
                echo "Napaka pri nalaganju datoteke.";
            }
        }
    }
    ?>

</body>
</html>
