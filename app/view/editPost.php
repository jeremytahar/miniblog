<h1>Modifier l'article</h1>

<form action="?action=updatePost" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($post['id_post']) ?>">

    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($post['post_title']) ?>"><br>

    <label for="content">Contenu :</label>
    <textarea name="content" id="content" rows="5"><?= htmlspecialchars($post['post_content']) ?></textarea><br>

    <button type="submit">Valider</button>
</form>
<a href="index.php">Annuler</a>