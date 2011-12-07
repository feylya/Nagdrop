<?php
/**
 * Host Template model
 * This is the file that talks to our database and pulls back host template information
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 31 December 2009
 */
class Thost_model extends Model
{
	/**
	 * Add a new host template into the database
	 *
	 * @return array $data
	 */
	function add($data)
	{
		$this->db->insert('nagdrop_thosts', $data);
		return;
	}

	/**
	 * Delete a host template from the database
	 * Make sure to clean up any hosts that use it
	 *
	 * @return array $data
	 */
	function delete($id)
	{
		//We're deleting a host template, we need to nullify the values
		$data = array('thost_id'=>NULL);
		$this->db->where('thost_id', $id);
		$this->db->update('nagdrop_hosts', $data);
		$this->db->where('thost_id', $id);
		$this->db->delete('nagdrop_thosts');
	}

	/**
	 * Get a specific host template back from the DB
	 * If the id is 0, it's a new host template
	 * Insert it and then grab it's ID back
	 *
	 * @return array $data
	 */
	function get($thost_id)
	{
		if ($thost_id == 0)
		{
			//If this host doesn't exist
			$data=array('thost_name'=>'CHANGEME');
			$this->db->insert('nagdrop_thosts', $data);
			$this->db->where('thost_name', 'CHANGEME');
			$q = $this->db->get('nagdrop_thosts');
			$row = $q->result();
			$thost_id = $row[0]->thost_id;
		}
		$this->db->where('thost_id', $thost_id);
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
	 * Get the name for a specific host template
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
	 * Get back details about all the host templates
	 *
	 * @return array $data
	 */
	function getAll()
	{
		$this->db->order_by('thost_name','asc');
		$this->db->where('thost_id >','0');
		$q = $this->db->get('nagdrop_thosts');
		$data = $q->result();
		foreach ($data as $row) {
			$output[] = $row;
		}

		return $output;
	}

	/**
	 * Get a count of all the host templates in the DB
	 *
	 * @return array $data
	 */
	function getCount()
	{
		return $this->db->count_all_results('nagdrop_hosts');
	}

	/**
	 * Get all the hosts that are using this template
	 *
	 * @return array $data
	 */
	function getHosts($id)
	{
		$output = array();
		$this->db->select("nagdrop_hosts.display_name, nagdrop_hosts.alias, nagdrop_hosts.thost_id as owner_id, nagdrop_hosts.thost_id as div_id, nagdrop_thosts.icon_image, 'delete'", false);
		$this->db->join('nagdrop_thosts','nagdrop_thosts.thost_id = nagdrop_hosts.thost_id');
		$this->db->order_by('display_name','asc');
		$this->db->where('nagdrop_hosts.thost_id', $id);
		$q = $this->db->get('nagdrop_hosts');
		$data = $q->result();
		foreach ($data as $row) {
			$output[] = $row;
		}

		return $output;
	}

	/**
	 * Return information about a specific template
	 *
	 * @return array $data
	 */
	function getTemplate($template_id)
	{
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
	 * Update a specific template
	 *
	 * @return array $data
	 */
	function update($id, $data)
	{
		$this->db->where('thost_id',$id);
		$this->db->update('nagdrop_thosts',$data);
	}


}
?>