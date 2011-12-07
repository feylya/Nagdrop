<?php
/**
 * File: nagios.php
 *
 * Controller for all nagios interactions
 * This has actually been shipped out to files.php
 *
 * @author Paul O'Connor 
 * @date 30 December 2009
 */
class Nagios extends Controller
{
	/**
	 * This function calls a command on the file system which checks the sanity of the Nagios configuration files
	 * If this check fails, Nagios won't be restarted because it would break
	 * There is a security issue here
	 *
	 * @return null
	 */
	function check()
	{
		$nagiosPath = '/usr/local/nagios';
		$xcommand = $nagiosPath."/bin/nagios -v ".$nagiosPath."/etc/nagios.cfg";
		exec($xcommand, $arlines, $returncode);
		if ($returncode > 0 || array_search("Error:", $arlines)) {
			//Something is broken!
			foreach ($arlines as $line)
			{
				if (strstr($line, "Error:"))
				{
					return $line;
				}
			}
		} else {
			//All good, restart!
			return $this->restart();
		}
	}

	/**
	 * This writes to the unix pipe of nagios and tells it to restart
	 * This is a much safer method of talking to Nagios than $this->nagios_check()
	 * No executable is run.
	 *
	 * The syntax for the pipe is FUNCTION_NAME\n 'Now in Epoch time'
	 * That is passed into the pipe file and is then run by the Nagios process
	 *
	 * @return null
	 */
	function restart()
	{
		$nagiosPath = '/usr/local/nagios';
		$now = date('U');
		$commandfile = "$nagiosPath/var/rw/nagios.cmd";
		 
		$xcommand = sprintf("/usr/bin/printf %s > %s", $now, $commandfile);
		exec($xcommand, $arlines, $returncode);
		if ($returncode > 0 || array_search("Error:", $arlines)) {
			//Somethings broken
			//This really shouldn't happen though cos the configs were checked
			echo $xcommand . "<br /> \n";
			echo $returncode . "<br /> \n";
			var_dump($arlines);
		} else {
			//All Good - Return
			echo "Restarted";
			return TRUE;
		}
	}


}
?>
