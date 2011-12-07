<?php
/**
 * Hostgroup controller
 * Gives back data for all calls about hostgroups
 * Menu data is also generated through here (this is so
 * the HS Menu can be refreshed when a new Host/Service/megadome
 * is added to it)
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */

class Hostgroup extends Controller{
  /**
   * Index function
   * First function that's hit when navigating to /nui/hostgroup
   *
   * Just here so that it doesn't error out
   * Could just redirect
   *
   * @TODO Change to a redirect() call
   *
   * @return null
   */
	function index()
	{
		$data = array();
		
		if($query = $this->hostgroup_model->getAll())
		{
			$data['records'] = $query;
		}
		
		$this->load->view('temp_view', $data);
	}

  /**
   * Returns information about all hostgroups
   *
   * @return array $data
   */
	function getAll()
	{
		$data['rows'] = $this->host_model->getAll();
		
		$this->load->view('page/host_view', $data);
	}
	
  /**
   * Gets all hosts that a specific hostgroup is a member of
   * host_id is passed in the uri - /nui/hostgroup/getHosts/host_id
   *
   *
   * @return array $data
   */
	function getHosts()
	{
		$id = $this->uri->segment(3);
		$q = $this->hostgroup_model->getHostsForHostgroup($id);
		$data = array('hosts'=>$q, 'javascript'=>'removeHostFromHostgroup');
		$page = $this->load->view('part/hosts_view', $data, TRUE);
		echo $page;
		//return $page;
	}
	
  /**
   * Gets all services that a specific hostgroup is a member of
   * host_id is passed in the uri - /nui/hostgroup/getServices/host_id
   *
   *
   * @return array $data
   */
	function getServices()
	{
		$id = $this->uri->segment(3);
		$q = $this->hostgroup_model->getServicesForHostgroup($id);
		$data = array('services'=>$q, 'javascript'=>'removeServiceFromHostgroup');
		$page = $this->load->view('part/services_view', $data, TRUE);
		echo $page;
		//return $page;
	}
	
    
  /**
   * Gets all hostgroups for the menu
   *
   * @return array $data
   */
  function menu()
  {
    $data = array();
    
    if($query = $this->hostgroup_model->getAllMenu())
    {
      $data['results'] = $query;
    }
    
    $this->load->view('menu/hostgroup_view', $data);
  }
  
	
}
