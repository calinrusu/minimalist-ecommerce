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

require APP_PATH . '/views/admin/layouts/header.php';

if (isset($_GET['add'])) {

	require_once APP_PATH . '/views/admin/pages/add_product.php';

} elseif (isset($_GET['view'])) {

	$productId = isset($_GET['view']) ? (int) $_GET['view'] : 0;
	$product = getProductById($productId);
	require_once APP_PATH . '/views/admin/pages/view_product.php';

} elseif (isset($_GET['edit'])) {

	$productId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
	$product = getProductById($productId);
	require_once APP_PATH . '/views/admin/pages/edit_product.php';

} elseif (isset($_GET['delete'])) {

	$productId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;

} else {

	$products = loadStore();
	require APP_PATH . '/views/admin/pages/products.php';	

}

require APP_PATH . '/views/admin/layouts/footer.php';
