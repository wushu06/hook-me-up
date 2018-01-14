<?php

namespace Inc\Data;

use \Inc\Base\BaseController;

class InsertUser extends BaseController {

    public $user_id;

    function handle_csv($file) {

    //$csv_file                        = 'http://localhost/wp_treehouse/wp-content/plugins/hook-me-up-csv/users.csv';
   // $csv_file = $this->plugin_url.'users.csv';
   $csv_file = $file;
    
        //for checking headers
        // $requiredHeaders                 = array( 'Product id', 'User', 'Price' );
        $requiredHeaders                 = array( 'Username', 'Email' );
    
        $fptr                            = fopen($csv_file, 'r');
        $firstLine                       = fgets($fptr); //get first line of csv file
        fclose($fptr);
         $foundHeaders                    = str_getcsv(trim($firstLine), ',', '"'); //parse to array
         
    
        //check the headers of file
        if ($foundHeaders !== $requiredHeaders) {
            echo 'File Header not the same';
            die();
        }
        $getfile = fopen($csv_file, 'r');
        //$users     = array();
        if (false !== ($getfile = fopen($csv_file, 'r') )) {
            $data        = fgetcsv($getfile, 1000, ',');
            //display table headers
            //var_dump($data  );
    
            $update_cnt  = 0;
            $insert_cnt  = 0;
            $count=0;
            while (false !== ($data      = fgetcsv($getfile, 1000, ','))) {
                $count++;
                $result                  = $data; // two sperate arrays
                $str                     = implode(',', $result); // join the two sperate arrays 
                $slice                   = explode(',', $str); // remove , 
                $username                 = $slice[ 0 ];
                $email                    = $slice[ 1 ];
                
    
                $this->insert_update_user( $username, $email, $password=NULL, $role='customer');
    
            }//end of while
            // $ruleManager->setUnusedRulesAsInactive();
            //display summary
        }
    
    
    
    }

    function insert_update_user( $username, $email, $password, $role){
        $pass = wp_hash_password($password);
        $userdata = array(
            'user_login'  =>  $username,
            'user_pass'   => $pass,
            'user_email'  =>$email,
            'role' => $role
        );

       global $wpdb;
        
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE user_email = %s", $email));

            echo $count;
            if($count == 1){
                $v = get_user_by( 'login', $username );
                $ID = $v->ID;
                $user_id = wp_update_user( array( 'ID'=>$ID,'user_login'=>$username, 'user_email' => $email ) );
                if ( is_wp_error( $user_id ) ) {
                    echo "There was an error, probably that user doesn't exist";
                } else {
                    echo ' User has been updated!';
                } 
             }else{
                $user_id = wp_insert_user( $userdata ) ;
                
                echo $username.' New User <br>';
                
                //On success
                if ( ! is_wp_error( $user_id ) ) {
                    echo "User created : ". $username.' ID: '.$user_id;
                }   
            }
       
        /*$exists = email_exists( $email );
        if ( $exists ) {
            $v = get_user_by( 'login', $username );
            $ID = $v->ID;
            $user_id = wp_update_user( array( 'ID'=>$ID,'user_login'=>$username, 'user_email' => $email ) );
            if ( is_wp_error( $user_id ) ) {
                echo "There was an error, probably that user doesn't exist";
            } else {
                echo ' Success!';
            }        
        } else {
            $user_id = wp_insert_user( $userdata ) ;
            
            echo $username.' New User <br>';
            
            //On success
            if ( ! is_wp_error( $user_id ) ) {
                echo "User created : ". $username.' ID: '.$user_id;
            }      
        }
*/
        /*$blogusers = get_users(  );
        foreach ( $blogusers as $user ) {
           
            $exist_username = $user->user_login;
           

            if( $exist_username == $username ) {
                $v = get_user_by( 'login', $username );
                $ID = $v->ID;
                echo $exist_username.' username already exists';
                 // wp_update_user ignores username (user_login) you must call sql to change user_login
                $user_id = wp_update_user( array( 'ID' => $ID,'user_login'=>$username, 'user_email' => $email ) );
                if ( is_wp_error( $user_id ) ) {
                    echo "There was an error, probably that user doesn't exist";
                } else {
                    echo ' Success!'.$ID;
                }
                
            }
            else {
                $user_id = wp_insert_user( $userdata ) ;

                echo $username.' New User <br>';
                
                //On success
                if ( ! is_wp_error( $user_id ) ) {
                    echo "User created : ". $username.' ID: '.$user_id;
                }
            }
        }*/




    }

}


