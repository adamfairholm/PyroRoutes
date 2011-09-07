<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroRoutes Routes Model
 *
 * @package  	PyroCMS
 * @subpackage  PyroRoutes
 * @category  	Models
 * @author  	Parse19
 */ 
class Routes_m extends MY_Model {
    
    /**
     * Get routes
     *
     * @access	public
     * @param	int limit
     * @param	int offset
     * @return	obj
     */
    public function get_routes($limit = FALSE, $offset = FALSE)
	{
		$this->db->order_by('name', 'asc');
	
		if($limit) $this->db->limit($limit);
		if($offset) $this->db->offset($offset);
		     
		$obj = $this->db->get('routes');
    	
    	return $obj->result();
	}

    // --------------------------------------------------------------------------
    
    /**
     * Add a route into the db
     *
     * @access	public
     * @return 	bool
     */
    public function add_route()
    {
    	$insert_data = array(
    		'name'			=> $this->input->post('name'),
    		'route_key'		=> $this->input->post('route_key'),
    		'route_value'	=> $this->input->post('route_value'),
    		'notes'			=> $this->input->post('notes'),
    		'when_added'	=> date('Y-m-d H:i:s'),
    		'added_by'		=> $this->user->id
    	);
    	
    	return $this->db->insert('routes', $insert_data);
    }

    // --------------------------------------------------------------------------
    
    /**
     * Sync routes
     *
     * @access	public
     * @return 	bool
     */
    public function sync_routes()
    {
    	$this->load->helper('file');
    
		// Check to make sure that we can read/write the
		// Routes file
		$route_file = APPPATH.'config/routes.php';
				
		$info = get_file_info($route_file, 'writable');
		
		// Does it even exist? Is it writable?
		if(!$info or !$info['writable']) return false;
	
		// Where are we?
		if(CMS_VERSION >= 1.3):
		
			if(is_dir(ADDONPATH.'modules/routes/')):
			
				$path = ADDONPATH.'modules/routes/';
			
			elseif(is_dir(SHARED_ADDONPATH.'modules/routes/')):
			
				$path = SHARED_ADDONPATH.'modules/routes/';
				
			else:
			
				// It isn't anywhere so why bother.
				return false;
			
			endif;
			
		else:
			$path = ADDONPATH.'modules/routes/';
		endif;
		
		if(!is_file($default_route_file = $path.'default_routes.php'));
	
		// Let's start our routes file!
		$file_data = read_file($default_route_file)."\n";
		
		// Get the routes
		$routes = $this->get_routes();
		
		if($routes):
				
			$file_data .= "\n/* Custom Routes from PyroRoutes */\n\n";
		
			foreach($routes as $route):
			
				$file_data .= "\$route['{$route->route_key}'] = '{$route->route_value}';\n";
			
			endforeach;
		
		endif;
		
		$file_data .= "\n".'/* End of file routes.php */';
		
		// Write the file
		return write_file($route_file, $file_data, 'r+');
	}
}

/* End of file routes_m.php */