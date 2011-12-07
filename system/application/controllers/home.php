<?php
/**
 * File: home.php
 * 
 * This is the main controller for the system
 * It routes the browser to the individual controllers as required
 * It sets up the main screens - Hosts, Services, Hostgroups, etc.
 *
 * @author Paul O'Connor paul.oconnor11@student.dit.ie
 * @date 30/12/2009
 */

class Home extends Controller{

	/**
	 * This is the function that is called if there is no specific function in the URI
	 *
	 * @return null
	 */
	function index()
	{
		//Hosts is the main page
		redirect('home/hosts');
	}

	/**
	 * Display all hosts and their status
	 *
	 * @return null
	 */
	function hosts()
	{
		$data = array();
		//Get the data for the drag and drop menu at the top
		//$data = $this->getMenuData();

		//This was all for pagination of the objects on the screen
		//It was removed due to a change in layout of the screen
		/*
		 $config['base_url']        = site_url('home/hosts');
		 $config['total_rows']      = $this->db->count_all('nagdrop_hosts');
		 $config['uri_segment']     = 3;
		 $config['per_page']        = '15';
		 $config['div'] = '#groups'; //Here #content is the CSS selector for target DIV
		 $config['js_rebind'] = ''; // if you want to bind extra js code

		 $this->jquery_pagination->initialize($config);

		 $data['pagination'] = $this->jquery_pagination->create_links();*/

		//Get all our hosts and services
		//if($query = $this->host_model->getAll($config['per_page'], $this->uri->segment(3)))
		if($query = $this->host_model->getAll())
		{
			$data['hosts'] = $query;
			//This is all commented because I moved the individual services call to a jQuery Post
			//Much faster to load the front page, less calls to the server
			/*$data = array_merge($data, $temp);
			 foreach ($temp['hosts'] as $row)
			 {
				$host_list[] = $row->host_id;
				}
				unset($temp);*/
			/*if($query = $this->service_model->getAllForHost($host_list))
			 {
				$temp['services'] = $query;
				$data = array_merge($data, $temp);
				unset($temp);
				}*/
		}
		if ($this->input->post('t') == 't')
		{
			$this->load->view('page/hosts_view', $data);
		} else {
			$this->load->view('menu/menu_view');
			$this->load->view('page/hosts_view', $data);
			$this->load->view('part/footer');
		}
	}

	/**
	 * Display all host templates
	 *
	 * @return null
	 */
	function thosts()
	{
		$data = array();

		//Get all our hosts and services
		//if($query = $this->host_model->getAll($config['per_page'], $this->uri->segment(3)))
		if($query = $this->thost_model->getAll())
		{
			$data['thosts'] = $query;
		}
		if ($this->input->post('t') == 't')
		{
			$this->load->view('page/thosts_view', $data);
		} else {
			$this->load->view('menu/menu_view');
			$this->load->view('page/thosts_view', $data);
			$this->load->view('part/footer');
		}
	}

	/**
	 * Display all services
	 *
	 * @return null
	 */
	function services()
	{
		$data = array();

		//This was all for pagination of the objects on the screen
		//It was removed due to a change in layout of the screen
		/*
		 $config['base_url']        = site_url('home/services');
		 $config['total_rows']      = $this->db->count_all('nagdrop_services');
		 $config['uri_segment']     = 3;
		 $config['per_page']        = '15';
		 $config['div'] = '#groups'; // Here #content is the CSS selector for target DIV
		 $config['js_rebind'] = ''; // if you want to bind extra js code

		 $this->jquery_pagination->initialize($config);

		 $data['pagination'] = $this->jquery_pagination->create_links();*/

		//Get all our hosts and services
		if($query = $this->service_model->getAll())
		{
			$data['services'] = $query;
		}
		if ($this->input->post('t') == 't')
		{
			$this->load->view('page/services_view', $data);
		} else {
			$this->load->view('menu/menu_view');
			$this->load->view('page/services_view', $data);
			$this->load->view('part/footer');
		}

	}

	/**
	 * Display all services
	 *
	 * @return null
	 */
	function tservices()
	{
		$data = array();

		//This was all for pagination of the objects on the screen
		//It was removed due to a change in layout of the screen
		/*
		 $config['base_url']        = site_url('home/services');
		 $config['total_rows']      = $this->db->count_all('nagdrop_services');
		 $config['uri_segment']     = 3;
		 $config['per_page']        = '15';
		 $config['div'] = '#groups'; // Here #content is the CSS selector for target DIV
		 $config['js_rebind'] = ''; // if you want to bind extra js code

		 $this->jquery_pagination->initialize($config);

		 $data['pagination'] = $this->jquery_pagination->create_links();*/

		//Get all our hosts and services
		if($query = $this->tservice_model->getAll())
		{
			$data['tservices'] = $query;
		}
		if ($this->input->post('t') == 't')
		{
			$this->load->view('page/tservices_view', $data);
		} else {
			$this->load->view('menu/menu_view');
			$this->load->view('page/tservices_view', $data);
			$this->load->view('part/footer');
		}

	}

	/**
	 * Display all hostgroups
	 *
	 * @return null
	 */
	function hostgroups()
	{
		$data = array();

		//This was all for pagination of the objects on the screen
		//It was removed due to a change in layout of the screen
		/*$data = $this->getMenuData();
		 $config['base_url']        = site_url('home/hosts');
		 $config['total_rows']      = $this->db->count_all('nagdrop_hosts');
		 $config['uri_segment']     = 3;
		 $config['per_page']        = '15';
		 $config['div'] = '#groups'; // Here #content is the CSS selector for target DIV
		 $config['js_rebind'] = ''; // if you want to bind extra js code

		 $this->jquery_pagination->initialize($config);
		 $data['pagination'] = $this->jquery_pagination->create_links(); */

		//Get all our hosts and services
		//if($query = $this->hostgroup_model->getAll($config['per_page'], $this->uri->segment(3)))
		if($query = $this->hostgroup_model->getAll())
		{
			$data['hostgroups'] = $query;
		}
		//var_dump($data);
		if ($this->input->post('t') == 't')
		{
			$this->load->view('page/hostgroups_view', $data);
		} else {
			$this->load->view('menu/menu_view');
			$this->load->view('page/hostgroups_view', $data);
			$this->load->view('part/footer');
		}

	}

	/**
	 * Display all servicegroups
	 *
	 * @return null
	 */
	function servicegroups()
	{
		$data = array();
		//Get the data for the drag and drop menu at the top
		//$data = $this->getMenuData();

		//This was all for pagination of the objects on the screen
		//It was removed due to a change in layout of the screen
		/*$config['base_url']     = site_url('home/servicegroups');
		 $config['total_rows']   = $this->db->count_all('nagdrop_servicegroups');
		 $config['uri_segment']  = 3;
		 $config['per_page']     = '15';
		 $config['div'] 			= '#groups'; // Here #content is the CSS selector for target DIV
		 $config['js_rebind']	= ''; // if you want to bind extra js code

		 $this->jquery_pagination->initialize($config);

		 $data['pagination'] = $this->jquery_pagination->create_links();*/

		//Get all our hosts and services
		if($query = $this->servicegroup_model->getAll($config['per_page'], $this->uri->segment(3)))
		{
			$data['servicegroups'] = $query;
		}
		if ($this->input->post('t') == 't')
		{
			$this->load->view('page/servicegroups_view', $data);
		} else {
			$this->load->view('menu/menu_view');
			$this->load->view('page/servicegroups_view', $data);
			$this->load->view('part/footer');
		}
	}

	/**
	 * Display all servicegroups
	 *
	 * @todo Write this function
	 * @return null
	 */
	function contacts()
	{

	}

	/**
	 * This was used to loads the menu at the top of the page
	 * It was deprecated in favour of a on call loading AJAX menu at the side of the screen
	 *
	 * @deprecated
	 * @return
	 */
	function getMenuData()
	{
		$data = array();
		$data = array(
				"menu"=>array(
				"menuHosts"=>$this->host_model->getAllMenu(),
				"menuServices"=>$this->service_model->getAllMenu(),
				"menuHostgroups"=>$this->hostgroup_model->getAllMenu(),
				"menuServicegroups"=>$this->servicegroup_model->getAllMenu()));

		return $data;

	}

	/**
	 * This is never called. It was used for the migration to CodeIgniter and MVC
	 *
	 * @deprecated
	 * @return
	 */
	/*function create()
	 {
		$data = array(
		'alias' => $this->input->post('alias'),
		'icon_image' => $this->input->post('icon_image')
		);

		$this->host_model->addHost($data);

		$this->index();

		}*/

	/**
	 * This is never called. It was used for the migration to CodeIgniter and MVC
	 *
	 * @deprecated
	 * @return
	 */
	/*function delete()
	 {
		$this->host_model->deleteHost();
		$this->index();
		}*/

	/**
	 * This is never called. It was used for the migration to CodeIgniter and MVC
	 *
	 * @deprecated
	 * @return
	 */
	/*function update()
	 {
		$data = array(
		'alias' => 'name');
		}*/

	/**
	 * This is never called. It was used for the migration to CodeIgniter and MVC
	 *
	 * @deprecated
	 * @return
	 */
	/*function menu()
	 {
		$data = array();

		if($query = $this->host_model->getAllMenu())
		{
		$data['results'] = $query;
		}

		$this->load->view('menu/host_view', $data);
		}*/

	/**
	 * This is never called. It was used for the migration to CodeIgniter and MVC
	 *
	 * @deprecated
	 * @return
	 */
	/*function getAll()
	 {
		$data['rows'] = $this->host_model->getAll();

		$this->load->view('host_view', $data);
		}*/

}
?>