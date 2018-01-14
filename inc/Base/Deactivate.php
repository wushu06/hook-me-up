<?php 

namespace Inc\Base;



class Deactivate  {


    public static function deactivate () {

        $roles = array ('5_discount'=>'5% Discount', '10_discount'=>'10% Discount', '15_discount'=>'15% Discount');

        foreach($roles as $slug=>$role) {
            remove_role( $slug, $role );
        }




        flush_rewrite_rules();
    }
}