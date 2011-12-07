<?php
/**
 * This file writes configuration files for Nagios
 * All content data is passed into it
 * Missing directories will be generated
 * Restart Nagios after a check
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 30/12/2009
 */

class Files extends Controller {

	var $success = FALSE;

	/**
	 * Initial contrusct function
	 * Sets up the timezone (CodeIgniter complains otherwise)
	 * Allows loads the CodeIgniter file helper
	 *
	 * @return null
	 *
	 */
	function __construct()
	{
		parent::Controller();
		date_default_timezone_set('Europe/Dublin');
		$this->load->helper('file');
	}

	/**
	 * Dumps out the output for a hostgroup with template information
	 * Makes all the files uniform
	 *
	 * @param object $content
	 * @return
	 */
	function checkCommandTemplate($results) {
		$hashes = "###############################################################################";
		$data = "";
		$date = date("Y-M-j G:i:s");
		$header = "$hashes \n# Check Command configuration file\n# Date:\t\t $date \n$hashes \n\n";

		foreach ($results as $content)
		{
			$data .= "define command {\n";
			foreach ($content as $key=>$value) {
				if ($value != "" && $value != NULL) {
					//Calculate how long the string is and how many spaces you need between
					//the name of the setting and it's value
					$spaces = "";
					for ($i = 0; $i <= (50 - strlen($key)); $i++) {
						$spaces .= " ";
					}
					$data .= "\t".$key.$spaces.$value."\n";
				}
			}
			$data .= "}\n\n";
		}
		$footer = "$hashes \n# Check Command configuration file\n# END OF FILE\n$hashes\n\n";

		return $header.$data.$footer;
	}

	/**
	 * Gets all the check commands and writes them to the files
	 *
	 * @return null
	 */
	function checkCommands()
	{
		$basepath = "/usr/local/nagios";
		$results = $this->misc_model->getCheckCommandsFile();
		$output = $this->checkCommandTemplate($results);
		$this->writeFile($basepath."/etc/objects", 'commands.cfg', $output);
	}

	/**
	 * Dumps out the output for a host with template information
	 * Makes all the files uniform
	 *
	 * @param object $content
	 * @return
	 */
	function hostTemplate($content) {
		$hashes = "###############################################################################";
		$data = "";
		$date = date("Y-M-j G:i:s");
		$header = "$hashes \n# Host configuration file\n# Date:\t\t $date \n$hashes \n\n";


		$data .= "define host {\n";
		foreach ($content as $key=>$value) {
			if ($value != "" && $value != NULL) {
				//Have to rename the variables here
				//PHP doesn't like variables like $this->3 for obvious reasons
				//(letters only at the start of variable names please)
				if ($key == 'twod_coords')
				{
					$key = '2d_coords';
				}
				if ($key == 'threed_coords')
				{
					$key = '3d_coords';
				}

				//Calculate how long a piece of string is and how many spaces you need between
				//the name of the varible and it's value
				$spaces = "";
				for ($i = 0; $i <= (50 - strlen($key)); $i++) {
					$spaces .= " ";
				}
				$data .= "\t".$key.$spaces.$value."\n";
			}
		}
		$data .= "}\n\n";

		$footer = "$hashes \n# Host configuration file\n# END OF FILE\n$hashes\n\n";

		return $header.$data.$footer;
	}

	/**
	 * Dumps out the output for a hostgroup with template information
	 * Makes all the files uniform
	 *
	 * @param object $content
	 * @return
	 */
	function hostgroupTemplate($content) {
		$hashes = "###############################################################################";
		$data = "";
		$date = date("Y-M-j G:i:s");
		$header = "$hashes \n# Hostgroup configuration file\n# Date:\t\t $date \n$hashes \n\n";


		$data .= "define hostgroup {\n";
		foreach ($content as $key=>$value) {
			if ($value != "" && $value != NULL) {
				//Calculate how long the string is and how many spaces you need between
				//the name of the setting and it's value
				$spaces = "";
				for ($i = 0; $i <= (50 - strlen($key)); $i++) {
					$spaces .= " ";
				}
				$data .= "\t".$key.$spaces.$value."\n";
			}
		}
		$data .= "}\n\n";

		$footer = "$hashes \n# Hostgroup configuration file\n# END OF FILE\n$hashes\n\n";

		return $header.$data.$footer;
	}

	/**
	 * Gets all the hostgroups and writes them to the files
	 *
	 * @return null
	 */
	function hostgroups()
	{
		$basepath = "/usr/local/nagios";
		delete_files($basepath."/etc/hostgroups");
		$results = $this->hostgroup_model->getFileInfo();

		foreach ($results as $content) {
			$hostgroup_name = ereg_replace("[^A-Za-z0-9]", "_", $content->alias); //Strip out OS unfriendly characters
			$content->hostgroup_name = ereg_replace("[^A-Za-z0-9]", "_", $content->hostgroup_name); //Strip out OS unfriendly characters
			$content->alias = ereg_replace("[^A-Za-z0-9]", "_", $content->alias); //Strip out OS unfriendly characters
			$output = $this->hostgroupTemplate($content);
			$this->writeFile($basepath."/etc/hostgroups", "$hostgroup_name.cfg", $output);
		}
	}

	/**
	 * Gets all the hosts and writes them to the files
	 * Applies any templates to the host so the Nagios templating system isn't necessary
	 *
	 * @return null
	 */
	function hosts()
	{
		$basepath = "/usr/local/nagios";
		delete_files($basepath."/etc/hosts");
		$results = $this->host_model->getFileInfo();

		foreach ($results as $content) {
			$output = $this->hostTemplate($content);
			$server_name = ereg_replace("[^A-Za-z0-9]", "_", $content->host_name); //Strip out OS unfriendly characters
			$this->writeFile($basepath."/etc/hosts", $server_name.".cfg", $output);
		}
	}





	/**
	 * Moves files around the file system
	 * @deprecated
	 * @param object $oldPath
	 * @param object $oldFilename
	 * @param object $newPath
	 * @param object $newFilename
	 * @return
	 */
	function moveFile($oldPath, $oldFilename, $newPath, $newFilename) {
		copy($basepath." / ".$oldpath."/".$oldFilename, $basepath." / ".$newpath."/".$newFilename);
	}

	/**
	 * This function calls a command on the file system which checks the sanity of the Nagios configuration files
	 * If this check fails, Nagios won't be restarted because it would break
	 * There is a security issue here
	 *
	 * @return null
	 */
	function nagios_check()
	{
		$arlines = array();
		$nagiosPath = '/usr/local/nagios';
		$xcommand = $nagiosPath."/bin/nagios -v ".$nagiosPath."/etc/nagios.cfg";
		exec($xcommand, $arlines, $returncode);
		if ($returncode > 0 || array_search("Error:", $arlines))
		{
			$this->success = FALSE;
			//Something is broken!
			foreach ($arlines as $line)
			{
				if (strstr($line, "Error:"))
				{
					//Something is broken
					echo $line . "<br /> \n";
				}
			}
		} else {
			//All good, restart!
			$this->nagios_restart();
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
	function nagios_restart()
	{
		$nagiosPath = '/usr/local/nagios';
		$now = date('U');
		$command = "'RESTART_PROGRAM\n" . $now . "'";
		$commandfile = "$nagiosPath/var/rw/nagios.cmd";

		//$xcommand = sprintf("/usr/bin/printf %s > %s", $command, $commandfile);
		$xcommand = "/usr/bin/printf \"[%lu] RESTART_PROGRAM\n\" $now > $commandfile";
		exec($xcommand, $arlines, $returncode);
		if ($returncode > 0 || array_search("Error:", $arlines)) {
			//Somethings broken
			//This really shouldn't happen though cos the configs were checked
			$this->success = FALSE;
			//Commented out because we don't really need unless we're debugging
			/*echo "Restart failed";
			 echo $xcommand . "<br /> \n";
			 echo $returncode . "<br /> \n";
			 var_dump($arlines);*/
		} else {
			$this->success = TRUE;
			//All Good - Return
			//echo "Restarted";
			//return TRUE;
		}
	}

	/**
	 * Dumps the ouput for a service with template information
	 * Makes all the files uniform
	 *
	 * @param object $content
	 * @return
	 */
	function serviceTemplate($content) {
		$hashes = "###############################################################################";
		$data = "";
		$date = date("Y-M-j G:i:s");
		$header = "$hashes \n# Service configuration file\n# Date:\t\t $date \n$hashes\n\n";
		$data .= "define service {\n";
		foreach ($content as $key=>$value)
		{
			if ($value != "" && $value != NULL)
			{
				//Calculate how long the string is and how many spaces you need between
				//the name of the setting and it's value
				//(letters only at the start of variable names please)
				$spaces = "";
				for ($i = 0; $i <= (50 - strlen($key)); $i++) {
					$spaces .= " ";
				}
				$data .= "\t".$key.$spaces.$value."\n";
			}


		}
		$data .= "}\n\n";
		$footer = "$hashes\n# Service configuration file\n# END OF FILE\n$hashes \n\n";

		return $header.$data.$footer;
	}

	/**
	 * Gets all the services and writes them to the files
	 * Applies any templates to the host so the Nagios templating system isn't necessary
	 *
	 * @return null
	 */
	function services()
	{
		$basepath = "/usr/local/nagios";
		delete_files($basepath."/etc/services");
		$results = $this->service_model->getFileInfo();
		$output = '';
		foreach ($results as $content)
		{
			$server_name = ereg_replace("[^A-Za-z0-9]", "_", $content->service_description); //Strip out OS unfriendly characters
			if (isset($content->hostgroup_name))
			{
				$content->hostgroup_name = ereg_replace("[^A-Za-z0-9,]", "_", $content->hostgroup_name); //Strip out OS unfriendly characters
			}
			$output = $this->serviceTemplate($content);
			$this->writeFile($basepath."/etc/services", "$server_name-services.cfg", $output);
		}
	}

	/**
	 * This is the main access point into this Controller
	 * It steps through writing files for all the hosts, services, etc
	 * Once the files are written, it runs the Nagios sanity check on the files
	 * If that passes, Nagios is restarted and a JSON message is returned to be displayed
	 *
	 * @return text
	 *
	 */
	function write() {
		$this->hosts();
		$this->services();
		$this->hostgroups();
		$this->checkCommands();
		$this->nagios_check();
		if ($this->success === TRUE)
		{
			$returned = array("Success"=>$this->success);
		} else {
			$returned = array("Success"=>$this->success);
		}
		print(json_encode($returned));
		return;
	}

	/**
	 * Writes files to the hard drive
	 * @param object $path
	 * @param object $filename
	 * @param object $content
	 * @return
	 */
	function writeFile($path, $filename, $content)
	{
		if (file_exists($path)==FALSE) {
			mkdir('$path', 0777, true);
		}
		$fh = fopen($path."/".$filename, 'w+') or die("can't open file");
		fwrite($fh, $content);
		fclose($fh);
	}

}
?>
