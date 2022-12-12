<?php
session_start();
require_once 'db_connect.php';

$sql = 'SELECT comment, date, users.login FROM comments INNER JOIN users ON comments.user_id = users.id ORDER BY date DESC';

// statement
$stmt = $pdo->prepare($sql);

$stmt->execute();

$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Commentaires | Livre d'Or</title>
</head>

<body>
    <?php require_once 'elements/header.php'; ?>
    <h1>Livre d'Or</h1>
    <h2>Vos commentaires</h2>
    <main>
        <?php foreach ($comments as $comment) : ?>

            <article>
                <!-- Format string to timestamp Unix w/ strtotime, then format it w/ date function -->
                <h3>Posté le <?= date('d/m/Y', strtotime($comment['date'])) ?> par <?= $comment['login'] ?></h3>
                <p><?= $comment['comment'] ?></p>
            </article>

        <?php endforeach ?>
    </main>
</body>

</html>