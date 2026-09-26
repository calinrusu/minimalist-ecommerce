<?php

require_once dirname(__DIR__) . '/../app/bootstrap.php';

if (!isAdminLoggedIn()) {
    header('Location: /admin/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	

}

$users = loadUsersList();

require APP_PATH . '/views/admin/layouts/header.php';
require APP_PATH . '/views/admin/pages/users.php';
require APP_PATH . '/views/admin/layouts/footer.php';
