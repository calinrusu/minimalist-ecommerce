<h1>Products</h1>
<div class="text-end mt3">
	<a href="/admin/products.php?add">Add product</a>
</div>
<table class="table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Price</th>
			<th>Description</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($products as $key => $value) { ?>
		<tr>
			<td><?= $value['id'] ?></td>
			<td><?= $value['name'] ?></td>
			<td><?= $value['price'] ?></td>
			<td><?= $value['description'] ?></td>
			<td>
				<a href="/admin/products.php?view=<?= $value['id'] ?>">View</a>
				<a href="/admin/products.php?edit=<?= $value['id'] ?>">Edit</a>
				<a href="/admin/products.php?delete=<?= $value['id'] ?>">Delete</a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
