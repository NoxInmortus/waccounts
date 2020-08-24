<?php

function logadd($arMsg)
{
	// Define empty string
	$stEntry = "";

	// Get the event occur date time, when it will happened
	$arLogData['event_datetime']="[".date('D Y-m-d h:i:s A')."] [client ".$_SERVER['REMOTE_ADDR']."]";

	if(isset($_SESSION['login']))
	{
	  $arLogData['event_datetime'] .= " [user ".$_SESSION['login']."]";
	}

	// If message is array type
	if(is_array($arMsg))
	{
		// Concatenate msg with datetime
		foreach($arMsg as $msg)
			$stEntry.=$arLogData['event_datetime']." ".$msg.PHP_EOL;
	}
	else
	{
		// Concatenate msg with datetime
		$stEntry.=$arLogData['event_datetime']." ".$arMsg.PHP_EOL;
	}

	// Create file with current date name
	$stCurLogFileName='log_'.date('Ymd').'.log';

	// Log path directory
  $logpath = getcwd();

  // Open the file append mode,dats the log file will create day wise
  $fHandler = fopen($logpath.'/log/'.$stCurLogFileName,'a+');

	// Write the info into the file
	fwrite($fHandler, $stEntry);

	// Close handler
	fclose($fHandler);
}
?>
