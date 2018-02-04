<?php 

namespace Inc\Base; 

use Inc\Base\BaseController;

class Enqueue extends BaseController {

    function register () {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    function enqueue () {
        // enqueue all our scripts
        wp_enqueue_style( 'mystyle', $this->plugin_url. 'assets/dist/app.min.css', array(), null, 'screen' );
        wp_enqueue_style( 'fontAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), null, 'screen' );
        wp_enqueue_script( 'myscript', $this->plugin_url. 'assets/dist/app.js', array(), null, true );
        wp_localize_script( 'myscript', 'WP_JOB_LISTING', array(
            'security' => wp_create_nonce( 'hmu-security' ),

        ) );

        wp_enqueue_media();
    }

}