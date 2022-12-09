<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="livre-or.php">Livre d'Or</a></li>
            <?php if (isset($_SESSION['is_logged'])): ?>
            <li><a href="commentaire.php">Ajouter un Commentaire</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>
            <?php else: ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>