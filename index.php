<?php
// Includes
require_once("include/includes.php");
headerPage();

// Check for POST login & password
if (isset($_POST['login']) AND isset($_POST['password']))
{
  // Set Password string
  $password = strtoupper(sha1(strtoupper($_POST['login']).':'.strtoupper($_POST['password'])));

  // Get login and hashed password
  $login_req = $databaseRealmd->prepare('SELECT id,username,sha_pass_hash,gmlevel FROM account WHERE username = :login;');
  $login_req->execute(['login' => $_POST['login']]);
  $login_result = $login_req->fetch();
  $login_req->closeCursor();

  if ($login_result)
  {
    if ($password == $login_result['sha_pass_hash'])
    {
        session_start();
        $_SESSION['id'] = $login_result['id'];
        $_SESSION['login'] = $login_result['username'];
        $_SESSION['gmlevel'] = $login_result['gmlevel'];
        header('Location: index.php');
        logadd("User successfully connected.");
    }
    else
    {
        $_SESSION['message'] = "Login failed.";
        header('Location: index.php');
        logadd($_SESSION['message']." : ".$_POST['login']);
    }
  }

  else
  {
    $_SESSION['message'] = "An error occured. Bad login?";
    header('Location: index.php');
    logadd($_SESSION['message']." : ".$_POST['login']);
  }
}

// If user session is OFF then ask for login
else if(!isset($_SESSION['login']))
{
?>
  <div class="row">
    <div class="col-3">
    </div>
    	<div class="col-6">
    		<form action="index.php" method="post">

    		  <div class="form-group">
      			<label for="login">Nom d'utilisateur</label>
      			<input type="text" class="form-control" name="login" placeholder="Nom d'utilisateur">
    		  </div>

    		  <div class="form-group">
      			<label for="password">Mot de passe</label>
      			<input type="password" class="form-control" name="password" placeholder="*******">
    		  </div>

    		  <button type="submit" class="btn btn-primary float-right">Connexion</button>

    		</form>

        <?php if ($register_active == 'yes') { ?>
        <button type="button" class="btn btn-success my-2 my-sm-0 mr-2" data-toggle="modal" data-target="#register">
          Inscription
        </button>
        <?php } ?>

    	</div>
  	<div class="col-3">
    </div>
  </div>
<?php
}

// If user session is ON display available actions
else
{
?>
	<div class="jumbotron">
	  <h1 class="display-7">Waccounts - Imperium</h1>
	  <hr class="my-3">
		<p>
			Dedicated interface to manage World of Warcraft accounts of the Imperium servers.
		</p>
    <!-- Forms -->
    <div class="row">
      <!-- Edit my password form -->
      <div class="col-3">
        <form action="management.php" method="post">
          <div class="form-group">
            <label for="pwdreset">Reset password</label>
            <input type="password" class="form-control" name="pwdreset" placeholder="*******">
          </div>

          <input type="hidden" name="action" value="pwdreset"/>
          <button type="submit" class="btn btn-primary float-right">Edit my password</button>
        </form>
      </div>

      <?php
      // If user is admin display admin forms
      if ($_SESSION['gmlevel'] == 3)
      {
      ?>
        <!-- Edit another account password form -->
        <div class="col-3">
          <form action="management.php" method="post">
            <div class="form-group">
              <label for="accountlogin">Reset password</label>
              <input type="text" class="form-control" name="accountlogin" placeholder="login">
            </div>

            <div class="form-group">
              <label for="accountpwd">Password</label>
              <input type="password" class="form-control" name="accountpwd" placeholder="*******">
            </div>

            <input type="hidden" name="action" value="pwdresetother"/>
            <button type="submit" class="btn btn-primary float-right">Edit another account password</button>
          </form>
        </div>

        <!-- Create new account form -->
        <div class="col-3">
          <form action="management.php" method="post">
            <div class="form-group">
              <label for="newaccountlogin">New account</label>
              <input type="text" class="form-control" name="newaccountlogin" placeholder="login">
            </div>

            <div class="form-group">
              <label for="newaccountpwd">Password</label>
              <input type="password" class="form-control" name="newaccountpwd" placeholder="*******">
            </div>

            <div class="form-group">
              <label for="newaccountpwd2">Password Again</label>
              <input type="password" class="form-control" name="newaccountpwd2" placeholder="*******">
            </div>

            <input type="hidden" name="action" value="newaccount"/>
            <button type="submit" class="btn btn-primary float-right">Create new account</button>
          </form>
        </div>

        <!-- Delete account form -->
        <div class="col-3">
          <form action="management.php" method="post">
            <div class="form-group">
              <label for="accountlogin">Account</label>
              <input type="text" class="form-control" name="accountlogin" placeholder="login">
            </div>

            <input type="hidden" name="action" value="deleteUser"/>
            <button type="submit" onclick="return confirm('Delete Account ?');" class="btn btn-primary float-right">Delete Account</button>
          </form>
        </div>
      <?php
      }
      ?>
    </div>
<?php
}
  if ($register_active == 'yes') {
?>
  <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="management.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title">S'enregistrer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="newaccountlogin">Nom d'utilisateur</label>
              <input type="text" class="form-control" name="newaccountlogin" placeholder="Login" required>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="newaccountpwd">Mot de passe</label>
                  <input type="password" class="form-control" name="newaccountpwd" placeholder="*******" required>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="newaccountpwd2">Confirmation</label>
                  <input type="password" class="form-control" name="newaccountpwd2" placeholder="*******" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="action" value="newaccount"/>
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
  }
	footer();
?>
