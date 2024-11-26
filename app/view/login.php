<!-- Page de connexion -->
<!-- Login admin : admin -->
<!-- Mot de passe admin : admin -->
<form action="?action=traiteLogin" method="POST" class="form">
    <h2>Connexion</h2>
    <div class="form-group">
        <input type="text" name="login" id="login" placeholder="Login">
        <label for="login">Login </label><br>
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password" placeholder="Mot de passe">
        <label for="password">Mot de passe </label><br>
    </div>
    <input type="submit" name="submit" value="Connexion" class="submit-btn">
    <p>Pas encore inscrit ?  <a href="?action=register">Inscrivez-vous</a></p> 
</form>
