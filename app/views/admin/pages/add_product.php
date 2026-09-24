<div class="container">
	<h1 class="text-center">Add new product</h1>
	<div class="w50">
		<form class="form" method="post" action="/admin/products.php" enctype="multipart/form-data">
			<input type="hidden" name="add">
			<div class="form-input">
				<label>Product name *</label>
				<input type="text" name="name" required maxlength="255">
			</div>
			<div class="form-input">
				<label>Product category *</label>
				<input type="text" name="category" required maxlength="255">
			</div>
			<div class="form-input">
				<label>Product description *</label>
				<textarea name="description" required rows="5"></textarea>
			</div>
			<div class="form-input">
				<label>Product price *</label>
				<input type="number" name="price" required min="0.01" step="0.01">
			</div>
			<div class="form-input">
				<label>Image *</label>
				<input type="file" name="img" required accept="image/jpeg">
			</div>
			<div class="submit">
				<input type="submit" class="btn w100" value="Add">
			</div>
		</form>
	</div>
</div>
