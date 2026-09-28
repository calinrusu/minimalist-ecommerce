<?php
require_once __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if (!is_valid_email($email)) {
    	setFlashMessage('Your email address is not valid!');
    	header('Location: /account.php');
    	exit;
    }
    if (empty($name)) {
    	setFlashMessage('Your name is required!');
    	header('Location: /account.php');
    	exit;
    }
    if (strlen($password) < 8) {
    	setFlashMessage('Your password is too short, 8 characters minimum!');
    	header('Location: /account.php');
    	exit;
    }
    $users = loadUsersList();
    $userExists = 0;
    foreach ($users as $key => $value) {
    	if ($value['email'] === $email) {
    		$userExists += 1;
    	}
    }
    if ($userExists > 0) {
    	setFlashMessage('The email address (' . $email . ') is already registered!');
    	header('Location: /account.php');
    	exit;
    }

    $nextId = count($users) + 1;
    $users[] = [
    	'id' => $nextId,
    	'name' => $name,
    	'email' => $email,
    	'password' => $password
    ];
    file_put_contents(DB_PATH . '/users.json', json_encode($users));
    setFlashMessage('Thank you for registering, use the login form to authenticate!');
    header('Location: /account.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $users = loadUsersList();
    $userExists = 0;
    $passwordMatches = 0;
    $userId = 0;
    foreach ($users as $key => $value) {
    	if ($value['email'] === $email) {
    		$userExists++;
    		if ($value['password'] === $password) {
    			$passwordMatches++;
    			$userId += (int) $value['id'];
    		}
    	}
    }
    if ($userExists < 1) {
    	setFlashMessage('The email address (' . htmlspecialchars($email) . ') is not registered!');
    	header('Location: /account.php');
    	exit;
    }
    if ($passwordMatches < 1) {
    	setFlashMessage('The password is not correct!');
    	header('Location: /account.php');
    	exit;
    }
    loginUser($userId);
    setFlashMessage('Welcome back!');
    header('Location: /account.php');
    exit;
}

if (isset($_GET['logout'])) {
    unset($_SESSION['customer']);
    setFlashMessage('You have been logged out.');
    header('Location: account.php');
    exit;
}

$customer = getUserById((int) $_SESSION['customer']);

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/pages/account.php';
require APP_PATH . '/views/layouts/footer.php';
