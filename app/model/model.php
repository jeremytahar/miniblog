<?php

// Fonction de connexion à la base de données
function dbConnect() {
   return require('./app/config/dbconnect.php');
}

// Fonction de vérification si l'admin est connecté 
function isAdmin() {
    if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == 1) {
        return true;
    } else {
        return false;
    }
}

// Fonction de connexion utilisateur
function loginUser($login, $password){
    $db = dbConnect();

    $query = "SELECT * FROM users WHERE login = :login";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();

        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['firstname'] = $user['firstname'];
        } else {
            header('Location: index.php?erreur=login');
        }
    } else {
        header('Location: index.php?erreur=login');
    }
}

// Fonction d'inscription utilisateur
function registerUser($login, $name, $firstname, $password, $confirmPassword, $photo) {
    $db = dbConnect();

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT id_user FROM users WHERE login = :login";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $query = "INSERT INTO users VALUES (NULL, :login, :name, :firstname, :password)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        $user_id = $db->lastInsertId();

        if($photo){
        addImage($photo, $user_id);
        }

        loginUser($login, $confirmPassword);

    } else {
        header('Location: index.php?action=register&erreur=login');
        exit;
    }

}


// Fonction d'ajout de l'image selon l'id utilisateur
function addImage($file, $user_id) {
    if (empty($file['tmp_name'])) {
        return true;
    }
    $file_type = mime_content_type($file['tmp_name']);
    if ($file_type !== 'image/jpeg') {
        return "Le fichier doit être un JPEG.";
    }

    $upload_dir = __DIR__ . '/../../media/photo/'; 

    $file_name = $user_id . '.jpg';
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        return true;
    } else {
        return "Échec du téléchargement de la photo.";
    }
}

// Fonction de déconnexion utilisateur
function logoutUser() {
    session_start();
    session_unset();
    session_destroy();
}

// Fonction d'insertion d'un article dans la base de données
function addPost($title, $content) {
    $db = dbConnect();

    $query = "INSERT INTO posts VALUES (NULL, :post_title, :post_content, NOW())";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':post_title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':post_content', $content, PDO::PARAM_STR);
    $stmt->execute();
}

// Fonction pour récupérer les 3 derniers posts
function getLatestPosts() {
    $db = dbConnect();

    $query = "SELECT * FROM posts ORDER BY post_date DESC LIMIT 3";
    $stmt = $db->query($query);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer tous les posts
function getAllPosts() {
    $db = dbConnect();

    $query = "SELECT * FROM posts ORDER BY post_date DESC";
    $stmt = $db->query($query);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour supprimer un post
function deletePost($id) {
    $db = dbConnect();

    $query = "DELETE FROM posts WHERE id_post = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Fonction pour récupérer un post par son id
function getPostById($id) {
    $db = dbConnect();

    $query = "SELECT * FROM posts WHERE id_post = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour mettre à jour un post
function updatePost($id, $title, $content) {
    $db = dbConnect();

    $query = "UPDATE posts SET post_title = :title, post_content = :content WHERE id_post = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->execute();
}

// Fonction pour récupérer tous les utilisateurs
function getUsers() {
    $db = dbConnect();

    $query = "SELECT * FROM users";
    $stmt = $db->query($query);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour supprimer un utilisateur et sa photo de profil
function deleteUser($id) {
    $db = dbConnect();

    $query = "DELETE FROM users WHERE id_user = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $photoPath = __DIR__ . "/../../media/photo/{$id}.jpg";

    if (file_exists($photoPath)) {
        unlink($photoPath);
    }
}

// Fonction pour récupérer un utilisateur par son id
function getUserById($id) {
    $db = dbConnect();

    $query = "SELECT * FROM users WHERE id_user = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour mettre à jour un utilisateur 
function updateUser($id, $name, $firstname, $login) {
    $db = dbConnect();

    $query = "UPDATE users SET name = :name, firstname = :firstname, login = :login WHERE id_user = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
}


// Fonction pour récupérer tous les commentaires d'un post
function getComments($id) {
    $db = dbConnect();

    $query = "
    SELECT c.id_comment, c.comment_content AS comment, c.comment_date, u.name, u.firstname
    FROM comments c
    JOIN users u ON c.user_id = u.id_user
    WHERE c.post_id = :id
    ORDER BY c.comment_date DESC
    ";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour ajouter un commentaire
function addComment($author, $comment, $post_id) {
    $db = dbConnect();

    $query = "INSERT INTO comments (comment_content, comment_date, user_id, post_id) 
                      VALUES (:comment, NOW(), :author, :post_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':author', $author, PDO::PARAM_INT); 
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT); 

    $stmt->execute();
}

// Fonction pour supprimer un commentaire
function deleteComment($id) {
    $db = dbConnect();

    $query = "DELETE FROM comments WHERE id_comment = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Fonction pour récupérer un commentaire par son id
function getCommentById($id) {
    $db = dbConnect();

    $query = "SELECT * FROM comments WHERE id_comment = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour mettre à jour un commentaire
function updateComment($id, $comment) {
    $db = dbConnect();

    $query = "UPDATE comments SET comment_content = :comment WHERE id_comment = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
}

?>