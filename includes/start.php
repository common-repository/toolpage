<?php
/*if (function_exists('wp_get_current_user')) {
	$u = wp_get_current_user();
	if (!isset($u->user_locale)) 
	{
		if ($this->user == $u->data->user_login) 
			$u->user_locale = '';
		else
			$u->user_locale = 'de_DE';
	}
	echo $u->user_locale;print_r($u);
}*/
global $wpdb;
$table_name = $wpdb->prefix . "toolpage";  
$table_name_box_relazioni = $wpdb->prefix . "toolpage_box_relazioni"; 
$toolpage_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
$option = 'toolpage_options';
$options = get_option($option);

if(isset($_GET['id_del'])) $_GET['id_del'] = $_GET['id_del'];
else $_GET['id_del'] = 0;

if($_GET['id_del'] > 0){
?>
<?php
	if(isset($_POST['del']) && $_POST['id_del'] > 0){
		$wpdb->query("DELETE FROM $table_name WHERE id='".$_POST['id_del']."' LIMIT 1");
		$wpdb->query("DELETE FROM $table_name_box_relazioni WHERE toolpage_id='".$_POST['id_del']."'");
?>
<div class="updated">
	<p>
		<?php _e('The ToolPage has been deleted successfully!', 'toolpage'); ?> <a href="?page=toolpage" class="button"><strong><?php _e('Refresh this page', 'toolpage'); ?></strong></a>
    </p>
</div>
<?php
		exit;
	}
	else{
?>
<div class="error">
	<p>
        <form class="form-horizontal" action="?page=toolpage&amp;id_del=<?php echo $_GET['id_del']; ?>" method="post" style="margin:0px; padding:0px">
        	<input type="hidden" name="id_del" value="<?php echo $_GET['id_del']; ?>" />
            
    		<?php _e('Do you really want to delete the ToolPage with title', 'toolpage'); ?> &quot;<strong><?php echo getTitoloPage($table_name, $_GET['id_del']); ?></strong>&quot;? <input type="submit" name="del" class="btn btn-danger button" value="<?php _e('Confirm Delete', 'toolpage'); ?>" /> <a href="?page=toolpage" class="btn button"><?php _e('Cancel', 'toolpage'); ?></a>
        </form>
    </p>
</div>
<?php
		exit;
	}
?>
<?php
}
?>

<br />

<div class="container-fluid">
    <div class="lead">
        <h1><?php _e('Welcome to', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></h1>
        <p><?php _e('With', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?> <?php _e('you can create new landing pages for your online advertising.', 'toolpage'); ?></p>
    </div>
    
    <div>
    	<?php require_once PLUGIN_PATH.'/includes/newsticker.php'; ?>   
    </div>
    
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
        	<th>#</th>            
            <th><?php _e('Title', 'toolpage'); ?></th>
            <th>Home</th>
            <th>Box</th>
            <th>SEO</th>
            <th>CSS</th>
            <th><?php _e('Theme', 'toolpage'); ?></th>
            <th><?php _e('Box scheme', 'toolpage'); ?></th>
            <th><?php _e('Tools', 'toolpage'); ?></th>
        </tr>
      </thead>
      <tbody>
<?php
	$i = 1;
    foreach ($toolpage_data as $data) {
?>
        <tr>
        	<td><?php echo $data->id; ?></td>
            <!--<td><img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/status_<?php echo $data->active; ?>.png" /></td>-->
            <td>
            	<a href="?page=gestione-toolpage&amp;id=<?php echo $data->id; ?>" title="Clicca per modificare"><strong><?php echo $data->titolo; ?></strong></a><br />
            	<small>&raquo; <?php _e('Created', 'toolpage'); ?> <?php echo date("d/m/Y - H:i:s", $data->data_insert); ?></small><br />
                <small>&raquo; <?php _e('Updated', 'toolpage'); ?> <?php if($data->data_update > 0) echo date("d/m/Y - H:i:s", $data->data_update); else echo '<small><em>- mai aggiornata -</em></small>'; ?></small><br />
                <small><?php _e('Status:', 'toolpage'); ?></small> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/status_<?php echo $data->active; ?>.png" /> -&nbsp;&nbsp;<small>Google Analytics:</small> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/status_<?php if($data->google_editor != '') echo '1'; else echo '0'; ?>.png" />
            </td>
            <td>
            	<img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/status_<?php if($data->is_home == '1') echo '1'; else echo '0'; ?>.png" />
            </td>
            <td>
            	<?php echo getTotBoxByToolpageId($data->id, $table_name_box_relazioni); ?>
            </td>
            <td><img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/status_<?php if($data->seo_titolo != '' && $data->seo_descrizione != '') echo '1'; else echo '0'; ?>.png" /></td>
            <td><img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/status_<?php if($data->css_editor != '') echo '1'; else echo '0'; ?>.png" /></td>
            <td><small><?php echo getTheme($data->url); ?></small></td>
            <td><img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/<?php echo $data->schema_box; ?>-cols.png" width="80" /></td>
            <td>
            	<a href="<?php echo get_home_url(); ?>/toolpage/<?php echo $data->url; ?>" class="btn btn-mini" target="_blank"><?php _e('Preview', 'toolpage'); ?></a>
                <a href="?page=gestione-toolpage&amp;id=<?php echo $data->id; ?>" class="btn btn-info btn-mini"><?php _e('Edit', 'toolpage'); ?></a>
                <a href="?page=toolpage&amp;id_del=<?php echo $data->id; ?>" class="btn btn-danger btn-mini"><?php _e('Delete', 'toolpage'); ?></a><br />
                <!--<br>-->
                <?php //echo $options['fuffivalore']; ?>
            </td>
        </tr>
<?php
		$i++;
	}
?>
		<tr>
        	<td colspan="9">
            	<a href="?page=gestione-toolpage" class="btn btn-success"><?php _e('Click here to create a new', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></a>
            </td>
        </tr>
      </tbody>
    </table>
    
    <?php require_once PLUGIN_PATH.'/includes/footer-general.php'; ?>
</div>