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
		
		$this->load->model('routes_m');

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
		// Get our routes
		$this->data->routes = $this->routes_m->get_routes('routes');

		$this->data->pagination = create_pagination(
										'admin/routes',
										$this->db->count_all('routes'),
										$this->settings->item('records_per_page'),
										3);
		
		$this->template->build('admin/list_routes', $this->data);
	}
	
	public function new_route()
	{
		$this->template->build('admin/list_routes', $this->data);
	}
	
	public function sync_routes()
	{
		if(!$this->routes_m->sync_routes()):
		
			$this->session->set_flashdata('error', 'There was an error in syncing your routes to file');
		
		else:
		
			$this->session->set_flashdata('success', 'Custom routes synced successf');
		
		endif;
		
		// Redirect
		redirect('admin/routes');
	}

}

/* End of file admin.php */