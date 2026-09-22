<div class="container">
	<h1 class="text-center">Edit product</h1>
	<div class="w50">
		<form class="form w-100" method="post" action="/admin/products.php">
			<input type="hidden" name="update" value="<?= $product['id'] ?>">
			<div class="form-input">
				<label>Product name *</label>
				<input type="text" name="name" required maxlength="255" value="<?= $product['name'] ?>">
			</div>
			<div class="form-input">
				<label>Product category *</label>
				<input type="text" name="category" required maxlength="255" value="<?= $product['category'] ?>">
			</div>
			<div class="form-input">
				<label>Product description *</label>
				<textarea name="description" required rows="5"><?= $product['description'] ?></textarea>
			</div>
			<div class="form-input">
				<label>Product price *</label>
				<input type="number" name="price" required min="0.01" step="0.01" value="<?= $product['price'] ?>">
			</div>
			<div class="submit">
				<input type="submit" class="btn w100" value="Update">
			</div>
		</form>
	</div>
</div>
