<?php 

namespace Inc\Api\Callbacks; 

use \Inc\Base\BaseController;

use \Inc\Api\SettingsApi;

class FieldsCallbacks extends BaseController {

    public function checkboxSanitize( $input )
	{
		// return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        //return ( isset($input) ? true : false );
        $output = array();
        
        foreach ($this->dahboardFields   as $id_dash => $dashtitle_callback ) {
                $output[$id_dash] = isset( $input[$id_dash] ) ? true : false;
            }
    
            return $output;
    }
    public function inputSanitize( $input )
	{
            // Create our array for storing the validated options
            $output = array();
            
        // Loop through each of the incoming options
        foreach ($this->fieldsOutput as $id => $title_callback) {
                
            // Check to see if the current option has a value. If so, process it.
            if( isset( $input[$id] ) ) {
                
                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$id] = strip_tags( stripslashes( $input[ $id ] ) );
                    
            } // end if
                
        } // end foreach
            
        // Return the array processing any additional functions filtered by this action
        return $output;

    }

	public function adminSectionManager()
	{
		echo 'Import Prices and Users';
    }
    public function dashboardSectionManager ()
    {
        echo 'Dashboard Control';
    }

    public function inputUploadField( $args )
	{
        $name = $args['label_for'];
		$classes = $args['class'];
        $option_name = $args['option_name'];
        $value =  get_option( $option_name );
        
		echo '<input type="text" class="regular-text" name="'. $option_name.'['.$name.']"  value="' . $value[$name] . '" >';
    }

    function profilePictureField($args) {

        $name = $args['label_for'];
		$classes = $args['class'];
        $option_name = $args['option_name'];
        $value =  get_option( $option_name );

        if( empty($value[$name]) ){
            echo '<button type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button"><span class="sunset-icon-button dashicons-before dashicons-format-image"></span> Upload Profile Picture</button><input type="hidden" id="profile-picture" name="'. $option_name.'['.$name.']"  value="" />';
        } else {
            echo '<button type="button" class="button button-secondary" value="Replace Profile Picture" id="upload-button"><span class="sunset-icon-button dashicons-before dashicons-format-image"></span> Replace Profile Picture</button><input type="hidden" id="profile-picture" name="'. $option_name.'['.$name.']" value="'.esc_attr($value[$name]).'" /> <button type="button" class="button button-secondary" value="Remove" id="remove-picture"><span class="sunset-icon-button dashicons-before dashicons-no"></span> Remove</button>';
        }
        
    }

    function emailActivationField ($args) {

        $name = $args['label_for'];
		$classes = $args['class'];
        $option_name = $args['option_name'];
        $checkbox = get_option( $option_name );
        $checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
        
        echo '<div id="toggles">
                <input id="checkboxEmail" class="ios-toggle" type="checkbox" name="' . $option_name . '[' . $name . ']" value="1"   ' . ($checked ? "checked": "") . '>
                <label for="checkboxEmail" class="checkbox-label" data-off="off" data-on="on">
                </label>';
    }
    function cronActivationField ($args) {
        
                $name = $args['label_for'];
                $classes = $args['class'];
                $option_name = $args['option_name'];
                $checkbox = get_option( $option_name );
                $checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;
                
                echo '<div id="toggles">
                        <input id="checkboxCron" class="ios-toggle" type="checkbox" name="' . $option_name . '[' . $name . ']" value="1"   ' . ($checked ? "checked": "") . '>
                        <label for="checkboxCron" class="checkbox-label" data-off="off" data-on="on">
                        </label>';
    }


    
}