<?php

require_once dirname(__DIR__) . '/../app/bootstrap.php';

if (!isAdminLoggedIn()) {
    header('Location: /admin/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['add'])) {
		
	}
	if (isset($_POST['update'])) {
		
	}
	header('Location: /admin/products.php');
	exit;
}

$products = loadStore();

require APP_PATH . '/views/admin/layouts/header.php';

if (isset($_GET['add'])) {

	require_once APP_PATH . '/views/admin/pages/add_product.php';

} elseif (isset($_GET['edit'])) {

	$productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
	$product = getProductById($productId);
	require_once APP_PATH . '/views/admin/pages/edit_product.php';

} else {

	require APP_PATH . '/views/admin/pages/products.php';	

}

require APP_PATH . '/views/admin/layouts/footer.php';
