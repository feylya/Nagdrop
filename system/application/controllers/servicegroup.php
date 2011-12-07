<?php
/**
 * Service controller
 * Gives back data for all calls about services
 * Menu data is also generated through here (this is so
 * the HS Menu can be refreshed when a new Host/Service/megadome
 * is added to it)
 *
 * This isn't being used in this version of the code
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 31 December 2009
 */

class Servicegroup extends Controller{

	/**
	 * Creates a new servicegroup
	 *
	 * @return null
	 */
	function create()
	{
		$data = array(
			'alias' => $this->input->post('alias'),
			'icon_image' => $this->input->post('icon_image')
		);

		$this->servicegroup_model->addHost($data);

		$this->index();
	}

	/**
	 * Deletes a specific servicegroup
	 *
	 * @return null
	 */
	function delete()
	{
		$this->servicegroup_model->deleteHost();
		$this->index();
	}

	/**
	 * Gets all the servicegroups and loads them up into the main view
	 *
	 * @return null
	 */
	function getAll()
	{
		$data['rows'] = $this->servicegroup_model->getAll();

		$this->load->view('page/servicegroup_view', $data);
	}

	/**
	 * Gets all the hosts for the service group
	 *
	 * @return null
	 */
	function getHosts()
	{
		$id = $this->uri->segment(3);
		$q = $this->hostgroup_model->getForHostgroup($id);
		$data = array("HGhosts"=>$q);
		$page = $this->load->view('part/hostgroups_hosts_view', $data, TRUE);
		echo $page;
		//return $page;
	}

	/**
	 * Index function
	 * First function that's hit when navigating to /nui/servicegroup
	 *
	 * Not actually needed - just used this as a test bed for migration
	 * to CodeIgniter
	 *
	 * @deprecated
	 *
	 * @return null
	 */
	function index()
	{
		$data = array();

		if($query = $this->servicegroup_model->getAll())
		{
			$data['records'] = $query;
		}

		$this->load->view('servicegroups_view', $data);
	}

	/**
	 * Gets the servicegroup objects for the menu
	 *
	 * @return null
	 */
	function menu()
	{
		$data = array();

		if($query = $this->servicegroup_model->getAllMenu())
		{
			$data['results'] = $query;
		}

		$this->load->view('menu/servicegroup_view', $data);
	}

	/**
	 * Updates a specific servicegroup
	 *
	 * @return null
	 */
	function update()
	{
		$data = array(
    'alias' => 'name');
	}
}
?>