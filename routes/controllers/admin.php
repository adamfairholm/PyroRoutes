<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroRoutes
 *
 * Controller for the redirects module
 * 
 * @author 		Parse19
 * @link		http://parse19.com
 * @package 	PyroRoutes
 * @category	Modules
 */
class Admin extends Admin_Controller
{
	public $data;

	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->language('pyroroutes');

		$this->template->append_metadata( css('pyroroutes.css', 'routes') )
							->set_partial('shortcuts', 'admin/shortcuts');
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Show routes
	 *
	 * @access	public
	 */
	public function index()
	{
		

		$this->template->build('admin/list_routes', $this->data);
	}

}

/* End of file admin.php */