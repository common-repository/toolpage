<?php
/*global $wpdb;
$table_name_box = $wpdb->prefix . "toolpage_box"; 
$toolpage_data = $wpdb->get_results("SELECT * FROM $table_name_box ORDER BY box_id DESC");
$option = 'toolpage_options';
$options = get_option($option);*/
?>

<br />

<div class="container-fluid">
    <div class="lead">
        <h1>Credits <?php echo PLUGIN_NAME; ?></h1>
        <p><?php _e('Thanks.', 'toolpage'); ?></p>
    </div>
    
    <div>
    	<?php require_once PLUGIN_PATH.'/includes/newsticker.php'; ?>   
    </div>
    
    <!--<div class="row">
      <div class="span20">
      </div>
      <div class="span5">...</div>
    </div>-->
    
    <p>
      	<a href="http://www.make23.com/#utm_source=wpadmin&amp;utm_medium=plugin&amp;utm_campaign=wptoolpageplugin" target="_blank"><img src="http://www.make23.com/wp-content/uploads/2011/07/logo-make23-2-trasp.png" width="204" height="41" align="left" hspace="10" /></a><?php echo PLUGIN_NAME; ?> <?php _e('is a registered trademark', 'toolpage'); ?><br />
        <small><?php _e('This plugin was designed and developed by', 'toolpage'); ?> <a href="http://www.make23.com/#utm_source=wpadmin&amp;utm_medium=plugin&amp;utm_campaign=wptoolpageplugin" target="_blank"><strong>Make23.com</strong></a></small>
        
        <br class="clear" />
        <br class="clear" />
        
        <img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/bootstrap-logo.png" width="204" align="left" hspace="10" />Twitter Bootstrap<br />
        <small><?php _e('Version', 'toolpage'); ?> 2.3.1</small>
    </p>
    
    <br />
    
    <?php require_once PLUGIN_PATH.'/includes/footer-general.php'; ?>
</div>