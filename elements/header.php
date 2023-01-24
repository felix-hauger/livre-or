<header>
    <h1>Livre d'Or</h1>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="livre-or.php">Le Livre d'Or</a></li>

            <?php if (isset($_SESSION['is_logged'])): ?>
                <li><a href="commentaire.php">Ajouter un Commentaire</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>

            <?php else: ?>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php">Inscription</a></li>
                
            <?php endif ?>
        </ul>
    </nav>
</header>