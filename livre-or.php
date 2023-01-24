<?php
session_start();
require_once 'db_connect.php';

$sql = 'SELECT comments.id as id, comment, date, users.login, users.id as user_id FROM comments INNER JOIN users ON comments.user_id = users.id ORDER BY date DESC';

// statement
$select = $pdo->prepare($sql);

$select->execute();

$comments = $select->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['delete-comment'])) {
    var_dump($_POST);
    $sql = 'DELETE FROM comments WHERE id = :id';
    $delete = $pdo->prepare($sql);
    $delete->execute([
        ':id' => $_POST['delete-comment']
    ]);
    header('Location: livre-or.php');
}

// At display, format fetched string date to timestamp Unix w/ strtotime, then format it w/ date function
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Commentaires | Livre d'Or</title>
    <link rel="stylesheet" href="font/webfont.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/42d5a324f0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once 'elements/header.php'; ?>

    <main>
        <div class="container comments-container">
            <h2>Vos commentaires</h2>
            <hr>
            <?php foreach ($comments as $comment) : ?>
    
                <div class="comment">
                    <div class="pfp-container">
                        <div class="pfp" style="background-image: url('uploads/pfp/<?= file_exists('uploads/pfp/' . $comment['user_id'] . '_pfp.png') ? $comment['user_id'] . '_pfp.png' : 'default_pfp.png' ?>');"></div>
                    </div>
                    <div class="text-container">
                        <h3>Posté le <?= date('d/m/Y', strtotime($comment['date'])) ?> par <?= $comment['login'] ?></h3>
                        <p><?= $comment['comment'] ?></p>
                    </div>
                    <?php if (isset($_SESSION['is_logged'])): ?>
                        <?php if ($_SESSION['logged_user_id'] === $comment['user_id'] || $_SESSION['logged_user_id'] == 1): ?>
                            <form method="post">
                                <button type="submit" name="delete-comment" class="delete-comment" value="<?= $comment['id'] ?>">Supprimer</button>
                            </form>
                        <?php endif ?>
                    <?php endif ?>
                </div>
    
            <?php endforeach ?>
        </div>
    </main>

    <?php require_once 'elements/footer.php' ?>
</body>

</html>