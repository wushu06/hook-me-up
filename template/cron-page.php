<?php use Inc\Base\BaseController; ?>
<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

<?php // if ( ! $this->activated( 'hmu_plugin', 'activate_cron' ) ) : ?>
<?php if(@get_option('hmu_dashboard')['activate_cron'] == false) : ?>

<h2>Cron Task Not Activated.</h2>

<p><a href="<?php echo get_admin_url()  ?>?page=hmu_plugin">Activate Here</a></p>

<?php else: ?>
<h2>Cron Activated</h2>


<?php settings_errors(); ?>

<form method="post" class="hmu-general-form" action="options.php">
    <?php
    settings_fields( 'hmu_cron_options_group' );
    do_settings_sections( 'cron_task' );
    submit_button( 'Create task', '', 'btnSubmit' );
    ?>
<?php
    @$option  = get_option ('hmu_cron');


    $output ="<table class='widefat fixed' cellspacing='0'>\n\n";
    $output .= "<thead>\n\n";
    $output .= "<tr>\n\n";
    $output .= "<th > Task ID</th>";
    $output .= "<th> Task Name</th>";
    $output .= "<th> Task Schedule</th>";
    $output .= "<th> Task Path</th>";
    $output .= "<th> Delete</th>";

    $output .= "</tr>\n\n";
    $output .= "</thead>\n\n";
    $output .= "<tbody> \n";



            foreach ($option as $key => $value) {
                $output .= "<tr>\n";
                $output .=  "<td>" . $key . "</td>";
                $output .=  "<td>" .$value['cron_name']. "</td>";
                $output .=  "<td>" .$value['cron_time']. "</td>";
                $output .=  "<td>" .$value['cron_file']. "</td>";
                $output .=  "<td><a href='".admin_url()."admin.php?page=cron_task&cron_delete=".$key."'><i class='fa fa-close'></i></a></td>";
                $output .= "</tr>\n";

            }

    $output .= "</tbody> \n ";
    $output .= "\n</table>";

    echo $output;




    if(@$cron_name):

        echo '<div class="cron-wrapper"><h4>Next Schdeduled Task:
                </h4>' . $cron_name . '<br>
                <h4>Frequency: </h4>' . $cron_time.'<br/>
                <h4>File Path:</h4>'.$cron_file;
    endif;



?>

</form>
    <form method="POST" action="">
        <input name="delete_cron" type="submit" value="Delete cron task">
    </form>

<?php endif; ?>
<?php
/*use Inc\Base\Cron;

$cron = new Cron();

 $cron->register() ;*/

if(isset($_POST['delete_cron'])){
    delete_option( 'hmu_cron' );
    wp_clear_scheduled_hook( 'hmu_upload_file_cron' );
    $default = array();

     add_option('hmu_cron', $default);
    $output = get_option('hmu_cron');
    $output = array();


    echo 'Tak has been deleted';
}
if(isset($_GET['cron_delete'])){
    echo $id = $_GET['cron_delete'];
    $option  = get_option ('hmu_cron');
    $option_id = $option[$id];
    $option_id = array();

}




?>



