<?php 
/**
 * 
 */
class Log
{
	function LogInfo()
	{
		$log = "[".date("Y-m-dTH:i:s")."] INFO: This is an information about something.".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}

	function LogError()
	{
		$log = "[".date("Y-m-dTH:i:s")."] ERROR: We can't divide any numbers by zero.".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}

	function LogNotice()
	{
		$log = "[".date("Y-m-dTH:i:s")."] NOTICE: Someone loves your status.".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}

	function LogWarning()
	{
		$log = "[".date("Y-m-dTH:i:s")."] WARNING: Insufficient funds.".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}

	function LogDebug()
	{
		$log = "[".date("Y-m-dTH:i:s")."] DEBUG: This is debug message.".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}

	function LogAlert()
	{
		$log = "[".date("Y-m-dTH:i:s")."] ALERT: Achtung! Achtung!".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}

	function LogCritical()
	{
		$log = "[".date("Y-m-dTH:i:s")."] CRITICAL: Medic!! We've got critical damages.".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}

	function LogEmergency()
	{
		$log = "[".date("Y-m-dTH:i:s")."] EMERGENCY: System hung. Contact system administrator immediately!".PHP_EOL;
		file_put_contents('./app.log', $log, FILE_APPEND);
	}
}

$log = new Log();
$log->LogInfo();
$log->LogError();
$log->LogNotice();
$log->LogWarning();
$log->LogDebug();
$log->LogAlert();
$log->LogCritical();
$log->LogEmergency();
 ?>