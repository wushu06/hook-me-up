<?php

namespace Inc\Base;
use Inc\Data\InsertLocations;

class Cron
{
    public $option ;
    public $cron;



    public function register()
    {
        $this->option  = get_option ('hmu_cron');
        @$cron_time  =  get_option('hmu_cron')['cron_time'] ;

        if(isset($cron_time) && !empty($cron_time)) {

            add_filter('cron_schedules', array($this, 'hmu_cron_recurrence_interval') );

            if (!wp_next_scheduled('hmu_upload_file_cron')) {
                wp_schedule_event(time(), $cron_time, 'hmu_upload_file_cron');
            }

            add_action('hmu_upload_file_cron', array($this,'hmu_upload_file_fun') );

        }else {
            wp_clear_scheduled_hook( 'hmu_upload_file_cron' );
        }
    }

    function hmu_cron_recurrence_interval($schedules) {

        $schedules['every_one_minute'] = array(
            'interval' => 60,
            'display' => __('Every 1 Minutes', 'textdomain')
        );
        $schedules['every_three_minutes'] = array(
            'interval' => 180,
            'display' => __('Every 3 Minutes', 'textdomain')
        );
        $schedules['every_fifteen_minutes'] = array(
            'interval' => 900,
            'display' => __('Every 15 Minutes', 'textdomain')
        );
        return $schedules;
    }


    function hmu_upload_file_fun()
    {
        $this->option  = get_option ('hmu_cron');
        $cron_file  =  get_option('hmu_cron')['cron_file'] ;
        $cron_name  =  get_option('hmu_cron')['cron_name'] ;
        $location = new InsertLocations();
        $location->handle_csv($cron_file);


     /*   wp_insert_post(array(
            'post_title' => $cron_name,
            'post_content' => $cron_file,
            'post_status' => 'publish',
            'post_type' => "wpsl_stores",
        ));*/

    }






} // end class