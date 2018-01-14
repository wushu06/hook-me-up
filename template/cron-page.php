<?php use Inc\Base\BaseController; ?>
<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

<?php if ( ! $this->activated( 'hmu_plugin_dashboard', 'activate_cron' ) ) : ?>

<h2>Cron Task Not Activated.</h2>
<p><a href="<?php echo get_admin_url()  ?>?page=hmu_plugin">Activate Here</a></p>
<?php else: ?>
<h2>Cron Activated</h2>

<?php endif; ?>



