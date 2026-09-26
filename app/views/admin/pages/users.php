<h1>Users (customers)</h1>
<table class="table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>
	<?php if (isset($users) && count($users) > 0): foreach ($users as $key => $value): ?>
		<tr>
			<td><?= $value['id'] ?></td>
			<td><?= htmlspecialchars($value['name']) ?></td>
			<td><?= htmlspecialchars($value['email']) ?></td>
			<td>
				<a href="/admin/users.php?view=<?= $value['id'] ?>">View</a>
				<a href="/admin/users.php?edit=<?= $value['id'] ?>">Edit</a>
				<a href="/admin/users.php?delete=<?= $value['id'] ?>">Delete</a>
			</td>
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
</table>
