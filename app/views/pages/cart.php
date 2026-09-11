<?php
// app/views/pages/cart.php
?>
<h2>Your cart</h2>
<?php if (empty($summary['items'])): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Line total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summary['items'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="0" style="width: 90px;"></td>
                        <td>$<?php echo number_format($item['line_total'], 2); ?></td>
                        <td><a class="btn btn-secondary" href="cart.php?remove=<?php echo $item['id']; ?>">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Subtotal: $<?php echo number_format($summary['total'], 2); ?></strong></p>
        <?php if ($coupon !== ''): ?>
            <p><strong>Coupon:</strong> <?php echo htmlspecialchars($coupon); ?> (-$<?php echo number_format($discountAmount, 2); ?>)</p>
        <?php endif; ?>
        <p><strong>Total: $<?php echo number_format($finalTotal, 2); ?></strong></p>
        <form method="post" class="inline-form" style="margin-top: 0.6rem;">
            <input type="text" name="coupon_code" placeholder="Coupon code" value="<?php echo htmlspecialchars($coupon); ?>">
            <button type="submit" name="apply_coupon">Apply coupon</button>
        </form>
        <div class="filter-row">
            <button type="submit" name="update_cart">Update cart</button>
            <a class="btn" href="checkout.php">Checkout</a>
        </div>
    </form>
<?php endif; ?>
