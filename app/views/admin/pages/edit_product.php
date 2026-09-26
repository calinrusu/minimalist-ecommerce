<div class="container">
	<h1 class="text-center">Edit product</h1>
	<div class="w50">
		<form class="form w-100" method="post" action="/admin/products.php" enctype="multipart/form-data">
			<input type="hidden" name="update" value="<?= $product['id'] ?>">
			<div class="form-input">
				<label>Product name *</label>
				<input type="text" name="name" required maxlength="255" value="<?= htmlspecialchars($product['name']) ?>">
			</div>
			<div class="form-input">
				<label>Product category *</label>
				<input type="text" name="category" required maxlength="255" value="<?= htmlspecialchars($product['category']) ?>">
			</div>
			<div class="form-input">
				<label>Product description *</label>
				<textarea name="description" required rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
			</div>
			<div class="form-input">
				<label>Product price *</label>
				<input type="number" name="price" required min="0.01" step="0.01" value="<?= (float) $product['price'] ?>">
			</div>
			<div class="form-input">
				<label>Available qty. *</label>
				<input type="number" name="qty" required min="1" step="1" value="<?= (int) $product['qty'] ?>">
			</div>
			<div class="img">
				<img src="<?= $product['image'] ?>" style="width:320px;height:320px;object-fit:cover;margin:auto;">
			</div>
			<div class="form-input">
				<label>New image (if selected it will replace existing - jpeg only)</label>
				<input type="file" name="img" accept="image/jpeg">
			</div>
			<div class="submit">
				<input type="submit" class="btn w100" value="Update">
			</div>
		</form>
	</div>
</div>
