<?php 

namespace Inc\Data;

use \Inc\Base\BaseController;

class Upload {

    public $html;

    public function register() {
        add_action('init',array( $this,'hook_me_up_install_csv_data'));
        
    }

    function hook_me_up_install_csv_data () {
       

        
            // Check if file was uploaded without errors
                $allowed = array("jpg" => "image/jpg");
               // $filename = $_FILES["file"]["name"];
                $filetype = $_FILES["file"]["type"];
                $filesize = $_FILES["file"]["size"];
                        $newFilename = time() . "_" . $_FILES["file"]["name"];
                        $location = $this->plugin_path.'upload/'. $newFilename;
                move_uploaded_file($_FILES["file"]["tmp_name"], $location);
                     $this->html = "Your file was uploaded successfully.";
                                 global $wpdb;
                                 global $current_user;
                                 wp_get_current_user();
                                 $table = $wpdb->prefix."hookMeUp_csv";
    
                                 $wpdb->insert(
                                         $table,
                                         array(
                                        'username_wp' =>$current_user->user_login,
                                        'upload' => $location,
    
                                         )
                                 );
    
             

                echo $this->html;
    

    }
}