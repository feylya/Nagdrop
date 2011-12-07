<?php
/**
 * Host model
 * This is the file that talks to our database and pulls back host information
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */
class Host_model extends Model
{
  /**
   * Insert a new host into the database
   *
   * @return array $data
   */
  function add($data)
  {
    $this->db->insert('nagdrop_hosts', $data);
    return;
  }
  
  /**
   * Delete a host from the database
   * Makes sure to remove all references to it
   *
   * @return array $data
   */
  function delete($id)
  {
    //Take the host out of any hostgroups it was in
    $this->db->where('host_id', $id);
    $this->db->delete('nagdrop_hostgroup_members');
    //Take the host out of any services it was in
    $this->db->where('host_id', $id);
    $this->db->delete('nagdrop_services_hosts');
    //Delete the actual host
    $this->db->where('host_id', $id);
    $this->db->delete('nagdrop_hosts');
  }
  
  /**
   * Gets all information about a particular host
   * If the host_id is 0, this is a new host and so inserts the values
   *
   * @return array $data
   */
  function get($host_id)
  {
    if ($host_id == 0)
    {
      //If this host doesn't exist
      $data=array('host_name'=>'CHANGEME',
            'alias'=>'CHANGEME',
            'display_name'=>'CHANGEME',
            'address'=>'CHANGEME',
            'thost_id'=>1);
      $this->db->insert('nagdrop_hosts', $data);
      $this->db->where('host_name', 'CHANGEME');
      $q = $this->db->get('nagdrop_hosts');
      $row = $q->result();
      $host_id = $row[0]->host_id;
    }
    $this->db->where('host_id', $host_id);
    $q = $this->db->get('nagdrop_hosts');
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
   * Gets the display_name and alias for a host_id
   *
   * @return array $data
   */
  function getAlias($data)
  {
    $this->db->where($data);
    $this->db->select('display_name, alias');
    $q = $this->db->get('nagdrop_hosts');
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
	 * Pulls back some details for the side menu
	 * Replaces in template information where necessary
	 *
	 * Mostly called via an AJAX post
	 *
	 *
	 * @return array $data
	 */
	function getAllMenu($perPage = 100000000, $start = 0)
	{
		$this->db->select('host_id, thost_id, alias, display_name, icon_image');
		$this->db->order_by("display_name", "asc");
		$this->db->limit($perPage, $start);
		$q = $this->db->get('nagdrop_hosts');
		if ($q->num_rows() >0)
		{
			foreach($q->result() as $row)
			{
				if ($row->icon_image == "" || $row->icon_image == NULL) {
					//The icon image is in the template so we'll need to grab that out
					$r = $this->db->select('icon_image')->where('thost_id', $row->thost_id)->get('nagdrop_thosts');
					$icon_image = $r->result();
					$row->icon_image = $icon_image[0]->icon_image;
				}
				$data[] = $row;
			}
			return $data;
		}
	}

	/**
	 * Pulls back all information about hosts
	 * Swaps out template icon image if necessary
	 *
	 * @return array $data
	 */
	function getAll($perPage = 100000000, $start = 0)
	{
		//$q = $this->db->get('nagdrop_hosts');
		//Should convert this query into an Active Record possibly...
		//    * OK
		//    * WARNING
		//    * UNKNOWN
		//    * CRITICAL
			
		if (!$start) $start=0;
			
		$q = $this->db->query("select
									host.host_id,
									host.thost_id,
									host.alias, 
									host.display_name, 
									host.address,
									host.icon_image as icon_image,
									thosts.icon_image as ticon_image,
									hoststatus.status_update_time,
									hoststatus.current_state,
									hoststatus.output,
									hoststatus.last_state_change,
									(case hoststatus.current_state when '0' then 'OK' when 1 then 'WARNING' when 2 then 'CRITCAL' else 'Not Checked' end) as current_state_friendly
								from nagdrop_hosts host
								left join nagios_hosts hosts on (host.display_name = hosts.display_name)
								left join nagios_hoststatus hoststatus on (hosts.host_object_id = hoststatus.host_object_id)
								left join nagdrop_thosts thosts on (host.thost_id = thosts.thost_id)
								order by display_name asc
								limit " . $start . ", " . $perPage);
		$data = $q->result();
		foreach ($data as $row) {
			if ($row->icon_image == NULL || $row->icon_image == "" || $row->icon_image == -1) {
				$row->icon_image = $row->ticon_image;
			}
			$output[] = $row;
		}

		return $output;
	}

  /**
   * Gets a count of all the hosts in the database
   *
   * @return array $data
   */
  function getCount()
  {
    return $this->db->count_all_results('nagdrop_hosts');
  }

  /**
   * Gets all information about all hosts
   * Swaps out template data as necessary
   * This is important - used to write the configuration files
   *
   * @return array $data
   */
  function getFileInfo()
  {
    //This needs to take template information into account
    //Use popup method for checking
    $query = "select
            thost_id,
            alias,
            display_name as host_name,
            address,
            eventhandler_command_args,
            check_interval,
            retry_interval,
            command_name as check_command,
            max_check_attempts,
            first_notification_delay,
            notification_interval,
            'notification_options',
            notify_on_down, 
            notify_on_unreachable, 
            notify_on_recovery, 
            notify_on_flapping, 
            notify_on_downtime,
            'stalking_options',
            stalk_on_up, 
            stalk_on_down, 
            stalk_on_unreachable,
            flap_detection_enabled,
            'flap_detection_options',
            flap_detection_on_up, 
            flap_detection_on_down, 
            flap_detection_on_unreachable,
            low_flap_threshold,
            high_flap_threshold,
            freshness_threshold,
            passive_checks_enabled,
            event_handler_enabled,
            active_checks_enabled,
            retain_status_information,
            retain_nonstatus_information,
            notifications_enabled,
            obsess_over_host,
            notes,
            notes_url,
            action_url,
            icon_image,
            icon_image_alt,
            vrml_image,
            statusmap_image,
            'twod_coords',
            'threed_coords',
            x_2d,
            y_2d,
            x_3d,
            y_3d,
            z_3d
          from nagdrop_hosts h
          left join nagdrop_check_commands c on (h.check_command_id = c.command_id)";

    $q = $this->db->query($query);
    $results = $q->result();
    foreach ($results as $result)
    {
      $tid = $result->thost_id;
      $thost = $this->host_model->getTemplate($tid);
      foreach ($result as $key=>$value) {
        //Let's check if we need to stick in the template info to our hash table
        $ignore = array('alias',
                'notification_options',
                'stalking_options',
                'flap_detection_options',
                'twod_coords',
                'threed_coords');
        if (!in_array($key, $ignore) && ($value == NULL || $value == -1 || $value == "")) {
          $result->$key = $thost[0]->$key;
        } else {
          $result->$key = $value;
        }
        $result->notification_options = ''; //We only want the field in the result set, not the data from the database
        $result->notify_on_down == 1 ? $result->notification_options = $result->notification_options . ",d" : 0;
        $result->notify_on_unreachable == 1 ? $result->notification_options = $result->notification_options . ",u" : 0;
        $result->notify_on_recovery == 1 ? $result->notification_options = $result->notification_options . ",r" : 0;
        $result->notify_on_flapping == 1 ? $result->notification_options = $result->notification_options . ",f" : 0;
        $result->notify_on_downtime == 1 ? $result->notification_options = $result->notification_options . ",s" : 0;

        $result->stalking_options = '';
        $result->stalk_on_up == 1 ? $result->stalking_options = $result->stalking_options . ",o" : 0;
        $result->stalk_on_down == 1 ? $result->stalking_options = $result->stalking_options . ",d" : 0;
        $result->stalk_on_unreachable == 1 ? $result->stalking_options = $result->stalking_options . ",u" : 0;

        $result->flap_detection_options = '';
        $result->flap_detection_on_up == 1 ? $result->flap_detection_options = $result->flap_detection_options . ",o" : 0;
        $result->flap_detection_on_down == 1 ? $result->flap_detection_options = $result->flap_detection_options . ",d" : 0;
        $result->flap_detection_on_unreachable == 1 ? $result->flap_detection_options = $result->flap_detection_options . ",u" : 0;

        $result->twod_coords = '';
        $result->twod_coords = $result->x_2d . ',' . $result->y_2d;

        $result->threed_coords = '';
        $result->threed_coords = $result->x_3d . ',' . $result->y_3d . ',' . $result->z_3d;
      }

      //If we don't unset, we'll get errors
      unset($result->thost_id);
      unset($result->notify_on_down);
      unset($result->notify_on_unreachable);
      unset($result->notify_on_recovery);
      unset($result->notify_on_flapping);
      unset($result->notify_on_downtime);
      unset($result->stalk_on_up);
      unset($result->stalk_on_down);
      unset($result->stalk_on_unreachable);
      unset($result->flap_detection_enabled);
      unset($result->flap_detection_on_up);
      unset($result->flap_detection_on_down);
      unset($result->flap_detection_on_unreachable);
      unset($result->x_2d);
      unset($result->y_2d);
      unset($result->x_3d);
      unset($result->y_3d);
      unset($result->z_3d);

      $result->notification_options = substr($result->notification_options, 1);
      $result->stalking_options = substr($result->stalking_options, 1);
      $result->flap_detection_options = substr($result->flap_detection_options, 1);
      $data[] = $result;
    }
    return $data;
  }
  
	/**
	 * Gets information about all the hostsgroups a host is in
	 *
	 * @return array $data
	 */
	function getHostgroupsForHost($id) {
		$data = array();
		$this->db->select('nagdrop_hostgroups.hostgroup_id,
		                  nagdrop_hostgroups.hostgroup_id as owner_id, 
		                  nagdrop_hostgroup_members.hostgroup_member_id as div_id, 
		                  nagdrop_hostgroups.alias as alias, 
		                  nagdrop_hostgroups.alias as display_name');
		$this->db->from('nagdrop_hostgroups');
		$this->db->join('nagdrop_hostgroup_members',
		                 'nagdrop_hostgroup_members.hostgroup_id = nagdrop_hostgroups.hostgroup_id');
		$this->db->where('nagdrop_hostgroup_members.host_id', $id);
		$this->db->order_by('alias', 'ASC');

		$q = $this->db->get();

		foreach ($q->result() as $row) {
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * Gets information about all the services the host has assigned to it
	 *
	 * @return array $data
	 */
	function getServicesForHost($host_id)
	{
		$data = array();
		$services = array();

		$this->db->select('*, service_host_id as div_id,
		                  nagdrop_services_hosts.host_id as owner_id');
		$this->db->join('nagdrop_services_hosts', 'nagdrop_services_hosts.service_id = nagdrop_services.service_id');
		$this->db->where('nagdrop_services_hosts.host_id', $host_id);
		$this->db->order_by('nagdrop_services_hosts.host_id', 'asc');
		$this->db->order_by('nagdrop_services.display_name', 'asc');
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
	 * Function to get a list of all hosts on the off chance that one of them is a parent.
	 * @return
	 */
	function getParentList()
	{

	}

	/**
	 * Pulls back information for a specific template
	 *
	 * @return array $data
	 */
	function getTemplate($template_id)
	{
		//$this->db->where('thost_id', $template_id);
		//$this->db->join('nagdrop_check_commands','check_command_id = command_id');
		//$q = $this->db->get('nagdrop_thosts');
		$query = "select *,
						command_name as check_command
					from nagdrop_thosts h
					left join nagdrop_check_commands c on (h.check_command_id = c.command_id)
					where thost_id = $template_id";
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
   * Update a host in the database
   *
   * @return array $data
   */
	function update($id, $data)
	{
		$this->db->where('host_id',$id);
		$this->db->update('nagdrop_hosts',$data);
	}


}
?>