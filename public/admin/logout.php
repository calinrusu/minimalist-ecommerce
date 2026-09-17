<?php

require_once dirname(__DIR__) . '/../app/bootstrap.php';

if (!isAdminLoggedIn()) {
	header('Location: /admin/login.php');
	exit;	
}

unset($_SESSION['is_admin']);
setFlashMessage('Your session ended!');
header('Location: /admin/login.php');
exit;
