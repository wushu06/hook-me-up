<?php 

namespace Inc\Data;

use \Inc\Base\BaseController;

class Read extends BaseController {

    //public $file;
    // function to install csv data
    function upload_csv_file(){

            // Check if file was uploaded without errors
               // $allowed = array("jpg" => "image/jpg");
                $filename = $_FILES["file_users"]["name"];
                $filetype = $_FILES["file_users"]["type"];
                $filesize = $_FILES["file_users"]["size"];
                    $newFilename = time() .'_'. $_FILES["file_users"]["name"];
                    $location = $this->plugin_path.'upload/'. $newFilename;
                move_uploaded_file($_FILES["file_users"]["tmp_name"], $location);
                    //echo "Your file was uploaded successfully.";
                               

                return $location;



    }

    function read_users_file($file) {

        if(file_exists($file)):
            $output ="<table class='table-bordered table-hover table-responsive'>\n\n";
            $output .= "<thead>\n\n";
            $output .= "<tr>\n\n";
            $output .= "<th > Username</th>";
            $output .= "<th> Email</th>";
            $output .= "<th> First Name</th> ";
            $output .= "<th> Last Name</th>";
            $output .= "<th > Role</th> ";

            $output .= "</tr>\n\n";
            $output .= "</thead>\n\n";
            $output .= "<tbody> \n";
            $f = fopen($file, "r");
            while (($line = fgetcsv($f)) !== false) {
                $output .= "<tr>\n";
                foreach ($line as $cell) {
                    $output .= "<td>" . htmlspecialchars($cell) . "</td>";
                }
                $output .= "</tr>\n";
            }
            fclose($f);
            $output .= "</tbody> \n ";
            $output .= "\n</table>";

            return $output;
        else :
            $output = "Couldn't find the file!";
            return $output;
        endif;
    }
    function read_prices_file ($file) {
        //  echo $this->file;
        
        // echo file_get_contents($this->file);
         
         /*****************
         Outputing the file
         *****************/
         if(file_exists($file)):
             $output ="<table class='table-bordered table-hover table-responsive'>\n\n";
             $output .= "<thead>\n\n";
             $output .= "<tr>\n\n";
             $output .= "<th > Product id </th>";
             $output .= "<th> User</th>";
             $output .= "<th> Min Qty</th> ";
             $output .= "<th> Flat</th>";
             $output .= "<th > %</th> ";
         
             $output .= "</tr>\n\n";
             $output .= "</thead>\n\n";
             $output .= "<tbody> \n";
             $f = fopen($file, "r");
             while (($line = fgetcsv($f)) !== false) {
                     $output .= "<tr>\n";
                     foreach ($line as $cell) {
                             $output .= "<td>" . htmlspecialchars($cell) . "</td>";
                     }
                     $output .= "</tr>\n";
             }
             fclose($f);
             $output .= "</tbody> \n ";
             $output .= "\n</table>";
         
             return $output;
         else :
             $output = "Couldn't find the file!";
             return $output;
         endif; 
    }
}