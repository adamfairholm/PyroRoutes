<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroRoutes Details File
 *
 * @author 		Adam Fairholm
 * @link		https://github.com/adamfairholm/PyroRoutes
 */ 
class Module_Routes extends Module {

	public $version = '1.2';
	
	public $db_pre;

 	// --------------------------------------------------------------------------

	public function __construct()
	{	
		if (CMS_VERSION >= 1.3) $this->db_pre = SITE_REF.'_';
	}

	// --------------------------------------------------------------------------
	
 	public function info()
	{
		return array(
		    'name' => array(
		        'en' => 'Routes', 
		        'fr' => 'Routes'
		    ),
		    'description' => array(
		        'en' => 'Manage custom routes.', 
		        'fr' => 'Gèrez vos routes personnalisées.'
		    ),
		    'frontend' => false,
			'backend' => true,
			'menu' => 'utilities',
			'author' => 'Adam Fairholm',
		    'shortcuts' => array(
				array(
					'name' => 'pyroroutes.new_route',
					'uri' => 'admin/routes/new_route',
					'class' => 'add'
				),
				array(
					'name' => 'pyroroutes.sync_routes',
					'uri' => 'admin/routes/sync_routes',
				)
		    )
		);
	}

	// --------------------------------------------------------------------------

	public function install()
	{
		$sql = "
            CREATE TABLE IF NOT EXISTS `{$this->db_pre}routes` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `route_key` varchar(200) NOT NULL,
                `route_value` varchar(200) NOT NULL,
                `when_added` datetime DEFAULT NULL,
                `last_updated` datetime DEFAULT NULL,
                `added_by` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
              
		return $this->db->query($sql);
	}

	// --------------------------------------------------------------------------

	public function uninstall()
	{
		$this->load->dbforge();
		
		return $this->dbforge->drop_table('routes');
	}

	// --------------------------------------------------------------------------

	public function upgrade($old_version)
	{
		return true;
	}

	// --------------------------------------------------------------------------

	public function help()
	{
		return "No documentation has been added for this module.<br/>Contact the module developer for assistance.";
	}
}

/* End of file details.php */