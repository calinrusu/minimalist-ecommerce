<?php

require_once dirname(__DIR__) . '/../app/bootstrap.php';

if (!isAdminLoggedIn()) {
    header('Location: /admin/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
}

$orders = loadOrders();

require APP_PATH . '/views/admin/layouts/header.php';
if (isset($_GET['view']) && (int) $_GET['view'] > 0) {
	$orderId = (int) $_GET['view'];
	$order = getOrderById($orderId);
	require APP_PATH . '/views/admin/pages/view_order.php';
} elseif (isset($_GET['edit']) && (int) $_GET['edit'] > 0) {
	$orderId = (int) $_GET['edit'];
	$order = getOrderById($orderId);
	require APP_PATH . '/views/admin/pages/edit_order.php';	
} else {
	require APP_PATH . '/views/admin/pages/orders.php';
}
require APP_PATH . '/views/admin/layouts/footer.php';
