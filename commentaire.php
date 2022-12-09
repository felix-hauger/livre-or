<?php
session_start();

var_dump($_SESSION);
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
</head>
<body>
    <?php require_once 'elements/header.php'; ?>
    <h1>Ajouter un Commentaire</h1>
    <form action="" method="post">
        <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</body>
</html>