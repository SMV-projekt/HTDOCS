<?php
include 'database.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href='admin.css' />
</head>
<body>
    <h1>Admin Panel</h1>
    <form method="post" action="admin_seznam_dijakov.php">
        <input type="submit" name="show_dijaki" value="Seznam dijakov">
    </form>
    <form method="post" action="admin_seznam_uciteljev.php">
        <input type="submit" name="show_ucitelji" value="Seznam učiteljev">
    </form>
</body>
</html>
