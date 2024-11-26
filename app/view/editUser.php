<!-- Edit user view -->
<h1>Modifier un utilisateur</h1>
<form action="?action=updateUser&id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data">

    <label for="name">Nom :</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" ><br>

    <label for="firstname">Prénom :</label>
    <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" ><br>

    <label for="login">Login :</label>
    <input type="text" id="login" name="login" value="<?= htmlspecialchars($user['login']) ?>" ><br>

    <label for="profile_picture">Photo de profil :</label>
    <img id="preview" 
         src="./media/photo/<?= $_GET['id']; ?>.jpg" 
         alt="Photo actuelle" width="150px" 
         onerror="this.src='media/photo/default.jpg'"> 
    <br>

    <input type="file" name="photo" id="photo" accept="image/jpeg" ><br><br>

    <button type="submit">Enregistrer les modifications</button>
</form>

<a href="index.php?action=users">Annuler</a>
