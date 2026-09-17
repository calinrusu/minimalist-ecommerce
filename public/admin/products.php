<?php

require_once dirname(__DIR__) . '/../app/bootstrap.php';

if (!isAdminLoggedIn()) {
    header('Location: /admin/login.php');
    exit;
}

require APP_PATH . '/views/admin/layouts/header.php';
require APP_PATH . '/views/admin/pages/products.php';
require APP_PATH . '/views/admin/layouts/footer.php';
