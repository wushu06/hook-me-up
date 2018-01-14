<?php 

namespace Inc\Pages; 

use \Inc\Base\BaseController;

use \Inc\Api\SettingsApi;

use \Inc\Api\Callbacks\AdminCallbacks;

use \Inc\Api\Callbacks\FieldsCallbacks;

class Admin extends BaseController {

    public $settings;
	public $admin_callbacks;
	public $fields_callbacks;
    public $pages = array();
	public $subpages = array();

   

    function register() {
		

		$this->settings = new SettingsApi();
		
				$this->admin_callbacks = new AdminCallbacks();
				$this->fields_callbacks = new FieldsCallbacks();
		
				$this->set_pages();
		
				$this->setSubpages();
		
				$this->setSettings();
				$this->setSections();
				$this->setFields();
		
				$this->settings->add_pages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();

				
    }

    /*
    * create menu 
    */
        
    function set_pages () {
        $this->pages = array(
            array(
                    'page_title' => 'Hook Me Up', 
                    'menu_title' => 'Hook Me Up', 
                    'capability' => 'manage_options', 
                    'menu_slug' => 'hmu_plugin', 
                    'callback' => array( $this->admin_callbacks, 'hmu_plugin' ), 
                    'icon_url' => $this->plugin_url.'assets/images/crane.png',
                    'position' => 110
                )
            );
  
    

	}
	public function setSubpages()
	{
		foreach ($this->subpagesOutput as $slug => $title_callback) {
			    $this->subpages[] = array (
				'parent_slug' => 'hmu_plugin', 
				'page_title' => $title_callback[0], 
				'menu_title' => $title_callback[0], 
				'capability' => 'manage_options', 
				'menu_slug' => $slug, 
				'callback' => array( $this->admin_callbacks, $title_callback[1] ), 
			);

		}

	}
    /*
    * create fields
    */
	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'hmu_options_group',
				'option_name' => 'hmu_plugin',
				'callback' => array( $this->fields_callbacks, 'inputSanitize' )
			),
			array(
				'option_group' => 'hmu__dashboard_options_group',
				'option_name' => 'hmu_plugin_dashboard',
				'callback' => array( $this->fields_callbacks, 'checkboxSanitize' )
			)
			
		);
	
		

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'hmu_admin_index',
				'title' => 'Settings',
				'callback' => array( $this->fields_callbacks, 'adminSectionManager' ),
				'page' => 'import_users'
			),
			array(
				'id' => 'hmu_dashboard_index',
				'title' => 'Dashboard',
				'callback' => array( $this->fields_callbacks, 'dashboardSectionManager' ),
				'page' => 'hmu_plugin' //dahboard page
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array ();

		foreach ($this->fieldsOutput as $id => $title_callback ) {

			$args[] = array (
				'id' => $id,
				'title' => $title_callback[0],
				'callback' => array( $this->fields_callbacks, $title_callback[1] ),
				'page' => 'import_users',
				'section' => 'hmu_admin_index',
					'args' => array(
						'option_name' => 'hmu_plugin',
						'label_for' => $id,
						'class' => 'hmu-upload'
					)
				);
		}
		foreach ($this->dahboardFields   as $id_dash => $dashtitle_callback ) {
			
			$args[] = array (
				'id' => $id_dash,
				'title' => $dashtitle_callback[0],
				'callback' => array( $this->fields_callbacks, $dashtitle_callback[1] ),
				'page' => 'hmu_plugin',
				'section' => 'hmu_dashboard_index',
					'args' => array(
						'option_name' => 'hmu_plugin_dashboard',
						'label_for' => $id_dash,
						'class' => 'hmu-upload'
					)
				);
		}
		

		$this->settings->setFields( $args );
	}

}