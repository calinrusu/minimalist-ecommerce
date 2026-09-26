<?php
// app/views/pages/home.php
?>
<h2>Featured products</h2>
<p>Browse the catalog, add items to your cart, and place an order quickly.</p>
<?php if (isset($categories) && count($categories) > 0): ?>
<div class="flex">
	<div class="mt3">
		<a class="btn btn-secondary" href="/">All</a>
		<?php foreach ($categories as $cat): ?>
			<a class="btn btn-secondary" href="/?category=<?= $cat ?>"><?= strtoupper($cat) ?></a>
		<?php endforeach; ?>
	</div>
	<div class="mt3">
        <form class="inline-form" method="get" action="/">
            <input type="text" name="search" class="w75" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Search products">
            <button type="submit" class="w25">Search</button>
        </form>
	</div>
</div>
<?php endif; ?>

<?php if (!empty($searchTerm) || !empty($category)): ?>
    <p>Showing results for: <strong><?php echo htmlspecialchars($searchTerm !== '' ? $searchTerm : $category); ?></strong></p>
<?php endif; ?>
<div class="flex mt3">
    <?php if (count($products) === 0): ?>
        <p>No products match your search.</p>
    <?php endif; ?>
    <?php foreach ($products as $product): ?>
        <div class="card product-card">
            <img src="<?php echo htmlspecialchars($product['image'] ?? 'placeholder.svg'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <h3><?= htmlspecialchars($product['name']); ?></h3>
            <p><?php if (strlen($product['description']) > 100) { echo substr(htmlspecialchars($product['description']), 0, 100) . ' ...'; } else { echo htmlspecialchars($product['description']); } ?></p>
            <p class="text-end">
            	<strong>$<?php echo number_format((float) $product['price'], 2); ?></strong>
            </p>
            <a class="btn btn-secondary" href="product.php?id=<?php echo (int) $product['id']; ?>">View details</a>
            <div class="flex mt3">
                <div class="w50">
                <form method="post" class="inline-form">
                    <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= (int) $product['qty'] ?>" style="width: 60px;">
                    <button type="submit" name="add_to_cart">Add to cart</button>
                </form>
                </div>
                <div class="w50">
                <form method="post" class="inline-form">
                    <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">
                    <button type="submit" name="add_to_wishlist">Add to wishlist</button>
                </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
