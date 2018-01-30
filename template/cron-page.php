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
    submit_button( 'Create task', 'primary', 'btnSubmit' );
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
    wp_clear_scheduled_hook( 'hmu_activation_cron' );
    $default = array();


    update_option( 'hmu_cron', $default );
    echo 'Cron has been deleted';
}




?>



