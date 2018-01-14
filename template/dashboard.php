<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

<h2>Plugin's Panel Control</h2>


<form method="post" class="hmu-general-form" action="options.php">
<?php 
    settings_fields( 'hmu__dashboard_options_group' );
    do_settings_sections( 'hmu_plugin' );
    submit_button( 'Upload Users', 'primary', 'btnSubmit' ); 
?>

</form>