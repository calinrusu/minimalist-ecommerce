<?php
// app/views/pages/account.php
?>
<h2>Customer account</h2>
<?php if ($loggedIn && $customer): ?>
    <div class="card">
        <h3>Welcome, <?php echo htmlspecialchars($customer['name']); ?></h3>
        <p>Email: <?php echo htmlspecialchars($customer['email']); ?></p>
        <p><a class="btn" href="account.php?logout=1">Log out</a></p>
    </div>
    <div class="card" style="margin-top: 1rem;">
        <h3>Wishlist</h3>
        <?php $wishlistItems = getWishlistItems(); ?>
        <?php if (empty($wishlistItems)): ?>
            <p>Your wishlist is empty.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($wishlistItems as $item): ?>
                    <li><?php echo htmlspecialchars($item['name']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="grid">
        <div class="card">
            <h3>Create account</h3>
            <form method="post" class="admin-form">
                <input type="text" name="name" placeholder="Your name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Create account</button>
            </form>
        </div>
        <div class="card">
            <h3>Login</h3>
            <form method="post" class="admin-form">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
<?php endif; ?>
