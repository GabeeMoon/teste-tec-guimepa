<?php
session_start();

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PostController.php';

$authController = new AuthController($pdo);
$postController = new PostController($pdo);

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register($_POST['name'], $_POST['email'], $_POST['password']);
            header('Location: ?page=login');
            exit;
        }
        include __DIR__ . '/../app/views/auth/register.php';
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $authController->login($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: ?page=posts');
                exit;
            } else {
                $error = "Usuário ou senha inválidos.";
            }
        }
        include __DIR__ . '/../app/views/auth/login.php';
        break;

    case 'logout':
        session_destroy();
        header('Location: ?page=login');
        exit;

    case 'posts':
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postController->create($_POST['title'], $_POST['content'], $_SESSION['user']['id']);
            header('Location: ?page=posts');
            exit;
        }

        $posts = $postController->getAll();
        include __DIR__ . '/../app/views/posts/index.php';
        break;

    case 'show':
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=login');
            exit;
        }

        $post = $postController->getById($_GET['id']);
        include __DIR__ . '/../app/views/posts/show.php';
        break;

    case 'edit':
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postController->update($_GET['id'], $_POST['title'], $_POST['content'], $_SESSION['user']['id']);
            header('Location: ?page=posts');
            exit;
        }

        $post = $postController->getById($_GET['id']);
        include __DIR__ . '/../app/views/posts/edit.php';
        break;

    case 'delete':
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=login');
            exit;
        }

        $postController->delete($_GET['id'], $_SESSION['user']['id']);
        header('Location: ?page=posts');
        exit;

    default:
        header('Location: ?page=login');
        exit;
}
