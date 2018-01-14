<?php
// custom login styles
function myplugin_custom_login_styles() { 
	
		
		/*
		
		wp_enqueue_style( 
			string           $handle, 
			string           $src = '', 
			array            $deps = array(), 
			string|bool|null $ver = false, 
			string           $media = 'all' 
		)
		
		wp_enqueue_script( 
			string           $handle, 
			string           $src = '', 
			array            $deps = array(), 
			string|bool|null $ver = false, 
			bool             $in_footer = false 
		)
		
		*/
		
        wp_enqueue_style( 'myplugin', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/style.css', array(), null, 'screen' );
        wp_enqueue_style( 'myplugin2', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/bootstrap.css', array(), null, 'screen' );
        wp_enqueue_script( 'myplugin3', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/jquery.js', array(), null, true );
        wp_enqueue_script( 'myplugin4', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/tether.js', array(), null, true );
        wp_enqueue_script( 'myplugin2', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/bootstrap.js', array(), null, true );
        
        wp_enqueue_script( 'myplugin', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/app.js', array(), null, true );
        
    
	
	
}
add_action( 'admin_enqueue_scripts', 'myplugin_custom_login_styles' );

