<h1>Products</h1>
<div class="text-end mt3">
	<a href="/admin/products.php?add">Add product</a>
</div>
<table class="table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Category</th>
			<th>Price</th>
			<th>Qty.</th>
			<th>Description</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>
	<?php if (isset($products) && count($products) > 0): foreach ($products as $key => $value): ?>
		<tr>
			<td><?= $value['id'] ?></td>
			<td><?= htmlspecialchars($value['name']) ?></td>
			<td><?= htmlspecialchars($value['category']) ?></td>
			<td><?= (float) $value['price'] ?></td>
			<td><?= (int) $value['qty'] ?></td>
			<td><?= substr(htmlspecialchars($value['description']), 0, 100) ?> ...</td>
			<td>
				<a href="/admin/products.php?view=<?= $value['id'] ?>">View</a>
				<a href="/admin/products.php?edit=<?= $value['id'] ?>">Edit</a>
				<a href="/admin/products.php?delete=<?= $value['id'] ?>">Delete</a>
			</td>
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
</table>
