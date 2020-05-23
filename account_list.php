<?php

// Includes + header
require_once("include/includes.php");
headerPage();

// Check if user exist or is not admin and redirect to index
if(!isset($_SESSION['login']) || (!isset($_SESSION['gmlevel']) || $_SESSION['gmlevel'] != 3))
{
	header("Location:index.php");
}

// Get user list details
$users = getUsers($databaseRealmd);
?>

<div class="container">
	<div class="row align-items-center">
		<div class="col-9">
			<h1 class="display-4">Account list</h1>
		</div>
	</div>

	<!-- Display array of users -->
	<table class="table">
		<thead>
			<tr>
				<th>Username</th>
				<th>Gmlevel</th>
				<th>Failed logins</th>
			</tr>
		</thead>
		<tbody>
			<?php	foreach ($users as $user)	{	?>
				<tr>
					<td><?= $user["username"] ?></td>
					<td><?= $user["gmlevel"] ?></td>
					<td><?= $user["failed_logins"] ?></td>
					<td> 
						<?php if ($user["gmlevel"] < 3) { ?>
						<a class="mx-auto btn btn-primary btn-sm" onclick="return confirm('Upgrade <?=$user['username']?> ?');" href="management.php?action=EditAccountGmLevel&id=<?= $user['id'] ?>&level=<?= $user["gmlevel"] + 1 ?>" role="button">Upgrade</a> 
						<?php } if ($user["gmlevel"] > 0) { ?>
						<a class="mx-auto btn btn-warning btn-sm" onclick="return confirm('Downgrade <?=$user['username']?> ?');" href="management.php?action=EditAccountGmLevel&id=<?= $user['id'] ?>&level=<?= $user["gmlevel"] - 1 ?>" role="button">Downgrade</a> <?php } ?>
					</td>
				</tr>
			<?php	}	?>
		</tbody>
	</table>
</div>

<?php
	footer();
?>
