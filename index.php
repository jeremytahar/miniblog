<?php 
session_start();
require('./app/model/model.php');

// Conditions de connexion et d'action utlisateur avec des switch case
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'traiteRegister':
            $login = $_POST['register-login'];
            $name = $_POST['register-name'];
            $firstname = $_POST['register-firstname'];
            $password = $_POST['register-password'];
            $confirmPassword = $_POST['register-confirm-password'];
            $photo = $_FILES['photo'];
            registerUser($login, $name, $firstname, $password, $confirmPassword, $photo);
            header('Location: index.php?action=home');
        break;
        case 'traiteLogin':
            $login = $_POST['login'];
            $password = $_POST['password'];
            loginUser($login, $password);
        break;
        case 'logout':
            logoutUser();
            header('Location: index.php?action=home');
        break;
        case 'addPost':
            if (isAdmin()) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                addPost($title, $content);
                header('Location: index.php?action=home');
            } else {
                header('Location: index.php?action=home'); 
            }
        break;            
        case 'deletePost':
            if (isAdmin()) {
                $id = $_GET['id'];
                deletePost($id);
                header('Location: index.php?action=home');
            } else {
                header('Location: index.php?action=home');
            }
        break;            
        case 'updatePost':
            if (isAdmin()) {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $content = $_POST['content'];
                updatePost($id, $title, $content);
                header('Location: index.php');
                exit();
            } else {
                header('Location: index.php?action=home');
            }
        break;
        case 'deleteUser':
            if (isAdmin()) {
                $id = $_GET['id'];
                deleteUser($id);
                header('Location: index.php?action=users');
            } else {
                header('Location: index.php?action=home');
            }
        break;
        case 'updateUser':
            if (isAdmin()) {
                $id = $_GET['id'];
                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $login = $_POST['login'];

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                    $targetPath = "media/photo/{$id}.jpg";
                    move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath);
                }

                updateUser($id, $name, $firstname, $login);
                header('Location: index.php?action=users');
            } else {
                header('Location: index.php?action=home');
            }
        break;
        case 'addComment':
            if (isset($_SESSION['id_user'])) {
                $id = $_GET['id'];
                $comment = $_POST['comment'];
                $author = $_SESSION['id_user'];
                
                addComment($author, $comment, $id);
                header("Location: index.php?action=post&id=$id");
            } else {
                header('Location: index.php?action=login');
            }
        break;
        case 'deleteComment':
            if (isAdmin()) {
                $id = $_GET['idComment'];
                $post_id = $_GET['id'];
                deleteComment($id);
                header("Location: index.php?action=post&id=$post_id");
            } else {
                header('Location: index.php?action=home');
            }
        break;
        case 'updateComment':
            if (isAdmin()) {
                $id = $_GET['idComment'];
                $comment = $_POST['comment'];
                $post_id = $_GET['id'];
                updateComment($id, $comment);
                header("Location: index.php?action=post&id=$post_id");
            } else {
                header('Location: index.php?action=home');
            }
        break;
    }
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Blog | Jérémy Tahar</title>
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <nav>
        <ul>
            <li class="home"><a href="?action=home"><img src="media/icons/home.svg" alt="Se connecter" class="icon"></a>
            </li>
            <div class="nav-right">
                <?php if (isAdmin()):?>
                <li><a href="?action=newPost"><img src="media/icons/plus.svg" alt="Ajouter un article" class="icon"></a>
                </li>
                <li><a href="?action=users"><img src="media/icons/users.svg" alt="Gérer les utilisateurs"
                            class="icon"></a></li>
                <?php endif; ?>
                <li><a href="?action=archives"><img src="media/icons/archive.svg" alt="Voir tous les articles"
                            class="icon"></a></li>
                <?php if (isset($_SESSION['login'])): ?>
                <?php
                    $profile_image = file_exists("media/photo/{$_SESSION['id_user']}.jpg") ? "media/photo/{$_SESSION['id_user']}.jpg" : 'media/icons/profile.svg';
                    $link_class = ($profile_image === 'media/icons/profile.svg') ? 'icon' : 'user-profile';
                ?>
                <li><a href="?action=profil"><img src="<?= $profile_image ?>" alt="Profil"
                            class="<?= $link_class ?>"></a></li>
                <li><a href="?action=logout"><img src="media/icons/logout.svg" alt="Se déconnecter" class="icon"></a>
                </li>
                <?php else: ?>
                <li><a href="?action=login"><img src="media/icons/profile.svg" alt="Se connecter" class="icon"></a></li>
                <?php endif; ?>
            </div>
        </ul>
    </nav>
    <?php



$action = $_GET['action'] ?? 'home';

if ($action === 'register' && isset($_GET['erreur']) && $_GET['erreur'] === 'login') {
    echo '<p style="color: red;">Le login existe déjà.</p>';
}

// Conditions d'affichage des vues
switch ($action) {
    case 'login':
        require('./app/view/login.php');
        break;

    case 'register':
        require('./app/view/register.php');
        break;
    case 'profil':
        require('./app/view/profil.php');
        break;
    case 'newPost':
        if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == '1') {
            require('./app/view/newPost.php');
        } else {
            header('Location: index.php?action=home');
            exit;
        }
        break;  
    case 'editPost':        
        if (isAdmin()) {
            $id = $_GET['id'];
            $post = getPostById($id);
            require './app/view/editPost.php'; 
        } else {
            header('Location: index.php?action=home');
            exit;
        }
        break;   
    case 'users':
        if (isAdmin()) {
            $users = getUsers();
            require('./app/view/users.php');
        } else {
            header('Location: index.php?action=home');
            exit;
        }
        break;  
    case 'editUser':
        if (isAdmin()) {
            $id = $_GET['id'];
            $user = getUserById($id);
            require './app/view/editUser.php'; 
        } else {
            header('Location: index.php?action=home');
            exit;
        }
        break; 
    case 'archives':
        $posts = getAllPosts();
        require('./app/view/archives.php');
        break;
    case 'post':
        $id = $_GET['id'];
        $post = getPostById($id);
        $comments = getComments($id);
        require('./app/view/post.php');
        break;
    case 'editComment':
        if (isAdmin()) {
            $id = $_GET['idComment'];
            $comment = getCommentById($id);
            require './app/view/editComment.php';
        } else {
            header('Location: index.php?action=home');
        }
    break;
    default:
        $posts = getLatestPosts();
        require('./app/view/home.php');
        break; 
}
?>

    <script src="script.js"></script>
</body>

</html>