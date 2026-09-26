<h1>Product details <?= $productId ?></h1>
<div class="product-detail">
	<img src="/assets/images/<?php echo htmlspecialchars($product['image'] ?? 'placeholder.svg'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image large">
    <div>
        <h2>Name: <?php echo htmlspecialchars($product['name']); ?></h2>
        <p>Description: <?php echo htmlspecialchars($product['description']); ?></p>
        <p>Price: <strong>$<?php echo number_format((float) $product['price'], 2); ?></strong></p>
        <p>Available quantity: <strong><?= (int) $product['qty'] ?> pcs.</strong></p>
        <p class="text-center">
        	<a href="/admin/products.php?edit=<?= $product['id'] ?>">Edit</a>
        	<a href="/admin/products.php?delete=<?= $product['id'] ?>">Delete</a>
        </p>
    </div>
</div>
