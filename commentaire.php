<?php
session_start();

if (!isset($_SESSION['is_logged'])) {
    header('Location: connexion.php');
}

// var_dump($_SESSION);
if (isset($_SESSION['is_logged']) && isset($_SESSION['logged_user_id'])) {

    if (isset($_POST['submit'])) {
        require_once 'db_connect.php';

        if (!empty($_POST['comment'])) {
            $comment = htmlspecialchars(trim($_POST['comment']));
            $logged_user_id = $_SESSION['logged_user_id'];

            $sql = 'INSERT into comments (`comment`, `user_id`, `date`) VALUES (:comment, :user_id, :date)';

            $insert = $pdo->prepare($sql);

            $insert->bindParam(':comment', $comment);
            $insert->bindParam(':user_id', $logged_user_id);
            $insert->bindValue(':date', date('Y-m-d H:i:s'));

            if ($insert->execute()) {
                $comment_success = 'Commentaire posté avec succès !';
            } else {
                $comment_error = 'Erreur dans l\' envoi du commentaire';
            }
        } else {
            $comment_error = 'Le champ est vide !';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Commentaire | Livre d'Or</title>
    <link rel="stylesheet" href="font/webfont.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/42d5a324f0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once 'elements/header.php'; ?>
    <main>
        <div class="container form-container">
            <form action="" method="post">
                <h2>Ajouter un Commentaire</h2>
                <textarea name="comment" id="comment" cols="30" rows="10" autofocus></textarea>
                <input type="submit" name="submit" value="Envoyer">
                <?php if (isset($comment_error)) : ?>
                    <p class="error_msg"><?= $comment_error ?></p>
                <?php elseif (isset($comment_success)) : ?>
                    <p class="success_msg"><?= $comment_success ?></p>
                    <a href="livre-or.php" class="btn-link btn-small">
                        <span>Livre d'or</span>
                        <svg>
                            <polyline class="fill" points="0 0, 150 0, 150 55, 0 55, 0 0"></polyline>
                            <polyline class="animated-line" points="0 0, 150 0, 150 55, 0 55, 0 0"></polyline>
                        </svg>
                    </a>
                <?php endif ?>
            </form>
        </div>
    </main>
    <?php require_once 'elements/footer.php'; ?>
</body>

</html>