<?php
require_once __DIR__ . '/../app/bootstrap.php';

$productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product = $productId > 0 ? getProductById($productId) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
    if ($product) {
        addToCart($product['id'], $quantity);
        setFlashMessage('Product added to cart.');
        header('Location: product.php?id=' . $product['id']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review']) && $product) {
    $author = trim($_POST['author'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $rating = max(1, min(5, (int) ($_POST['rating'] ?? 5)));

    if ($author !== '' && $comment !== '') {
        addReview((int) $product['id'], $author, $comment, $rating);
        setFlashMessage('Review submitted successfully.');
        header('Location: product.php?id=' . $product['id']);
        exit;
    }

    setFlashMessage('Please enter your name and review text.');
}

$reviews = $product ? getReviewsForProduct((int) $product['id']) : [];

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/pages/product.php';
require APP_PATH . '/views/layouts/footer.php';
