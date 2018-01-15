<?php // MyPlugin - Settings Page



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

use \Inc\Base\BaseController;
//$file = content_url().'/plugins/hook-me-up-csv/newp.csv';
//echo file_get_contents($file);

?>
<h1>
    <?php echo esc_html( get_admin_page_title() ); ?>
</h1>

  
        <div class="wrap">
            <h2>Upload CSV File</h2>
			<span>
			<?php use Inc\Data\Upload;

              /*  if ( isset( $_POST["submit_file"] ) && !empty($_FILES["file"]["name"]) ) {
					$upload = new Upload();
					echo $upload->html;
					$upload->register();
				} else{
                    echo "Error: There was a problem uploading your file. Please try again.";
                }*/
				

		     ?>
			</span>
            <hr>



            <div class="container">

                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">Upload File</li>
                    <li class="tab-link" data-tab="tab-2">User Based Prices</li>
                    <li class="tab-link" data-tab="tab-3">Role Based Prices</li>
                    <li class="tab-link" data-tab="tab-4">Import Users</li>

                </ul>
                <div id="tab-1" class="tab-content current">


                    <form action="" method="post" enctype="multipart/form-data">
                        Select file to upload:
                        <input type="file" name="file" id="fileToUpload">

                        <input class="btn btn-primary" type="submit" value="Upload File" name="submit_file">
                    </form>


                </div>

                <div id="tab-2" class="tab-content">


                        <form action="" method="post">
                            <label for="">Insert New Prices(By User):</label><br>
                            <input class="btn btn-primary" type="submit" value="Insert/Update Prices" name="submit_products">
                        </form>


                </div>
                <div id="tab-3" class="tab-content">

                    <form action="" method="post">
                        <label for="">Insert New Products(By Role):</label><br>
                        <input class="btn btn-primary" type="submit" value="Insert/Update Prices" name="submit_products_role">
                    </form>
                </div>
                <div id="tab-4" class="tab-content">

                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="">Insert Users:</label><br>
                        <input type="file" name="file_users" id="fileToUpload">
                        <input class="btn btn-primary" type="submit" value="Insert/Update Users" name="submit_users">
                    </form>
                </div>

            </div><!-- container -->


            <?php 
            use Inc\Data\Read;
            use Inc\Data\InsertPriceByUser;
            use Inc\Data\InsertPriceByRole;
            use Inc\Data\InsertUser;
            
            
            $read = new Read ();
            $insert_by_user = new InsertPriceByUser();
            $insert_by_role = new InsertPriceByRole();
            $insert_users = new InsertUser();

            if ( isset( $_POST["submit_products"] )  ) {

                echo '<h1>' .$insert_by_user->insert_update_by_user().'</h1>';
                //  echo  read_file_Nour();
                //  echo    $csv_file                        = $this->plugin_url.'user_price.csv';

            }

            if ( isset( $_POST["submit_products_role"] )  ) {


                  echo  '<h1>' .$insert_by_role->insert_update_by_role().'</h1>';
                //  echo    $csv_file                        = $this->plugin_url.'user_price.csv';

            }


           /* if ( isset( $_POST["submit_users"] )  && !empty($_FILES["file"]["name"]) ) {
                
                echo  '<h1>Products Uploaded:</h1>';
                // $file = $this->plugin_path.'price.csv';
                // $file = $read->upload_csv_file();
                 //echo $file;
               //  echo $read->read_prices_file($file); 
                //$insert_users->handle_csv($file);                //  echo    $csv_file                        = $this->plugin_url.'user_price.csv';
              
            }*/
           if ( isset( $_POST["submit_users"] )  && !empty($_FILES["file_users"]["name"]) ) {
                echo  '<h1>Products Uploaded:</h1>';
              //$file = $this->plugin_path.'price.csv';
               $file = $read->upload_csv_file();
               echo $insert_users->handle_csv($file);
               echo $read->read_prices_file($file);
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
            
        


            
          
      

            ?>
        </div>
    

        <hr>

        <div class="hook-show-data">
            <?php
           
           
            
          /*  if ( isset( $_POST["submit_file"] ) && !empty($_FILES["file"]["name"]) ) {
                echo  '<h1>Products Uploaded:</h1>';
              // $file = $this->plugin_path.'price.csv';
               $file = $read->upload_csv_file();
               echo $insert_users->handle_csv($file);
               echo $read->read_prices_file($file);              
               


            }*/


               ?>

        </div>

<?php

function read_file_Nour(){


    




}
