<?php

namespace Inc\Data;

use \Inc\Base\BaseController;
use \Inc\Base\Email;

class InsertUser extends BaseController
{

    public $user_id;
    public $dataCheck;
    public $user_data = array();
    public $email;

    public function __construct ()
    {
        $this->email = new Email();

    }



    function handle_csv($file)
    {
        $reault_array = array();

        //$csv_file                        = 'http://localhost/wp_treehouse/wp-content/plugins/hook-me-up-csv/users.csv';
        // $csv_file = $this->plugin_url.'users.csv';
        $csv_file = $file;

        //for checking headers
        // $requiredHeaders                 = array( 'Product id', 'User', 'Price' );
        $requiredHeaders = array('Username', 'Email', 'First Name', 'Last Name', 'Role', 'Custom ID', 'Address','City','Post code');

        $fptr = fopen($csv_file, 'r');
        $firstLine = fgets($fptr); //get first line of csv file
        fclose($fptr);
        $foundHeaders = str_getcsv(trim($firstLine), ',', '"'); //parse to array


        //check the headers of file
        if ($foundHeaders !== $requiredHeaders) {
            echo 'File Header not the same';
            die();
        }
        $getfile = fopen($csv_file, 'r');
        //$users     = array();
        if (false !== ($getfile = fopen($csv_file, 'r'))) {
            $data = fgetcsv($getfile, 1000, ',');
            //display table headers
            //var_dump($data  );

            $update_cnt = 0;
            $insert_cnt = 0;
            $count = 0;
            while (false !== ($data = fgetcsv($getfile, 1000, ','))) {
                $count++;
                $result = $data; // two sperate arrays
                $str = implode(',', $result); // join the two sperate arrays
                $slice = explode(',', $str); // remove ,
                $username = $slice[0];
                $email = $slice[1];
                $first_name = $slice[2];
                $last_name = $slice[3];
                $role = $slice[4];
                $custom_id = $slice[5];
                $address = $slice[6];
                $city = $slice[7];
                $post_code = $slice[8];


                 $reault_array[] = $this->insert_update_user($username, $email, $first_name, $last_name,  $role, $custom_id,$address,$city,$post_code);

                   // echo $reault_array['msg'];
                    //echo ($reault_array['check'] == true ? 'Send Email' : 'dont send email');



            }//end of while

        }
        return $reault_array;


    }

    function insert_update_user($username, $email, $first_name, $last_name, $role, $custom_id,$address,$city,$post_code)
    {


        $this->user_data ['username'] = $username;
        $this->user_data ['email'] = $email;
        wp_suspend_cache_addition(true);
        $password = $this->randomPassword();
        $pass = wp_hash_password($password);

        $userdata = array(
            'user_login' => $username,
            'user_pass' => $pass,
            'user_email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => $role
        );

        global $wpdb;

        // getting users by email

        //$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE user_email = %s", $email));

        // getting users by username

        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE user_login = %s", $username));


        if ($count == 1) { //

            $v = get_user_by('login', $username);
            if($v){

                $ID = $v->ID;            }

            $user_id = wp_update_user(array(
                                        'ID' => @$ID,
                                        'user_login' => $username,
                                        'user_email' => $email,
                                        'first_name'=>$first_name,
                                        'last_name'=>$last_name,
                                        'role'=>$role
                                        ));

            if (is_wp_error($user_id)) {
                $msg =  "There was an error, probably that user doesn't exist";
                $check = false;

            } else {
                $msg =  ' User has been updated!';
                $check = true;



            }
            $havemeta = get_user_meta(31, '_user_custom_id', false);

            if ($havemeta){
                update_user_meta( $user_id, '_user_custom_id', $custom_id);


            } else {
                add_user_meta( $user_id, '_user_custom_id', $custom_id);
            }

            update_user_meta( $user_id, 'shipping_address_1', $address);
            update_user_meta( $user_id, 'billing_address_1', $address);
            update_user_meta( $user_id, 'shipping_city', $city);
            update_user_meta( $user_id, 'billing_city', $city);
            update_user_meta( $user_id, 'shipping_postcode', $post_code);
            update_user_meta( $user_id, 'billing_postcode', $post_code);




        } else {

            $user_id = wp_insert_user($userdata);

            $msg =  $username . ' New User <br>';

            //On success
            if (!is_wp_error($user_id)) {

                $msg = "User created : " . $username . ' ID: ' . $user_id;


                if ($this->email->retrieve_password($username)) {
                    $msg =  "Reset Password link has been sent to ".$email;
                    $check = true;
                } else {
                    $msg = "Couldn't send reset password email to ".$email;
                    $check = false;
                }

            } else {

                $msg = "Couldn't create ";

            }

            add_user_meta( $user_id, '_user_custom_id', $custom_id);
            update_user_meta( $user_id, 'shipping_address_1', $address);
            update_user_meta( $user_id, 'billing_address_1', $address);
            update_user_meta( $user_id, 'shipping_city', $city);
            update_user_meta( $user_id, 'billing_city', $city);
            update_user_meta( $user_id, 'shipping_postcode', $post_code);
            update_user_meta( $user_id, 'billing_postcode', $post_code);


        }

         return array('username'=>$username,'msg'=>$msg, 'check'=>@$check);

    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


     /**
     * Handles sending password retrieval email to user.
     *
     * @uses $wpdb WordPress Database object
     * @param string $user_login User Login or Email
     * @return bool true on success false on error
     */





}


