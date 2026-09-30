<?php
// /app/views/admin/pages/view_order.php
?>
<h3>Order details</h3>
<table class="table-bordered">
	<tbody>
		<tr><td>Date and time</td><td><?= $order['created_at'] ?></td></tr>
		<tr><td>Order status</td><td><?= $order['status'] ?></td></tr>
		<tr><td>Order total</td><td><?= number_format($order['total'], 2) ?></td></tr>
		<tr><td>Customer name</td><td><?= $order['customer_name'] ?></td></tr>
		<tr><td>Customer email</td><td><?= $order['email'] ?></td></tr>
		<tr><td>Customer address</td><td><?= $order['address'] ?></td></tr>
	</tbody>
</table>
<h3>Items</h3>
<table class="table-bordered">
	<thead>
		<tr>
			<th>Item ID</th>
			<th>Item name</th>
			<th>Unit price</th>
			<th>Quantity</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($order['items'] as $item): ?>
		<tr>
			<td><?= (int) $item['id'] ?></td>
			<td><?= htmlspecialchars($item['name']) ?></td>
			<td><?= (float) $item['price'] ?></td>
			<td><?= (int) $item['quantity'] ?></td>
			<td><?= (float) $item['line_total'] ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
