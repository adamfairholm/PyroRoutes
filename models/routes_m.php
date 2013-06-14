<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroRoutes Routes Model
 *
 * @author      Adam Fairholm
 * @link        https://github.com/adamfairholm/PyroRoutes
 */ 
class Routes_m extends MY_Model {

	/* Fields */
	public $fields = array(
		array('field'=>'name', 'label'=>'Route Name', 'rules'=>'required|max_length[100]'),
		array('field'=>'route_key', 'label'=>'Route Name', 'rules'=>'required|max_length[200]'),
		array('field'=>'route_value', 'label'=>'Route Name', 'rules'=>'required|max_length[200]')
	);

    // --------------------------------------------------------------------------

    /**
     * Get routes
     *
     * @access	public
     * @param	int limit
     * @param	int offset
     * @return	obj
     */
    public function get_routes($limit = false, $offset = 0)
	{
        $this->db->order_by('name', 'asc');

        if ($limit) $this->db->limit($limit, $offset);

        return $this->db->get('routes')->result();
	}

    // --------------------------------------------------------------------------

    /**
     * Get a single route by ID
     *
     * @access	public
     * @param	int route_id
     * @return	obj
     */
    public function get_route($route_id)
	{
		return $this->db->limit(1)->where('id', $route_id)->get('routes')->row();
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
    		'when_added'	=> date('Y-m-d H:i:s'),
    		'added_by'		=> $this->current_user->id
    	);
    	
    	return $this->db->insert('routes', $insert_data);
    }
    
    // --------------------------------------------------------------------------
    
    /**
     * Update a route in the db
     *
     * @access	public
     * @param	int route_id
     * @return 	bool
     */
    public function update_route($route_id)
    {
    	$update_data = array(
    		'name'			=> $this->input->post('name'),
    		'route_key'		=> $this->input->post('route_key'),
    		'route_value'	=> $this->input->post('route_value'),
    		'last_updated'	=> date('Y-m-d H:i:s')
    	);
    	
    	$this->db->where('id', $route_id);
    	return $this->db->update('routes', $update_data);
    }

    // --------------------------------------------------------------------------
    
    /**
     * Update a route in the db
     *
     * @access	public
     * @param	int route_id
     * @return 	bool
     */
    public function delete_route($route_id)
    {
    	return $this->db->where('id', $route_id)->delete('routes');
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
		if ( ! $info or ! $info['writable']) return false;
	
		// Where are we?
		if (CMS_VERSION >= 1.3)
		{
			if (is_dir(ADDONPATH.'modules/routes/'))
			{
				$path = ADDONPATH.'modules/routes/';
			}
			elseif (is_dir(SHARED_ADDONPATH.'modules/routes/'))
			{
				$path = SHARED_ADDONPATH.'modules/routes/';
			}	
			else
			{
				// It isn't anywhere so why bother.
				return false;
			}
		}	
		else
        {
			$path = ADDONPATH.'modules/routes/';
		}
		
		if ( ! is_file($default_route_file = $path.'default_routes.php'));
	
		// Let's start our routes file!
		$file_data = read_file($default_route_file);
    $routes_str = '';
		
		// Get the routes
		$routes = $this->get_routes();
				
		if($routes):
				
			$routes_str .= "\n/* Custom Routes from PyroRoutes */\n\n";
		
			foreach($routes as $route):
			
				$routes_str .= "\$route['{$route->route_key}'] = '{$route->route_value}';\n";
			
			endforeach;
      
      $routes_str .= "\n".'/* End of Custom Routes from PyroRoutes */';
		
		endif;
    
    // Write the routes into the file (insert placeholder first, then final routes, to avoid corrupting regex)
    $findRoutesRegx = '%\/\* Custom Routes from PyroRoutes[\r\n\s\S]*End of Custom Routes from PyroRoutes \*\/%'; // Regx for existing PyroRoutes data
    $findEOFRegx = '%[\r\n\s]+\/\* End of file routes.php \*\/%'; // Regx for end of file
    // If existing PyroRoutes info is present, replace it
    if (preg_match($findRoutesRegx,$file_data) === 1) {
      $file_data = preg_replace($findRoutesRegx,'## Routes Here ##',$file_data);
    }
    // If no existing PyroRoutes is present, insert it before end of file
    elseif (preg_match($findEOFRegx,$file_data) === 1) {
      $file_data = preg_replace($findEOFRegx,'## Routes Here ##'."\n".'/* End of file routes.php */',$file_data);
    }
    // Just append it
    else {
      $file_data .= '## Routes Here ##'."\n".'/* End of file routes.php */';
    }
    $file_data = str_replace('## Routes Here ##',$routes_str,$file_data);
		
		// Clear the file first
		file_put_contents($route_file, '');
			
		// Write the file
		return write_file($route_file, $file_data, 'r+');
	}
}