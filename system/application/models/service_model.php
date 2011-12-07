<?php
/**
 * Service model
 * This is the file that talks to our database and pulls back Service information
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */
class Service_model extends Model
{
	/**
	 * Add a new service into the database
	 *
	 * @return array $data
	 */
	function add($data)
	{
		$this->db->insert('nagdrop_services', $data);
		return;
	}

	/**
	 * Delete a service from the database
	 *
	 * @return array $data
	 */
	function delete()
	{
		$this->db->where('service_id', $this->uri->segment(3));
		$this->db->delete('nagdrop_services');
	}

	/**
	 * Get information about a service from the database
	 * If the id is 0, then it's a new service
	 * Insert it into the DB and then grab it's ID
	 *
	 * @return array $data
	 */
	function get($service_id)
	{
		if ($service_id == 0)
		{
			//If this host doesn't exist
			$data=array('display_name'=>'CHANGEME',
                  'tservice_id'=>0);
			$this->db->insert('nagdrop_services', $data);
			$this->db->where('display_name', 'CHANGEME');
			$q = $this->db->get('nagdrop_services');
			$row = $q->result();
			$service_id = $row[0]->service_id;
		}
		$this->db->where('service_id', $service_id);
		$q = $this->db->get('nagdrop_services');
		if ($q->num_rows() >0)
		{
			foreach($q->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}

	}

	/**
	 * Get the name of the service
	 *
	 * @return array $data
	 */
	function getAlias($id)
	{
		$this->db->where($id);
		$this->db->select('display_name, display_name as alias');
		$q = $this->db->get('nagdrop_services');
		return $q->result();
	}

	/**
	 * Get information about all the services
	 * This is for the main page and menu
	 *
	 * @return array $data
	 */
	function getAll($perPage = 100000000, $start = 0)
	{
		//Get all service
		$this->db->order_by('display_name','asc');
		$this->db->limit($perPage, $start);
		$q = $this->db->get('nagdrop_services');
		return $q->result();
	}

	/**
	 * Get all the hosts that have this service attached
	 *
	 * @return array $data
	 */
	function getAllForHost($host_list)
	{
		$data = array();
		$services = array();
		foreach ($host_list as $host_id)
		{
			$this->db->join('nagdrop_services_hosts', 'nagdrop_services_hosts.service_id = nagdrop_services.service_id');
			$this->db->where('nagdrop_services_hosts.host_id', $host_id);
			$this->db->order_by('nagdrop_services.display_name', 'asc');
			$this->db->order_by('nagdrop_services_hosts.host_id', 'asc');
			$q = $this->db->get('nagdrop_services');
			foreach($q->result() as $row)
			{
				$services[] = $row;
			}
			$data[$host_id] = array("service"=>$services);
			unset($services);
			$services = array();
		}
		return $data;
	}

	/**
	 * Grab back our Host ID, Alias and Icon Image
	 * @return
	 */
	function getAllMenu($perPage = 100000000, $start = 0)
	{
		$this->db->select('service_id, display_name');
		$this->db->order_by("display_name", "asc");
		$this->db->limit($perPage, $start);
		$q = $this->db->get('nagdrop_services');
		if ($q->num_rows() >0)
		{
			foreach($q->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	/**
	 * Get a count of all the services
	 *
	 * @return array $data
	 */
	function getCount()
	{
		return $this->db->count_all_results('nagdrop_services');
	}

	/**
	 * Gets all information about all services
	 * Swaps out template data as necessary
	 * This is important - used to write the configuration files
	 *
	 * @return array $data
	 */
	function getFileInfo()
	{
		//This needs to take template information into account
		//Use popup method for checking
		//$host_services = $this->misc_model->getHostServices();

		$query = "select
		        		service_id,
						tservice_id,
						'host_name',
						'hostgroup_name',
						check_command_id,
						'check_command',
						display_name as service_description,
						check_command_args,
						failure_prediction_options,
						check_interval,
						retry_interval,
						max_check_attempts,
						first_notification_delay,
						notification_interval,
						'notification_options',
						notify_on_warning,
						notify_on_unknown,
						notify_on_critical,
						notify_on_recovery,
						notify_on_flapping,
						notify_on_downtime,
						'stalking_options',
						stalk_on_ok,
						stalk_on_warning,
						stalk_on_unknown,
						stalk_on_critical,
						is_volatile,
						flap_detection_enabled,
						'flap_detection_options',
						flap_detection_on_ok,
						flap_detection_on_warning,
						flap_detection_on_unknown,
						flap_detection_on_critical,
						low_flap_threshold,
						high_flap_threshold,
						freshness_threshold,
						passive_checks_enabled,
						event_handler_enabled,
						active_checks_enabled,
						retain_status_information,
						retain_nonstatus_information,
						notifications_enabled,
						obsess_over_service,
						failure_prediction_enabled,
						notes,
						notes_url,
						action_url,
						icon_image,
						icon_image_alt
					from nagdrop_services";
			
		$q = $this->db->query($query);
		$results = $q->result();
		foreach ($results as $result)
		{
			$id = $result->service_id;
			$hosts = $this->getHosts($id);
			$hostgroups = $this->getHostgroups($id);
			$tid = $result->tservice_id;
			$tservice = $this->service_model->getTemplate($tid);
			foreach ($result as $key=>$value) {
				//Let's check if we need to stick in the template info to our hash table
				$ignore = array('notification_options',
								'stalking_options',
								'flap_detection_options',
								'twod_coords',
								'threed_coords',
								'host_name',
								'hostgroup_name');
				if (!in_array($key, $ignore) && ($value == NULL || $value == -1 || $value == "")) {
					$result->$key = $tservice[0]->$key;
				} else {
					$result->$key = $value;
				}

				$this->db->where('command_id', $result->check_command_id);
				$this->db->select('command_name');
				$q = $this->db->get('nagdrop_check_commands');
				$command_result = $q->result();

				$result->check_command = $command_result[0]->command_name . '!' . $result->check_command_args;

				$result->host_name = $hosts;
				if (strlen($hostgroups) > 2)
				{
					$result->hostgroup_name = $hostgroups;
				} else {
					unset($result->hostgroup_name);
				}

				$result->notification_options = ''; //We only want the field in the result set, not the data from the database
				$result->notify_on_warning == 1 ? $result->notification_options = $result->notification_options . ",w" : 0;
				$result->notify_on_unknown == 1 ? $result->notification_options = $result->notification_options . ",u" : 0;
				$result->notify_on_critical == 1 ? $result->notification_options = $result->notification_options . ",r" : 0;
				$result->notify_on_flapping == 1 ? $result->notification_options = $result->notification_options . ",r" : 0;
				$result->notify_on_recovery == 1 ? $result->notification_options = $result->notification_options . ",s" : 0;
				$result->notify_on_downtime == 1 ? $result->notification_options = $result->notification_options . ",s" : 0;

				$result->stalking_options = '';
				$result->stalk_on_ok == 1 ? $result->stalking_options = $result->stalking_options . ",o" : 0;
				$result->stalk_on_warning == 1 ? $result->stalking_options = $result->stalking_options . ",w" : 0;
				$result->stalk_on_unknown == 1 ? $result->stalking_options = $result->stalking_options . ",u" : 0;
				$result->stalk_on_critical == 1 ? $result->stalking_options = $result->stalking_options . ",c" : 0;

				$result->flap_detection_options = '';
				$result->flap_detection_on_ok == 1 ? $result->flap_detection_options = $result->flap_detection_options . ",o" : 0;
				$result->flap_detection_on_warning == 1 ? $result->flap_detection_options = $result->flap_detection_options . ",w" : 0;
				$result->flap_detection_on_unknown == 1 ? $result->flap_detection_options = $result->flap_detection_options . ",u" : 0;
				$result->flap_detection_on_critical == 1 ? $result->flap_detection_options = $result->flap_detection_options . ",c" : 0;
			}

			//These have to be unset or we start getting errors
			unset($result->service_id);
			unset($result->tservice_id);
			unset($result->check_command_id);
			unset($result->check_command_args);
			unset($result->notify_on_warning);
			unset($result->notify_on_unknown);
			unset($result->notify_on_recovery);
			unset($result->notify_on_flapping);
			unset($result->notify_on_downtime);
			unset($result->notify_on_critical);
			unset($result->stalk_on_ok);
			unset($result->stalk_on_warning);
			unset($result->stalk_on_unknown);
			unset($result->stalk_on_critical);
			unset($result->flap_detection_enabled);
			unset($result->flap_detection_on_ok);
			unset($result->flap_detection_on_warning);
			unset($result->flap_detection_on_unknown);
			unset($result->flap_detection_on_critical);

			$result->notification_options = substr($result->notification_options, 1);
			$result->stalking_options = substr($result->stalking_options, 1);
			$result->flap_detection_options = substr($result->flap_detection_options, 1);
			$data[] = $result;
		}
		return $data;
	}

	/**
	 * Get all services attached to hostgroups
	 *
	 * @return array $data
	 */
	function getForHostgroup($hostgroup_list)
	{
		$data = array();
		$services = array();
		foreach ($hostgroup_list as $host_id)
		{
			$this->db->join('nagdrop_hostgroup_services', 'nagdrop_hostgroup_services.service_id = nagdrop_services.service_id');
			$this->db->where('nagdrop_hostgroup_services.hostgroup_id', $host_id);
			$this->db->order_by('nagdrop_services.display_name', 'asc');
			$this->db->order_by('nagdrop_hostgroup_services.hostgroup_id', 'asc');
			$q = $this->db->get('nagdrop_services');
			var_dump($q->result());
			foreach($q->result() as $row)
			{
				$data[] = $row;
			}
		}
		return $data;
	}

	/**
	 * Gets hostgroups that are attached to a service
	 * This is for file writing
	 *
	 * @return array $data
	 */
	function getHostgroups($id)
	{
		$this->db->where('nagdrop_hostgroup_services.service_id', $id);
		$this->db->join('nagdrop_hostgroups', 'nagdrop_hostgroups.hostgroup_id = nagdrop_hostgroup_services.hostgroup_id');
		$this->db->join('nagdrop_hostgroup_members', 'nagdrop_hostgroup_members.hostgroup_id = nagdrop_hostgroups.hostgroup_id', 'INNER');
		$this->db->distinct();
		$this->db->select('nagdrop_hostgroups.alias');
		$q = $this->db->get('nagdrop_hostgroup_services');
		$query = "SELECT DISTINCT nagdrop_hostgroups.alias
                  FROM   nagdrop_hostgroup_services
                         INNER JOIN nagdrop_hostgroups
                         ON     (nagdrop_hostgroups.hostgroup_id = nagdrop_hostgroup_services.hostgroup_id)
                         INNER JOIN nagdrop_hostgroup_members
                         ON     (nagdrop_hostgroup_members.hostgroup_id = nagdrop_hostgroups.hostgroup_id)
                  WHERE  nagdrop_hostgroup_services.service_id         = $id";
		$data = '';
		foreach ($q->result() as $value)
		{
			$data .= ',' . $value->alias ;
		}
		return substr($data, 1);
	}

	/**
	 * Gets hostgroups that are attached to a service
	 * This is for the UI
	 *
	 * @return array $data
	 */
	function getHostgroupsForService($id) {
		$data = array();
		$this->db->select('nagdrop_hostgroups.hostgroup_id, nagdrop_hostgroups.hostgroup_id as owner_id, nagdrop_hostgroup_services.hostgroup_service_id as div_id, nagdrop_hostgroups.alias as alias, nagdrop_hostgroups.alias as display_name');
		$this->db->from('nagdrop_hostgroups');
		$this->db->join('nagdrop_hostgroup_services', 'nagdrop_hostgroup_services.hostgroup_id = nagdrop_hostgroups.hostgroup_id');
		$this->db->where('nagdrop_hostgroup_services.service_id', $id);
		$this->db->order_by('alias', 'ASC');

		$q = $this->db->get();

		foreach ($q->result() as $row) {
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * Gets hosts that are attached to a service
	 * This is for file writing
	 *
	 * @return array $data
	 */
	function getHosts($id)
	{
		//$query = 'select nagdrop_hosts.host_name from nagdrop_services_hosts left join nagdrop_hosts on (nagdrop_hosts.host_id = nagdrop_services_hosts.host_id) where nagdrop_services_hosts.service_id = ' . $id;
		//$q = $this->db->query($query);
		$this->db->where('nagdrop_services_hosts.service_id', $id);
		$this->db->join('nagdrop_hosts', 'nagdrop_hosts.host_id = nagdrop_services_hosts.host_id');
		$this->db->select('nagdrop_hosts.host_name');
		$q = $this->db->get('nagdrop_services_hosts');
		$results = $q->result();
		$data = '';
		foreach ($results as $result)
		{
			$data .= ',' . $result->host_name ;
		}
		return substr($data, 1);
	}

	/**
	 * Gets hosts that are attached to a service
	 * This is for the UI
	 *
	 * @return array $data
	 */
	function getHostsForService($id) {
		$data = array();
		$this->db->select('nagdrop_hosts.host_id, nagdrop_hosts.host_id as div_id, nagdrop_services_hosts.service_host_id as owner_id, display_name as host_name, nagdrop_hosts.alias as alias, nagdrop_hosts.display_name as display_name, nagdrop_thosts.icon_image as icon_image');
		$this->db->from('nagdrop_hosts');
		$this->db->join('nagdrop_services_hosts', 'nagdrop_services_hosts.host_id = nagdrop_hosts.host_id');
		$this->db->join('nagdrop_thosts', 'nagdrop_thosts.thost_id = nagdrop_hosts.thost_id');
		$this->db->where('nagdrop_services_hosts.service_id', $id);
		$this->db->order_by('display_name', 'ASC');
		$q = $this->db->get();

		foreach ($q->result() as $row) {
			$data[] = $row;
		}
		return $data;
	}

	/**
	 * Gets service and host ids for a particular value in nagdrop_services_hosts
	 *
	 * @return array $data
	 */
	function getServiceHost($data)
	{
		$this->db->where('service_host_id', $data);
		$this->db->select('service_id, host_id');
		$q = $this->db->get('nagdrop_services_hosts');
		$data = $q->result();
		return $data;
	}

	/**
	 * Gets a particular template
	 *
	 * @return array $data
	 */
	function getTemplate($template_id)
	{
		$query = "select *,
              command_name as check_command, s.check_command_id as check_command_id
              from nagdrop_tservices s
              left join nagdrop_check_commands c on (s.check_command_id = c.command_id)
              where tservice_id = $template_id";
		$q = $this->db->query($query);
		if ($q->num_rows() >0)
		{
			foreach($q->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	/**
	 * Insert a host into the service-host table
	 *
	 * @return array $data
	 */
	function insertHost($data)
	{
		//Add a host to the services to hosts table
		//Make sure it doesn't already exist!
		$sql = 'select service_host_id from nagdrop_services_hosts where host_id = ? and service_id = ?';
		//We need the keys for the insert but just the values for the select
		$q = $this->db->query($sql, array($data['host_id'], $data['service_id']));
		if ($q->num_rows == 0)
		{
			$success = $this->db->insert('nagdrop_services_hosts', $data);
		} else {
			$success = FALSE;
		}
		return $success;
	}

	/**
	 * Take a host out of the service-host table
	 *
	 * @return array $data
	 */
	function removeServiceHost($data)
	{
		//Add a host to the services to hosts table
		//Make sure it doesn't already exist!
		$this->db->where('service_host_id', $data);
		$success = $this->db->delete('nagdrop_services_hosts');
		return $success;
	}

  /**
   * Update a particular service
   *
   * @return array $data
   */
	function update($id, $data)
	{
		$this->db->where('service_id',$id);
		$this->db->update('nagdrop_services',$data);
	}




}
?>
