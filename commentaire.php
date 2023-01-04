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
            $insert->execute([
                'comment' => $comment,
                'user_id' => $logged_user_id,
                'date'    => date('Y-m-d h:m:s')
            ]);
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
            </form>
            <?php if (isset($comment_error)) : ?>
                <p class="error_msg"><?= $comment_error ?></p>
            <?php endif ?>
        </div>
    </main>
    <?php require_once 'elements/footer.php'; ?>
</body>

</html>