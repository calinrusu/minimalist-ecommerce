<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= META_TITLE ?></title>
    <meta name="description" content="<?= META_DESCRIPTION ?>">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<?php if (isAdminLoggedIn()) { ?>
<header class="site-header">
    <div class="container">
        <nav>
            <a href="/admin">Admin</a>
            <a href="/admin/products.php">Products</a>
            <a href="/admin/users.php">Users</a>
            <a href="/admin/orders.php">Orders</a>
            <a href="/admin/logout.php">Logout</a>
        </nav>
    </div>
</header>
<?php } ?>
<main class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert"><?php echo htmlspecialchars($_SESSION['flash']); ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
