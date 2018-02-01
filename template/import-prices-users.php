<?php // MyPlugin - Settings Page


// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

use \Inc\Base\BaseController;

//$file = content_url().'/plugins/hook-me-up-csv/newp.csv';
//echo file_get_contents($file);

?>
    <h1>
        <?php echo esc_html(get_admin_page_title()); ?>
    </h1>


    <div class="wrap">
        <h2>Upload CSV File</h2>
        <span>
			<?php use Inc\Data\Upload;


            ?>
			</span>
        <hr>


        <div class="container">

            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">User Based Prices</li>
                <li class="tab-link" data-tab="tab-2">Role Based Prices</li>
                <li class="tab-link" data-tab="tab-3">Import Users</li>
                <li class="tab-link" data-tab="tab-4">Import Products</li>
                <li class="tab-link" data-tab="tab-5">Import Locations</li>

            </ul>


            <div id="tab-1" class="tab-content  current">


                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Insert New Prices(By User):</label><br>
                    <input type="file" name="file_prices_users" id="fileToUpload">
                    <input class="btn btn-primary" type="submit" value="Insert/Update Prices"
                           name="submit_prices_users">
                </form>


            </div>

            <div id="tab-2" class="tab-content">

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Insert New Products(By Role):</label><br>
                    <input type="file" name="file_price_role" id="fileToUpload">
                    <input class="btn btn-primary" type="submit" value="Insert/Update Prices" name="submit_prices_role">
                </form>
            </div>

            <div id="tab-3" class="tab-content">

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Insert Users:</label><br>
                    <input type="file" name="file_users" id="fileToUpload">
                    <input class="btn btn-primary" type="submit" value="Insert/Update Users" name="submit_users">
                </form>
            </div>


            <div id="tab-4" class="tab-content">

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Import Products:</label><br>
                    <input type="file" name="file_products" id="fileToUpload">
                    <input class="btn btn-primary" type="submit" value="Insert/Update Products" name="submit_products">
                </form>
            </div>

            <div id="tab-5" class="tab-content">

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Import Locations:</label><br>
                    <input type="file" name="file_locations" id="fileToUpload">
                    <input class="btn btn-primary" type="submit" value="Insert/Update Locations" name="submit_locations">
                </form>
            </div>

        </div><!-- container -->


        <?php

        use Inc\Data\Submit;
        $submit = new Submit();


        if (isset($_POST["submit_prices_users"]) && !empty($_FILES["file_prices_users"]["name"])) {

            echo '<h1>Upload Prices By User</h1>';
            $FILE_POST = $_FILES["file_prices_users"];
            echo $submit->submit_data($FILE_POST, 'submit_prices_users');


        }

        if (isset($_POST["submit_prices_role"]) && !empty($_FILES["file_price_role"]["name"])) {


            echo '<h1>Upload Prices By Role</h1>';
            //  echo    $csv_file                        = $this->plugin_url.'user_price.csv';
            //$file = $this->plugin_path.'price.csv';
            $FILE_POST = $_FILES["file_price_role"];
            echo $submit->submit_data($FILE_POST, 'submit_prices_role');
        }


        if (isset($_POST["submit_users"]) && !empty($_FILES["file_users"]["name"])) {
            echo '<h1>Users Uploaded:</h1>';
            //$file = $this->plugin_path.'price.csv';
            $FILE_POST = $_FILES["file_users"];
            echo $submit->submit_data($FILE_POST, 'submit_users');


        }

        if (isset($_POST["submit_products"]) && !empty($_FILES["file_products"]["name"]) ) {
            echo '<h1>Products Uploaded:</h1>';
            // $file = $this->plugin_path.'new.csv';
             $FILE_POST = $_FILES["file_products"];
             echo $submit->submit_data($FILE_POST, 'submit_products');


        }

        if (isset($_POST["submit_locations"]) && !empty($_FILES["file_locations"]["name"]) ) {
	        echo '<h1>Locations Uploaded:</h1>';
	        // $file = $this->plugin_path.'new.csv';
	        $FILE_POST = $_FILES["file_locations"];
	        echo $submit->submit_data($FILE_POST, 'submit_locations');


        }


        ?>
    </div>

<?php























