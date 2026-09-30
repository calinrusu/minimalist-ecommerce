<?php if (!isAdminLoggedIn()) { ?>
<div class="grid">
    <div class="card mt3 w50">
        <h3>Login</h3>
        <form method="post" class="admin-form">
            <input type="hidden" name="submit" value="1">
            <input type="email" name="email" class="mt3" placeholder="Email" required>
            <input type="password" name="password" class="mt3" placeholder="Password" required>
            <button type="submit" class="mt3" name="login">Login</button>
        </form>
    </div>
</div>
<?php } ?>
