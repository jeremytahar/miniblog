<!-- Page d'affichage de tous les posts -->
<h1>archives - tous les posts</h1>

<?php if (!empty($posts)): ?>
<div class="posts-container">
    <?php foreach ($posts as $post): ?>
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
        <div class="actions">
            <a href="?action=post&id=<?= $post['id_post'] ?>" class="seemore-btn">Voir plus</a>
            <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1): ?>
            <div class="admin-actions">
                <a href="?action=editPost&id=<?= $post['id_post'] ?>" class="btn edit-btn">Modifier</a>
                <a href="?action=deletePost&id=<?= $post['id_post'] ?>" class="btn delete-btn"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p>Aucun article disponible pour le moment.</p>
<?php endif; ?>