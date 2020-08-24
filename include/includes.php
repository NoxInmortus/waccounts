<?php

	// PHP ini force display errors
	ini_set('display_errors', 1);

	// Include files
	require_once("header.php");
	require_once("footer.php");
	require_once("config.php");
	require_once("logger.php");

	// Databases connection details
	$databaseRealmd = new PDO("mysql:host=$dbhost;dbname=$dbnameRealmd","$dbuser", "$dbpassword");
	$databaseCharacters = new PDO("mysql:host=$dbhost;dbname=$dbnameCharacters","$dbuser", "$dbpassword");

	// Get user list
	function getUsers($database)
	{
		try
		{
			$getusers_req = $database->prepare('SELECT id,username,gmlevel,failed_logins from account WHERE id > 4 ORDER BY username;');
			$getusers_req->execute();
			$getusers_result = $getusers_req->fetchAll(PDO::FETCH_ASSOC);
			$getusers_req->closeCursor();
			return $getusers_result;
		}

		catch(Exception $error)
		{
			die('Error : '.$error->getMessage());
			logadd($error);
		}
	}

	// Get characters list
	function getCharacters($id,$database)
	{
		try
		{
			$getcharacters_req = $database->prepare('SELECT guid,name,level,class from characters WHERE account = '.$id.' ORDER BY name;');
			$getcharacters_req->execute();
			$getcharacters_result = $getcharacters_req->fetchAll(PDO::FETCH_ASSOC);
			$getcharacters_req->closeCursor();
			return $getcharacters_result;
		}

		catch(Exception $error)
		{
			die('Error : '.$error->getMessage());
			logadd($error);
		}
	}
?>
