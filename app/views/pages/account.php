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
        <div class="card w50">
            <h3>Create account</h3>
            <form method="post">
                <div class="w100">
                	<label>Your name *</label>
                	<input type="text" name="name" required>
                </div>
                <div class="w100">
                	<label>Your email *</label>
                	<input type="email" name="email" required>
                </div>
                <div class="w100">
                	<label>Your password *</label>
                	<input type="password" name="password" minlength="8" required>
                </div>
                <div class="w100">
                	<button type="submit" name="register">Create account</button>
                </div>
            </form>
        </div>

        <div class="card w50">
            <h3>Login</h3>
            <form method="post">
                <div class="w100">
                	<label>Your email *</label>
                	<input type="email" name="email" required>
                </div>
                <div class="w100">
                	<label>Your password *</label>
                	<input type="password" name="password" minlength="8" required>
                </div>
                <div class="w100">
                	<button type="submit" name="login">Login</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
