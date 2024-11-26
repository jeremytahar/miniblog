<!-- Page de modification d'un commentaire -->
<h1>Modifier un commentaire</h1>
<form action="?action=updateComment&id=<?= $_GET['id'] ?>&idComment=<?= $comment['id_comment'] ?>" method="post">
    <label for="comment">Votre commentaire</label><br>
    <textarea name="comment" id="comment" cols="30" rows="10"><?= $comment['comment_content'] ?></textarea><br>
    <input type="submit" value="Envoyer">
</form>