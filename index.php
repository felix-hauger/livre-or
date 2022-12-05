<?php
session_start();
var_dump($_SESSION);
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | Livre d'Or</title>
</head>
<body>
    <?php require_once 'elements/header.php'; ?>
    <h1>Livre d'or</h1>
    <h2>Bonjour <?= isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : 'invité' ?> !</h2>
</body>
</html>