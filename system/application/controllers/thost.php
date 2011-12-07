<?php
/**
 * Host template controller
 * Gives back data for all calls about host templates
 * 
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 31 December 2009
 */

class Thost extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->scaffolding('nagdrop_thosts');
	}

	/**
	 * Gets all configuration items for a specific host
	 * host_id is passed in the uri - /nagios/nui/host/get/host_id
	 * Gets all details about the host and the hosts template
	 * Data need to be manipulated later to fill in the blanks
	 * from the host table with the template data
	 * 
	 * Mostly called via an AJAX post
	 * 
	 * This needs to be done a bit better!
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
   * Gets all the hosts that have this template attached to them
   *
   * @return null
   */
  function getHosts()
  {
    $id = $this->uri->segment(3);
    $q = $this->thost_model->getHosts($id);
    $data = array('hosts'=>$q, 'javascript'=>'none');
    $page = $this->load->view('part/hosts_view', $data, TRUE);
    echo $page;
    //return $page;
  }	
	/**
   * Gets all the services that have this host attached to them
   *
   * @return null
   */
  function getServices()
  {
    $id = $this->uri->segment(3);
    $q = $this->service_model->getForHost($id);
    $data = array('services'=>$q, 'javascript'=>'removeServiceFromHost');
    $page = $this->load->view('part/services_view', $data, TRUE);
    echo $page;
    //return $page;
  }
  
  /**
   * Index function
   * First function that's hit when navigating to /nagios/nui/host
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
    
    if($query = $this->thost_model->getAll())
    {
      $data['thosts'] = $query;
    }
    
    $this->load->view('page/thosts_view', $data);
  }
	

}
?>