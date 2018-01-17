<?php

namespace Inc\Data;

use Inc\Data\Read;
use Inc\Data\InsertPriceByUser;
use Inc\Data\InsertPriceByRole;
use Inc\Data\InsertUser;

class Submit
{



    public function submit_data($FILE_POST, $POST)
    {
        $output ='';
        $output_array ='';
        $read = new Read();
        $insert_by_user = new InsertPriceByUser();
        $insert_by_role = new InsertPriceByRole();
        $insert_users = new InsertUser();


        $file = $read->upload_csv_file($FILE_POST);

        if( $POST == 'submit_prices_users'):
            $output_array   = $insert_by_user->insert_update_by_user($file);
            $output .= $read->read_prices_file($file);
         elseif( $POST == 'submit_prices_role') :
             $output_array   = $insert_by_role->insert_update_by_role($file);
             $output  .= $read->read_prices_file($file);
         elseif( $POST == 'submit_users') :
             $output_array = $insert_users->handle_csv($file);
             $output  = $read->read_users_file($file);
         endif;


         $this->send_email ($file);


        return sprintf("<h3> %s </h3> <hr><h3>Result:</h3> %s.",$output_array['msg'],$output);


    }

    public function send_email ($file)
    {
        $insert_users = new InsertUser();
        $option = get_option ('hmu_plugin_dashboard');
        $send_email = $option["activate_email"];


        if($send_email == true) {
            if ($insert_users->data_check  == true ){
                $to = get_bloginfo('admin_email');
                $subject = get_bloginfo('name').' Users Update';
                $message = 'new users have been added / updated';
                $headers[] = 'From: '.get_bloginfo('name').' <'.$to.'>'; // 'From: Alex <me@alecaddd.com>'
                // $headers[] = 'Content-Type: text/html: charset=UTF-8';
                $attachments = $file;
                wp_mail($to, $subject, $message, $headers, $attachments);

                echo '<h3>Email has been sent</h3>';


            }
        }


    }


}