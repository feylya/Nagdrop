<?php
/**
 * File: popup.php
 *
 * Controller for all popups (edit dialogs that are displayed
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 30 December 2009
 */
class popup extends Controller {

	/**
	 * Deletes the host specified in the URI
	 *
	 * @return
	 */
	function deleteHost() {
		$id = $this->uri->segment(3);
		$this->host_model->delete($id);
	}


	/**
	 * Deletes the hostgroup specified in the URI
	 *
	 * @return
	 */
	function deleteHostgroup() {
		$id = $this->uri->segment(3);
		$this->hostgroup_model->delete($id);
	}

	/**
	 * Deletes the host template specified in the URI
	 *
	 * @return
	 */
	function deleteHostTemplate() {
		$id = $this->uri->segment(3);
		$this->thost_model->delete($id);
	}

	/**
	 * Deletes the service template specified in the URI
	 *
	 * @return
	 */
	function deleteServiceTemplate() {
		$id = $this->uri->segment(3);
		$this->tservice_model->delete($id);
	}

	/**
	 * Deletes the service specified in the URI
	 *
	 * @return
	 */
	function deleteService() {
		$id = $this->uri->segment(3);
		$this->service_model->delete($id);
	}

	/**
	 * Gets all data about the host for the popup dialog
	 * This includes all dropdown menus
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function getHost()
	{
		//Yup, Star Trek reference. Kept typing commander instead of command. It's easier this way
		$commanderData = array();
		$templateData = array();
		//Get host info from the URI
		$id = $this->uri->segment(3);
		//Use this id to get information about the host
		$host = $this->host_model->get($id);
		//Get template info
		$tid = $host[0]->thost_id;
		$thost = $this->host_model->getTemplate($tid);
		foreach ($host[0] as $key=>$value) {
			//Let's check if we need to stick in the template info to our hash table
			if ($value == NULL || $value == -1 || $value == "") {
				$host[0]->$key = array("t", $thost[0]->$key);
			} else {
				$host[0]->$key = array("h", $value);
			}
		}

		//Get Check Commands Drop down info
		$commands = $this->misc_model->getCommands();
		$hostTemplates = $this->misc_model->getHostTemplates();

		//Take it out of the 2d array and dump it into a 1d.
		foreach ($commands as $command) {
			//We're only returning the first 80 characters to stop the drop down spilling over
			//$commanderData = array_merge($commanderData, array($command->command_id=>substr($command->command_line, 0, 80)));
			//Make an array from the Objects that have been returned to us.
			$commanderData = $commanderData + array($command->command_id=>$command->command_name);
		}

		//Time to do the same for the Host Templates
		foreach ($hostTemplates as $hostTemplate) {
			//Make an array from the Objects that have been returned to us.
			$templateData = $templateData + array($hostTemplate->thost_id=>$hostTemplate->thost_name);
		}
		//Build the associative array
		$data = array("host"=>$host, "commands"=>$commanderData, "hostTemplates"=>$templateData);
		//Send it over.
		$this->load->view('popup/host_popup_view', $data);

	}

	/**
	 * Gets all data about the hostgoup for the popup dialog
	 * This includes all dropdown menus
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function getHostgroup()
	{
		//Get host info from the URI
		$id = $this->uri->segment(3);
		//Use this id to get information about the host
		$hostgroup = $this->hostgroup_model->get($id);
		//Build the associative array
		$data = array("hostgroup"=>$hostgroup);
		//Send it over.
		$this->load->view('popup/hostgroup_popup_view', $data);

	}

	/**
	 * Gets all data about the host for the popup dialog
	 * This includes all dropdown menus
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function getHostTemplate()
	{
		//Yup, Star Trek reference. Kept typing commander instead of command. It's easier this way
		$commanderData = array();
		$templateData = array();
		//Get host info from the URI
		$id = $this->uri->segment(3);
		//Use this id to get information about the host
		$host = $this->thost_model->get($id);
		//Get Check Commands Drop down info
		$commands = $this->misc_model->getCommands();

		//Take it out of the 2d array and dump it into a 1d.
		foreach ($commands as $command) {
			//We're only returning the first 80 characters to stop the drop down spilling over
			//$commanderData = array_merge($commanderData, array($command->command_id=>substr($command->command_line, 0, 80)));
			//Make an array from the Objects that have been returned to us.
			$commanderData = $commanderData + array($command->command_id=>$command->command_name);
		}
		//Build the associative array
		$data = array("thost"=>$host, "commands"=>$commanderData);
		//Send it over.
		$this->load->view('popup/thost_popup_view', $data);

	}

	/**
	 * Gets all data about the host for the popup dialog
	 * This includes all dropdown menus
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function getService()
	{
		//Yup, Star Trek reference. Kept typing commander instead of command. It's easier this way
		$commanderData = array();
		$templateData = array();
		//Get host info from the URI
		$id = $this->uri->segment(3);
		//Use this id to get information about the host
		$service = $this->service_model->get($id);
		//Get template info
		$tid = $service[0]->tservice_id;
		$tservice = $this->service_model->getTemplate($tid);
		foreach ($service[0] as $key=>$value) {
			//Let's check if we need to stick in the template info to our hash table
			if ($value == NULL || $value == -1 || $value == "") {
				$service[0]->$key = array("t", $tservice[0]->$key);
			} else {
				$service[0]->$key = array("s", $value);
			}
		}

		//Get Check Commands Drop down info
		$commands = $this->misc_model->getCommands();

		//Take it out of the 2d array and dump it into a 1d.
		foreach ($commands as $command) {
			$newData = array($command->command_id => $command->command_name);
			$commanderData = $commanderData + $newData;
		}

		$serviceTemplates = $this->misc_model->getServiceTemplates();

		//Time to do the same for the Host Templates
		foreach ($serviceTemplates as $serviceTemplate) {
			//Make an array from the Objects that have been returned to us.
			$templateData = $templateData + array($serviceTemplate->tservice_id=>$serviceTemplate->display_name);
		}
		//Build the associative array
		$data = array("service"=>$service, "commands"=>$commanderData, "serviceTemplates"=>$templateData);
		//Send it over.
		$this->load->view('popup/service_popup_view', $data);
	}

	/**
	 * Gets all data about the host for the popup dialog
	 * This includes all dropdown menus
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function getServiceTemplate()
	{
		//Yup, Star Trek reference. Kept typing commander instead of command. It's easier this way
		$commanderData = array();
		$templateData = array();
		//Get host info from the URI
		$id = $this->uri->segment(3);
		//Use this id to get information about the host
		$tservice = $this->tservice_model->get($id);
		//Get Check Commands Drop down info
		$commands = $this->misc_model->getCommands();

		//Take it out of the 2d array and dump it into a 1d.
		foreach ($commands as $command) {
			//We're only returning the first 80 characters to stop the drop down spilling over
			//$commanderData = array_merge($commanderData, array($command->command_id=>substr($command->command_line, 0, 80)));
			//Make an array from the Objects that have been returned to us.
			$commanderData = $commanderData + array($command->command_id=>$command->command_name);
		}
		//Add a blank option at the start. We need this
		$commanderData = array(null=>null) + $commanderData;
		//Build the associative array
		$data = array("tservice"=>$tservice, "commands"=>$commanderData);
		//Send it over.
		$this->load->view('popup/tservice_popup_view', $data);

	}

	/**
	 * Updates a host with updated information from the UI
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function setHost()
	{
		$output = array();
		$query = array();
		//Grab out data variable from the $_POST global
		$data = $this->input->post("data");

		//Split $data into an array on every &
		$fields = explode("&", $data);
		//Every field that we have
		foreach ($fields as $field) {
			//Seperate them on the = character
			$field_key_value = explode("=", $field);
			//Remove any URL encoding that javascript.serilize() put into the values
			//Things like + for spaces etc
			$key = urldecode($field_key_value[0]);
			$value = urldecode($field_key_value[1]);
			//And assign to a variable
			$output[$key] = $value;
		}

		//Grab the id of the Host
		$id = $output['host_id'];
		//Go through our array
		foreach ($output as $key=>$value)
		{
			//If the value isn't from a template
			if (substr($key,0,2) != "t_")
			{
				//For some reason, there are ; being introduced to 2 fields
				//Rip them out until we can find a decent fix
				$key = str_replace(";", "", $key);
				//Put it into our query array
				$query = array_merge($query, array($key=>$value));
			}
		}
		//Cludge because there are two identical fields in the nagdrop_hosts table and both are used throughout the code
		$query = array_merge($query, array('host_name'=>$query['display_name']));
		//Send the ID and the query array over to the Host update function
		$this->host_model->update($id, $query);

	}

	/**
	 * Updates a hostgroup with updated information from the UI
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function setHostgroup()
	{
		$output = array();
		$query = array();
		//Grab out data variable from the $_POST global
		$data = $this->input->post("data");

		//Split $data into an array on every &
		$fields = explode("&", $data);
		//Every field that we have
		foreach ($fields as $field) {
			//Seperate them on the = character
			$field_key_value = explode("=", $field);
			//Remove any URL encoding that javascript.serilize() put into the values
			//Things like + for spaces etc
			$key = urldecode($field_key_value[0]);
			$value = urldecode($field_key_value[1]);
			//For some reason, there are ; being introduced to 2 fields
			//Rip them out until we can find a decent fix
			$key = str_replace(";", "", $key);
			//And assign to a variable
			$output[$key] = $value;
		}

		//Grab the id of the Host
		$id = $output['hostgroup_id'];
		$query = array('alias'=>$output['alias']);
		//Send the ID and the query array over to the Hostgroup update function
		$this->hostgroup_model->update($id, $query);

	}

	/**
	 * Updates a service with updated information from the UI
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function setService()
	{
		$output = array();
		$query = array();
		//Grab out data variable from the $_POST global
		$data = $this->input->post("data");

		//Split $data into an array on every &
		$fields = explode("&", $data);
		//Every field that we have
		foreach ($fields as $field) {
			//Seperate them on the = character
			$field_key_value = explode("=", $field);
			//Remove any URL encoding that javascript.serilize() put into the values
			//Things like + for spaces etc
			$key = urldecode($field_key_value[0]);
			$value = urldecode($field_key_value[1]);
			//For some reason, there are ; being introduced to 2 fields
			//Rip them out until we can find a decent fix
			$key = str_replace(";", "", $key);
			//And assign to a variable
			$output[$key] = $value;
		}

		//Grab the id of the Host
		$id = $output['service_id'];
		//Go through our array
		foreach ($output as $key=>$value)
		{
			//If the value isn't from a template
			if (substr($key,0,2) != "t_")
			{
				//Put it into our query array
				$query = array_merge($query, array($key=>$value));
			}
		}
		//Send the ID and the query array over to the Host update function
		$this->service_model->update($id, $query);

	}

	/**
	 * Updates a host template with updated information from the UI
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function setHostTemplate()
	{
		$output = array();
		$query = array();
		//Grab out data variable from the $_POST global
		$data = $this->input->post("data");

		//Split $data into an array on every &
		$fields = explode("&", $data);
		//Every field that we have
		foreach ($fields as $field) {
			//Seperate them on the = character
			$field_key_value = explode("=", $field);
			//Remove any URL encoding that javascript.serilize() put into the values
			//Things like + for spaces etc
			$key = urldecode($field_key_value[0]);
			$value = urldecode($field_key_value[1]);

			//For some reason, there are ; being introduced to 2 fields
			//Rip them out until we can find a decent fix
			$key = str_replace(";", "", $key);
			//And assign to a variable
			$output[$key] = $value;
		}

		//Grab the id of the Host
		$id = $output['thost_id'];
		//Go through our array
		foreach ($output as $key=>$value)
		{
			echo $key;
			//Put it into our query array
			$query = array_merge($query, array($key=>$value));
		}
		//Send the ID and the query array over to the Host update function
		$this->thost_model->update($id, $output);
	}


	/**
	 * Updates a service template with updated information from the UI
	 * Data is stored as an associative array
	 *
	 * @return
	 */
	function setServiceTemplate()
	{
		$output = array();
		$query = array();
		//Grab out data variable from the $_POST global
		$data = $this->input->post("data");

		//Split $data into an array on every &
		$fields = explode("&", $data);
		//Every field that we have
		foreach ($fields as $field) {
			//Seperate them on the = character
			$field_key_value = explode("=", $field);
			//Remove any URL encoding that javascript.serilize() put into the values
			//Things like + for spaces etc
			$key = urldecode($field_key_value[0]);
			$value = urldecode($field_key_value[1]);

			//For some reason, there are ; being introduced to 2 fields
			//Rip them out until we can find a decent fix
			$key = str_replace(";", "", $key);
			//And assign to a variable
			$output[$key] = $value;
		}

		//Grab the id of the Host
		$id = $output['tservice_id'];
		//Go through our array
		foreach ($output as $key=>$value)
		{
			//Put it into our query array
			$query = array_merge($query, array($key=>$value));
		}
		//Send the ID and the query array over to the Service update function
		$this->tservice_model->update($id, $output);
	}



}
?>
