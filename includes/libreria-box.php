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
$table_name_box = $wpdb->prefix . "toolpage_box";
$table_name_box_relazioni = $wpdb->prefix . "toolpage_box_relazioni"; 
$toolpage_data = $wpdb->get_results("SELECT * FROM $table_name_box ORDER BY box_id DESC");
$option = 'toolpage_options';
$options = get_option($option);

if(isset($_GET['id_del'])) $_GET['id_del'] = $_GET['id_del'];
else $_GET['id_del'] = 0;

if($_GET['id_del'] > 0){
?>
<?php
	if(isset($_POST['del']) && $_POST['id_del'] > 0){
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name_box WHERE box_id='".$_POST['id_del']."' LIMIT 1"));
		$wpdb->query($wpdb->prepare("DELETE FROM $table_name_box_relazioni WHERE box_id='".$_POST['id_del']."'"));
?>
<div class="updated">
	<p>
		<?php _e('The Box has been deleted successfully!', 'toolpage'); ?> <a class="button" href="?page=libreria-box"><strong><?php _e('Refresh Box List', 'toolpage'); ?></strong></a>
    </p>
</div>
<?php
		exit;
	}
	else{
?>
<div class="error">
	<p>
        <form class="form-horizontal" action="?page=libreria-box&amp;id_del=<?php echo $_GET['id_del']; ?>" method="post" style="margin:0px; padding:0px">
        	<input type="hidden" name="id_del" value="<?php echo $_GET['id_del']; ?>" />
            
    		<?php _e('Do you really want delete box with title', 'toolpage'); ?> &quot;<strong><?php echo @getTitoloBox($table_name_box, $_GET['id_del']); ?></strong>&quot;? <input type="submit" name="del" class="btn btn-danger button" value="Conferma eliminazione" /> <a href="?page=libreria-box" class="btn button"><?php _e('Cancel', 'toolpage'); ?></a>
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
        <h1><?php _e('Library Box to your', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></h1>
        <p><?php _e('From here you can manage to associate with Box to your Landing Pages.', 'toolpage'); ?></p>
    </div>
    
    
    <div>
    	<?php require_once PLUGIN_PATH.'/includes/newsticker.php'; ?>   
    </div>
    
    <table class="table table-bordered table-hover">
      <!--<caption>ttttttt</caption>-->
      <thead>
        <tr>
        	<th>#</th>       
            <th>s</th>     
            <th><?php _e('Title', 'toolpage'); ?></th>
            <th><?php _e('Created on', 'toolpage'); ?></th>
            <th><?php _e('Last Updated', 'toolpage'); ?></th>
            <th><?php _e('Type', 'toolpage'); ?></th>
            <th><?php _e('Tools', 'toolpage'); ?></th>
        </tr>
      </thead>
      <tbody>
<?php
	$i = 1;
    foreach ($toolpage_data as $data) {
		if($data->box_tipo == 'form'){
			$url_icona = WP_CONTENT_URL.'/plugins/contact-form-7/admin/images/menu-icon.png';
		}
		else{
			$url_icona = WP_CONTENT_URL.'/plugins/toolpage/imgs/icon/'.$data->box_tipo.'.png';
		}
?>
        <tr>
        	<td><?php echo $data->box_id; ?></td>
            <td><img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/status_<?php echo $data->box_active; ?>.png" /></td>
            <td><a href="?page=add-box&amp;tipo=<?php echo $data->box_tipo; ?>&amp;id=<?php echo $data->box_id; ?>" title="<?php _e('Click to edit', 'toolpage'); ?>"><strong><?php echo $data->box_titolo; ?></strong></a></td>
            <td><?php echo date("d/m/Y - H:i:s", $data->box_data_insert); ?></td>
            <td><?php if($data->box_data_update > 0) echo date("d/m/Y - H:i:s", $data->box_data_update); else echo '<small><em>- mai aggiornata -</em></small>'; ?></td>
            <td>
<?php
		if(!@getimagesize($url_icona)){
?>
            	<?php echo $data->box_tipo; ?>
<?php
		}
		else{
?>
            	<img src="<?php echo $url_icona; ?>" alt="<?php echo $data->box_tipo; ?>" width="20" />
<?php
		}
?>
            </td>
            <td>
                <a href="?page=add-box&amp;tipo=<?php echo $data->box_tipo; ?>&amp;id=<?php echo $data->box_id; ?>" class="btn btn-info btn-mini"><?php _e('Edit', 'toolpage'); ?></a>
                <a href="?page=libreria-box&amp;id_del=<?php echo $data->box_id; ?>" class="btn btn-danger btn-mini"><?php _e('Delete', 'toolpage'); ?></a>
                <!--<br>-->
                <?php //echo $options['fuffivalore']; ?>
            </td>
        </tr>
<?php
		$i++;
	}
?>
		<tr>
        	<td colspan="7">
            	<a href="?page=add-box" class="btn btn-success"><?php _e('Click here to create a new Box', 'toolpage'); ?></a>
            </td>
        </tr>
      </tbody>
    </table>
    
    <?php require_once PLUGIN_PATH.'/includes/footer-general.php'; ?>
</div>