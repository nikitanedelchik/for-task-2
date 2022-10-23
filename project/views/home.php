<a class="m-lg-2" href="/create">
	<button type="submit" name="show" class="btn btn-primary mt-4">Create user</button>
</a>
<div class="table container">
	<table class="table table-hover table-responsive table-bordered">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Gender</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
		<?php
		foreach ($model->users as $user):
			extract($user);
			?>
			<tr>
				<td><?= $id ?></td>
				<td><?= $name ?></td>
				<td><?= $email ?></td>
				<td><?= $gender ?></td>
				<td><?= $status ?></td>
				<td>
					<a href="/edit?id=<?= $id ?>" class="btn btn-info left-margin">
						<span class="glyphicon glyphicon-edit">Edit</span>
					</a>
					<a href="/delete?id=<?= $id ?>" class="btn btn-danger delete-object">
						<span class="glyphicon glyphicon-remove">Delete</span>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
<script src="/js/script.js"></script>
</body>
</html>