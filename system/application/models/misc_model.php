<?php
/**
 * Misc model
 * Any database functions that don't belong elsewhere go here
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */
class Misc_model extends Model {
	/**
	 * Gets all information about the check_commands in the database
	 * This is used to write the check command file
	 *
	 * @return array $data
	 */
	function getCheckCommandsFile()
	{
		$this->db->order_by('command_name');
		$this->db->select('command_name, command_line');
		$q = $this->db->get('nagdrop_check_commands');
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
	 * Gets information about the check_commands in the database
	 *
	 * @return array $data
	 */
	function getCommands()
	{
		$this->db->order_by('command_line');
		$this->db->select('command_id, command_name');
		$q = $this->db->get('nagdrop_check_commands');
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
	 * Gets all services assigned to a hostgroup
	 *
	 * @return array $data
	 */
	function getHostgroupServices()
	{
		$this->db->order_by('hostgroup_id');
		$q = $this->db->get('nagdrop_hostgroup_services');
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
	 * Gets all services assigned to a host
	 *
	 * @return array $data
	 */
	function getHostServices()
	{
		$this->db->order_by('host_id');
		$q = $this->db->get('nagdrop_services_hosts');
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
	 * Gets all information about host templates
	 *
	 * @return array $data
	 */
	function getHostTemplates()
	{
		$this->db->order_by('thost_name');
		$this->db->select('thost_id, thost_name');
		$q = $this->db->get('nagdrop_thosts');
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
	 * Gets all information about service templates
	 *
	 * @return array $data
	 */
	function getServiceTemplates()
	{
		$this->db->order_by('display_name');
		$this->db->select('tservice_id, display_name');
		$q = $this->db->get('nagdrop_tservices');
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
	 * Gets all information about timeperiods
	 *
	 * @return array $data
	 */
	function getTimeperiods()
	{
		$this->db->order_by('alias');
		$q = $this->db->get('nagdrop_timeperiods');
		if ($q->num_rows() >0)
		{
			foreach($q->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
	}

}
?>