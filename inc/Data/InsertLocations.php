<?php
/**
 * Created by PhpStorm.
 * User: nourlatreche
 * Date: 01/02/2018
 * Time: 10:38
 */

namespace Inc\Data;


class InsertLocations
{
	function handle_csv($file)
	{

		//$csv_file                        = 'http://localhost/wp_treehouse/wp-content/plugins/hook-me-up-csv/users.csv';
		// $csv_file = $this->plugin_url.'users.csv';
		$csv_file = $file;


		//for checking headers
		$requiredHeaders = array("location name","postcode","locaiton address","city","country");

		$fptr = fopen($csv_file, 'r');
		$firstLine = fgets($fptr); //get first line of csv file
		fclose($fptr);
		$foundHeaders = str_getcsv(trim($firstLine), ',', '"'); //parse to array


		//check the headers of file
		if ($foundHeaders !== $requiredHeaders) {?>
            <div class="notice notice-warning is-dismissible">
                <p>File Header not the same</p>
            </div>

		<?php
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
				$location_name = $slice[0];
				$location_postcode = $slice[1];
				$location_address = $slice[2];
				$location_city = $slice[3];
				$location_country = $slice[4];

				$reault_array = $this->insert_update_locations($location_name, $location_postcode, $location_address, $location_city, $location_country);





			}//end of while


		}
        return $reault_array;




	}

	function insert_update_locations($location_name, $location_postcode, $location_address, $location_city, $location_country)
	{
	    global  $wpdb;
        $page = get_page_by_title($location_name, OBJECT, 'wpsl_stores');
        if( null ==  $page  ) {
            $post_id = wp_insert_post( array(
                'post_title' =>  $location_name ,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => "wpsl_stores",
            ) );

            if($post_id)

                wp_set_object_terms( $post_id, 'cat-two', 'wpsl_store_category' );
              //  wp_set_post_terms($post_id, wp_create_category('My Category'), 'category');

                update_post_meta( $post_id , 'wpsl_zip', $location_postcode );
                update_post_meta( $post_id , 'wpsl_address', $location_address );
                update_post_meta( $post_id , 'wpsl_city', $location_city );
                update_post_meta( $post_id , 'wpsl_country', $location_country );




            $this->data_check = true;
        } else {?>
            <div class="notice notice-error is-dismissible">
                <p>This Post <strong><?php echo $location_name ?></strong> already exists</p>
            </div>

           <?php $my_post = array(
                'ID'           =>  $page->ID,
                'post_title'   => $location_name,

            );
            wp_update_post( $my_post );

            wp_set_object_terms( $page->ID, 'cat-two', 'wpsl_store_category' );

            update_post_meta( $page->ID , 'wpsl_zip', $location_postcode );
            update_post_meta( $page->ID , 'wpsl_address', $location_address );
            update_post_meta( $page->ID , 'wpsl_city', $location_city );
            update_post_meta( $page->ID , 'wpsl_country', $location_country );
        } // end if





	}


}