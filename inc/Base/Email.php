<?php

namespace Inc\Base;


class Email
{


    public function hmu_send_admin_email() {

        $message = '<h1>Import Result</h1>';
        $message .= '<p>List of new/updated users:<br/>';
        $message .=  $_POST['username'].' <br>';

        $to = get_bloginfo('admin_email');
        $subject = get_bloginfo('name').' Users Update';
        $headers[] = 'From: '.get_bloginfo('name').' <'.$to.'>';
        wp_mail($to, $subject, $message, $headers);

        return $msg = 'email was sent';
    }

    public function retrieve_password($user_login) {
        global $wpdb, $current_site;

        if ( empty( $user_login) ) {
            return false;
        } else if ( strpos( $user_login, '@' ) ) {
            $user_data = get_user_by( 'email', trim( $user_login ) );
            if ( empty( $user_data ) )
                return false;
        } else {
            $login = trim($user_login);
            $user_data = get_user_by('login', $login);
        }

        do_action('lostpassword_post');


        if ( !$user_data ) return false;

        // redefining user_login ensures we return the right case in the email
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

        do_action('retreive_password', $user_login);  // Misspelled and deprecated
        do_action('retrieve_password', $user_login);

        $allow = apply_filters('allow_password_reset', true, $user_data->ID);

        if ( ! $allow )
            return false;
        else if ( is_wp_error($allow) )
            return false;

        $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
        if ( empty($key) ) {
            // Generate something random for a key...
            $key = wp_generate_password(20, false);
            do_action('retrieve_password_key', $user_login, $key);
            // Now insert the new md5 key into the db
            $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
        }
        $message = __('Checkfire.co.uk requested that the password be reset for the following account:') . "\r\n\r\n";
        $message .= network_home_url( '/' ) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
        $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
        $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

        if ( is_multisite() )
            $blogname = $GLOBALS['current_site']->site_name;
        else
            // The blogname option is escaped with esc_html on the way into the database in sanitize_option
            // we want to reverse this for the plain text arena of emails.
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $title = sprintf( __('[%s] Password Reset'), $blogname );

        $title = apply_filters('retrieve_password_title', $title);
        $message = apply_filters('retrieve_password_message', $message, $key);

        if ( $message && !wp_mail($user_email, $title, $message) )
            wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );

        return true;
    }


	public function welcome_email($username, $user_email)
	{
	    $message = '<h1>Dear '.$username.'</h1>';
	    $message .= '<p>We wish you a very warm welcome to CheckFire and very much look forward to working with you.<br/>';
	    $message .= 'Your online account is currently being set up, you will receive an email shortly with further instruction on how to access your account.</p>';
	    $message .= '<p>Thanks</p><p><strong>CheckFire Team</strong></p>';

        $to = $user_email;
        $subject = get_bloginfo('name').' Welcome!';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $message, $headers);

        return $msg = 'email was sent';

	}

    public function followUp_email($username, $user_email)
    {
        $message = '<h1>Dear '.$username.'</h1>';
        $message .= '<p>We’re pleased to confirm that your online account is now set up.<br/>';
        $message .= 'Please log In using you username and password in order to access your account.<br/>Don’t forget, our online live chat support is available Monday to Friday 9am – 4pm should you need any help.</p>';
        $message .= '<p>Thanks</p><p><strong>CheckFire Team</strong></p>';

        $to = $user_email;
        $subject = get_bloginfo('name').' online account';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $message, $headers);

        return $msg = 'email was sent';

    }


}