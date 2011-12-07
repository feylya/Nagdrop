<?php
/**
 * Generates the content for the side menu for adding objects
 * Also handles the AJAX pagination requests
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */
class Menu extends Controller
{
	/**
	 * Returns all information about all menu options
	 * This is deprecated
	 *
	 * @deprecated
	 * @return null
	 */
	function index()
	{
		$data = array();
		$data = array_merge($data, $this->hosts(FALSE));
		$data = array_merge($data, $this->services(FALSE));
		$data = array_merge($data, $this->hostgroups(FALSE));
		$data = array_merge($data, $this->servicegroups(FALSE));
		$this->load->view('menu/menu_view', $data);
	}

	/**
	 * Sends back information for the hosts menu
	 *
	 * @return null
	 */
	function hosts($view = TRUE)
	{
		$data = array();
			
		$config['base_url']        = site_url('menu/hosts');
		$config['total_rows']      = $this->db->count_all('nagdrop_hosts');
		$config['uri_segment']     = 3;
		$config['per_page']        = '15';
		$config['div'] = '#holder';
		$config['js_rebind'] = '';

		$this->jquery_pagination->initialize($config);
			
		$data['pagination'] = $this->jquery_pagination->create_links();

		if($query = $this->host_model->getAllMenu($config['per_page'], $this->uri->segment(3)))
		{
			$data['menuHosts'] = $query;
		}
			
		if ($view == FALSE)
		{
			return array('menuHosts'=>$data);
		} else {
			$this->load->view('menu/host_view', $data);
		}
	}

  /**
   * Sends back information for the services menu
   *
   * @return null
   */	
	function services($view = TRUE)
	{
		$data = array();

		$config['base_url']        = site_url('menu/services');
		$config['total_rows']      = $this->db->count_all('nagdrop_services');
		$config['uri_segment']     = 3;
		$config['per_page']        = '15';
		$config['div'] = '#holder'; /* Here #content is the CSS selector for target DIV */
		$config['js_rebind'] = ''; /* if you want to bind extra js code */

		$this->jquery_pagination->initialize($config);
			
		$data['pagination'] = $this->jquery_pagination->create_links();

		if($query = $this->service_model->getAllMenu($config['per_page'], $this->uri->segment(3)))
		{
			$data['menuServices'] = $query;
		}
		if ($view == FALSE)
		{
			return $data;
		} else {
			$this->load->view('menu/service_view', $data);
		}
	}

  /**
   * Sends back information for the hostgroups menu
   *
   * @return null
   */
	function hostgroups($view = TRUE)
	{
		$data = array();
			
		$config['base_url']        = site_url('menu/hostgroups');
		$config['total_rows']      = $this->db->count_all('nagdrop_hostgroups');
		$config['uri_segment']     = 3;
		$config['per_page']        = '15';
		$config['div'] = '#holder'; /* Here #content is the CSS selector for target DIV */
		$config['js_rebind'] = ''; /* if you want to bind extra js code */

		$this->jquery_pagination->initialize($config);
			
		$data['pagination'] = $this->jquery_pagination->create_links();

		if($query = $this->hostgroup_model->getAllMenu($config['per_page'], $this->uri->segment(3)))
		{
			$data['menuHostgroups'] = $query;
		}
			
		if ($view == FALSE)
		{
			return $data;
		} else {
			$this->load->view('menu/hostgroup_view', $data);
		}
	}

	 /**
   * Sends back information for the servicegroups menu
   *
   * @return null
   */
	function servicegroups($view = TRUE)
	{
		$data = array();

		if($query = $this->servicegroup_model->getAllMenu())
		{
			$data['menuServicegroups'] = $query;
		}
			
		if ($view == FALSE)
		{
			return $data;
		} else {
			$this->load->view('menu/servicegroup_view', $data);
		}
	}
}
