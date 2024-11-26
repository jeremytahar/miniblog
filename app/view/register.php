<!-- Page d'inscrption -->
<form action="?action=traiteRegister" method="POST" enctype="multipart/form-data" class="form">
    <h2>Inscription</h2>
    <div class="form-group">
        <input type="text" name="register-login" id="register-login" placeholder="Login" required >
        <label for="register-login">Login </label>
    </div>

    <div class="form-group">
        <input type="text" name="register-name" id="register-name" placeholder="Nom" required>
        <label for="register-nom">Nom</label>
    </div>

    <div class="form-group">
        <input type="text" name="register-firstname" id="register-firstname" placeholder="Prénom" required>
        <label for="register-prenom">Prénom</label>
    </div>

    <div class="form-group">
        <input type="password" name="register-password" id="register-password" placeholder="Mot de passe" required>
        <label for="password">Mot de passe</label>
    </div>

    <div class="form-group">
        <input type="password" name="register-confirm-password" id="register-confirm-password" placeholder="Confirmation du mot de passe" required>
        <label for="register-confirm-password">Confirmation du mot de passe</label>
    </div>

    <div>
        <input type="file" name="photo" id="photo" accept="image/jpeg">
        <label for="photo"><img src="./media/icons/upload.svg" alt="">Photo de profil (JPEG)</label><br>
        <img src="" alt="" id="preview">
    </div>

    <input type="submit" name="submit" value="Inscription" class="submit-btn">
    <p>Vous avez un compte ? <a href="?action=login">Connectez-vous</a></p> 
</form>
