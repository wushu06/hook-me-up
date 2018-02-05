<?php
/*
Plugin Name: Hook Me Up
Plugin URI:  http://ukcoding.com
Description: Track submit of reviews
Version:     1.0.0
Author:      Noureddine Latreche
Text Domain: Hook Me Up
Domain Path: /languages
License:     GPL3

*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define ('SITE_ROOT', realpath(dirname(__FILE__)));
/**
 * first we call the files we are using
 */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}



require_once dirname(__FILE__) . '/testUpload.php';

use Inc\Base\Activate;
use Inc\Base\Deactivate;
function hook_me_up_activate () {
	Activate::activate();
}
function hook_me_up_deactivate () {
	Deactivate::deactivate();
}
register_activation_hook( __FILE__, 'hook_me_up_activate' );
register_deactivation_hook( __FILE__, 'hook_me_up_deactivate' );


if (class_exists ('Inc\\Init')) {
	Inc\Init::register_services();
}
/*class cron_nour{

    function __construct()
    {
        add_filter('cron_schedules', array($this, 'isa_add_cron_recurrence_interval') );

        if (!wp_next_scheduled('your_three_minute_action_hook')) {
            wp_schedule_event(time(), 'every_three_minutes', 'your_three_minute_action_hook');
        }

        add_action('your_three_minute_action_hook', array($this,'isa_test_cron_job_send_mail') );
    }

    function isa_add_cron_recurrence_interval($schedules) {

        $schedules['every_three_minutes'] = array(
            'interval' => 60,
            'display' => __('Every 3 Minutes', 'textdomain')
        );

        return $schedules;
    }


    function isa_test_cron_job_send_mail()
    {
        wp_insert_post(array(
            'post_title' => 'threeCRONMINE',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => "wpsl_stores",
        ));

    }

}
new cron_nour();*/
 //wp_clear_scheduled_hook( 'hmu_upload_file_cron' );

/*
function hook_me_up_upload_csv_file(){

    // $_FILES['file']['tmp_name'];
  $FILE_POST =  $_FILES['file'] ;
    // Check if file was uploaded without errors
    // $allowed = array("jpg" => "image/jpg");
   $filename = $FILE_POST["name"];
    $filetype = $FILE_POST["type"];
    $filesize = $FILE_POST["size"];
    $newFilename = time() .'_'. $FILE_POST["name"];
   $location = plugin_dir_path( __FILE__ ).'upload/'. $newFilename;
    //$filetype = wp_check_filetype( basename( $FILE_POST["tmp_name"] ), array('csv' => 'text/csv') );
    $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');




    move_uploaded_file($FILE_POST["tmp_name"], $location);

    if( ($handle = fopen( $location, 'r' )) !== false )
    {
        $output = '<table class="widefat fixed" cellspacing="0">';
        while( ($data = fgetcsv( $handle )) !== false )
        {
            $output .= '<tr >';
            foreach( $data as $value )
            {
                $output .= sprintf( '<td>%s</td>', $value );

            }
            $output .= sprintf( '<td>%s</td>', '+' );
            $output .= sprintf( '<td>%s</td>', 'x' );
            $output .= '</tr>';

        }
        fclose( $handle );
        $output .= '</table>';
    }
    echo $output;



}




add_action( 'wp_ajax_hook_me_up_upload_csv_file', 'hook_me_up_upload_csv_file' );






*/













