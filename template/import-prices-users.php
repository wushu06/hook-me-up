<?php // MyPlugin - Settings Page


// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

use Inc\Data\InsertPriceByUser;
use Inc\Data\InsertPriceByRole;
use Inc\Data\InsertUser;
use Inc\Base\Email;
use Inc\Data\InsertProducts;
use Inc\Data\Submit;
use Inc\Data\InsertLocations;
use Inc\Data\UploadFile;

$insert_by_user = new InsertPriceByUser();
$insert_by_role = new InsertPriceByRole();

$insert_products = new InsertProducts();
$insert_locations = new InsertLocations();

$submit = new Submit();
$upload = new UploadFile();
$email = new Email ();
?>
    <h1>
        <?php echo esc_html(get_admin_page_title()); ?>
    </h1>


    <div class="wrap">
        <h2>Upload CSV File</h2>
        <span>

			</span>
        <hr>


        <div class="container">

            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1"><i class="fas fa-pound-sign"></i> User Based Prices</li>
                <li class="tab-link" data-tab="tab-2"><i class="fas fa-pound-sign"></i> Role Based Prices</li>
                <li class="tab-link" data-tab="tab-3"><i class="fas fa-upload"></i> Import Users</li>
                <li class="tab-link" data-tab="tab-4"><i class="fas fa-truck"></i> Import Products</li>
                <li class="tab-link" data-tab="tab-5"><i class="fas fa-thumbtack"></i> Import Locations</li>

            </ul>


            <div id="tab-1" class="tab-content  current">


                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Insert New Prices(By User):</label><br>
                    <input type="file" name="file_prices_users" id="locationUpload1">
                    <button id="importTable1" class="upload-file hmu-btn"> Upload File </button>
                    <input class="hmu-input hmu-primary  hidden" type="submit" value="Insert/Update Prices"  name="submit_prices_users">
                </form>


            </div>

            <div id="tab-2" class="tab-content">

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Insert New Products(By Role):</label><br>
                    <input type="file" name="file_price_role" id="locationUpload2">
                    <button id="importTable2" class="upload-file hmu-btn"> Upload File </button>
                    <input class="hmu-input hmu-primary  hidden" type="submit" value="Insert/Update Prices" name="submit_prices_role">
                </form>
            </div>

            <div id="tab-3" class="tab-content">
                <span>New users must have unique username and email.</span>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Insert Users:</label><br>
                    <input type="file" name="file_users" id="locationUpload3">
                    <button id="importTable3" class="upload-file hmu-btn"> Upload File </button>
                    <input class="hmu-input hmu-primary  hidden" type="submit" value="Insert/Update Users" name="submit_users">
                </form>

            </div>


            <div id="tab-4" class="tab-content">

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Import Products:</label><br>
                    <input type="file" name="file_products" id="locationUpload4">
                    <button id="importTable4" class="upload-file hmu-btn"> Upload File </button>
                    <input class="hmu-input hmu-primary  hidden" type="submit" value="Insert/Update Products" name="submit_products">
                </form>
            </div>

            <div id="tab-5" class="tab-content">

                <form action=""   method="post" enctype="multipart/form-data">
                    <label for="">Import Locations:</label><br>
                    <input  type="file" name="file_locations" id="locationUpload5">
                    <button id="importTable" class="upload-file hmu-btn"> Upload File </button>
                    <input class="hmu-input hmu-primary  hidden" type="submit" value="Insert/Update Locations" name="submit_locations">
                </form>

            </div>

        </div><!-- container -->

        <div class="output-table">


        </div>


        <?php



        if (isset($_POST["submit_prices_users"]) && !empty($_FILES["file_prices_users"]["name"])) {

            echo '<h1>Upload Prices By User</h1>';
            $FILE_POST = $_FILES["file_prices_users"]['tmp_name'];
	        $result = $submit->submit_data( 'submit_prices_users', $FILE_POST);
	        foreach ($result as $key => $value ) {
		        echo $value;
	        }



        }

        if (isset($_POST["submit_prices_role"]) && !empty($_FILES["file_price_role"]["name"])) {?>
            <div class="notice notice-success is-dismissible">
                <h1>Prices Uploaded:</h1>
            </div>
            <?php
            //  echo    $csv_file                        = $this->plugin_url.'user_price.csv';
            //$file = $this->plugin_path.'price.csv';
            $FILE_POST = $_FILES["file_price_role"]['tmp_name'];
	        $result = $submit->submit_data( 'submit_prices_role', $FILE_POST);
	        foreach ($result as $key => $value ) {
		        echo $value;
	        }
        }


        if (isset($_POST["submit_users"]) && !empty($_FILES["file_users"]["name"])) {?>
            <div class="notice notice-success is-dismissible">
                <h1>Users Uploaded:</h1>
            </div>
            <?php
            $email_results = array();
            $FILE_POST = $_FILES["file_users"]['tmp_name'];
            $result =  $submit->submit_data( 'submit_users', $FILE_POST);

            $output ="<table class='widefat fixed' >\n\n";
            $output .= "<thead>\n\n";
            $output .= "<tr>\n\n";
            $output .= "<th > Username </th>";
            $output .= "<th> message</th>";
            $output .= "<th> result</th> ";
            $output .= "</tr>\n\n";
            $output .= "</thead>\n\n";
            $output .= "<tbody> \n";


                foreach ($result as  $key=>$value ) {
                    $email_results[] =  $value['username'];
                    $output .= "<tr>\n";
                    $output .= "<td>".$value['username']."</td>";
                    $output .= "<td>" . $value['msg'] . "</td>";
                    $output .= "<td>" . ($value['check'] == true ? 'Success' : 'Failed') . "</td>";
                    $output .= "</tr>\n";

                }


            $output .= "</tbody> \n ";
            $output .= "\n</table>";

            echo $output;

           // var_dump($email_results);




            //  var_dump($result);
           // if($value['check'] == true ){echo 'true';}else {echo 'false';}



        }




        if (isset($_POST["submit_products"]) && !empty($_FILES["file_products"]["name"]) ) {?>

            <?php
            // $file = $this->plugin_path.'new.csv';
             $FILE_POST = $_FILES["file_products"]['tmp_name'];
              $result =  $submit->submit_data( 'submit_products', $FILE_POST);
              if($result) { ?>
                <div class="notice notice-success is-dismissible">
                    <h1>Products Uploaded:</h1>
                </div>
                <div class="hmu-result  ">
	             <?php foreach ($result as $key => $value ) {?>

	                    <?php   echo $value; ?>

	             <?php }?>
                  </div>
              <?php }



        }

        if (isset($_POST["submit_locations"]) ) {
             ?>
            <div class="notice notice-success is-dismissible">
                <h1>Locations Uploaded:</h1>
            </div>
            <?php
            $FILE_POST = $_FILES["file_locations"]['tmp_name'];
            echo $submit->submit_data( 'submit_locations', $FILE_POST);
           // echo $insert_locations->handle_csv($FILE_POST);


        }



        ?>
    </div>

    <form action="" method="post">
        <input class=" hmu-input hmu-success" type="submit" value="Send result to the admin's email" name="send_email">
        <input type="hidden" value="<?php if(isset($email_results )){ foreach ($email_results as $key=>$email_result ){echo $email_result.', ';}} ?>" name="username">
    </form>

<?php





