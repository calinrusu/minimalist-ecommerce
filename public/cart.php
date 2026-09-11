<?php
require_once __DIR__ . '/../app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        updateCartQuantity((int) $productId, (int) $quantity);
    }
    setFlashMessage('Cart updated.');
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['remove'])) {
    removeFromCart((int) $_GET['remove']);
    setFlashMessage('Item removed.');
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_coupon'])) {
    $coupon = trim($_POST['coupon_code'] ?? '');
    $discount = applyCoupon($coupon);
    if ($discount > 0) {
        setFlashMessage('Coupon applied successfully.');
    } else {
        $_SESSION['coupon'] = '';
        setFlashMessage('Coupon code is invalid.');
    }
    header('Location: cart.php');
    exit;
}

$summary = getCartSummary();
$coupon = getAppliedCoupon();
$discountAmount = getDiscountAmount($summary['total']);
$finalTotal = getFinalTotal($summary['total']);

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/pages/cart.php';
require APP_PATH . '/views/layouts/footer.php';
