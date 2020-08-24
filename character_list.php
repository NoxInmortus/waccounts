<?php

// Includes + header
require_once("include/includes.php");
headerPage();

// Check if user exist or is not admin and redirect to index
if(!isset($_SESSION['login']) || (!isset($_SESSION['gmlevel'])) || (!isset($_SESSION['id'])))
{
	header("Location:index.php");
}

// Get user list details
$characters = getCharacters($_SESSION['id'],$databaseCharacters);
?>

<div class="container">
	<div class="row align-items-center">
		<div class="col-9">
			<h1 class="display-4">Characters list</h1>
		</div>
	</div>

	<!-- Display array of users -->
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Level</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($characters as $character) { ?>
				<tr>
					<td><?= $character["name"] ?></td>
					<td><?= $character["level"] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<?php
	footer();
?>
