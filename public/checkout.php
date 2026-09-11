<?php
require_once __DIR__ . '/../app/bootstrap.php';

$summary = getCartSummary();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $customerName = trim($_POST['customer_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($customerName !== '' && $email !== '' && $address !== '' && !empty($summary['items'])) {
        $orderId = createOrder($customerName, $email, $address);
        clearCart();
        setFlashMessage('Order placed successfully. Order ID: #' . $orderId . ' Payment placeholder accepted.');
        header('Location: orders.php');
        exit;
    }

    setFlashMessage('Please provide your name, email, and address.');
}

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/pages/checkout.php';
require APP_PATH . '/views/layouts/footer.php';
