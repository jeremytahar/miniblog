<h1>Liste des utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Login</th>
            <th>Photo de profil</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['firstname']) ?></td>
            <td><b><?= htmlspecialchars($user['login']) ?></b></td>
            <td>
                <img src="media/photo/<?= htmlspecialchars($user['id_user']) ?>.jpg"
                    alt="Photo de <?= htmlspecialchars($user['name']) ?>" onerror="this.src='media/photo/default.jpg'">
            </td>
            <td>
                <div class="admin-actions">
                    <a href="?action=editUser&id=<?= $user['id_user'] ?>" class="btn edit-btn">Modifier</a>
                    <a href="?action=deleteUser&id=<?= $user['id_user'] ?>" class="btn delete-btn"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>