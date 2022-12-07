<?php
session_start();
var_dump($_SESSION);

// If logged, get user login with user id
if (isset($_SESSION['is_logged'])) {
    require_once 'functions/db_connect.php';
    
    $sql = "SELECT login FROM users WHERE id LIKE :id";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    $stmt->execute([
        'id' => $_SESSION['logged_user_id']
    ]);
    
    $user_infos = $stmt->fetch();
    
    var_dump($user_infos);
    
    $logged_user = $user_infos['login'];
    
    var_dump($logged_user);

}
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
    <h2>Bonjour <?= isset($logged_user) ? $logged_user : 'invité' ?> !</h2>
</body>
</html>