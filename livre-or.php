<?php
session_start();
require_once 'db_connect.php';

$sql = 'SELECT comment, date, users.login FROM comments INNER JOIN users ON comments.user_id = users.id ORDER BY date DESC';

// statement
$select = $pdo->prepare($sql);

$select->execute();

$comments = $select->fetchAll(PDO::FETCH_ASSOC);

// At display, format fetched string date to timestamp Unix w/ strtotime, then format it w/ date function
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Commentaires | Livre d'Or</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/42d5a324f0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once 'elements/header.php'; ?>

    <main>
        <div class="comments-container">
            <h2>Vos commentaires</h2>
            <hr>
            <?php foreach ($comments as $comment) : ?>
    
                <div class="comment">
                    <h3>Posté le <?= date('d/m/Y', strtotime($comment['date'])) ?> par <?= $comment['login'] ?></h3>
                    <p><?= $comment['comment'] ?></p>
                </div>
    
            <?php endforeach ?>
        </div>
    </main>

    <?php require_once 'elements/footer-static.php' ?>
</body>

</html>