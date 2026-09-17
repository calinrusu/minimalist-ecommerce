<?php

require_once dirname(__DIR__) . '/../app/bootstrap.php';

if (isAdminLoggedIn()) {
	header('Location: /admin/');
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['submit'])) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$admins = loadAdminList();
		foreach ($admins as $key => $value) {
			if ($value['username'] === $username && $value['password'] === $password) {
				break;
			}
			$_SESSION['is_admin'] = md5($username);
			setFlashMessage('Login successful!');
			header('Location: /admin/');
			exit;
		}
	}
}

require APP_PATH . '/views/admin/layouts/header.php';
require APP_PATH . '/views/admin/pages/login.php';
require APP_PATH . '/views/admin/layouts/footer.php';
