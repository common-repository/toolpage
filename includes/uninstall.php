<?php
function toolpage_uninstall(){
  /*if($_POST['uninstalltoolpage']){
echo '<div class="wrap"><div id="message" class="updated fade">';
    echo '<p><h2> ToolPage Successfully Uninstalled </h2></p></div>';
	echo '<h2>'.__('ToolPage Uninstall', 'toolpage').'</h2>';
	echo '<p><p><h3> ToolPage Successfully Uninstalled </h3></p><strong>'.sprintf(__('Deactivate the ToolPage from Plugins panel to Finish the Uninstallation.', 'toolpage'), $deactivate_url).'</strong></p>';
	echo '</div>';    }else { ?>
<form method="post" action="">
<div class="wrap">
	<h2><?php _e('Uninstall ToolPage', 'ToolPage'); ?></h2>
	<p>
		<?php _e('Deactivating ToolPage plugin does not remove any data that may have been created, such as the slider data and the image links. To completely remove this plugin, you can uninstall it here.', 'ToolPage'); ?>
	</p>
	<p style="color: red">
		<strong><?php _e('WARNING:', 'ToolPage'); ?></strong><br />
		<?php _e('Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.', 'toolpage'); ?>
	</p>
	<p style="color: red">
		<strong><?php _e('The following WordPress Options/Tables will be DELETED:', 'toolpage'); ?></strong><br />
	</p>
	<table class="widefat" style="width: 200px;">
		<thead>
			<tr>
            <?php
					global $wpdb;
	                $table_name = $wpdb->prefix . "toolpage"; ?>
				<th><?php _e('Table: '.$table_name, 'toolpage'); ?></th>
			</tr>
		</thead>
		<tr>
			<td valign="top" class="alternate">
				<ol>
				<?php
                     $toolpage_data = $wpdb->get_results("SELECT option_name FROM $table_name ORDER BY id");
                      foreach ($toolpage_data as $data) {
                      echo '<li>'.$data->option_name.'</li>';
                      }
				?>
				</ol>
			</td>
		</tr>
	</table>
	<p style="text-align: center;">
		<?php _e('Do you really want to uninstall ToolPage?', 'toolpage'); ?><br /><br />
		<input type="checkbox" name="uninstall_toolpage" value="yes" />&nbsp;<?php _e('Yes', 'toolpage'); ?><br /><br />
		<input type="submit" name="uninstalltoolpage" value="<?php _e('UNINSTALL ToolPage', 'toolpage'); ?>" class="button-primary" onclick="return confirm('<?php _e('You Are About To Uninstall ToolPage From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.', 'toolpage'); ?>')" />
	</p>
</div>
</form>
  <?php    
  }*/
}

function toolpage_plugin_uninstall() {
    global $wpdb;
	$table_name = $wpdb->prefix . "toolpage"; 
	$table_name2 = $wpdb->prefix . "toolpage_box"; 
	$table_name3 = $wpdb->prefix . "toolpage_box_relazioni"; 
	
	delete_option('toolpage_options');
	
    /*$toolpage_data = $wpdb->get_results("SELECT id FROM $table_name ORDER BY id");
    foreach ($toolpage_data as $data) {
        delete_option($data->option_name);
    }*/
    $sql = "DROP TABLE " . $table_name;
	$wpdb->query( $sql );
    $sql2 = "DROP TABLE " . $table_name2;
	$wpdb->query( $sql2 );
    $sql3 = "DROP TABLE " . $table_name3;
	$wpdb->query( $sql3 );
}
?>