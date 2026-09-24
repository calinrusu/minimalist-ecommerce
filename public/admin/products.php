<?php

require_once dirname(__DIR__) . '/../app/bootstrap.php';

if (!isAdminLoggedIn()) {
    header('Location: /admin/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['add'])) {
		$name = htmlspecialchars(trim($_POST['name']));
		$category = htmlspecialchars(trim($_POST['category']));
		$price = (float) $_POST['price'];
		$description = htmlspecialchars(trim($_POST['description']));
		if (!isset($_FILES['img']['name']) || $_FILES['img']['error'] > 0 || $_FILES['img']['type'] !== 'image/jpeg') {
			setFlashMessage('Image is required, no errors, only jpeg!');
			header('Location: /admin/products.php');
			exit;
		}
		$image = '/assets/images/' . preg_replace('/[^a-z0-9]/', '', strtolower($name)) . '.jpeg';
		move_uploaded_file($_FILES['img']['tmp_name'], BASE_PATH . '/public' . $image);
		createProductInStorage($name, $category, $price, $description, $image);
		setFlashMessage('Product created!');
	}
	if (isset($_POST['update'])) {
		$id = (int) $_POST['update'];
		$product = getProductById($id);
		$data = [
			'name' => htmlspecialchars(trim($_POST['name'])),
			'category' => htmlspecialchars(trim($_POST['category'])),
			'price' => (float) $_POST['price'],
			'description' => htmlspecialchars(trim($_POST['description']))
		];
		if (isset($_FILES['img']['name']) && $_FILES['img']['error'] === 0 && $_FILES['img']['type'] === 'image/jpeg') {
			$data['image'] = '/assets/images/' . preg_replace('/[^a-z0-9]/', '', strtolower($data['name'])) . '-' . $id . '.jpeg';
			move_uploaded_file($_FILES['img']['tmp_name'], BASE_PATH . '/public' . $data['image']);
		} else {
			$data['image'] = $product['image'];
		}
		updateProductInStorage($id, $data);
		setFlashMessage('Product updated!');
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

	$productId = isset($_GET['delete']) ? (int) $_GET['delete'] : 0;
	$product = getProductById($productId);
	if (file_exists(BASE_PATH . '/public/' . $product['image'])) {
		@unlink(BASE_PATH . '/public/' . $product['image']);
	}
	deleteProductFromStorage($productId);
	setFlashMessage('Product deleted!');
	header('Location: /admin/products.php');
	exit;

} else {

	$products = loadStore();
	require APP_PATH . '/views/admin/pages/products.php';	

}

require APP_PATH . '/views/admin/layouts/footer.php';
