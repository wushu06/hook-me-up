<?php 

namespace Inc\Base; 

use Inc\Base\BaseController;

class Enqueue extends BaseController {

    function register () {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    function enqueue () {
        // enqueue all our scripts
        wp_enqueue_style( 'mystyle', $this->plugin_url. 'assets/css/style.css', array(), null, 'screen' );
        wp_enqueue_script( 'myscript', $this->plugin_url. 'assets/js/app.js', array(), null, true );
        wp_enqueue_media();
    }
}