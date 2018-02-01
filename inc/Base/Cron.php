<?php

namespace Inc\Base;

class Cron
{
    public $option ;
    public $cron;



    public function register()
    {

        $this->option  = get_option ('hmu_cron');
        @$cron_time  =  get_option('hmu_cron')['cron_time'] ;



            if(@$cron_time !== '') {

               add_filter( 'cron_schedules',  array($this, 'cron_recurrence_interval') );
               add_action('cron_recurrence_interval','hmu_activation_cron');
                if (!wp_next_scheduled('hmu_activation_cron') ) {
                    wp_schedule_event(time(), $cron_time , 'hmu_activation_cron');
                }

            }else {
                wp_clear_scheduled_hook( 'hmu_activation_cron' );

            }


    }

    public function cron_action ($cron_time)
    {}


    public function hmu_activation_cron ()
    {
        ob_start();

        $to = 'nourwushu@gmail.com';
        $subject = 'Test my 3-minute cron job';
        $message = 'If you received this message, it means that your 3-minute cron job has worked!';
        wp_mail($to, $subject, $message);
        ob_get_contents();
        ob_end_clean();
    }
    public function cron_recurrence_interval($schedules)
    {

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








} // end class