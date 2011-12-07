<?php
/**
 * Servicegroup model
 * Service groups aren't being used yet so this isn't complete or tested
 * This is the file that talks to our database and pulls back Servicegroup information
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 31 December 2009
 */
class Servicegroup_model extends Model
{
	/**
	 * Add a new servicegroup into the database
	 *
	 * @return array $data
	 */
	function add($data)
	{
		$this->db->insert('nagdrop_servicegroups', $data);
		return;
	}

	/**
	 * Deletes a servicegroup into the database
	 *
	 * @return array $data
	 */
	function delete()
	{
		$this->db->where('host_id', $this->uri->segment(3));
		$this->db->delete('nagdrop_servicegroups');
	}

	/**
	 * Returns servicegroups
	 *
	 * @return array $data
	 */
	function getAll($perPage = 100000000, $start = 0)
	{
		$this->db->select('servicegroup_id, alias');
		$this->db->order_by("alias", "asc");
		$this->db->limit($perPage, $start);
		$q = $this->db->get('nagdrop_servicegroups');
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
	 * Grab back our Host ID, Alias and Icon Image
	 * @return
	 */
	function getAllMenu($perPage = 100000000, $start = 0)
	{
		$this->db->select('servicegroup_id, alias');
		$this->db->order_by("alias", "asc");
		$this->db->limit($perPage, $start);
		$q = $this->db->get('nagdrop_servicegroups');
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
	 * Gets a count of service groups in our DB
	 *
	 * @return array $data
	 */
	function getCount()
	{
		return $this->db->count_all_results('nagdrop_servicegroups');
	}

	/**
	 * Update a servicegroup
	 *
	 * @return array $data
	 */
	function update($data)
	{
		$this->db->where('id',$this->uri->segment(3));
		$this->db->update('nagdrop_servicegroups',$data);
	}

}
?>