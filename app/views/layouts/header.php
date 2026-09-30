<?php
// app/views/layouts/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= META_TITLE ?></title>
    <meta name="description" content="<?= META_DESCRIPTION ?>">
    <style><?php echo str_replace(PHP_EOL, ' ', file_get_contents(BASE_PATH . '/public/assets/css/style.css')); ?></style>
</head>
<body>
<header class="site-header">
    <div class="container flex">
        <nav>
            <a href="/"><?= SHOP_NAME ?></a>
            <a href="/" title="Browse Products">Products</a>
            <a href="/cart.php" title="My Shopping cart">Cart</a>
            <a href="/account.php" title="My Account">Account</a>
            <?php if (isset($_SESSION['customer'])): ?>
            	<a href="/account.php?logout" title="Logout">Logout</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['flash']); ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
