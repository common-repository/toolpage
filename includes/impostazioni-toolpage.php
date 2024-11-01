<?php
global $wpdb;
$table_name_box = $wpdb->prefix . "toolpage_box"; 
$table_name_settings = $wpdb->prefix . "toolpage_settings"; 
	
$sql4 = "CREATE TABLE IF NOT EXISTS " . $table_name_settings . " (
  nome VARCHAR(255) NOT NULL DEFAULT '',
  valore VARCHAR(255) NOT NULL DEFAULT ''
);";
$wpdb->query($sql4);
?>


<br />

<?php
if(isset($_POST['toolpage_update_settings'])){
	
	if(isset($_POST['powered'])) $_POST['powered'] = $_POST['powered'];
	else $_POST['powered'] = 0;
	
	if(isset($_POST['stat'])) $_POST['stat'] = $_POST['stat'];
	else $_POST['stat'] = 0;
	if($_POST['stat'] == 1){
		/* Invia e-mail allo staff di ToolPage */
	}


	if($_POST['stat'] == 1) $_POST['stat'] = 1;
	else $_POST['stat'] = 0;
	if($_POST['powered'] == 1) $_POST['powered'] = 1;
	else $_POST['powered'] = 0;
	
	$sql_delete = "DELETE FROM " . $table_name_settings . "";
    $wpdb->query($sql_delete);	
    $sql_settings = "INSERT IGNORE INTO " . $table_name_settings . " values ('stat', '".$_POST['stat']."');";
    $wpdb->query($sql_settings);
    $sql_settings = "INSERT IGNORE INTO " . $table_name_settings . " values ('powered', '".$_POST['powered']."');";
    $wpdb->query($sql_settings);	
?>
<div class="updated">
    <p><strong><?php _e('Wonderful!', 'toolpage'); ?></strong> <?php _e('The settings have been saved successfully.', 'toolpage'); ?></p>
</div>
<?php
}
?>

<div class="container-fluid">
    <div class="lead">
        <h1><?php _e('General Settings', 'toolpage'); ?></h1>
        <p><?php _e('Set Your Toolpage&trade;', 'toolpage'); ?></p>
    </div>
    
    <div>
    	<?php require_once PLUGIN_PATH.'/includes/newsticker.php'; ?>   
    </div>
    
    <div class="row">
    	<form action="admin.php?page=impostazioni-toolpage" method="post">
            <div class="span9">
				<label>
                	<strong><?php _e('Anonymous Statistics', 'toolpage'); ?></strong><br />
                    <small><?php _e('Contribute to improve this Plugin by sending anonymous statistics. The anonymous data will not be divulged.', 'toolpage'); ?></small><br />
                	<input type="checkbox" value="1" name="stat"<?php if(getSettingsByNome('stat') == '1') echo ' checked="checked"' ?> /> <?php _e('Yes, send anonymous statistics', 'toolpage'); ?>
                </label>            
            </div>
                        
            <div class="span9">
            	<br />
                
				<label>
                	<strong><?php _e('&quot;Powered by&quot; link', 'toolpage'); ?></strong><br />
                    <small><?php _e('Add link "powered" in the footer.', 'toolpage'); ?></small><br />
                	<input type="checkbox" value="1" name="powered"<?php if(getSettingsByNome('powered') == '1') echo ' checked="checked"' ?> /> <?php _e('Yes', 'toolpage'); ?>
                </label>            
            </div>
            
            <div class="span9">
            	<br />
            	
                <input type="submit" class="button" name="toolpage_update_settings" value="<?php _e('Save Settings', 'toolpage'); ?>" />
            </div>
		</form>      
    </div>
    
    <br />
    
    <?php require_once PLUGIN_PATH.'/includes/footer-general.php'; ?>
</div>