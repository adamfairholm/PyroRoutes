<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroRoutes
 *
 * Controller for the redirects module
 * 
 * @author 		Adam Fairholm
 * @link		https://github.com/adamfairholm/PyroRoutes
 */
class Admin extends Admin_Controller
{
	public $data;

	// --------------------------------------------------------------------------	

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

		$this->data = new stdClass();
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
		// Get the limit
		$offset = $this->uri->segment(4, 0);

		// Get our routes
		$this->data->routes = $this->routes_m->get_routes(Settings::get('records_per_page'), $offset);

		$this->data->pagination = create_pagination(
										'admin/routes/index',
										$this->db->count_all('routes'),
										Settings::get('records_per_page'),
										4);
		
		$this->template->build('admin/index', $this->data);
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
		$this->form_validation->set_rules($this->routes_m->fields);

		$this->data->route = new stdClass();

		foreach ($this->routes_m->fields as $field)
		{
			$this->data->route->{$field['field']} = $this->input->post($field['field']);
		}	
		
		if ($this->form_validation->run() === true)
		{
			// Add our route!
			if ( ! $this->routes_m->add_route())
			{
				$this->session->set_flashdata('error', lang('pyroroutes.add_route_error'));	
			}	
			else
			{
				// Sync since we have a new route
				if ( ! $this->routes_m->sync_routes())
				{
					$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
				}

				$this->session->set_flashdata('success', lang('pyroroutes.add_route_success'));
			}	
		
			redirect('admin/routes');
		}
		
		$this->template->build('admin/form', $this->data);
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
		
		if ( ! is_numeric($route_id)) show_error("Invalid route ID.");
	
		$this->data->method = 'edit';
		
		// Get the route
		$this->data->route = $this->routes_m->get_route($route_id);
		
		if (is_null($this->data->route)) show_error("Invalid route ID.");
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules( $this->routes_m->fields );		
		
		if ($this->form_validation->run() === true)
		{
			// Add our route!
			if ( ! $this->routes_m->update_route($route_id))
			{
				$this->session->set_flashdata('error', lang('pyroroutes.edit_route_error'));	
			}	
			else
			{
				// Sync since we have a new route
				if ( ! $this->routes_m->sync_routes())
				{
					$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
				}

				$this->session->set_flashdata('success', lang('pyroroutes.edit_route_success'));
			}
		
			redirect('admin/routes');
		}
		
		$this->template->build('admin/form', $this->data);
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
		
		if ( ! is_numeric($route_id)) show_error("Invalid route ID.");
	
		// Delete that route!
		if ( ! $this->routes_m->delete_route($route_id))
		{
			$this->session->set_flashdata('error', lang('pyroroutes.delete_route_error'));	
		}	
		else
		{
			// Sync since we have deleted a route
			if ( ! $this->routes_m->sync_routes())
			{
				$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
			}

			$this->session->set_flashdata('success', lang('pyroroutes.delete_route_success'));
		}
	
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
		if ( ! $this->routes_m->sync_routes())
		{
			$this->session->set_flashdata('error', lang('pyroroutes.sync_error'));
		}
		else
		{
			$this->session->set_flashdata('success', lang('pyroroutes.sync_success'));
		}
		
		redirect('admin/routes');
	}

}