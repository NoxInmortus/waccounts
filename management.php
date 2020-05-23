<?php
// Includes
require_once("include/includes.php");
HeaderPage();

/////////////////////////////////////////////////////////
/////////// Password reset action for my user ///////////
/////////////////////////////////////////////////////////
if ($_POST['action'] == 'pwdreset' ?? null)
{
  $password = htmlspecialchars($_POST['pwdreset']);

  try
  {
    // UPDATE password entry
    $pwdreset_req = $databaseRealmd->prepare("UPDATE account SET sha_pass_hash = UPPER(SHA1(CONCAT(UPPER(:username),':',UPPER(:password)))), v='', s='' WHERE id = :id;");
    $pwdreset_req->execute(['username' => $_SESSION['login'],'password' => $password,'id' => $_SESSION['id']]);
    $pwdreset_req->closeCursor();
  }

  catch(Exception $error)
  {
    logadd($error);
    die('Error : '.$error->getMessage());
  }

  $_SESSION['message'] = "Password edited.";
	logadd($_SESSION['message']);
}

//////////////////////////////////////////////////////////////
/////////// Password reset action for another user ///////////
//////////////////////////////////////////////////////////////
if ($_POST['action'] == 'pwdresetother' ?? null)
{

  $account = htmlspecialchars($_POST['accountlogin']);
  $password = htmlspecialchars($_POST['pwdreset']);

  try
  {
    // UPDATE another account password entry
		$pwdreset_req = $databaseRealmd->prepare("UPDATE account SET sha_pass_hash = UPPER(SHA1(CONCAT(UPPER(:username),':',UPPER(:password)))), v='', s='' WHERE username = :username;");
		$pwdreset_req->execute(['username' => $account,'password' => $password]);
    $pwdreset_req->closeCursor();
  }

  catch(Exception $error)
  {
    logadd($error);
    die('Error : '.$error->getMessage());
  }

	$_SESSION['message'] = "Password edited.";
	logadd($_POST['accountlogin']." : ".$_SESSION['message']);
}

////////////////////////////////////
/////////// New account ///////////
//////////////////////////////////
if ($_POST['action'] == 'newaccount' ?? null)
{
  if(isset($_POST['newaccountlogin']) && isset($_POST['newaccountpwd']) && isset($_POST['newaccountpwd2']))
  {
    if ($_POST['newaccountpwd'] == $_POST['newaccountpwd2'])
    {
      try
      {
        $account = htmlspecialchars($_POST['newaccountlogin']);
        $password = htmlspecialchars($_POST['newaccountpwd']);

        // INSERT New account entry
    		$pwdreset_req = $databaseRealmd->prepare("INSERT INTO account (username,sha_pass_hash,expansion,os) VALUES (:username, UPPER(SHA1(CONCAT(UPPER(:username),':',UPPER(:password)))),1,'Win');");
    		$pwdreset_req->execute(['username' => $account,'password' => $password]);
        $pwdreset_req->closeCursor();
      }

      catch(Exception $error)
      {
        logadd($error);
        die('Error : '.$error->getMessage());
      }

      $_SESSION['message'] = "Account created";
    	logadd($_SESSION['message']." : ".$_POST['newaccountlogin']);
    }
    else
    {
      $_SESSION['message'] = "Register account failed, passwords does not match.";
    }
  }
  else
  {
    $_SESSION['message'] = "Register account failed, something is missing !";
  }
}

///////////////////////////////////////
/////////// Delete Account ///////////
/////////////////////////////////////
if ($_POST['action'] == 'deleteUser' ?? null)
{
  if (isset($_POST['accountlogin']))
  {
    try
    {
      $account = htmlspecialchars($_POST['accountlogin']);

      // Delete account entry
  		$deleteUser_req = $databaseRealmd->prepare("DELETE from account WHERE username = :username;");
  		$deleteUser_req->execute(['username' => $account]);
      $deleteUser_req->closeCursor();
    }

    catch(Exception $error)
    {
      logadd($error);
      die('Error : '.$error->getMessage());
    }

    $_SESSION['message'] = "Account ".$_POST['accountlogin']." deleted.";
  	logadd($_SESSION['message']);
  }
  else
  {
    $_SESSION['message'] = "Delete account failed, no account specified. Please contact an administrator if it occurs again.";
  }
}

/////////////////////////////////////////////////////////
/////////// Edit Account GM Level ///////////////////////
/////////////////////////////////////////////////////////
if ($_GET['action'] == 'EditAccountGmLevel' ?? null)
{
  $gmlevel = htmlspecialchars($_GET['level']);
  $id = htmlspecialchars($_GET['id']);

  try
  {
    // UPDATE password entry
    $editgmlevel_req = $databaseRealmd->prepare("UPDATE account SET gmlevel = :gmlevel WHERE id = :id;");
    $editgmlevel_req->execute(['gmlevel' => $gmlevel,'id' => $id]);
    $editgmlevel_req->closeCursor();
  }

  catch(Exception $error)
  {
    logadd($error);
    die('Error : '.$error->getMessage());
  }

	$_SESSION['message'] = "Account GM level edited.";
	logadd($_SESSION['message']);
}
// Redirect to Index
header("Location:index.php");

?>
