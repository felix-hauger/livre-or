<?php
session_start();

if (!isset($_SESSION['is_logged'])) {
    header('Location: index.php');
    die();
}

if (isset($_POST['delete-confirm'])) {
    require_once('db_connect.php');

    $sql = 'DELETE FROM users WHERE id = :id';
    $delete = $pdo->prepare($sql);

    $delete->execute([
        'id' => $_SESSION['logged_user_id']
    ]);

    header('Location: deconnexion.php');

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les Informations de Profil | Livre d'Or</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/42d5a324f0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once('elements/header.php'); ?>

    <main>
        <div class="container form-container">
            <form action="" method="post" id="delete-confirm">
                <h2>Voulez-vous vraiment supprimer votre compte ?</h2>
                <p class="form-paragraph">Tous vos commentaires seront supprimés.<br />
                Cette action n'est pas réversible.</p>
                <input type="submit" id="delete" name="delete-confirm" value="Supprimer">
            </form>
        </div>
    </main>

    <?php require_once('elements/footer.php'); ?>
</body>

</html>