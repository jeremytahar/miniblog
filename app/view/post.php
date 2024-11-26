<!-- Visualisation d'un post-->
<h1>post</h1>
<div class="posts-container">
    <div class="post">
        <div class="title-date">
            <h2><?= htmlspecialchars($post['post_title']) ?></h2>
            <?php
                    $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    $date = $formatter->format(new DateTime($post['post_date']));
                ?>
            <p class="date"><?= htmlspecialchars($date) ?></p>
        </div>
        <p><?= nl2br(htmlspecialchars($post['post_content'])) ?></p>
    
        <!-- Commentaires -->
        <h3>Commentaires</h3>
        <?php if (!empty($comments)): ?>
        <ul>
            <?php foreach ($comments as $comment): ?>
            <li>
                <p><strong><?= htmlspecialchars($comment['firstname'] . ' ' . $comment['name']) ?></strong> le
                    <?= htmlspecialchars($comment['comment_date']) ?></p>
                <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
    
                <?php if (isAdmin()): ?>
                <a href="?action=deleteComment&id=<?= $_GET['id'] ?>&idComment=<?= $comment['id_comment'] ?>" class="button"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">Supprimer</a>
                <a href="?action=editComment&id=<?= $_GET['id'] ?>&idComment=<?= $comment['id_comment'] ?>"
                    class="button">Modifier</a>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p>Aucun commentaire pour le moment.</p>
        <?php endif; ?>
    
        <!-- Formulaire de commentaire -->
        <?php if (isset($_SESSION['id_user'])): ?>
        <form action="?action=addComment&id=<?= $post['id_post'] ?>" method="post">
            <label for="comment">Votre commentaire</label><br>
            <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
            <input type="submit" value="Envoyer">
        </form>
        <?php else: ?>
        <p>Vous devez être connecté pour laisser un commentaire.</p>
        <?php endif; ?>
    </div>
</div>