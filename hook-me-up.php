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
add_action( 'show_user_profile', 'hmu_user_custom_field' );
add_action( 'edit_user_profile', 'hmu_user_custom_field' );

function hmu_user_custom_field() {
   $custom_id = get_user_meta(
                     31,
                    '_user_custom_id'

            );

    ?>
    <table class="form-table">
        <tbody>
        <tr>
            <th><label>custom id</label></th>
            <td> <input type="text" name="hmu_custom_id" placeholder="user custom id" value="<?php echo @$custom_id[0]; ?>"><br>
                </td>
        </tr>
        </tbody>
    </table>



<?php
}
function hmu_update_user_meta() {
    $values = array(
        // String value. Empty in this case.
        '_user_custom_id'             => filter_input( INPUT_POST, 'hmu_custom_id', FILTER_SANITIZE_STRING ),

    );

    foreach ( $values as $key => $value ) {
        update_user_meta( '31', $key, $value );
    }
}

add_action( 'personal_options_update', 'hmu_update_user_meta' );
add_action( 'edit_user_profile_update', 'hmu_update_user_meta' );



/* =================== */
// 1- create custom tab
add_action( 'woocommerce_product_write_panel_tabs', 'woo_add_custom_admin_product_tab' );

function woo_add_custom_admin_product_tab() {
    ?>
    <li class="custom_tab"><a href="#custom_tab_data"><?php _e('My Custom Tab', 'woocommerce'); ?></a></li>

    <?php

}

// 3- save to database
function woo_add_custom_general_fields_save( $post_id ){

    // Text Field
    $woocommerce_text_field = $_POST['_text_field'];
    if( !empty( $woocommerce_text_field ) )
        update_post_meta( $post_id, '_text_field', esc_attr( $woocommerce_text_field ) );

    // Number Field
    $woocommerce_number_field = $_POST['_number_field'];
    if( !empty( $woocommerce_number_field ) )
        update_post_meta( $post_id, '_number_field', esc_attr( $woocommerce_number_field ) );

    // Textarea
    $woocommerce_textarea = $_POST['_textarea'];
    if( !empty( $woocommerce_textarea ) )
        update_post_meta( $post_id, '_textarea', esc_html( $woocommerce_textarea ) );

    // Select
    $woocommerce_select = $_POST['_select'];
    if( !empty( $woocommerce_select ) )
        update_post_meta( $post_id, '_select', esc_attr( $woocommerce_select ) );

    // Checkbox
    $woocommerce_checkbox = isset( $_POST['_checkbox'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_checkbox', $woocommerce_checkbox );

    // Custom Field
    $custom_field_type =  array( esc_attr( $_POST['_field_one'] ), esc_attr( $_POST['_field_two'] ) );
    update_post_meta( $post_id, '_custom_field_type', $custom_field_type );

    // Hidden Field
    $woocommerce_hidden_field = $_POST['_hidden_field'];
    if( !empty( $woocommerce_hidden_field ) )
        update_post_meta( $post_id, '_hidden_field', esc_attr( $woocommerce_hidden_field ) );

    // Product Field Type
    $product_field_type =  $_POST['product_field_type'];
    update_post_meta( $post_id, '_product_field_type_ids', $product_field_type );

}

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

//2- create fields inside custom tab
// Display Fields
add_action('woocommerce_product_data_panels', 'woo_add_custom_general_fields');

function woo_add_custom_general_fields() {

    global $woocommerce, $post;

    echo '<div class="options_group">';

    // Text Field
    woocommerce_wp_text_input(
        array(
            'id'          => '_text_field',
            'label'       => __( 'My Text Field', 'woocommerce' ),
            'placeholder' => 'http://',
            'desc_tip'    => 'true',
            'description' => __( 'Enter the custom value here.', 'woocommerce' )
        )
    );
    // Number Field
    woocommerce_wp_text_input(
        array(
            'id'                => '_number_field',
            'label'             => __( 'My Number Field', 'woocommerce' ),
            'placeholder'       => '',
            'description'       => __( 'Enter the custom value here.', 'woocommerce' ),
            'type'              => 'number',
            'custom_attributes' => array(
                'step' 	=> 'any',
                'min'	=> '0'
            )
        )
    );
    // Textarea
    woocommerce_wp_textarea_input(
        array(
            'id'          => '_textarea',
            'label'       => __( 'My Textarea', 'woocommerce' ),
            'placeholder' => '',
            'description' => __( 'Enter the custom value here.', 'woocommerce' )
        )
    );
    // Select
    woocommerce_wp_select(
        array(
            'id'      => '_select',
            'label'   => __( 'My Select Field', 'woocommerce' ),
            'options' => array(
                'one'   => __( 'Option 1', 'woocommerce' ),
                'two'   => __( 'Option 2', 'woocommerce' ),
                'three' => __( 'Option 3', 'woocommerce' )
            )
        )
    );
    // Checkbox
    woocommerce_wp_checkbox(
        array(
            'id'            => '_checkbox',
            'wrapper_class' => 'show_if_simple',
            'label'         => __('My Checkbox Field', 'woocommerce' ),
            'description'   => __( 'Check me!', 'woocommerce' )
        )
    );
    // Product Select
    ?>
    <p class="form-field product_field_type">
        <label for="product_field_type"><?php _e( 'Product Select', 'woocommerce' ); ?></label>
        <select id="product_field_type" name="product_field_type[]" class="ajax_chosen_select_products" multiple="multiple" data-placeholder="<?php _e( 'Search for a product&hellip;', 'woocommerce' ); ?>">
            <?php
            $product_field_type_ids = get_post_meta( $post->ID, '_product_field_type_ids', true );
            $product_ids = ! empty( $product_field_type_ids ) ? array_map( 'absint',  $product_field_type_ids ) : null;
            if ( $product_ids ) {
                foreach ( $product_ids as $product_id ) {
                    $product      = get_product( $product_id );
                    $product_name = woocommerce_get_formatted_product_name( $product );
                    echo '<option value="' . esc_attr( $product_id ) . '" selected="selected">' . esc_html( $product_name ) . '</option>';
                }
            }
            ?>
        </select> <img class="help_tip" data-tip='<?php _e( 'Your description here', 'woocommerce' ) ?>' src="<?php echo $woocommerce->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
    </p>
    <?php

    echo '</div>';

}


function add_new_menu_items()
{
    add_menu_page(
        "Theme Options",
        "Theme Options",
        "manage_options",
        "theme-options",
        "theme_options_page",
        "",
        100
    );

}

function theme_options_page()
{
 ?>



        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php

            settings_fields("header_section");

            do_settings_sections("theme-options");

            submit_button();

            ?>
        </form>

    <?php
}

add_action("admin_menu", "add_new_menu_items");

function display_options()
{
         add_settings_section("header_section", "Header Options", "display_header_options_content", "theme-options");


            add_settings_field("background_picture", "Picture File Upload", "background_form_element", "theme-options", "header_section");
            register_setting("header_section", "background_picture", "handle_file_upload");


}

function handle_file_upload($options)
{
    if(!empty($_FILES["background_picture"]["tmp_name"]))
    {
        $urls = wp_handle_upload($_FILES["background_picture"], array('test_form' => FALSE));
        $temp = $urls["url"];
        return $temp;
    }

    return get_option("background_picture");
}


function display_header_options_content(){echo "The header of the theme";}
function background_form_element()
{
    ?>
    <input type="file" name="background_picture" id="background_picture" value="<?php echo get_option('background_picture'); ?>" />
    <?php echo get_option("background_picture"); ?>
    <?php
}

add_action("admin_init", "display_options");










