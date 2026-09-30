<?php
// /app/views/admin/pages/orders.php
?>
<h1>Orders</h1>
<table class="table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Customer name</th>
			<th>Customer email</th>
			<th>Customer address</th>
			<th>Order total</th>
			<th>Order status</th>
			<th>Order datetime</th>
			<th>Items</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>
	<?php if (isset($orders) && count($orders) > 0): foreach ($orders as $key => $value): ?>
		<tr>
			<td><?= $value['id'] ?></td>
			<td><?= htmlspecialchars($value['customer_name']) ?></td>
			<td><?= htmlspecialchars($value['email']) ?></td>
			<td><?= htmlspecialchars($value['address']) ?></td>
			<td><?= (float) $value['total'] ?></td>
			<td><?= $value['status'] ?></td>
			<td><?= $value['created_at'] ?></td>
			<td>
				<?php foreach ($value['items'] as $item) { echo htmlspecialchars($item['name']) . ' x ' . $item['quantity'] . ' pcs.<br>'; } ?>
			</td>
			<td>
				<a href="/admin/orders.php?view=<?= $value['id'] ?>">View</a>
				<a href="/admin/orders.php?edit=<?= $value['id'] ?>">Edit</a>
				<a href="/admin/orders.php?delete=<?= $value['id'] ?>">Delete</a>
			</td>
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
</table>
