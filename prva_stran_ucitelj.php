<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ucitelj</title>
    <link rel="stylesheet" type="text/css" href="prva_stran_ucitelj.css" />
</head>
<body>
    <h1>Hej učitelj :)</h1>
    <table border="0">
        <tr>
            <td>
                <form action="prijava.html">
                    <button type="submit">Predmet,<br>razred</button>
                 </form>
            </td>
            <td>
                <form action="prijava.html">
                    <button type="submit">Predmet,<br>razred</button>
                 </form>
            </td>
            <td>
                <form action="prijava.html">
                    <button type="submit">
                    <?php
                    echo "<p>"$predmet_ucitelja . ", <br>" . $razred_ucitelja "</p>";
                    ?>
                    </button>
                 </form>
            </td>
        </tr>
        <tr>
            <td>
                <form action="prijava.html">
                    <button type="submit">Predmet,<br>razred</button>
                 </form>
            </td>
            <td>
                <form action="prijava.html">
                    <button type="submit">Predmet,<br>razred</button>
                 </form>
            </td>
            <td>
                <form action="prijava.html">
                    <button type="submit">Predmet,<br>razred</button>
                 </form>
            </td>
        </tr>
    </table>
</body>
</html>
