<?php
require_once __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name !== '' && $email !== '' && $password !== '') {
        $_SESSION['customer'] = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];
        setFlashMessage('Account created successfully.');
        header('Location: account.php');
        exit;
    }

    setFlashMessage('Please complete all fields.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $customer = $_SESSION['customer'] ?? null;
    if ($customer && $customer['email'] === $email && $customer['password'] === $password) {
        $customer['logged_in'] = true;
        $_SESSION['customer'] = $customer;
        setFlashMessage('Welcome back.');
        header('Location: account.php');
        exit;
    }

    setFlashMessage('Invalid email or password.');
}

if (isset($_GET['logout'])) {
    unset($_SESSION['customer']);
    setFlashMessage('You have been logged out.');
    header('Location: account.php');
    exit;
}

$customer = $_SESSION['customer'] ?? null;
$loggedIn = !empty($customer['logged_in']);

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/pages/account.php';
require APP_PATH . '/views/layouts/footer.php';
