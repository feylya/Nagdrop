<?php
/**
 * Service controller
 * Gives back data for all calls about services
 * Menu data is also generated through here (this is so
 * the HS Menu can be refreshed when a new Host/Service/megadome
 * is added to it)
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 31 December 2009
 */

class Service extends Controller{

	/**
	 * Creates a new service
	 *
	 * @return null
	 */
	function create()
	{
		$data = array(
      'alias' => $this->input->post('alias'),
      'icon_image' => $this->input->post('icon_image')
		);

		$this->host_model->addHost($data);

		$this->index();

	}

	/**
	 * Deletes a specific service
	 *
	 * @return null
	 */
	function delete()
	{
		$this->host_model->deleteHost();
		$this->index();
	}

	/**
	 * Index function
	 * First function that's hit when navigating to /nui/host
	 *
	 * Not actually needed - just used this as a test bed for migration
	 * to CodeIgniter
	 *
	 * @TODO Redo this whole function or delete
	 *
	 * @return null
	 */
	function index()
	{
		$data = array();

		if($query = $this->service_model->getAll())
		{
			$data['records'] = $query;
		}

		$this->load->view('temp_view', $data);
	}

	/**
	 * Gets all information about all hosts including template data for that service
	 *
	 * @return null
	 */
	function get()
	{
		$data = array();
		$id = $this->uri->segment(3);

		if($query = $this->service_model->get($id))
		{
			$data['service'] = $query;
		}

		if($query = $this->service_model->getTemplate($data['service'][0]->tservice_id))
		{
			$data['template'] = $query;
		}

		return $data;
	}

	/**
	 * Gets all the services and loads them up into the main view
	 *
	 * @return null
	 */
	function getAll()
	{
		$data['rows'] = $this->host_model->getAll();

		$this->load->view('page/host_view', $data);
	}

	/**
	 * Gets all the hosts that have this service attached to them
	 *
	 * @return null
	 */
	function getHosts()
	{
		$id = $this->uri->segment(3);
		$q = $this->service_model->getHostsForService($id);
		$data = array('hosts'=>$q, 'javascript'=>'removeHostFromService');
		$page = $this->load->view('part/hosts_view', $data, TRUE);
		echo $page;
		//return $page;
	}

	/**
	 * Gets all the hostgroups that have this service attached to them
	 *
	 * @return null
	 */
	function getHostgroups()
	{
		$id = $this->uri->segment(3);
		$q = $this->service_model->getHostgroupsForService($id);
		$data = array('hostgroups'=>$q, 'javascript'=>'removeServiceFromHostgroup');
		$page = $this->load->view('part/hostgroups_view', $data, TRUE);
		echo $page;
		//return $page;
	}

	/**
	 * Loads all the services objects for the side menu
	 *
	 * @return null
	 */
	function menu()
	{
		$data = array();

		if($query = $this->service_model->getAllMenu())
		{
			$data['results'] = $query;
		}

		$this->load->view('menu/service_view', $data);
	}

	/**
	 * Updates a specific service
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