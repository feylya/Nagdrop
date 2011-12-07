<?php
/**
 * Modify controller
 * This controller is the main controller for adding and removing
 * objects from other objects (services from hosts etc)
 *
 * Drop is whatever HASN'T been moved
 * Drag is the item dragged from above
 * If a Service is DRAGGED and then DROPPED onto a host
 * Drag - Service
 * Drop - Host
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */

class Modify extends Controller
{
	var $host_accept = array("service","hostgroup");
	var $service_accept = array("host","hostgroup", "servicegroup");
	var $hostgroup_accept = array("host", "service");
	var $servicegroup_accept = array("service");
	var $error = array(
				"host"=>"Hosts cannot be added to this",
				"service"=>"Service cannot be added to this", 
				"hostgroup"=>"Host Group cannot be added to this",
				"servicegroup"=>"Service Group cannot be added to this");	

	/**
	 * Standard constructor
	 * @return null
	 */
	function __construct()
	{
		parent::Controller();
	}

	/**
	 * Takes the data that's been passed by the ui
	 * and decides what to do with it
	 * based on the decoded JSON in the DIV id's
	 *
	 * @return null
	 */
	function add()
	{

		//Local variables only
		//The decoded JSON becomes the Class scope variables
		$drop = $this->input->post("drop");
		$drag = $this->input->post("drag");
		$this->drop = json_decode($drop);
		$this->drag = json_decode($drag);

		switch ($this->drop->type)
		{
			case "host":
				$this->host();
				break;
			case "service":
				$this->service();
				break;
			case "hostgroup":
				$this->hostgroup();
				break;
			case "servicegroup":
				$this->servicegroup();
				break;
			default:
				//redirect('home/host');
				//Should probably return a "What are you trying to do?!" error here
		}
	}

	/**
	 * Index function
	 * Just redirects in case someone hits the url
	 *
	 * @return null
	 */
	function index()
	{
		//We cannot just hit this function
		//Return to the main page
		redirect('home/hosts');

	}



	/**
	 * This function decides what we can add to a Host
	 * and then routes the calls to the appropriate models
	 *
	 * @return null
	 */
	function host()
	{
		if (!in_array($this->drag->type, $this->host_accept))
		{
			//We can't add this item to this object
			$result = array("Success"=>FALSE, "Message"=>$this->error['host']);
			echo json_encode($result);
			return;
		} else {
			//Let's update the database, write the files and restart the process
			switch ($this->drag->type)
			{
				case "service":
					//Add service to host
					$data = array(
							'service_id'=>$this->drag->id, 
							'host_id'=>$this->drop->id);

					$success = $this->service_model->insertHost($data);

					$where = array("host_id"=>$this->drop->id);
					$host_alias = $this->host_model->getAlias($where);
					//$host_alias = $host_alias[0]->alias;

					$where = array("service_id"=>$this->drag->id);
					$service_alias = $this->service_model->getAlias($where);
					$service_alias = $service_alias[0]->display_name;

					if ($success === true)
					{
						$returned = array(
							"Success"=>$success,
							"Message"=>$service_alias . 
							         " has been added to " . 
						$host_alias[0]->display_name .
						            ' (' . $host_alias[0]->alias . ')');
					} else {
						$returned = array(
							"Success"=>$success,
							"Message"=>$service_alias . 
							           " was not added to " . 
						$host_alias[0]->display_name .
						              ' (' . $host_alias[0]->alias . ')');
					}
					print(json_encode($returned));
					break;
				case "hostgroup":
					//Add hostgroup to host
					//Add service to hostgroup
					$data = array(
			              'hostgroup_id'=>$this->drag->id,
			              'host_id'=>$this->drop->id); 

					$success = $this->hostgroup_model->insertHost($data);

					$where = array("host_id"=>$data['host_id']);
					$host_alias = $this->host_model->getAlias($where);
					//host_alias = $host_alias[0]->alias;

					$where = array("hostgroup_id"=>$data['hostgroup_id']);
					$hostgroup_alias = $this->hostgroup_model->getAlias($where);
					$hostgroup_alias = $hostgroup_alias[0]->alias;

					if ($success === true)
					{
						$returned = array(
				              "Success"=>$success,
				              "Message"=>$host_alias[0]->display_name . 
				                         ' (' . $host_alias[0]->alias . ')' . 
				                         " has been added to " . 
						$hostgroup_alias);
					} else {
						$returned = array(
				              "Success"=>$success,
				              "Message"=>$host_alias[0]->display_name . 
				                          ' (' . $host_alias[0]->alias . ')' . 
				                          " was not added to " . 
						$hostgroup_alias);
					}
					print(json_encode($returned));
					break;
			}
		}
	}

	/**
	 * This function decides what we can add to a Hostgroup
	 * and then routes the calls to the appropriate models
	 *
	 * @return null
	 */
	function hostgroup()
	{
		if (!in_array($this->drag->type, $this->hostgroup_accept))
		{
			//We can't add this item to this object
			$result = array("Success"=>FALSE, "Message"=>$this->error['host']);
			echo json_encode($result);
			return;
		} else {
			//Let's update the database, write the files and restart the process
			switch ($this->drag->type)
			{
				case "host":
					//Add service to host
					$data = array(
              'host_id'=>$this->drag->id, 
              'hostgroup_id'=>$this->drop->id);

					$success = $this->hostgroup_model->insertHost($data);

					$where = array("host_id"=>$this->drag->id);
					$host_alias = $this->host_model->getAlias($where);
					$host_alias = $host_alias[0]->alias;

					$where = array("hostgroup_id"=>$this->drop->id);
					$hostgroup_alias = $this->hostgroup_model->getAlias($where);
					$hostgroup_alias = $hostgroup_alias[0]->alias;

					if ($success === true)
					{
						$returned = array(
              "Success"=>$success,
              "Message"=>$host_alias . " has been added to " . $hostgroup_alias);
					} else {
						$returned = array(
              "Success"=>$success,
              "Message"=>$host_alias . " was not added to " . $hostgroup_alias);
					}
					print(json_encode($returned));
					break;
				case "service":
					//Add service to host
					$data = array(
              'service_id'=>$this->drag->id, 
              'hostgroup_id'=>$this->drop->id);

					$success = $this->hostgroup_model->insertService($data);

					$where = array("service_id"=>$this->drag->id);
					$service_alias = $this->service_model->getAlias($where);
					$service_alias = $service_alias[0]->alias;

					$where = array("hostgroup_id"=>$this->drop->id);
					$hostgroup_alias = $this->hostgroup_model->getAlias($where);
					$hostgroup_alias = $hostgroup_alias[0]->alias;

					if ($success === true)
					{
						$returned = array(
              "Success"=>$success,
              "Message"=>$service_alias . " has been added to " . $hostgroup_alias);
					} else {
						$returned = array(
              "Success"=>$success,
              "Message"=>$service_alias . " was not added to " . $hostgroup_alias);
					}
					print(json_encode($returned));
					break;
			}
		}
	}


	/**
	 * This function decides what we can add to a Service
	 * and then routes the calls to the appropriate models
	 *
	 * @return null
	 */
	function service()
	{
		if (!in_array($this->drag->type, $this->service_accept))
		{
			//We can't add this item to this object
			$result = array("Success"=>FALSE, "Message"=>$this->error['host']);
			echo json_encode($result);
			return;
		} else {
			//Let's update the database
			switch ($this->drag->type)
			{
				case "host":
					//Add host to service
					$data = array(
              'service_id'=>$this->drop->id, 
              'host_id'=>$this->drag->id);

					$success = $this->service_model->insertHost($data);

					$where = array("host_id"=>$data['host_id']);
					$host_alias = $this->host_model->getAlias($where);
					//$host_alias = $host_alias[0]->alias;

					$where = array("service_id"=>$data['service_id']);
					$service_alias = $this->service_model->getAlias($where);
					$service_alias = $service_alias[0]->display_name;

					if ($success === true)
					{
						$returned = array(
              "Success"=>$success,
              "Message"=>$service_alias . " has been added to " . 
						$host_alias[0]->display_name .
						             ' (' . $host_alias[0]->alias . ')');
					} else {
						$returned = array(
              "Success"=>$success,
              "Message"=>$service_alias . " was not added to " . 
						$host_alias[0]->display_name .
						              ' (' . $host_alias[0]->alias . ')');
					}
					print(json_encode($returned));
					break;
				case "hostgroup":
					//Add service to hostgroup
					$data = array(
              'hostgroup_id'=>$this->drag->id,
              'service_id'=>$this->drop->id);

					$success = $this->hostgroup_model->insertService($data);

					$where = array("service_id"=>$data['service_id']);
					$service_alias = $this->service_model->getAlias($where);
					$service_alias = $service_alias[0]->alias;

					$where = array("hostgroup_id"=>$data['hostgroup_id']);
					$hostgroup_alias = $this->hostgroup_model->getAlias($where);
					$hostgroup_alias = $hostgroup_alias[0]->alias;

					if ($success === true)
					{
						$returned = array(
              "Success"=>$success,
              "Message"=>$hostgroup_alias . " has been added to " . $service_alias);
					} else {
						$returned = array(
              "Success"=>$success,
              "Message"=>$hostgroup_alias . " was not added to " . $service_alias);
					}
					print(json_encode($returned));
          break;
			}
		}
	}


	/**
	 * This function decides what we can add to a Servicegroup
	 * and then routes the calls to the appropriate models
	 *
	 * @return null
	 */
	function servicegroup()
	{
		if (!in_array($drag['type'], $service_accept))
		{
			//We can't add this item to this object
			return $error['host'];
			break;
		} else {
			//Let's update the database, write the files and restart the process

			switch ($drag['type'])
			{
				case "service":
					//Add service to host

					break;
				case "hostgroup":
					//Add host to hostgroup

					break;
			}
		}
	}

	/**
	 * Removes a host from a hostgroup
	 * Hostgroup and host id's are collected by
	 * querying the database for the nagdrop_hostgroup_members id
	 * that was passed by the UI
	 *
	 * @return null
	 */
	function removeHostFromHostgroup()
	{
		$success = FALSE;
		//Remove host_id/service_id
		$id = $this->input->post('id');
		$ids = $this->hostgroup_model->getHostgroupHost($id);

		$where = array("host_id"=>$ids[0]->host_id);
		$host_alias = $this->host_model->getAlias($where);
		$host_alias = $host_alias[0]->alias;

		$where = array("hostgroup_id"=>$ids[0]->hostgroup_id);
		$hostgroup_alias = $this->hostgroup_model->getAlias($where);
		$hostgroup_alias = $hostgroup_alias[0]->alias;

		$success = $this->hostgroup_model->removeHostgroupHost($id);
		if ($success === TRUE)
		{
			$returned = array(
        "Success"=>$success,
        "Message"=>$host_alias . " has been removed from " . $hostgroup_alias);
		} else {
			$returned = array(
        "Success"=>$success,
        "Message"=>$host_alias . " was not removed from " . $hostgroup_alias);
		}
		print(json_encode($returned));
		return;
	}

	/**
	 * Removes a host from a service
	 * Service and host id's are collected by
	 * querying the database for the nagdrop_service_host id
	 * that was passed by the UI
	 *
	 * @return null
	 */
	function removeHostFromService()
	{
		$success = FALSE;
		//Remove host_id/service_id
		$id = $this->input->post('id');
		$ids = $this->service_model->getServiceHost($id);

		$where = array("host_id"=>$ids[0]->host_id);
		$host_alias = $this->host_model->getAlias($where);
		//$host_alias = $host_alias[0]->alias;

		$where = array("service_id"=>$ids[0]->service_id);
		$service_alias = $this->service_model->getAlias($where);
		$service_alias = $service_alias[0]->display_name;

		$success = $this->service_model->removeServiceHost($id);
		if ($success === TRUE)
		{
			$returned = array(
        "Success"=>$success,
        "Message"=>$host_alias[0]->display_name . 
                  ' (' . $host_alias[0]->alias . 
                  ') has been removed from ' . 
			$service_alias);
		} else {
			$returned = array(
        "Success"=>$success,
        "Message"=>$host_alias[0]->display_name . 
                   ' (' . $host_alias[0]->alias . 
                   ') was not removed from ' . 
			$service_alias);
		}
		print(json_encode($returned));
		return;
	}


	/**
	 * Removes a service from a hostgroup
	 * Service and hostgroup id's are collected by
	 * querying the database for the nagdrop_hostgroup_services id
	 * that was passed by the UI
	 *
	 * @return null
	 */
	function removeServiceFromHostgroup()
	{
		$success = FALSE;
		//Get inputs from the POS
		$id = $this->input->post('id');
		$hg_id = $this->input->post('hg_id');
		//Get back the id of the Service that was removed
		$ids = $this->hostgroup_model->getHostgroupService($id);

		$where = array("service_id"=>$ids[0]->service_id);
		$service_alias = $this->service_model->getAlias($where);
		$service_alias = $service_alias[0]->alias;

		$where = array("hostgroup_id"=>$ids[0]->hostgroup_id);
		$hostgroup_alias = $this->hostgroup_model->getAlias($where);
		$hostgroup_alias = $hostgroup_alias[0]->alias;

		$success = $this->hostgroup_model->removeHostgroupService($id);
		if ($success === TRUE)
		{
			$returned = array(
        "Success"=>$success,
        "Message"=>$service_alias . " has been removed from " . $hostgroup_alias);
		} else {
			$returned = array(
        "Success"=>$success,
        "Message"=>$service_alias . " was not removed from " . $hostgroup_alias);
		}
		print(json_encode($returned));
		return;
	}


	/**
	 * Removes a service from a host
	 * Service and host id's are collected by
	 * querying the database for the nagdrop_service_host id
	 * that was passed by the UI
	 *
	 * @return null
	 */
	function removeServiceHost()
	{
		$success = FALSE;
		//Remove host_id/service_id
		$id = $this->input->post('id');
		$ids = $this->service_model->getServiceHost($id);

		$where = array("host_id"=>$ids[0]->host_id);
		$host_alias = $this->host_model->getAlias($where);
		$host_alias = $host_alias[0]->alias;

		$where = array("service_id"=>$ids[0]->service_id);
		$service_alias = $this->service_model->getAlias($where);
		$service_alias = $service_alias[0]->display_name;

		$success = $this->service_model->removeServiceHost($id);
		if ($success === TRUE)
		{
			$returned = array(
        "Success"=>$success,
        "Message"=>$service_alias . " has been removed from " . $host_alias);
		} else {
			$returned = array(
        "Success"=>$success,
        "Message"=>$service_alias . " was not removed from " . $host_alias);
		}
		print(json_encode($returned));
		return;
	}

}
