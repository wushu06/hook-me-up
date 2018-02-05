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
    $option  = get_option ('hmu_cron');
    @$cron_time  =   $option['cron_time'] ;
    @$cron_file  =   $option['cron_file'] ;
    @$cron_name  =   $option['cron_name'] ;

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
    wp_clear_scheduled_hook( 'hmu_upload_file_cron' );
    $default = array();
    update_option( 'hmu_cron', $default );
    echo 'Task has been deleted';
}




?>



