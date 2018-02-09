<?php


namespace Inc\Data;


class InsertProducts
{
    public $data_check = false;

    function handle_csv($file)
    {

        //$csv_file                        = 'http://localhost/wp_treehouse/wp-content/plugins/hook-me-up-csv/users.csv';
        // $csv_file = $this->plugin_url.'users.csv';
        $csv_file = $file;

        //for checking headers
        $requiredHeaders = array('Internal ID','Product Code','Suggested Name','Website Category','Sub-brand,Description','Short Description','Certification','');

        $fptr = fopen($csv_file, 'r');
        $firstLine = fgets($fptr); //get first line of csv file
        fclose($fptr);
        $foundHeaders = str_getcsv(trim($firstLine), ',', '"'); //parse to array


        //check the headers of file
       /* if ($foundHeaders !== $requiredHeaders) {
            echo 'File Header not the same';
            die();
        }**/
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

	            //variables
                $product_id = $slice[0];
	            $product_code = $slice[1];
                $post_title = $slice[2];
                $cat = $slice[3];
	            $description = $slice[4];
	            $short_description = $slice[5];
	            $cert = $slice[6];


                 $reault_array [] = $this->insert_update_products($product_id,$post_title,$cat, $description);





            }//end of while


        }
        return $reault_array;


    }

    function insert_update_products($product_id,$post_title,$cat, $description)
    {
        //wp_suspend_cache_addition(true);

        global $wpdb;
	    function seoUrl($string) {
		    //Lower case everything
		    $string = strtolower($string);
		    //Make alphanumeric (removes all other characters)
		    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		    //Clean up multiple dashes or whitespaces
		    $string = preg_replace("/[\s-]+/", " ", $string);
		    //Convert whitespaces and underscore to dash
		    $string = preg_replace("/[\s_]/", "-", $string);
		    return $string;
	    }

	    $seo = seoUrl($post_title);


      /*  $qry = "INSERT INTO wp_posts (ID,post_title,post_type) VALUES (%d,%s,%s)";
        $qry = $wpdb->prepare(
            $qry,
            $post_id,
            $key,
            $value
        );
        var_dump($qry);
        $wpdb->query($qry);*/
       // $wpdb->insert( 'wp_posts', array( 'post_title' => $key, 'ID' => $post_id,'post_type'=>'product' ), array( '%s', '%d', '%s') );

       // $results = $wpdb->get_results( "SELECT ID FROM wp_posts WHERE post_type = 'product'" );

        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts WHERE ID = %d AND post_type = 'product'", $product_id));

        if($count == 1){

                $wpdb->update(
                    $wpdb->posts,
                        array(
                            'post_title' => $post_title,
	                        'post_content' => $description
                        ),
                        array(
                            'ID' => $product_id
                        ),

                        array(
                            '%s',
	                        '%s'
                        )
                );

                $msg = $post_title. ' Product has been updated <br/ >';

            }else {
                $wpdb->insert(
                    $wpdb->posts,
                    array(
                        'ID'    => $product_id,
                        'post_title'    => $post_title,
                        'post_name' => $post_title,
                        'post_content'=> 'test content',
                        'guid'=> get_site_url().'/product/'.$seo,
                        'post_type'=>'product'
                    ),
	                array(
		                '%d',
		                '%s',
		                '%s',
		                '%s',
		                '%s',
		                '%s'
	                )
                );

               $msg = $post_title. '  Product has been insert <br/ >';

            }





	   // wp_set_object_terms( $product_id, 'simple', 'product_type' );
	    $cat_slug = seoUrl($cat);
	    //wp_set_post_terms( $product_id, $cat_slug, 'product_cat', true );
	   // wp_set_post_terms($product_id, $cat_slug, 'product_cat');
	    wp_set_object_terms($product_id, $cat, 'product_cat', true);



	    update_post_meta( $product_id, '_visibility', 'visible' );
	    update_post_meta( $product_id, '_stock_status', 'instock');
	    update_post_meta( $product_id, 'total_sales', '0' );
	    update_post_meta( $product_id, '_downloadable', 'no' );
	    update_post_meta( $product_id, '_virtual', 'yes' );
	    update_post_meta( $product_id, '_price',  '' );
	    update_post_meta( $product_id, '_regular_price',  '' );
	    update_post_meta( $product_id, '_sale_price', '' );
	    update_post_meta( $product_id, '_purchase_note', '' );
	    update_post_meta( $product_id, '_featured', 'no' );
	    update_post_meta( $product_id, '_weight', '' );
	    update_post_meta( $product_id, '_length', '' );
	    update_post_meta( $product_id, '_width', '' );
	    update_post_meta( $product_id, '_height', '' );
	    update_post_meta( $product_id, '_sku', '' );
	    update_post_meta($product_id, '_product_attributes', array() );
	    update_post_meta( $product_id, '_sale_price_dates_from', '' );
	    update_post_meta( $product_id, '_sale_price_dates_to', '' );
	    update_post_meta( $product_id, '_price', '' );
	    update_post_meta( $product_id, '_sold_individually', '' );
	    update_post_meta( $product_id, '_manage_stock', 'no' );
	    update_post_meta( $product_id, '_backorders', 'no' );
	    update_post_meta( $product_id, '_stock', '' );

        $wpdb->show_errors();
        return $msg;



        /* $post_id = wp_insert_post( array(
             'post_ID'=> $product_id,
             'post_title' =>  $post_title ,
             'post_content' => $post_name,
             'post_status' => 'publish',
             'post_type' => "product",
         ) );

         wp_set_object_terms( $post_id, 'simple', 'product_type' );

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
         update_post_meta( $post_id, '_stock', '' );


           $this->data_check = true;*/


    }


}