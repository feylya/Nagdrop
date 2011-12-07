<?php
/**
 * Service Template model
 * This is the file that talks to our database and pulls back service template information
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 31 December 2009
 */
class Tservice_model extends Model
{
	/**
	 * Add a new service template into the database
	 *
	 * @return array $data
	 */
	function add($data)
	{
		$this->db->insert('nagdrop_services', $data);
		return;
	}

	/**
	 * Delete a service template into the database
	 *
	 * @return array $data
	 */
	function delete($id)
	{
		//We're deleting a service template, we need to nullify the values
		$data = array('tservice_id'=>NULL);
		$this->db->where('tservice_id, $id');
		$this->db->update('nagdrop_services', $data);
		//Delete the template
		$this->db->where('tservice_id', $id);
		$this->db->delete('nagdrop_tservices');
	}

	/**
	 * Get details about a specific template
	 *
	 * @return array $data
	 */
	function get($tservice_id)
	{
		$this->db->where('tservice_id', $tservice_id);
		$q = $this->db->get('nagdrop_tservices');
		return $q->result() ;
	}

	/**
	 * Get the name for a specific service template
	 *
	 * @return array $data
	 */
	function getAlias($data)
	{
		$this->db->where($data);
		$this->db->select('display_name, display_name as alias');
		$q = $this->db->get('nagdrop_tservices');
		return $q->result();
	}

	/**
	 * Get all service templates where the id is greater than 0
	 *
	 * @return array $data
	 */
	function getAll()
	{
		//Get all templates
		$this->db->order_by('display_name','asc');
		$this->db->where('tservice_id >', '0');
		$q = $this->db->get('nagdrop_tservices');
		$data = $q->result();
		foreach ($data as $row) {
			$output[] = $row;
		}

		return $output;
	}

	/**
	 * Get a count of all service templates
	 *
	 * @return array $data
	 */
	function getCount()
	{
		return $this->db->count_all_results('nagdrop_tservices');
	}

	/**
	 * Get all the hosts that are currently using this template
	 *
	 * @return array $data
	 */
	function getServices($id)
	{
		$output = array();
		$this->db->select("nagdrop_services.display_name, nagdrop_services.display_name as alias, nagdrop_services.tservice_id as owner_id, nagdrop_services.tservice_id as div_id, nagdrop_tservices.icon_image, 'delete'", false);
		$this->db->join('nagdrop_tservices','nagdrop_tservices.tservice_id = nagdrop_services.tservice_id');
		$this->db->order_by('display_name','asc');
		$this->db->where('nagdrop_services.tservice_id', $id);
		$q = $this->db->get('nagdrop_services');
		$data = $q->result();
		foreach ($data as $row) {
			$output[] = $row;
		}

		return $output;
	}

	/**
	 * Get all information about this template
	 *
	 * @return array $data
	 */
	function getTemplate($template_id)
	{
		$this->db->where('tservice_id', $template_id);
		$q = $this->db->get('nagdrop_tservices');
		return $q->result();
	}

/**
   * Update this template
   *
   * @return array $data
   */
		function update($id, $data)
	{
		$this->db->where('tservice_id',$id);
		$this->db->update('nagdrop_tservices',$data);
	}




}
?>
