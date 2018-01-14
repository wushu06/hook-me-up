<?php 
?>
<h1>
<?php echo esc_html( get_admin_page_title() ); ?>

</h1>
<div class="wrap">

<?php settings_errors(); ?>

<form method="post" class="hmu-general-form" action="options.php">
	<?php 
		settings_fields( 'hmu_options_group' );
		do_settings_sections( 'import_users' );
		submit_button( 'Upload Users', 'primary', 'btnSubmit' ); 
	?>

</form>
<?php
$option = get_option ('hmu_plugin');
$picture = $option["profile_picture"];
 ?>

<div id="profile-picture-preview" class="profile-picture" >
<img src="<?php echo $picture; ?>" alt="">
</div>
</div>