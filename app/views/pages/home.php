<?php
// app/views/pages/home.php
?>
<h2>Featured products</h2>
<p>Browse the catalog, add items to your cart, and place an order quickly.</p>
<div class="filter-row">
    <a class="btn btn-secondary" href="index.php">All</a>
    <a class="btn btn-secondary" href="index.php?category=Apparel">Apparel</a>
    <a class="btn btn-secondary" href="index.php?category=Accessories">Accessories</a>
    <a class="btn btn-secondary" href="index.php?category=Home">Home</a>
</div>
<?php var_export($products); if ($searchTerm !== '' || $category !== ''): ?>
    <p>Showing results for: <strong><?php echo htmlspecialchars($searchTerm !== '' ? $searchTerm : $category); ?></strong></p>
<?php endif; ?>
<div class="grid">
    <?php if (count($products) === 0): ?>
        <p>No products match your search.</p>
    <?php endif; ?>
    <?php foreach ($products as $product): ?>
        <div class="card product-card">
            <img src="assets/images/<?php echo htmlspecialchars($product['image'] ?? 'placeholder.svg'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>$<?php echo number_format((float) $product['price'], 2); ?></strong></p>
            <div class="product-actions">
                <a class="btn btn-secondary" href="product.php?id=<?php echo (int) $product['id']; ?>">View details</a>
                <form method="post" class="inline-form">
                    <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
                    <button type="submit" name="add_to_cart">Add to cart</button>
                </form>
                <form method="post" class="inline-form">
                    <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">
                    <button type="submit" name="add_to_wishlist">Add to wishlist</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
