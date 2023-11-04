<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Skupinice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: beige;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        h1 {
            font-size: 60px;
        }

        .buttons {
            margin-top: 20px;
        }

        .button {
            width: 90px;
            display: inline-block;
            background-color: sandybrown;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px; /* Make the buttons rounded */
            text-decoration: none;
            margin: 0 10px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #005983;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SKUPINICE</h1>
        <div class="buttons">
            <a href="prijava.php" class="button">Prijava</a>
            <a href="registracija.php" class="button">Registracija</a>
        </div>
    </div>
</body>
</html>
