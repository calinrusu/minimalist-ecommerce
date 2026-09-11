<?php
require_once __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = (int) ($_POST['product_id'] ?? 0);
    $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

    if ($productId > 0 && getProductById($productId)) {
        addToCart($productId, $quantity);
        setFlashMessage('Product added to cart.');
        header('Location: index.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $productId = (int) ($_POST['product_id'] ?? 0);
    if ($productId > 0 && getProductById($productId)) {
        addToWishlist($productId);
        setFlashMessage('Product added to wishlist.');
        header('Location: index.php');
        exit;
    }
}

$searchTerm = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$products = searchCatalog($searchTerm, $category);

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/pages/home.php';
require APP_PATH . '/views/layouts/footer.php';
