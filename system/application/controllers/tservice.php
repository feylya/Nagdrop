<?php
/**
 * Service template controller
 * Gives back data for all calls about service templates
 *
 * @author Paul O'Connor 
 * @date 31 December 2009
 */
class Tservice extends Controller{

	/**
	 * Gets all the services that have this host attached to them
	 *
	 * @return null
	 */
	function getServices()
	{
		$id = $this->uri->segment(3);
		$q = $this->tservice_model->getServices($id);
		$data = array('services'=>$q, 'javascript'=>'none');
		$page = $this->load->view('part/services_view', $data, TRUE);
		echo $page;
		//return $page;
	}

}
?>