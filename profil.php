<?php
session_start();


var_dump($_SESSION);

if (!isset($_SESSION['is_logged'])) {
    header('Location: connexion.php');
    die();
}


require_once('db_connect.php');
require_once('functions/is_user_in_db.php');

// $logged_user = $_SESSION['logged_user'];
$logged_user_id = $_SESSION['logged_user_id'];


$sql = "SELECT login, password FROM users WHERE id LIKE :id";

// $query = $id->query($sql);

// $user_infos = $query->fetch_assoc();

$select = $pdo->prepare($sql);

$select->execute([
    'id' => $logged_user_id
]);

$user_infos = $select->fetch(PDO::FETCH_ASSOC);

var_dump($user_infos);


$db_login = $user_infos['login'];
$db_password = $user_infos['password'];

if (isset($_POST['submit'])) {

    if (!empty($_POST['login']) && !empty($_POST['password'])&& !empty($_POST['password-confirmation'])) {
        
        $inputs_ok = true;

        $input_login = htmlspecialchars(trim($_POST['login']), ENT_QUOTES, "UTF-8");
        $input_password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, "UTF-8");
        $input_password_confirmation = htmlspecialchars(trim($_POST['password-confirmation']), ENT_QUOTES, "UTF-8");
        
    
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
        
        if ($input_password === $input_password_confirmation) {
            $password_ok = true;
        } else {
            $password_ok = false;
            $password_error = 'Valeurs non identiques dans les champs de mot de passe';
        }
    
    } else {
        $inputs_ok = false;
        $inputs_error = 'Remplissez tous les champs !';
    }
    
    
    if ($inputs_ok && $login_ok && $password_ok) {

        $hashed_password = password_hash($input_password, PASSWORD_BCRYPT);

        
        $sql = "UPDATE users SET login = :login, password = :password WHERE id LIKE :id";
        
        $insert = $pdo->prepare($sql);

        $insert->execute([
            'login' => $input_login,
            'password' => $hashed_password,
            'id' => $logged_user_id
        ]);
        
        var_dump($insert);
        // if ($id->query($sql)) {
        //     echo 'Update complete! ';

        //     // if the condition is realized the table is updated with the value of $input_login, 
        //     // therefore it is not needed to fetch a new query to update the session variable
        //     $_SESSION['logged_user'] = $input_login;

        //     // we need however to redirect to update the inputs informations
        //     header('Location: profil.php');

        // } else {
        //     echo 'Error: ' . $id->error;
        // }
    }

}
// session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les Informations de Profil | Livre d'Or</title>
</head>
<body>
    <?php require_once('elements/header.php'); ?>

    <main>
        <div class="hero">
            <div class="form-container">
                <form action="" method="post">
                    <h2>Modifier vos informations de profil</h2>
        
                    <input type="text" name="login" id="login" placeholder="Votre Identifiant" value="<?= $db_login ?>">
                    <?php if (isset($login_error)): ?>
                    <p class="error_msg"><?= $login_error ?></p>
                    <?php endif; ?>
        
                    <input type="password" name="password" id="password" placeholder="Votre Mot de Passe">
                    <input type="password" name="password-confirmation" id="password-confirmation" placeholder="Confirmation Mot de Passe">
                    <?php if (isset($password_error)): ?>
                    <p class="error_msg"><?= $password_error ?></p>
                    <?php endif; ?>
        
                    <input type="submit" value="Mettre à Jour" name="submit">
                    <?php if (isset($inputs_error)): ?>
                    <p class="error_msg"><?= $inputs_error ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </main>

    <?php require_once('elements/footer.php'); ?>
</body>
</html>

