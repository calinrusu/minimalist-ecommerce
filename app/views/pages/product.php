<?php
// app/views/pages/product.php
?>
<?php if (!$product): ?>
    <h2>Product not found</h2>
    <p>The requested product could not be found.</p>
<?php else: ?>
    <div class="product-detail">
        <img src="<?php echo htmlspecialchars($product['image'] ?? 'placeholder.svg'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image large">
        <div>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>$<?php echo number_format((float) $product['price'], 2); ?></strong></p>
            <form method="post" class="inline-form">
                <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
                <button type="submit" name="add_to_cart">Add to cart</button>
            </form>
        </div>
    </div>

    <div class="card" style="margin-top: 1rem;">
        <h3>Leave a review</h3>
        <form method="post" class="admin-form">
            <input type="text" name="author" placeholder="Your name" required>
            <select name="rating">
                <option value="5">5 stars</option>
                <option value="4">4 stars</option>
                <option value="3">3 stars</option>
                <option value="2">2 stars</option>
                <option value="1">1 star</option>
            </select>
            <textarea name="comment" placeholder="Write your review" required></textarea>
            <button type="submit" name="submit_review">Submit review</button>
        </form>
    </div>

    <div class="card" style="margin-top: 1rem;">
        <h3>Customer reviews</h3>
        <?php if (empty($reviews)): ?>
            <p>No reviews yet. Be the first to share your experience.</p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <strong><?php echo htmlspecialchars($review['author']); ?></strong>
                    <span> - <?php echo str_repeat('★', (int) ($review['rating'] ?? 5)); ?><?php echo str_repeat('☆', 5 - (int) ($review['rating'] ?? 5)); ?></span>
                    <p><?php echo htmlspecialchars($review['comment']); ?></p>
                    <small><?php echo htmlspecialchars($review['created_at']); ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
