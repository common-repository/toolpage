<?php
global $wpdb;
$table_name_box = $wpdb->prefix . "toolpage_box"; 
$table_posts = $wpdb->prefix . "posts"; 

if(isset($_GET['tipo'])) $_GET['tipo'] = $_GET['tipo'];
else $_GET['tipo'] = '';

/*
$toolpage_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
$option = 'toolpage_options';
$options = get_option($option);*/
?>

<br />

<div class="container-fluid">
    <div class="lead">
<?php
	if((isset($_GET['id']) && $_GET['id'] > 0) || (isset($_POST['box_id']) && $_POST['box_id'] > 0)){
?>
        <h1><?php _e('Edit Box', 'toolpage'); ?></h1>
        
<?php
	}
	else{
?>
        <h1><?php _e('Add new Box', 'toolpage'); ?></h1>
        <p><?php _e('Create Box to associate with your', 'toolpage'); ?> <?php echo PLUGIN_NAME; ?>.</p>
<?php
	}
?>
    </div>
    
    <div>
    	<?php require_once PLUGIN_PATH.'/includes/newsticker.php'; ?>   
    </div>
    
<?
	if(
	((isset($_POST['salva_box']) || isset($_POST['edit_box'])) && $_POST['tipo'] != 'twitter' && ($_POST['titolo'] == '' || $_POST['content'] == '')) || 
	((isset($_POST['salva_box'])) && $_POST['tipo'] == 'twitter' && ($_POST['widget_id'] == '' || (widgetIdEsiste($_POST['widget_id'], $table_name_box)) == 1 )) || 
	((isset($_POST['edit_box'])) && $_POST['tipo'] == 'twitter' && ($_POST['widget_id'] == '' || (getWidgetIdAttuale($_POST['box_id'], $table_name_box) != $_POST['widget_id'] && widgetIdEsiste($_POST['widget_id'], $table_name_box)) == 1 ))
	){
		/*echo getWidgetIdAttuale($_POST['box_id'], $table_name_box).'fff--'.$_POST['box_id'];
		print_r($_POST);*/
		$my_error = 1;
		if($_POST['tipo'] == '') $_POST['tipo'] = 'text';
		//print_r($_POST);
		
		switch($_POST['tipo']){
			default:
			case 'text':
?>
	<div class="alert alert-error">
		<h3><?php _e('Warning, there have been errors!', 'toolpage'); ?></h3>
        
        <p>
        	<?php _e('You have to write a title and text / HTML.', 'toolpage'); ?>
        </p>
    </div>  
<?
			break;
			case 'image':
?>
	<div class="alert alert-error">
		<h3><?php _e('Warning, there have been errors!', 'toolpage'); ?></h3>
        
        <p>
        	<?php _e('You have to write a title and select an image by clicking on', 'toolpage'); ?> &quot;<strong><?php _e('Add Media', 'toolpage'); ?></strong>&quot;.
        </p>
    </div>  
<?
			break;
			case 'menu':
?>
	<div class="alert alert-error">
		<h3><?php _e('Warning, there have been errors!', 'toolpage'); ?></h3>
        
        <p>
        	<?php _e('You have to write a title and select a menu.', 'toolpage'); ?>
        </p>
    </div>  
<?
			break;
			case 'twitter':
?>
	<div class="alert alert-error">
		<h3><?php _e('Warning, there have been errors!', 'toolpage'); ?></h3>
        
        <p>
<?php
				if($_POST['widget_id'] != '' && widgetIdEsiste($_POST['widget_id'], $table_name_box) == 1){
?>
        	<?php _e('The', 'toolpage'); ?> <strong>Widget ID</strong> <?php _e('has already been written on.', 'toolpage'); ?> <u><?php _e('You can not create more than one box with unique Twitter Widget ID.', 'toolpage'); ?></u>
<?php				
				}
				else{
?>
        	<?php _e('You have to write a title, Nickname Twitter and Widget ID.', 'toolpage'); ?>
<?php				
				}
?>
        </p>
    </div>  
<?
			break;
			case 'facebook':
?>
	<div class="alert alert-error">
		<h3><?php _e('Warning, there have been errors!', 'toolpage'); ?></h3>
        
        <p>
        	<?php _e('You have to write a title and URL to Facebook page.', 'toolpage'); ?>
        </p>
    </div>  
<?
			break;
			case 'youtube':
?>
	<div class="alert alert-error">
		<h3><?php _e('Warning, there have been errors!', 'toolpage'); ?></h3>
        
        <p>
        	<?php _e('You have to write a title and URL of the YouTube video.', 'toolpage'); ?>
        </p>
    </div>  
<?
			break;
		}
	}
	elseif(isset($_POST['edit_box']) && $_POST['titolo'] != ''){
		if($_POST['tipo'] == '') $_POST['tipo'] = 'text';
		
		$parametri = '|';
		switch($_POST['tipo']){
			case 'twitter':
				$parametri .= ''.$_POST['widget_id'].'|';
			break;
			case 'facebook':
				$parametri .= ''.$_POST['fb_intestazione'].'|';
				$parametri .= ''.$_POST['fb_border_color'].'|';
				$parametri .= ''.$_POST['fb_feed'].'|';
				$parametri .= ''.$_POST['fb_color_schema'].'|';
				$parametri .= ''.$_POST['fb_fans'].'|';
			break;
		}
		
		if(isset($_POST['box_width'])) $_POST['box_width'] = $_POST['box_width'];
		else $_POST['box_width'] = 0;
		if(isset($_POST['box_height'])) $_POST['box_height'] = $_POST['box_height'];
		else $_POST['box_height'] = 0;
		if(isset($_POST['box_ordine'])) $_POST['box_ordine'] = $_POST['box_ordine'];
		else $_POST['box_ordine'] = 0;
		if(isset($_POST['box_background_img'])) $_POST['box_background_img'] = $_POST['box_background_img'];
		else $_POST['box_background_img'] = 0;
		if(isset($_POST['box_border_size'])) $_POST['box_border_size'] = $_POST['box_border_size'];
		else $_POST['box_border_size'] = 0;
		
		$wpdb->query("UPDATE $table_name_box SET
			box_titolo='".$_POST['titolo']."',
			value='".$_POST['content']."',
			box_width='".$_POST['box_width']."',
			box_height='".$_POST['box_height']."',
			box_ordine='".$_POST['box_ordine']."',
			box_background='".$_POST['box_background']."',
			box_background_img='".$_POST['box_background_img']."',
			box_border_size='".$_POST['box_border_size']."',
			box_border_color='".$_POST['box_border_color']."',
			parametri='".$parametri."',
			box_data_update='".time()."',
			box_active='".$_POST['stato']."'
			WHERE box_id='".$_POST['box_id']."'");
			
?>
	<div class="alert alert-success">
		<h3><?php _e('Well, the Box has been changed successfully!', 'toolpage'); ?></h3>
        
        <a href="?page=add-box&amp;tipo=<?php echo $_GET['tipo']; ?>&amp;id=<?php echo $_POST['box_id']; ?>" class="btn btn-info"><?php _e('Edit again the Box', 'toolpage'); ?></a> <a href="?page=libreria-box" class="btn btn-primary"><?php _e('Go to Box Library', 'toolpage'); ?></a> <a href="?page=add-box" class="btn btn-success"><?php _e('Add new Box', 'toolpage'); ?></a><br />
        <br />
        
        <a href="https://twitter.com/Make23Creations" class="twitter-follow-button" data-show-count="true" data-lang="it">Follow @Make23Creations</a>
    </div>
<?php
		
	}
	elseif(isset($_POST['salva_box']) && $_POST['titolo'] != ''){
		if($_POST['tipo'] == '') $_POST['tipo'] = 'text';
		
		$parametri = '|';
		switch($_POST['tipo']){
			case 'twitter':
				$parametri .= ''.$_POST['widget_id'].'|';
			break;
			case 'facebook':
				$parametri .= ''.$_POST['fb_intestazione'].'|';
				$parametri .= ''.$_POST['fb_border_color'].'|';
				$parametri .= ''.$_POST['fb_feed'].'|';
				$parametri .= ''.$_POST['fb_color_schema'].'|';
				$parametri .= ''.$_POST['fb_fans'].'|';
			break;
		}
		
		if(isset($_POST['box_width'])) $_POST['box_width'] = $_POST['box_width'];
		else $_POST['box_width'] = 0;
		if(isset($_POST['box_height'])) $_POST['box_height'] = $_POST['box_height'];
		else $_POST['box_height'] = 0;
		if(isset($_POST['box_ordine'])) $_POST['box_ordine'] = $_POST['box_ordine'];
		else $_POST['box_ordine'] = 0;
		if(isset($_POST['box_background_img'])) $_POST['box_background_img'] = $_POST['box_background_img'];
		else $_POST['box_background_img'] = 0;
		if(isset($_POST['box_border_size'])) $_POST['box_border_size'] = $_POST['box_border_size'];
		else $_POST['box_border_size'] = 0;
		
		$wpdb->query("INSERT INTO $table_name_box VALUES('',
												 '".$_POST['titolo']."',
												 '".$_POST['tipo']."',
												 '".$_POST['content']."',
												 '".$_POST['box_width']."',
												 '".$_POST['box_height']."',
												 '".$_POST['box_ordine']."',
												 '".$_POST['box_background']."',
												 '".$_POST['box_background_img']."',
												 '".$_POST['box_border_size']."',
												 '".$_POST['box_border_color']."',
												 '".$parametri."',
												 '".time()."',
												 '0',
												 '".$_POST['stato']."')");
																	 
	//echo $wpdb->show_errors(); echo $wpdb->print_error();
?>
	<div class="alert alert-success">
		<h3><?php _e('Well, the Box has been created successfully!', 'toolpage'); ?></h3>
        
        <a href="?page=libreria-box" class="btn btn-primary"><?php _e('Go to Library Box', 'toolpage'); ?></a> <a href="?page=add-box" class="btn btn-success"><?php _e('Add new Box', 'toolpage'); ?></a><br />
        <br />
        
        <a href="https://twitter.com/Make23Creations" class="twitter-follow-button" data-show-count="true" data-lang="it">Follow @Make23Creations</a>
    </div>  
<?
	}
	else $my_error = 2;
	
	if(isset($my_error)) $my_error = $my_error;
	else $my_error = 0;
	
	if(($my_error == 1 || $my_error == 2)){
		if((isset($_POST['salva_box']) || isset($_POST['edit_box'])) && !isset($_GET['id'])){
			//print_r($_POST);
			$titolo = $_POST['titolo'];
			$content = $_POST['content'];
			$widget_id = $_POST['widget_id'];
			$stato = $_POST['stato'];
			$box_height = $_POST['box_height'];
			$box_ordine = $_POST['box_ordine'];
			$box_background = $_POST['box_background'];
			$box_border_size = $_POST['box_border_size'];
			
			$fb_intestazione = $_POST['fb_intestazione'];
			$fb_border_color = $_POST['fb_border_color'];
			$fb_feed = $_POST['fb_feed'];
			$fb_color_schema = $_POST['fb_color_schema'];
			$fb_fans = $_POST['fb_fans'];
		}
		//elseif(isset($_GET['id']) && $_GET['id'] > 0){
		elseif((isset($_GET['id']) && $_GET['id'] > 0) || (isset($_POST['box_id']) && $_POST['box_id'] > 0)){
			if($_GET['id'] > 0) $box_id = $_GET['id'];
			elseif($_POST['id'] > 0) $box_id = $_POST['id'];
			$box_edit = $wpdb->get_row("SELECT * FROM $table_name_box WHERE box_id='".$box_id."'");
			$titolo = $box_edit->box_titolo;
			$content = $box_edit->value;
			$stato = $box_edit->box_active;
			$box_height = $box_edit->box_height;
			$box_ordine = $box_edit->box_ordine;
			$box_background = $box_edit->box_background;
			$box_border_size = $box_edit->box_border_size;
			
			switch($box_edit->box_tipo){
				case 'twitter':
					$widget_id = explode("|", $box_edit->parametri);
					$widget_id = $widget_id[1];
				break;
				case 'facebook':
					$par = explode("|", $box_edit->parametri);
					$fb_intestazione = $par[1];
					$fb_border_color = $par[2];
					$fb_feed = $par[3];
					$fb_color_schema = $par[4];
					$fb_fans = $par[5];
				break;
			}
			
		}
		else{
			$titolo = '';
			$content = '';
			$widget_id = '';
			$stato = '';
			$box_height = '';
			$box_ordine = '';
			$box_background = '';
			$box_border_size = '';
			
			$fb_intestazione = '';
			$fb_border_color = '';
			$fb_feed = '';
			$fb_color_schema = '';
			$fb_fans = '';
		}
?>  
<?php
	if((isset($_GET['id']) && $_GET['id'] > 0) || (isset($_POST['box_id']) && $_POST['box_id'] > 0)){
	//if(isset($_GET['id']) && $_GET['id'] > 0){
?>  
	<div>
    	<img src="<?php echo WP_CONTENT_URL; ?>/plugins/toolpage/imgs/icon/<?php echo $_GET['tipo']; ?>.png" alt="<?php echo $_GET['tipo']; ?>" width="20" align="left" />&nbsp;&nbsp;&nbsp;<?php _e('Box Type:', 'toolpage'); ?> <strong><?php echo $_GET['tipo']; ?></strong>
    </div>
    
    <br />
<?php
	}
	else{
?>
    <form class="form-horizontal" action="" method="get">
    	<input type="hidden" name="page" value="add-box" />
    	<input type="hidden" name="add" value="vai" />
         
        <div>    
            <label>
            	<?php _e('Select Box Type', 'toolpage'); ?><br />
                <select id="tipoSel" name="tipoSel">
                    <option value="?page=add-box&amp;add=vai&amp;tipo=text&amp;vai=Aggiungi+Box"<?php if($_GET['tipo'] == 'text') echo ' selected="selected"'; ?>>text/HTML (<?php _e('available', 'toolpage'); ?>)</option>
                    <option value="?page=add-box&amp;add=vai&amp;tipo=image&amp;vai=Aggiungi+Box"<?php if($_GET['tipo'] == 'image') echo ' selected="selected"'; ?>>image (<?php _e('available', 'toolpage'); ?>)</option>
                    <option value="?page=add-box&amp;add=vai&amp;tipo=menu&amp;vai=Aggiungi+Box"<?php if($_GET['tipo'] == 'menu') echo ' selected="selected"'; ?>>menu (<?php _e('available', 'toolpage'); ?>)</option>
                    <option value="?page=add-box&amp;add=vai&amp;tipo=form&amp;vai=Aggiungi+Box"<?php if($_GET['tipo'] == 'form') echo ' selected="selected"'; ?>>form (<?php _e('available', 'toolpage'); ?>)</option>
                    <option value="?page=add-box&amp;add=vai&amp;tipo=twitter&amp;vai=Aggiungi+Box"<?php if($_GET['tipo'] == 'twitter') echo ' selected="selected"'; ?>>twitter (<?php _e('available', 'toolpage'); ?>)</option>
                    <option value="?page=add-box&amp;add=vai&amp;tipo=facebook&amp;vai=Aggiungi+Box"<?php if($_GET['tipo'] == 'facebook') echo ' selected="selected"'; ?>>facebook (<?php _e('available', 'toolpage'); ?>)</option>
                    <option value="?page=add-box&amp;add=vai&amp;tipo=youtube&amp;vai=Aggiungi+Box"<?php if($_GET['tipo'] == 'youtube') echo ' selected="selected"'; ?>>youtube (<?php _e('available', 'toolpage'); ?>)</option>
                </select> <!--<input type="submit" name="vai" class="btn btn-success" value="Aggiungi Box" />-->
            </label>
        </div>
    </form>
<?php
	}
?>
<?
		//if(isset($_GET['add']) && $_GET['add'] == 'vai'){
?>    
    
    <form class="form-horizontal" action="?page=add-box&amp;add=ok&amp;tipo=<?php echo $_GET['tipo']; ?><?php if($_GET['id'] > 0) echo '&amp;id='.$_GET['id']; ?>" method="post"> 
    	<input type="hidden" name="box_id" value="<?php echo $_GET['id']; ?>" />
        
        <p>
            <ul id="myTabs" class="nav nav-tabs">
              <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
              <li><a href="#settings" data-toggle="tab"><?php _e('Advanced Settings', 'toolpage'); ?></a></li>
            </ul>    
            
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <input type="hidden" name="tipo" value="<?php echo $_GET['tipo']; ?>" />
<?php
		//if($_GET['tipo'] != 'form'){
?>
                    <p>
                        <label>
                        <?php _e('Box Title', 'toolpage'); ?> <?php echo STELLINA; ?>
                        <input class="input-block-level" type="text" name="titolo" placeholder="<?php _e('Box Title', 'toolpage'); ?>" value="<?php echo $titolo; ?>" />
                        </label>
                    </p>
<?php
		//}
?>
             
<?php
	switch($_GET['tipo']){
		default:
		case 'text':
?>                  
					<br />
                    
					<label>
                    <?php _e('Box text/HTML', 'toolpage'); ?> <?php echo STELLINA; ?><br />
                    <br />
                    
                    <?php 	wp_editor( $content, 'content-id', array( 'textarea_name' => 'content', 'media_buttons' => true, 'quicktags' => true) ); ?>
                    </label>
                    
                    <br />
<?php
		break;
		case 'image':
?>
					<br />
                    
					<label>
                    <?php _e('Select an image by clicking on', 'toolpage'); ?> &quot;<strong><?php _e('Add Media', 'toolpage'); ?></strong>&quot; <?php echo STELLINA; ?><br />
                    <br />
                    
                    <?php 	wp_editor( stripslashes($content), 'content-id', array( 'textarea_name' => 'content', 'media_buttons' => true, 'quicktags' => false, 'tinymce' => array(
        'theme_advanced_buttons1' => '',
        'theme_advanced_buttons2' => '',
        'theme_advanced_buttons3' => ''
    )) ); ?>
    				</label>
                    
                    <br />
<?php
		break;
		case 'menu':
?>
					<br />
                    
					<label>
                    <?php _e('Select a menu to be displayed in the Box', 'toolpage'); ?> <?php echo STELLINA; ?> <small><?php _e('Creating a custom menu', 'toolpage'); ?> <a href="nav-menus.php" target="_blank"><?php _e('click here', 'toolpage'); ?></a>.</small><br />                   
                    <select name="content">
						<option value="">--- <?php _e('select a menu', 'toolpage'); ?> ---</option>
<?php
			// Get all nav menus
			$nav_menus = wp_get_nav_menus( array('orderby' => 'name') );
			//print_r($nav_menus);
			
			foreach( (array) $nav_menus as $key => $_nav_menu ) {
?>
                        <option value="<?php echo $_nav_menu->slug; ?>"<?php if($_nav_menu->slug == $content) echo ' selected="selected"'; ?>><?php echo $_nav_menu->name; ?></option>
<?php
			}
?>
					</select>
    				</label>
                    
                    <br />
<?php
		break;
		case 'form':
			if(!is_plugin_active('contact-form-7/wp-contact-form-7.php')){
?>
					<div class="alert alert-error">
                    	<strong><?php _e('Attention!', 'toolpage'); ?></strong> <?php _e('To use this Box Type you must install and activate the plugin', 'toolpage'); ?> <em>Contact Form 7</em> <small>(<a href="http://wordpress.org/extend/plugins/contact-form-7/" target="_blank"><?php _e('download plugin', 'toolpage'); ?></a>)</small>
                    </div>
<?php			
			}
			else{
?>
					<div class="alert alert-success">
                    	<?php _e('Create new contact forms using the plugin', 'toolpage'); ?> <strong>Contact Form 7</strong>: <a href="?page=wpcf7"><strong><?php _e('click here', 'toolpage'); ?></strong></a>
                    </div>
<?php			
				// post_type = wpcf7_contact_form
				// [contact-form-7 id="POST_ID" title="TITOLO"]
				$cf7_data = $wpdb->get_results("SELECT ID, post_title FROM $table_posts WHERE post_type='wpcf7_contact_form' ORDER BY ID DESC");
			}
?>                  
                    
					<label>
                    <?php _e('Select the module to be displayed in the Box', 'toolpage'); ?> <?php echo STELLINA; ?><br />                   
                    <select name="content">
						<option value="">--- <?php _e('select a menu', 'toolpage'); ?> ---</option>
<?php		
			foreach($cf7_data as $cf7) {
?>
                        <option value="<?php echo $cf7->ID; ?>"<?php if($cf7->ID == $content) echo ' selected="selected"'; ?>><?php echo $cf7->post_title; ?></option>
<?php
			}
?>
					</select>
    				</label>
                    
                    <br />
<?php
		break;
		case 'twitter':
?>                  
                    
                    <br />
					
                    <label>
                    <?php _e('Twitter Nickname.', 'toolpage'); ?> <?php echo STELLINA; ?> <small><?php _e('Example:', 'toolpage'); ?> https://twitter.com/<strong>Make23Creations</strong></small>
                    <input class="input-block-level" type="text" name="content" placeholder="Nickname Twitter" value="<?php echo $content; ?>" />
                    </label>
                    
                    <br />
					
                    <label>
                    <?php _e('Widget ID.', 'toolpage'); ?> <?php echo STELLINA; ?> <small><?php _e('To get a Widget ID you must first create your Widget:', 'toolpage'); ?> <a href="https://twitter.com/settings/widgets" target="_blank"><strong><?php _e('click here', 'toolpage'); ?></strong></a>.</small>
                    <input class="input-block-level" type="text" name="widget_id" placeholder="Widget ID" value="<?php echo $widget_id; ?>" />
                    </label>
                    
                    <br />
<?php
		break;
		case 'facebook':
?>                  
                    
                    <br />
					
                    <label>
                    <?php _e('Write the URL of the Facebook page.', 'toolpage'); ?> <?php echo STELLINA; ?> <small><?php _e('Example:', 'toolpage'); ?> <strong>https://www.facebook.com/Make23FB</strong></small>
                    <input class="input-block-level" type="text" name="content" placeholder="URL pagina Facebook" value="<?php echo $content; ?>" />
                    </label>
                    
                    <br />
					
                    <label>
                    <?php _e('Show Header', 'toolpage'); ?><br />
                    <select class="span3" name="fb_intestazione">
                        <option value="true"<?php if($fb_intestazione == 'true') echo ' selected="selected"'; ?>><?php _e('Active', 'toolpage'); ?></option>
                        <option value="false"<?php if($fb_intestazione == 'false') echo ' selected="selected"'; ?>><?php _e('Not Active', 'toolpage'); ?></option>
                    </select>
                    </label>
                    
                    <br />
					
                    <label>
                    <?php _e('Border Color.', 'toolpage'); ?> <small><?php _e('Example:', 'toolpage'); ?> #333333 <em>oppure</em> grey</small><br />
                    <input class="my-color-field3 span3" type="text" name="fb_border_color" placeholder="<?php _e('Border Color', 'toolpage'); ?>" value="<?php echo $fb_border_color; ?>" data-default-color="#333333" />
                    </label>
                    
                    <br />
					
                    <label>
                    <?php _e('Show Feed', 'toolpage'); ?><br />
                    <select class="span3" name="fb_feed">
                        <option value="true"<?php if($fb_feed == 'true') echo ' selected="selected"'; ?>><?php _e('Active', 'toolpage'); ?></option>
                        <option value="false"<?php if($fb_feed == 'false') echo ' selected="selected"'; ?>><?php _e('Not Active', 'toolpage'); ?></option>
                    </select>
                    </label>
                    
                    <br />
					
                    <label>
                    <?php _e('Color Scheme', 'toolpage'); ?><br />
                    <select class="span3" name="fb_color_schema">
                        <option value="light"<?php if($fb_color_schema == 'light') echo ' selected="selected"'; ?>>Light</option>
                        <option value="dark"<?php if($fb_color_schema == 'dark') echo ' selected="selected"'; ?>>Dark</option>
                    </select>
                    </label>
                    
                    <br />
					
                    <label>
                    <?php _e('Show Fans Pic', 'toolpage'); ?><br />
                    <select class="span3" name="fb_fans">
                        <option value="true"<?php if($fb_fans == 'true') echo ' selected="selected"'; ?>><?php _e('Yes', 'toolpage'); ?></option>
                        <option value="false"<?php if($fb_fans == 'false') echo ' selected="selected"'; ?>><?php _e('No', 'toolpage'); ?></option>
                    </select>
                    </label>
                    
                    <br />
<?php
		break;
		case 'youtube':
?>                  
                    
                    <br />
					
                    <label>
                    <?php _e('Write the URL of the YouTube video.', 'toolpage'); ?> <?php echo STELLINA; ?> <small><?php _e('Example:', 'toolpage'); ?> <strong>http://www.youtube.com/embed/uBOWIavrvw4</strong></small>
                    <input class="input-block-level" type="text" name="content" placeholder="URL video YouTube" value="<?php echo $content; ?>" />
                    </label>
                    
                    <br />
<?php
		break;
	}
?>                
                </div>
                
                <div class="tab-pane" id="settings">
<?php
		//if($_GET['tipo'] != 'form'){
?>
                    <label>
                    <?php _e('Box Status:', 'toolpage'); ?>
                    <select class="span3" name="stato">
                        <option value="1"<?php if($stato == '1') echo ' selected="selected"'; ?>><?php _e('Active', 'toolpage'); ?></option>
                        <option value="0"<?php if($stato == '0') echo ' selected="selected"'; ?>><?php _e('Not Active', 'toolpage'); ?></option>
                    </select>
                    </label>
                    
                    <br />
            
                    <div class="row">
                        <!--<div class="span2">
                            <label>
                            Larghezza in pixel.<br />
                            <small>Esempio: 450px</small>
                            <input class="input-block-level input-medium" type="text" name="box_width" value="<?php echo $box_width; ?>" />
                            </label>
                        </div>-->
                        
                        <div class="span2">
                            <label>
                            <?php _e('Maximum height in pixels', 'toolpage'); ?><br />
                            <small><?php _e('Example:', 'toolpage'); ?> 100px</small>
                            <input class="input-block-level input-medium" type="text" name="box_height" value="<?php echo $box_height; ?>" />
                            </label>
                        </div>
                        
                        <div class="span2">
                            <label>
                            <?php _e('Background Color', 'toolpage'); ?><br />
                            <small><?php _e('Example:', 'toolpage'); ?> #cccccc <em>oppure</em> grey</small>
                            <input class="my-color-field1 input-block-level input-medium" type="text" name="box_background" id="color" value="<?php echo $box_background; ?>" data-default-color="#cccccc" />
                            <!--<div id="ilctabscolorpicker"></div>-->
                            </label>
                        </div>
                        
                        <div class="span2">
                            <label>
                            <?php _e('Border Size', 'toolpage'); ?><br />
                            <small><?php _e('Example:', 'toolpage'); ?> 1px</small>
                            <input class="input-block-level input-medium" type="text" name="box_border_size" id="color" value="<?php echo $box_border_size; ?>" />
                            <!--<div id="ilctabscolorpicker"></div>-->
                            </label>
                        </div>
                        
                        <div class="span2">
                            <label>
                            <?php _e('Border Color', 'toolpage'); ?><br />
                            <small><?php _e('Example:', 'toolpage'); ?> #000000</small><br />
                            <input class="my-color-field2 input-block-level input-medium" type="text" name="box_border_color" id="color" value="<?php echo $box_border_color; ?>" data-default-color="#000000" />
                            <!--<div id="ilctabscolorpicker"></div>-->
                            </label>
                        </div>
                    </div>
                    
                </div>
<?php
		/*}
		else{
?>
				<em>Presto Disponibile...</em>
                <a href="https://twitter.com/Make23Creations" class="twitter-follow-button" data-show-count="true" data-lang="it">Follow @Make23Creations</a>
<?php		
		}*/
?>
            </div>   	
        </p>
<?php
		//if($_GET['tipo'] != 'form'){
?>        
        <hr />

    	<p>
<?php
			if((isset($_GET['id']) && $_GET['id'] > 0) || (isset($_POST['box_id']) && $_POST['box_id'] > 0)){
			//if(isset($_GET['id']) && $_GET['id'] > 0){
?>
            <label>
            	<input type="submit" class="btn btn-primary" value="<?php _e('Save Changes Box', 'toolpage'); ?>" name="edit_box" /> 
<?php
			}
			else{
?>
            <label>
            	<input type="submit" class="btn btn-primary" value="<?php _e('Save Box', 'toolpage'); ?>" name="salva_box" /> 
<?php
			}
?>
                
                <a href="?page=libreria-box" class="btn btn-danger"><?php _e('Cancel', 'toolpage'); ?></a>
            </label>
    	</p>
<?php
		//}
?>        
    </form>
<?
		//}
	}
?>    
    
    <?php require_once PLUGIN_PATH.'/includes/footer-general.php'; ?>
</div>
