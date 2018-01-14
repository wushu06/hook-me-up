<?php 

namespace Inc\Base;



class Activate {

    public static function activate () {

        $roles = array ('5_discount'=>'5% Discount', '10_discount'=>'10% Discount', '15_discount'=>'15% Discount');

        foreach($roles as $name=>$role) {
            add_role( $name, $role );

            $role = get_role( $name );
            $role->add_cap( 'read' );
        }

        global $wp_roles;

        $roles_to_remove = array('subscriber', 'contributor', 'author', 'editor','shop_manager');

        foreach ($roles_to_remove as $role) {
            if (isset($wp_roles->roles[$role])) {
                $wp_roles->remove_role($role);
            }
        }


        if ( get_option( 'hmu_plugin' ) ) {
			return;
		}

		$default = array();

		update_option( 'hmu_plugin', $default );





        flush_rewrite_rules();

    }
}