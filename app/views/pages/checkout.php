<?php
// app/views/pages/checkout.php
?>
<h2>Checkout</h2>
<?php if (empty($summary['items'])): ?>
    <p>Your cart is empty. Add products before checkout.</p>
<?php else: ?>
    <p><strong>Total due:</strong> $<?php echo number_format($summary['total'], 2); ?></p>
    <form method="post">
        <label>Name</label><br>
        <input type="text" name="customer_name" required style="width: 100%; max-width: 320px; margin-bottom: 0.7rem;"><br>
        <label>Email</label><br>
        <input type="email" name="email" required style="width: 100%; max-width: 320px; margin-bottom: 0.7rem;"><br>
        <label>Address</label><br>
        <textarea name="address" required style="width: 100%; max-width: 320px; height: 100px;"></textarea><br>
        <label>Payment method</label><br>
        <select name="payment_method" style="width: 100%; max-width: 320px; margin-bottom: 0.7rem;">
            <option value="Card">Credit card</option>
            <option value="Cash">Cash on delivery</option>
        </select><br>
        <label>Card holder</label><br>
        <input type="text" name="card_holder" style="width: 100%; max-width: 320px; margin-bottom: 0.7rem;"><br>
        <label>Card number</label><br>
        <input type="text" name="card_number" placeholder="4242 4242 4242 4242" style="width: 100%; max-width: 320px; margin-bottom: 0.7rem;"><br><br>
        <button type="submit" name="place_order">Place order</button>
    </form>
<?php endif; ?>
