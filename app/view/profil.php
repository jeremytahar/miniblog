<!-- Vue contenant les informations du profil -->
    <h1>Bienvenue sur votre profil, <?php echo htmlspecialchars($_SESSION['login']); ?>!</h1>

    <img src="media/photo/<?= file_exists("media/photo/{$_SESSION['id_user']}.jpg") ? $_SESSION['id_user'] . '.jpg' : 'default.jpg' ?>" alt="Photo de profil" style="width: 150px; height: 150px; border-radius: 50%;"> <br>


    <p>Nom : <?php echo htmlspecialchars($_SESSION['name']); ?></p>
    <p>Prénom : <?php echo htmlspecialchars($_SESSION['firstname']); ?></p>

    <a href="?action=logout">Se déconnecter</a>
