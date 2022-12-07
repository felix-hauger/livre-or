<?php
session_start();

if (isset($_SESSION['is_logged'])) {
    header('Location: index.php');
    die();
}
var_dump($_SESSION);
require_once('elements/header.php');

if (isset($_POST['submit'])) {

    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        require_once('functions/db_connect.php');
        require_once('functions/is_user_in_db.php');
    
        $input_login = htmlspecialchars(trim($_POST['login']), ENT_QUOTES, "UTF-8");
        $input_password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, "UTF-8");
    
        // test if user in db, from the required function
        $user_in_db = is_user_in_db($input_login, $pdo);
    
        if ($user_in_db) {
            // echo 'le login ' . $input_login . ' est dans la base de données<br>';
            
            // $sql = "SELECT login, password FROM users WHERE login LIKE '$input_login'";

            $sql = "SELECT id, login, password FROM users WHERE login LIKE :login";
            
            // $query = $id->query($sql);

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                'login' => $input_login
            ]);

            var_dump($stmt);
            // get login & password from db in associative array
            $user_infos = $stmt->fetch(PDO::FETCH_ASSOC);
            $db_login = $user_infos['login'];
            $db_password = $user_infos['password'];
    
            // log in if matching password
            if ($input_password === $db_password || password_verify($input_password, $db_password)) {
    
                $db_id = $user_infos['id'];
                
                session_start();
                
                // to display log out button & give access to profil.php
                $_SESSION['is_logged'] = true;
                
                // to get user infos from db
                $_SESSION['logged_user_id'] = $db_id;

                $logged_user = $_SESSION['logged_user_id'];
                
                echo 'utilisateur ' . $_SESSION['logged_user'] . ' connecté !';
                header('Location: index.php');

                die();
                
            } else {
                // if password is incorrect
                $login_error = 'Identifiants incorrects.';
            }
    
        } else {
            // if user is NOT in db
            $login_error = 'Identifiants incorrects.';
        }
    } else {
        $inputs_error = 'Remplissez tous les champs !';
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Livre d'Or</title>
</head>
<body>
    <?php require_once 'elements/header.php'; ?>
    <main>
        <div class="hero">
            <div class="form-container">
                <form action="" method="post">
                    <h2>Connexion</h2>
        
                    <input type="text" name="login" id="login" placeholder="Votre Identifiant">
                    
                    <input type="password" name="password" id="password" placeholder="Votre Mot de Passe">
                    <?php if (isset($login_error)): ?>
                    <p class="error_msg"><?= $login_error ?></p>
                    <?php endif; ?>
        
                    <input type="submit" value="Connexion" name="submit">
                    <?php if (isset($inputs_error)): ?>
                    <p class="error_msg"><?= $inputs_error ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </main>
</body>
</html>



<?php

require_once('elements/footer.php');
