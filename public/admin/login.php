<?php
require_once dirname(__DIR__) . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
}

require APP_PATH . '/views/admin/layouts/header.php';
require APP_PATH . '/views/admin/pages/login.php';
require APP_PATH . '/views/admin/layouts/footer.php';
