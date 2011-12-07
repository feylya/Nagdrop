<?php
/**
 * Host controller
 * Gives back data for all calls about hosts
 * Menu data is also generated through here (this is so
 * the HS Menu can be refreshed when a new Host/Service/megadome
 * is added to it)
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 31 December 2009
 */

class Host extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->scaffolding('nagdrop_thosts');
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

		if($query = $this->host_model->getAll($config['per_page'], $this->uri->segment(3)))
		{
			$data['hosts'] = $query;
		}

		$this->load->view('page/hosts_view', $data);
	}

	/**
	 * Gets all configuration items for a specific host
	 * host_id is passed in the uri - /nui/host/get/host_id
	 * Gets all details about the host and the hosts template
	 * Data need to be manipulated later to fill in the blanks
	 * from the host table with the template data
	 *
	 * Mostly called via an AJAX post
	 *
	 *
	 * @return array $data
	 */
	function get()
	{
		$data = array();
		$id = $this->uri->segment(3);

		if($query = $this->host_model->get($id))
		{
			$data['host'] = $query;
		}

		if($query = $this->host_model->getTemplate($data['host'][0]->thost_id))
		{
			$data['template'] = $query;
		}

		var_export($data);
		return $data;
	}
  
  /**
   * Gets all hostgroups that a specific host is a member of
   * host_id is passed in the uri - /nui/host/get/host_id
   *
   *
   * @return array $data
   */
	function getHostgroups()
	{
		$id = $this->uri->segment(3);
		$q = $this->host_model->getHostgroupsForHost($id);
		$data = array('hostgroups'=>$q, 'javascript'=>'removeHostgroupFromHost');
		$page = $this->load->view('part/hostgroups_view', $data, TRUE);
		echo $page;
		//return $page;
	}
  
  /**
   * Gets all services that a specific host is a member of
   * host_id is passed in the uri - /nui/host/get/host_id
   *
   *
   * @return array $data
   */
	function getServices()
	{
		$id = $this->uri->segment(3);
		$q = $this->host_model->getServicesForHost($id);
		$data = array('services'=>$q, 'javascript'=>'removeServiceFromHost');
		$page = $this->load->view('part/services_view', $data, TRUE);
		echo $page;
		//return $page;
	}

	/**
	 * Creates a new host item
	 * This needs to be compeletely redone
	 * It was used as a test bed for the migration to CodeIgniter
	 *
	 * @TODO Redo this whole function
	 *
	 * @return
	 */
	function create()
	{
		$data = array(
			'alias' => $this->input->post('alias'),
			'icon_image' => $this->input->post('icon_image')
		);

		$this->host_model->addHost($data);

		//This is probably not going to redirect anywhere
		$this->index();

	}

	/**
	 * This deletes a host item
	 * This needs to be redone
	 * It was a testbed for migration to CodeIgniter
	 *
	 * @TODO Redo this whole function
	 *
	 * @return
	 */
	function delete()
	{
		$this->host_model->deleteHost();
		$this->index();
	}
  
  /**
   * This updates a host item
   * This needs to be redone
   * It was a testbed for migration to CodeIgniter
   *
   * @TODO Redo this whole function
   *
   * @return
   */
	function update()
	{
		$data = array(
		'alias' => 'name');
	}
  
  /**
   * This displays hosts for the menu
   * This needs to be redone
   * It was a testbed for migration to CodeIgniter
   *
   * @TODO Redo this whole function
   *
   * @return
   */
	function menu()
	{
		$data = array();

		if($query = $this->host_model->getAllMenu())
		{
			$data['results'] = $query;
		}

		$this->load->view('menu/host_view');
	}
  
  /**
   * Same as $this->get()
   * Needs to be cleaned up
   *
   * @TODO Cleanup
   *
   * @return
   */
	function getAll()
	{
		$data['rows'] = $this->host_model->getAll();

		$this->load->view('page/host_view', $data);
	}

}
?>