<?php 

namespace Inc\Base;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $subpagesOutput = array();

	public $dahboardFields = array();
	public $fieldsOutput = array();
	
	
	

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/hook-me-up-csv.php';

		$this->subpagesOutput = array (
			'import_users' =>
				array('Import Users', 'hmu_users_page'), 
			'import_prices' =>
				array('Import Prices & Users', 'hmu_prices_page'),
			'cron_task' =>
				array('Cron Task', 'hmu_cron_page'),  
		);

		/* 
		* FIELDS
		*/

		$this->dahboardFields = array (
			'activate_email' => 
				array('Activate Email ', 'emailActivationField'),
			'activate_cron' => 
				array('Activate Cron ', 'cronActivationField'),
			
		);
		$this->fieldsOutput = array (
			'upload_file' => 
				array('Upload File', 'inputUploadField'),
			'profile_picture' => 
				array('Profile Picture', 'profilePictureField'),
		
			
		);
		
	}

	public function activated(  string $option_name, string $key )
	{
		$option = get_option( $option_name );

		return  $option[ $key ] == 1  ? true : false;
	}

	
}