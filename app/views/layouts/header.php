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
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="container flex">
        <nav>
            <a href="/"><?= SHOP_NAME ?></a>
            <a href="/">Products</a>
            <a href="/cart.php">Cart</a>
            <a href="/account.php">Account</a>
        </nav>
        <form class="search-form" method="get" action="/">
            <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Search products">
            <button type="submit">Search</button>
        </form>
    </div>
</header>
<main class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['flash']); ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
