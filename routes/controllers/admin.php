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
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Show routes
	 *
	 * @access	public
	 * @return	void
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

	// --------------------------------------------------------------------------	
	
	/**
	 * Add a new route
	 *
	 * @access	public
	 * @return 	void
	 */
	public function new_route()
	{
		$this->data->method = 'new';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules( $this->routes_m->fields );		

		foreach($this->routes_m->fields as $field):
		
			$this->data->route->{$field['field']} = $this->input->post($field['field']);
			
		endforeach;	
		
		if($this->form_validation->run() === true):
		
			// Add our route!
			if(!$this->routes_m->add_route()):
			
				$this->session->set_flashdata('error', lang('pyroroutes.add_route_error'));	
				
			else:
			
				// Sync since we have a new route
				if(!$this->routes_m->sync_routes())
					$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
			
				$this->session->set_flashdata('success', lang('pyroroutes.add_route_success'));
				
			endif;
		
			redirect('admin/routes');
		
		endif;
		
		$this->template->build('admin/route_form', $this->data);
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Add a new route
	 *
	 * @access	public
	 * @return 	void
	 */
	public function edit_route()
	{
		// Get the ID of the route
		$route_id = $this->uri->segment(4);
		
		if(!is_numeric($route_id)) show_error("Invalid route ID.");
	
		$this->data->method = 'edit';
		
		// Get the route
		$this->data->route = $this->routes_m->get_route($route_id);
		
		if(is_null($this->data->route)) show_error("Invalid route ID.");
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules( $this->routes_m->fields );		
		
		if($this->form_validation->run() === true):
		
			// Add our route!
			if(!$this->routes_m->update_route($route_id)):
			
				$this->session->set_flashdata('error', lang('pyroroutes.edit_route_error'));	
				
			else:
			
				// Sync since we have a new route
				if(!$this->routes_m->sync_routes())
					$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
			
				$this->session->set_flashdata('success', lang('pyroroutes.edit_route_success'));
				
			endif;
		
			redirect('admin/routes');
		
		endif;
		
		$this->template->build('admin/route_form', $this->data);
	}

	// --------------------------------------------------------------------------	
	
	/**
	 * Add a new route
	 *
	 * @access	public
	 * @return 	void
	 */
	public function delete_route()
	{
		// Get the ID of the route
		$route_id = $this->uri->segment(4);
		
		if(!is_numeric($route_id)) show_error("Invalid route ID.");
	
		// Delete that route!
		if(!$this->routes_m->delete_route($route_id)):
		
			$this->session->set_flashdata('error', lang('pyroroutes.delete_route_error'));	
			
		else:
		
			// Sync since we have deleted a route
			if(!$this->routes_m->sync_routes())
				$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
		
			$this->session->set_flashdata('success', lang('pyroroutes.delete_route_success'));
			
		endif;
	
		redirect('admin/routes');
	}

	// --------------------------------------------------------------------------	

	/**
	 * Controller wrapper for syncing routes to a file
	 *
	 * @access	public
	 * @return	redirect
	 */
	public function sync_routes()
	{
		if(!$this->routes_m->sync_routes()):
		
			$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
		
		else:
		
			$this->session->set_flashdata('success', lang('pyroroutes.sync_success'));
		
		endif;
		
		redirect('admin/routes');
	}

}

/* End of file admin.php */