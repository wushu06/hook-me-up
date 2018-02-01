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
        $op = array('hmu_plugin'=>'activate_cron');

		$this->dahboardFields = array (
		    // ID
            //0- title 1- callback 2-page 3- section 4- option name 5-input type

			'activate_cron' => 
				array('Activate Cron ',
                    'cronActivationField',
                    'hmu_plugin',
                    'hmu_dashboard_index',
                    'hmu_dashboard',
                    'boolean'
                ),
            'activate_email' =>
                array('Activate Email ', 'emailActivationField','hmu_plugin','hmu_dashboard_index','hmu_dashboard','boolean'),
            'upload_file' =>
                array('Upload File',
                    'inputUploadField',
                    'import_users',
                    'hmu_import_index',
                    'hmu_import',
                    'string'
                ),
            'profile_picture' =>
                array('Profile Picture', 'profilePictureField','import_users','hmu_import_index','hmu_import','string'),
            'cron_time' =>
                array('Cron Time ', 'cronTimeField','cron_task','hmu_cron_index','hmu_cron','string'),
            'cron_name' =>
                array('Cron Name ', 'cronNameField','cron_task','hmu_cron_index','hmu_cron','string'),


			
		);




		
	}

	/*public function activated(   $option_name,  $key )
	{
		$option = get_option( $option_name );

		return  $option[ $key ] == 1  ? true : false;
	}

	public function activated_string (   $option_name,  $key )
    {
        $option = get_option( $option_name );

        return  $option[ $key ] !== ''  ? $option[ $key ] : '';
    }*/

	
}