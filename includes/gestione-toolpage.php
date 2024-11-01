<?php
global $wpdb;
$table_name = $wpdb->prefix . "toolpage";
$table_name_box = $wpdb->prefix . "toolpage_box";
$table_name_box_relazioni = $wpdb->prefix . "toolpage_box_relazioni"; 
$toolpage_data = $wpdb->get_results("SELECT * FROM $table_name_box ORDER BY box_id DESC");

if(isset($_GET['id'])) $_GET['id'] = $_GET['id'];
else $_GET['id'] = 0;
/*
$toolpage_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
$option = 'toolpage_options';
$options = get_option($option);*/

if(isset($_POST['salva']) && ($_POST['titolo'] == '' || $_POST['url'] == '')){
?>
	<div class="error">
		<p><strong><?php _e('Attention!', 'toolpage'); ?></strong> <?php _e('Some required fields are blank.', 'toolpage'); ?> <?php _e('Check:', 'toolpage'); ?> <em><?php _e('title, url', 'toolpage'); ?></em></p>
	</div>
<?php
}
?>

<div class="container-fluid">
    <div class="lead">
<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
	$toolpage_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE id='".$_GET['id']."'");
?>
        <h1><?php _e('Edit', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></h1>
        
<?php
}
else{
?>
        <h1><?php _e('Add new', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></h1>
        <p><?php _e('You can create unlimited', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?>. <?php _e('Write the title, enter the properties, select the box to show and click &quot;Save&quot;.', 'toolpage'); ?></p>
<?php
}
?>
    </div>
    
    <div>
    	<?php require_once PLUGIN_PATH.'/includes/newsticker.php'; ?>   
    </div>
    
    
<?php
if(isset($_POST['salva']) && $_POST['titolo'] != '' && $_POST['url'] != ''){
	
		$wpdb->query( "INSERT INTO $table_name VALUES('',
										 '".$_POST['titolo']."',
										 '".sanitize_title($_POST['url'])."',
										 '".$_POST['is_home']."',
										 '".$_POST['schema']."',
										 '".$_POST['appearance']."',
										 '".$_POST['larghezza']."',
										 '".$_POST['background_color']."',
										 '".$_POST['background_color_contenitore']."',
										 '".$_POST['font']."',
										 '".$_POST['font_size']."',
										 '".$_POST['font_color']."',
										 '".$_POST['font_color_links']."',
										 '".$_POST['font_color_links_hover']."',
										 '".$_POST['seo_titolo']."',
										 '".$_POST['seo_descrizione']."',
										 '".$_POST['seo_robots']."',
										 '".$_POST['css_editor']."',
										 '".$_POST['google_editor']."',
										 '".time()."',
										 '0',
										 '".$_POST['stato']."')");
																
		$ultimo_id = $wpdb->insert_id;
		$wpdb->query("DELETE FROM $table_name_box_relazioni WHERE toolpage_id='".$ultimo_id."'");
		if(isset($_POST['id_box'])){
		if(is_array($_POST['id_box'])){
			for($i=0;$i<=(sizeof($_POST['id_box'])-1);$i++){
				$wpdb->query("INSERT INTO $table_name_box_relazioni VALUES('".$ultimo_id."', '".$_POST['id_box'][$i]."', '".$_POST['id_box_ordine'][$i]."')");
			}
		}	 
		}
		//echo $wpdb->show_errors(); echo $wpdb->print_error();
		//print_r($_POST);
?>
	<div class="alert alert-success">
		<h3><?php _e('Well, the', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?> <?php _e('was created successfully!', 'toolpage'); ?></h3>
        
        <a href="?page=toolpage" class="btn btn-primary"><?php _e('Go to the list of your', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></a> <a href="?page=gestione-toolpage" class="btn btn-success"><?php _e('Add new', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></a><br />
        <br />
        
        <a href="https://twitter.com/Make23Creations" class="twitter-follow-button" data-show-count="true" data-lang="it">Follow @Make23Creations</a>
    </div>
<?php
}
elseif(isset($_POST['edit']) && $_GET['id'] > 0 && $_POST['titolo'] != '' && $_POST['url'] != ''){
		
		if($_POST['larghezza'] == '') $_POST['larghezza'] = '980px';
		else $_POST['larghezza'] = str_replace("%", "&#37;", $_POST['larghezza']);
		
		/* REIMPOSTA is_home */
		$wpdb->query("UPDATE $table_name SET is_home='0'");
		
		$wpdb->query("UPDATE $table_name SET titolo='".$_POST['titolo']."', url='".sanitize_title($_POST['url'])."', is_home='".$_POST['is_home']."',
		 	  schema_box='".$_POST['schema']."',		 
			  appearance_box='".$_POST['appearance']."',
			  larghezza='".$_POST['larghezza']."',
			  background_color='".$_POST['background_color']."',
			  background_color_contenitore='".$_POST['background_color_contenitore']."',
			  font='".$_POST['font']."',
			  font_size='".$_POST['font_size']."',
			  font_color='".$_POST['font_color']."',
			  font_color_links='".$_POST['font_color_links']."',
			  font_color_links_hover='".$_POST['font_color_links_hover']."',
			  seo_titolo='".$_POST['seo_titolo']."',
			  seo_descrizione='".$_POST['seo_descrizione']."',
			  seo_robots='".$_POST['seo_robots']."',
			  css_editor='".$_POST['css_editor']."',	
			  google_editor='".$_POST['google_editor']."',						  
			  data_update='".time()."', 
			  active='".$_POST['stato']."' WHERE id='".$_GET['id']."'");
		
		$wpdb->query("DELETE FROM $table_name_box_relazioni WHERE toolpage_id='".$_GET['id']."'");
		if(isset($_POST['id_box'])){
		if(is_array($_POST['id_box'])){
			for($i=0;$i<=(sizeof($_POST['id_box'])-1);$i++){
				$plus = 'id_box_ordine_'.$_POST['id_box'][$i];
				$wpdb->query("INSERT INTO $table_name_box_relazioni VALUES('".$_GET['id']."', '".$_POST['id_box'][$i]."', '".$_POST[$plus]."')");
				//$_POST['id_box_ordine'][$i]
			}
		}
		}
		
		//print_r($_POST);
		
		//echo $wpdb->show_errors(); echo $wpdb->print_error();

?>
	<div class="alert alert-success">
		<h3><?php _e('Well, the', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?> <?php _e('has been modified successfully!', 'toolpage'); ?></h3>
        
        <a href="?page=gestione-toolpage&amp;id=<?php echo $_GET['id']; ?>" class="btn btn-info"><?php _e('Edit again', 'toolpage'); ?></a> <a href="?page=toolpage" class="btn btn-primary"><?php _e('Go to the list of your', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></a> <a href="?page=gestione-toolpage" class="btn btn-success"><?php _e('Add new', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?></a><br />
        <br />
        
        <a href="https://twitter.com/Make23Creations" class="twitter-follow-button" data-show-count="true" data-lang="it">Follow @Make23Creations</a>
    </div>
<?php
}
else{
	if(isset($_GET['id']) && $_GET['id'] > 0){
		$toolpage_edit = $wpdb->get_row("SELECT * FROM $table_name WHERE id='".$_GET['id']."'");
		$titolo = $toolpage_edit->titolo;
		$url = $toolpage_edit->url;
		$is_home = $toolpage_edit->is_home;
		$schema = $toolpage_edit->schema_box;
		$appearance = $toolpage_edit->appearance_box;
		
		$larghezza = $toolpage_edit->larghezza;
		$background_color = $toolpage_edit->background_color;
		$background_color_contenitore = $toolpage_edit->background_color_contenitore;
		$font = $toolpage_edit->font;
		$font_size = $toolpage_edit->font_size;
		$font_color = $toolpage_edit->font_color;
		$font_color_links = $toolpage_edit->font_color_links;
		$font_color_links_hover = $toolpage_edit->font_color_links_hover;
		
		$seo_titolo = $toolpage_edit->seo_titolo;
		$seo_descrizione = $toolpage_edit->seo_descrizione;
		$seo_robots = $toolpage_edit->seo_robots;
		$css_editor = $toolpage_edit->css_editor;
		$google_editor = $toolpage_edit->google_editor;
		
		$data_insert = $toolpage_edit->data_insert;
		$data_update = $toolpage_edit->data_update;
		$active = $toolpage_edit->active;
	}
	else{
		$titolo = '';
		$url = '';
		$is_home = '';
		$schema = '';
		$appearance = '';
		
		$larghezza = '';
		$background_color = '';
		$background_color_contenitore = '';
		$font = '';
		$font_size = '';
		$font_color = '';
		$font_color_links = '';
		$font_color_links_hover = '';
		
		$seo_titolo = '';
		$seo_descrizione = '';
		$seo_robots = '';
		$css_editor = '';
		$google_editor = '';
		
		$data_insert = '';
		$data_update = '';
		$active = '';
	}
?>
    
<?php
	if(get_option('permalink_structure')){
?>
    <form class="form-horizontal" action="?page=gestione-toolpage&amp;add=ok<?php if(isset($_GET['id']) && $_GET['id'] > 0) echo '&amp;id='.$_GET['id']; ?>" method="post">
    	<p>        
        	<label>
    		<input class="input-block-level" type="text" id="titolo" name="titolo" placeholder="<?php _e('Landing Page Title', 'toolpage'); ?>" value="<?php echo $titolo; ?>" />
            </label>
        </p>
            
        <br />
        
        <p>
            <ul id="myTabs" class="nav nav-tabs">
              <li class="active"><a href="#home" data-toggle="tab"><?php _e('General Settings', 'toolpage'); ?></a></li>
              <li><a href="#settingsbox" data-toggle="tab"><?php _e('Box Setup', 'toolpage'); ?></a></li>
              <li><a href="#seobox" data-toggle="tab">S.E.O.</a></li>
              <li><a href="#cssbox" data-toggle="tab">CSS Editor</a></li>
              <li><a href="#googlebox" data-toggle="tab">Google Analytics</a></li>
            </ul>  
            
            <div class="tab-content">
                <div class="tab-pane active" id="home">
   
                    <label>
                    <?php echo get_home_url(); ?>/toolpage/<input class="input-medium" type="text" name="url" id="url" placeholder="Url Slug" value="<?php echo $url; ?>" />
                    </label>
                    
                    <br />
                    
                    <label>
                    	<?php _e('Front page / Home', 'toolpage'); ?><br />
                        <select class="span3" name="is_home">
                        	<option value="0"<?php if($is_home == '' || $is_home == '0') echo ' selected="selected"'; ?>><?php _e('No, do not set as Homepage', 'toolpage'); ?></option>
                        	<option value="1"<?php if($is_home == '1') echo ' selected="selected"'; ?>><?php _e('Yes, set as Homepage', 'toolpage'); ?></option>
                        </select>
                    </label>
                    
                    <br />
                    
                    
                    <div class="row">
                        <div class="span12"><?php _e('Appearance Themes', 'toolpage'); ?></div>
                        <div class="span2">
                            <label class="radio">
                                <input type="radio" name="appearance" value="1"<?php if($appearance == '1' || $appearance == '' || $appearance == '0') echo ' checked="checked"'; ?> /> Base
                            </label>
                        </div>
                        <div class="span2">
                            <label class="radio">
                                <input type="radio" name="appearance" value="2"<?php if($appearance == '2') echo ' checked="checked"'; ?> /> Professional
                            </label>
                        </div>
                    </div>
                    
                    <br />
                    
                    <div class="row">
                        <div class="span12"><?php _e('Box Scheme', 'toolpage'); ?></div>
                        <div class="span1">
                            <label class="radio">
                                <input type="radio" name="schema" value="1"<?php if($schema == '1') echo ' checked="checked"'; ?> /> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/1-cols.png" width="50" />
                            </label>
                        </div>
                        <div class="span1">
                            <label class="radio">
                                <input type="radio" name="schema" value="2"<?php if($schema == '2' || $schema == '' || $schema == '0') echo ' checked="checked"'; ?> /> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/2-cols.png" width="50" />
                            </label>
                        </div>
                        <div class="span1">
                            <label class="radio">
                                <input type="radio" name="schema" value="3"<?php if($schema == '3') echo ' checked="checked"'; ?> /> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/3-cols.png" width="50" />
                            </label>
                        </div>
                        <div class="span1">
                            <label class="radio">
                                <input type="radio" name="schema" value="4"<?php if($schema == '4') echo ' checked="checked"'; ?> /> <img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/4-cols.png" width="50" />
                            </label>
                        </div>
                    </div>
                    
                    <br />
                    
                    <div class="row">
                        <div class="span3">
                            <label>
                            <?php _e('Page Width', 'toolpage'); ?><br>
                            <small><?php _e('Example:', 'toolpage'); ?> 100% oppure 980px</small>
                            <input class="input-block-level input-xlarge" type="text" name="larghezza" value="<?php echo $larghezza; ?>" /> 
                            </label>
                        </div>
                    </div>
                    
                    <br />
                    
                    <div class="row">
                        <div class="span3">
                            <label>
                            <?php _e('General Background Color', 'toolpage'); ?> (<em>body</em>)<br>
                            <small><?php _e('Example:', 'toolpage'); ?> #333 <?php _e('or', 'toolpage'); ?> white</small><br />
                            <input class="my-color-field1 input-block-level input-xlarge" type="text" name="background_color" value="<?php echo $background_color; ?>" data-default-color="#333" /> 

                            </label>
                        </div>
                        <div class="span3">
                            <label>
                            <?php _e('Background Color box container', 'toolpage'); ?><br>
                            <small><?php _e('Example:', 'toolpage'); ?> #fff <?php _e('or', 'toolpage'); ?> white</small><br />
                            <input class="my-color-field2 input-block-level input-xlarge" type="text" name="background_color_contenitore" value="<?php echo $background_color_contenitore; ?>" data-default-color="#fff" /> 
                            </label>
                        </div>
                    </div>
                    
                    <br />
                    
                    <div class="row">
                        <div class="span3">
                            <label>
                            <?php _e('Font type', 'toolpage'); ?><br>
                            <br>
                            <select class="span3" name="font">
                                <option value='Helvetica Neue, Helvetica, Arial, sans-serif'<?php if($font == 'Helvetica Neue, Helvetica, Arial, sans-serif') echo " selected='selected'" ?>>&quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif</option>
                                <option value='Trebuchet MS, Arial, Helvetica, sans-serif'<?php if($font == 'Trebuchet MS, Arial, Helvetica, sans-serif') echo " selected='selected'" ?>>&quot;Trebuchet MS&quot;, Arial, Helvetica, sans-serif</option>
                                <option value="Verdana, Geneva, sans-serif"<?php if($font == 'Verdana, Geneva, sans-serif') echo ' selected="selected"'; ?>>Verdana, Geneva, sans-serif</option>
                            </select>
                            </label>
                        </div>
                        <div class="span3">
                            <label>
                            <?php _e('Font Size', 'toolpage'); ?><br>
                            <small><?php _e('Example:', 'toolpage'); ?> 12px <?php _e('or', 'toolpage'); ?> 0.8em</small>
                            <input class="input-block-level input-xlarge" type="text" name="font_size" value="<?php echo $font_size; ?>" /> 
                            </label>
                        </div>
                    </div>
                    
                    <br />
                    
                    <div class="row">
                        <div class="span3">
                            <label>
                            <?php _e('Font Color', 'toolpage'); ?><br />
                            <small><?php _e('Example:', 'toolpage'); ?> #000 <?php _e('or', 'toolpage'); ?> black</small><br />
                            <input class="my-color-field3 input-block-level input-xlarge" type="text" name="font_color" value="<?php echo $font_color; ?>" data-default-color="#000" /> 
                            </label>
                        </div>
                        <div class="span3">
                            <label>
                            <?php _e('Font Color Links', 'toolpage'); ?><br />
                            <small><?php _e('Example:', 'toolpage'); ?> #dd3333 <?php _e('or', 'toolpage'); ?> red</small><br />
                            <input class="my-color-field4 input-block-level input-xlarge" type="text" name="font_color_links" value="<?php echo $font_color_links; ?>" data-default-color="#dd3333" /> 
                            </label>
                        </div>
                    </div>
                    
                    <br />
                    
                    <div class="row">
                        <div class="span3">
                            <label>
                            <?php _e('Font Color Links Hover', 'toolpage'); ?><br />
                            <small><?php _e('Example:', 'toolpage'); ?> #27ad9b <?php _e('or', 'toolpage'); ?> green</small><br />
                            <input class="my-color-field5 input-block-level input-xlarge" type="text" name="font_color_links_hover" value="<?php echo $font_color_links_hover; ?>" data-default-color="#27ad9b" /> 
                            </label>
                        </div>
                    </div>
                    
                    <br />
                    
                    <label>
                    <?php _e('Landing Page Status', 'toolpage'); ?><br />
                    <select class="span3" name="stato">
                        <option value="1"<?php if($active == '1') echo ' selected="selected"'; ?>>Attiva</option>
                        <option value="0"<?php if($active == '0') echo ' selected="selected"'; ?>>Non Attiva</option>
                    </select>
                    </label>                
                </div>
                
                <div class="tab-pane" id="settingsbox">
                	<?php _e('Select the Box to associate with this', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?>.<br />
                    <br />
<?php
	$lista_box_id_attuali = @getBoxIdByToolpageId($_GET['id'], $table_name_box_relazioni);
	//$lista_ordine_attuali = getOrdineBoxByToolpageId($_GET['id'], $table_name_box_relazioni);
    foreach ($toolpage_data as $data) {
		//echo getBoxIdByToolpageId($_GET['id'], $table_name_box_relazioni);
?>	
					<div class="span3">
						<blockquote>
                        <label class="checkbox"><input type="checkbox" name="id_box[]" value="<?php echo $data->box_id; ?>"<?php if(@in_array($data->box_id, $lista_box_id_attuali)) echo ' checked="checked"'; ?> /> <?php echo $data->box_titolo; ?>
                    	<small><?php _e('Type:', 'toolpage'); ?> <?php echo $data->box_tipo; ?></small></label>
                        <?php _e('Display Order:', 'toolpage'); ?> <input type="text" class="input-mini" name="id_box_ordine_<?php echo $data->box_id; ?>" value="<?php if(@getOrdineBoxByToolpageId($_GET['id'], $data->box_id, $table_name_box_relazioni) != '') echo @getOrdineBoxByToolpageId($_GET['id'], $data->box_id, $table_name_box_relazioni); else echo '0'; ?>" />
                        </blockquote>
                    </div>
<?php	
	}
?>                
                </div>
                
                <div class="tab-pane" id="seobox">
                	<?php _e('S.E.O. Settings to optimize the', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?>.<br />
                    <br />
                    
                    <p>
                        <label>
                        <?php _e('SEO Title', 'toolpage'); ?><br />
                        <input class="input-block-level" type="text" id="seo_titolo" name="seo_titolo" placeholder="<?php _e('SEO Title', 'toolpage'); ?>" value="<?php echo $seo_titolo; ?>" />
                        </label>
                        
                        <br />
                        
                        <label>
                        <?php _e('SEO Short description', 'toolpage'); ?><br />
                        <input class="input-block-level" type="text" id="seo_descrizione" name="seo_descrizione" placeholder="<?php _e('SEO Short description', 'toolpage'); ?>" value="<?php echo $seo_descrizione; ?>" />
                        </label>
                        
                        <br />
                        
                        <label>
                        	<?php _e('META Robots Settings', 'toolpage'); ?><br />
                            <select class="span3" id="seo_robots" name="seo_robots">
                            	<option value=""<?php if($seo_robots == '') echo ' selected="selected"'; ?>>--- <?php _e('nothing', 'toolpage'); ?> ---</option>
                            	<option value="index, follow"<?php if($seo_robots == 'index, follow') echo ' selected="selected"'; ?>>index, follow</option>
                            	<option value="noindex, nofollow"<?php if($seo_robots == 'noindex, nofollow') echo ' selected="selected"'; ?>>noindex, nofollow</option>
                            	<option value="index, nofollow"<?php if($seo_robots == 'index, nofollow') echo ' selected="selected"'; ?>>index, nofollow</option>
                            	<option value="noindex, follow"<?php if($seo_robots == 'noindex, follow') echo ' selected="selected"'; ?>>noindex, follow</option>
                            	<option value="noarchive"<?php if($seo_robots == 'noarchive') echo ' selected="selected"'; ?>>noarchive</option>
                            </select>
                        </label>
                    </p>
                </div>
                
                <div class="tab-pane" id="cssbox">
                	<label>
                    	<?php _e('These CSS override completely the main style.', 'toolpage'); ?><br />
                    	<textarea name="css_editor" rows="5" class="span10"><?php echo $css_editor; ?></textarea>
                    </label>
                </div>
                
                <div class="tab-pane" id="googlebox">
                	<label>
                    	<?php _e('Paste here the tracking code for Google Analytics.', 'toolpage'); ?><br />
                    	<textarea name="google_editor" rows="5" class="span10"><?php echo $google_editor; ?></textarea>
                    </label>
                </div>
                
            </div>  
        </p>
        
        <br />

    	<p>
            <label>
            	<input type="submit" class="btn btn-primary" value="<?php _e('Save', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?>" name="<?php if(isset($_GET['id']) && $_GET['id'] > 0) echo 'edit'; else echo 'salva'; ?>" /> <a href="?page=toolpage" class="btn btn-danger"><?php _e('Cancel', 'toolpage'); ?></a>
            </label>
    	</p>
    </form>
<?php
	}
	else{
?>
        <div class="alert alert-error">
        	<h3><?php _e('Attention!', 'toolpage'); ?></h3>
			
            
			<?php _e('To correctly use this plugin, you must enable Permalinks.', 'toolpage'); ?><br />
			<?php _e('To activate Permalinks go to &quot;Settings &gt; Permalinks&quot; or', 'toolpage'); ?> <a href="options-permalink.php"><strong><?php _e('click here', 'toolpage'); ?></strong></a>.
        </div>
<?php
	}
?>
<?php
}
?>
    
    <?php require_once PLUGIN_PATH.'/includes/footer-general.php'; ?>
</div>