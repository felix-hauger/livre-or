<?php
session_start();

// Set in connexion.php at user log in 
if (!isset($_SESSION['is_logged'])) {
    header('Location: connexion.php');
    die();
}

// PDO connection
require_once('db_connect.php');

require_once('functions/is_user_in_db.php');

// Set in connexion.php at user log in 
$logged_user_id = $_SESSION['logged_user_id'];

// get user infos using id, that will use session variable
$sql = "SELECT login, password FROM users WHERE id LIKE :id";

$select = $pdo->prepare($sql);

$select->execute([
    'id' => $logged_user_id
]);

$user_infos = $select->fetch(PDO::FETCH_ASSOC);


$db_login = $user_infos['login'];
$db_password = $user_infos['password'];

if (isset($_POST['infos-submit'])) {

    if (!empty($_POST['login']) && !empty($_POST['new-password']) && !empty($_POST['new-password-confirmation']) && !empty($_POST['current-password'])) {

        $inputs_ok = true;

        $input_login = htmlspecialchars(trim($_POST['login']), ENT_QUOTES, "UTF-8");
        $input_new_password = htmlspecialchars(trim($_POST['new-password']), ENT_QUOTES, "UTF-8");
        $input_new_password_confirmation = htmlspecialchars(trim($_POST['new-password-confirmation']), ENT_QUOTES, "UTF-8");
        $input_current_password = htmlspecialchars(trim($_POST['current-password']), ENT_QUOTES, "UTF-8");

        // test if user in db, from the required function
        $user_in_db = is_user_in_db($input_login, $pdo);

        $login_ok = true;
        // add a test if user does not wish to change login
        if ($input_login != $db_login) {
            if ($user_in_db) {
                $login_ok = false;
                $login_error = 'L\'utilisateur existe déjà !';
            }
        }

        if ($input_new_password === $input_new_password_confirmation) {
            $new_password_ok = true;
        } else {
            $new_password_ok = false;
            $new_password_error = 'Valeurs non identiques dans les champs de mot de passe.';
        }

        if (password_verify($input_current_password, $db_password)) {
            $current_password_ok = true;
        } else {
            $current_password_ok = false;
            $current_password_error = 'Mot de Passe Actuel erroné.';
        }
    } else {
        $inputs_ok = false;
        $inputs_error = 'Remplissez tous les champs !';
    }


    if ($inputs_ok && $login_ok && $new_password_ok && $current_password_ok) {

        $hashed_password = password_hash($input_new_password, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET login = :login, password = :password WHERE id LIKE :id";

        $insert = $pdo->prepare($sql);

        $insert->execute([
            'login' => $input_login,
            'password' => $hashed_password,
            'id' => $logged_user_id
        ]);

        $success_msg = 'Mise à jour des information effectuée !';

        // Refresh to get update informations from db
        header('refresh: 3');
    }
} elseif (isset($_POST['pfp-submit'])) {
    var_dump($_POST);
    var_dump($_FILES);

    echo exec('whoami');

    if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] == 0) {
        if ($_FILES['profile-picture']['size'] <= 1000000) {
            $file_infos = pathinfo($_FILES['profile-picture']['name']);
            var_dump($file_infos);
            $file_extension = $file_infos['extension'];
            var_dump($file_extension);
            $extensions_array = ['png', 'gif', 'jpg', 'jpeg', 'webp'];

            if (in_array($file_extension, $extensions_array)) {
                if (file_exists(''))
                echo 'proute';
                imagepng(imagecreatefromstring(file_get_contents($_FILES['profile-picture']['tmp_name'])), 'uploads/pfp/' . $logged_user_id . '_pfp' . '.png');

            }
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
    <title>Modifier les Informations de Profil | Livre d'Or</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/42d5a324f0.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once('elements/header.php'); ?>

    <main>
        <div class="hero">
            <div id="profile-forms" class="form-container">
                <form action="" method="post">
                    <h2>Modifier vos informations de profil</h2>

                    <input type="text" name="login" id="login" placeholder="Votre Identifiant" value="<?= $db_login ?>">
                    <?php if (isset($login_error)) : ?>
                        <p class="error_msg"><?= $login_error ?></p>
                    <?php endif; ?>

                    <input type="password" name="new-password" id="new-password" placeholder="Nouveau MDP">
                    <input type="password" name="new-password-confirmation" id="new-password-confirmation" placeholder="Confirmation Nouveau MDP">
                    <?php if (isset($new_password_error)) : ?>
                        <p class="error_msg"><?= $new_password_error ?></p>
                    <?php endif; ?>
                        
                    <input type="password" name="current-password" id="current-password" placeholder="Tapez votre MDP Actuel">
                    <?php if (isset($current_password_error)) : ?>
                        <p class="error_msg"><?= $current_password_error ?></p>
                    <?php endif; ?>
                    
                    <input type="submit" value="Mettre à Jour" name="infos-submit">
                    <?php if (isset($inputs_error)) : ?>
                        <p class="error_msg"><?= $inputs_error ?></p>
                    <?php elseif (isset($success_msg)) : ?>
                        <p class="success_msg"><?= $success_msg ?></p>
                    <?php endif; ?>
                </form>

                <form action="" method="post" enctype="multipart/form-data">
                    <h2>Modifier votre image de profil</h2>

                    <div class="pfp-container">
                        <div class="pfp" style="background-image: url('uploads/pfp/<?= file_exists('uploads/pfp/' . $logged_user_id . '_pfp.png') ? $logged_user_id . '_pfp.png' : 'default_pfp.png' ?>');"></div>
                    </div>

                    <label for="profile-picture" class="file-upload">
                        <img src="img/upload-icon-20609.png" alt="upload icon" id="upload-icon">
                        <span>Télécharger une image (max 1mo)</span>
                        <input type="file" name="profile-picture" id="profile-picture">
                    </label>

                    <input type="submit" name="pfp-submit" value="Modifier">
                </form>

                <form action="supprimer-compte.php" method="post">
                    <h2>Supprimer votre compte</h2>

                    <input type="submit" name="delete" id="delete" value="Supprimer">
                </form>
            </div>
        </div>
    </main>

    <?php require_once('elements/footer.php'); ?>
</body>

</html>