<?php
// Header Page
function headerPage()
{
	// User session
	if (session_status() !== PHP_SESSION_ACTIVE)
	{
		session_start();
	}
?>

<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Imperium Waccounts</title>
		<!-- Bootstrap & css stuff -->
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<link rel="stylesheet" href="style/css/style.css" >
  </head>

  <body>
		<nav class="navbar navbar-dark bg-dark">
			<span class="navbar-text mx-auto">
				<a class="navbar-brand" href="index.php">World of Warcraft - Accounts</a>
			</span>
		</nav>

	<!-- Logo -->
	<center><img src="style/img/imperium_alternative.png" style="height:15%; width:15%"></center>

	<!-- Navigation bar -->
	<?php
	if(isset($_SESSION['login']))
	{
		?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Index</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="character_list.php">Characters</a>
					</li>
					<?php if($_SESSION['gmlevel'] == 3) { ?>
						<li class="nav-item">
							<a class="nav-link" href="account_list.php">Accounts</a>
						</li>
					<?php } ?>

				</ul>
				<ul class="navbar-nav navbar-right">

					<!-- Logout button -->
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Déconnexion</a>
					</li>

				</ul>
			  </div>
			</div>
		</nav>
	<?php
	}

	// Display $_SESSION['message']
	if(isset($_SESSION['message']))
	{
		?>
			<div class="alert alert-top alert-info alert-dismissible fade show" role="alert">
				<?php
					echo ($_SESSION['message']);
					unset($_SESSION['message']);
				?>
		  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button>
			</div>
		<?php
	}
}
?>
