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
				$location_name = $slice[0];
				$location_postcode = $slice[1];
				$location_address = $slice[2];
				$location_city = $slice[3];
				$location_country = $slice[4];

				return $reault_array = $this->insert_update_locations($location_name, $location_postcode, $location_address, $location_city, $location_country);





			}//end of while


		}


	}

	function insert_update_locations($location_name, $location_postcode, $location_address, $location_city, $location_country)
	{

		/*$post_id = wp_insert_post( array(
			'post_title' =>  $location_name ,
			'post_content' => '',
			'post_status' => 'publish',
			'post_type' => "wpsl_stores",
		) );*/

		/*wp_set_object_terms( $post_id, 'simple', 'product_type' );

		update_post_meta( $post_id, '_visibility', 'visible' );
		update_post_meta( $post_id, '_stock_status', 'instock');
		update_post_meta( $post_id, 'total_sales', '0' );
		update_post_meta( $post_id, '_downloadable', 'no' );
		update_post_meta( $post_id, '_virtual', 'yes' );
		update_post_meta( $post_id, '_price',  '' );
		update_post_meta( $post_id, '_regular_price',  '' );
		update_post_meta( $post_id, '_sale_price', '' );
		update_post_meta( $post_id, '_purchase_note', '' );
		update_post_meta( $post_id, '_featured', 'no' );
		update_post_meta( $post_id, '_weight', '' );
		update_post_meta( $post_id, '_length', '' );
		update_post_meta( $post_id, '_width', '' );
		update_post_meta( $post_id, '_height', '' );
		update_post_meta( $post_id, '_sku', '' );
		update_post_meta( $post_id, '_product_attributes', array() );
		update_post_meta( $post_id, '_sale_price_dates_from', '' );
		update_post_meta( $post_id, '_sale_price_dates_to', '' );
		update_post_meta( $post_id, '_price', '' );
		update_post_meta( $post_id, '_sold_individually', '' );
		update_post_meta( $post_id, '_manage_stock', 'no' );
		update_post_meta( $post_id, '_backorders', 'no' );
		update_post_meta( $post_id, '_stock', '' );*/


		$this->data_check = true;
		echo 'it works';


	}


}