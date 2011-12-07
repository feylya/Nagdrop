<?php
/**
 * Hostgroup model
 * This is the file that talks to our database and pulls back hostgroup information
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */
class Hostgroup_model extends Model {
	/**
	 * Delete a hostgroup from the database
	 * Makes sure to remove all references to it
	 *
	 * @return array $data
	 */
	function delete($id)
	{
		//Delete the actual hostgroup
		$this->db->where('hostgroup_id', $id);
		$this->db->delete('nagdrop_hostgroups');
		//And any members or services it had
		$this->db->where('hostgroup_id', $id);
		$this->db->delete('nagdrop_hostgroup_members');
		$this->db->where('hostgroup_id', $id);
		$this->db->delete('nagdrop_hostgroup_services');
	}

	/**
	 * Gets all information about a particular hostgroup
	 * If the host_id is 0, this is a new hostgroup and so inserts the values
	 *
	 * @return array $data
	 */
	function get($hostgroup_id)
	{
		if ($hostgroup_id == 0)
		{
			//If this host doesn't exist
			$data=array('alias'=>'CHANGEME');
			$this->db->insert('nagdrop_hostgroups', $data);
			//We've added it, let's find out it's ID
			$this->db->where('alias', 'CHANGEME');
			$q = $this->db->get('nagdrop_hostgroups');
			$row = $q->result();
			$hostgroup_id = $row[0]->hostgroup_id;
		}
		$this->db->where('hostgroup_id', $hostgroup_id);
		$q = $this->db->get('nagdrop_hostgroups');
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
	function getAlias($data) {
		$this->db->where($data);
		$this->db->select('alias');
		$q = $this->db->get('nagdrop_hostgroups');
		return $q->result();
	}

	/**
	 * Pulls back all information
	 *
	 * Mostly called via an AJAX post
	 *
	 *
	 * @return array $data
	 */
	function getAll($perPage = 100000000, $start = 0) {
		$this->db->select('*');
		$this->db->order_by('alias', 'asc');
		$this->db->from('nagdrop_hostgroups');
		$q = $this->db->get();

		foreach ($q->result() as $hostgroup) {
			$data[] = $hostgroup;
		}

		return $data;
	}

	/**
	 * Pulls back some details for the side menu
	 *
	 * Mostly called via an AJAX post
	 *
	 *
	 * @return array $data
	 */
	function getAllMenu($perPage = 100000000, $start = 0) {
		$this->db->select('hostgroup_id, alias');
		$this->db->order_by("alias", "asc");
		$this->db->limit($perPage, $start);
		$q = $this->db->get('nagdrop_hostgroups');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}

	/**
	 * Gets a count of all the hostgroups in the database
	 *
	 * @return array $data
	 */
	function getCount() {
		return $this->db->count_all_results('nagdrop_hostgroups');
	}

	/**
	 * Gets all information about all hostgroups and their hosts
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
              hostgroup_id,
              alias,
              alias as hostgroup_name,
              'members'
            from nagdrop_hostgroups";

		$q = $this->db->query($query);
		$results = $q->result();
		foreach ($results as $result)
		{
			$id = $result->hostgroup_id;
			$members = $this->getMembers($id);
			/* if (strlen($members) < 1)
			 {
			 break 1; //don't include this hostgroup if it doesn't have any members!
			 }*/
			foreach ($result as $key=>$value) {
				//Let's check if we need to stick in the template info to our hash table
				$ignore = array('members');
				if (!in_array($key, $ignore) && ($value == NULL || $value == -1 || $value == ""))
				{
					$result->$key = $thost[0]->$key;
				} else {
					$result->$key = $value;
				}
				$result->members = $members;
			}
			unset($result->hostgroup_id);
			$data[] = $result;
		}
		return $data;
	}


	/**
	 * Gets id's for a host in a particular hostgroup
	 *
	 * @return array $data
	 */
	function getHostgroupHost($data) {
		$this->db->where('hostgroup_member_id', $data);
		$this->db->select('hostgroup_id, host_id');
		$q = $this->db->get('nagdrop_hostgroup_members');
		$data = $q->result();
		return $data;
	}

	/**
	 * Gets id's for a service in a particular hostgroup
	 *
	 * @return array $data
	 */
	function getHostgroupService($data) {
		$this->db->where('hostgroup_service_id', $data);
		$this->db->select('hostgroup_id, service_id');
		$q = $this->db->get('nagdrop_hostgroup_services');
		$data = $q->result();
		return $data;
	}


	/**
	 * Gets information about the hosts in a particular hostgroup
	 *
	 * @return array $data
	 */
	function getHostsForHostgroup($id) {
		$data = array();
		$this->db->select('nagdrop_hosts.host_id, nagdrop_hostgroup_members.hostgroup_member_id as owner_id, nagdrop_hostgroup_members.hostgroup_id as div_id, display_name as host_name, nagdrop_hosts.alias as alias, nagdrop_hosts.display_name as display_name, nagdrop_thosts.icon_image as icon_image');
		$this->db->from('nagdrop_hosts');
		$this->db->join('nagdrop_hostgroup_members', 'nagdrop_hostgroup_members.host_id = nagdrop_hosts.host_id');
		$this->db->join('nagdrop_thosts', 'nagdrop_thosts.thost_id = nagdrop_hosts.thost_id');
		$this->db->where('nagdrop_hostgroup_members.hostgroup_id', $id);
		$this->db->order_by('display_name', 'ASC');

		$q = $this->db->get();

		foreach ($q->result() as $row) {
			$data[] = $row;
		}

		return $data;
	}

	/**
	 * Gets information about what hosts in a particular hostgroup
	 *
	 * @return array $data
	 */
	function getMembers($id)
	{
		$this->db->where('nagdrop_hostgroup_members.hostgroup_id', $id);
		$this->db->join('nagdrop_hosts', 'nagdrop_hosts.host_id = nagdrop_hostgroup_members.host_id');
		$this->db->select('nagdrop_hosts.host_name');
		$q = $this->db->get('nagdrop_hostgroup_members');
		$results = $q->result();
		$data = '';
		foreach ($results as $result)
		{
			$data .= ',' . $result->host_name ;
		}
		return substr($data, 1);
	}

	/**
	 * Gets information about the services in a particular hostgroup
	 *
	 * @return array $data
	 */
	function getServicesForHostgroup($id) {
		$data = array();
		$this->db->select('nagdrop_services.service_id, nagdrop_hostgroup_services.hostgroup_service_id as div_id, nagdrop_hostgroup_services.hostgroup_id as owner_id, display_name as display_name, display_name as alias, nagdrop_services.icon_image as icon_image');
		$this->db->from('nagdrop_services');
		$this->db->join('nagdrop_hostgroup_services', 'nagdrop_hostgroup_services.service_id = nagdrop_services.service_id');
		$this->db->where('nagdrop_hostgroup_services.hostgroup_id', $id);
		$this->db->order_by('alias', 'ASC');

		$q = $this->db->get();

		foreach ($q->result() as $row) {
			$data[] = $row;
		}
		return $data;
	}

	/**
	 * Inserts a host into a hostgroup
	 *
	 * @return array $data
	 */
	function insertHost($data) {
		//Add a host to the hostgroup_member table
		//Make sure it doesn't already exist!
		$sql = 'select hostgroup_member_id from nagdrop_hostgroup_members where host_id = ? and hostgroup_id = ?';
		//We need the keys for the insert but just the values for the select
		$q = $this->db->query($sql, array($data['host_id'], $data['hostgroup_id']));
		if ($q->num_rows == 0) {
			$success = $this->db->insert('nagdrop_hostgroup_members', $data);
		} else {
			$success = FALSE;
		}
		return $success;
	}

	/**
	 * Inserts a service into a hostgroup
	 *
	 * @return array $data
	 */
	function insertService($data) {
		//Add a service to the hostgroup_member table
		//Make sure it doesn't already exist!
		$sql = 'select hostgroup_service_id from nagdrop_hostgroup_services where service_id = ? and hostgroup_id = ?';
		//We need the keys for the insert but just the values for the select
		$q = $this->db->query($sql, array($data['service_id'], $data['hostgroup_id']));
		if ($q->num_rows == 0) {
			$success = $this->db->insert('nagdrop_hostgroup_services', $data);
		} else {
			$success = FALSE;
		}
		return $success;
	}

	/**
	 * Removes a host from a hostgroup
	 *
	 * @return array $data
	 */
	function removeHostgroupHost($data) {
		//Add a host to the services to hosts table
		//Make sure it doesn't already exist!
		$this->db->where('hostgroup_member_id', $data);
		$success = $this->db->delete('nagdrop_hostgroup_members');
		return $success;
	}

	/**
	 * Removes a service from a hostgroup
	 *
	 * @return array $data
	 */
	function removeHostgroupService($data) {
		//Add a host to the services to hosts table
		//Make sure it doesn't already exist!
		$this->db->where('hostgroup_service_id', $data);
		$success = $this->db->delete('nagdrop_hostgroup_services');
		return $success;
	}

	/**
	 * Updates a hostgroup
	 *
	 * @return array $data
	 */
	function update($id, $data)
	{
		$this->db->where('hostgroup_id',$id);
		$this->db->update('nagdrop_hostgroups',$data);
	}
}
?>
