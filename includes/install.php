<?php
function toolpage_plugin_install() {
    //add_option('toolpage_options', toolpage_defaults());
    //add_option('toolpage_copyright_footer', 0);
    toolpage_install();
    global $wpdb;
	$table_name = $wpdb->prefix . "toolpage"; 
	$table_name2 = $wpdb->prefix . "toolpage_box"; 
	$table_name3 = $wpdb->prefix . "toolpage_box_relazioni"; 
	$table_name4 = $wpdb->prefix . "toolpage_settings"; 
	
	$wpdb->get_results("SELECT * FROM " . $table_name . " WHERE url='myfirsttoolpage'");
	if($wpdb->num_rows == 0){
    $sql = "INSERT IGNORE INTO " . $table_name . " values ('', 
	'My first ToolPage', 
	'myfirsttoolpage', 
	'0', 
	'2', 
	'1', 
	'980px', 
	'#333', 
	'#fff', 
	'\"Trebuchet MS\", Arial, Helvetica, sans-serif', 
	'12px', 
	'#000', 
	'red',  
	'#333', 
	'SEO TITLE',
	'SEO DESCRIPTION',
	'index, nofollow',
	'', 
	'', 
	'".time()."', 
	'', 
	'1');";
    $wpdb->query( $sql );	
	}
	
	//$toolpage_id = $wpdb->insert_id;
    
	$wpdb->get_results("SELECT * FROM " . $table_name2 . " WHERE box_titolo='Box Title' AND box_tipo='text' AND value='Text/HTML box'");
	if($wpdb->num_rows == 0){
		$sql2 = "INSERT IGNORE INTO " . $table_name2 . " values ('', 
		'Box Title', 
		'text', 
		'Text/HTML box', 
		'', 
		'100px', 
		'0', 
		'#fff', 
		'', 
		'1px', 
		'red', 
		'',
		'".time()."', 
		'', 
		'1');";
		$wpdb->query( $sql2 );
	}
	
	$wpdb->get_results("SELECT * FROM " . $table_name2 . " WHERE box_titolo='Twitter' AND box_tipo='twitter' AND value='Make23Creations'");
	if($wpdb->num_rows == 0){
		$sql2a = "INSERT IGNORE INTO " . $table_name2 . " values ('', 
		'Twitter', 
		'twitter', 
		'Make23Creations', 
		'', 
		'500px', 
		'0', 
		'', 
		'', 
		'', 
		'', 
		'|310343167885049856|',
		'".time()."', 
		'', 
		'1');";
		$wpdb->query( $sql2a );
	}
	
	$wpdb->get_results("SELECT * FROM " . $table_name3 . " WHERE toolpage_id='1' AND box_id='1'");
	if($wpdb->num_rows == 0){
		$sql3 = "INSERT IGNORE INTO " . $table_name3 . " values ('1', '1', '0');";
		$wpdb->query( $sql3 );	
	}
	
	$wpdb->get_results("SELECT * FROM " . $table_name3 . " WHERE toolpage_id='1' AND box_id='2'");
	if($wpdb->num_rows == 0){
    	$sql3a = "INSERT IGNORE INTO " . $table_name3 . " values ('1', '2', '1');";
    	$wpdb->query( $sql3a );	
	}
	
	$wpdb->get_results("SELECT nome FROM " . $table_name4 . " WHERE nome='stat'");
	if($wpdb->num_rows == 0){
		$sql4 = "INSERT IGNORE INTO " . $table_name4 . " values ('stat', '0');";
		$wpdb->query( $sql4 );	
	}
}

//ToolPage Table
function toolpage_install(){
    global $wpdb;
	$table_name = $wpdb->prefix . "toolpage"; 
	$table_name2 = $wpdb->prefix . "toolpage_box"; 
	$table_name3 = $wpdb->prefix . "toolpage_box_relazioni"; 
	$table_name4 = $wpdb->prefix . "toolpage_settings"; 
    
	/* tipo: text, image, menu, form, twitter, facebook, video_youtube */
		
	$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  titolo VARCHAR(255) NOT NULL DEFAULT  '',
	  url VARCHAR(255) NOT NULL DEFAULT  '',
	  is_home VARCHAR(255) NOT NULL DEFAULT  '0',
	  schema_box VARCHAR(255) NOT NULL DEFAULT  '',
	  appearance_box VARCHAR(255) NOT NULL DEFAULT  '',	  
	  larghezza VARCHAR(255) NOT NULL DEFAULT  '',
	  background_color VARCHAR(255) NOT NULL DEFAULT  '',
	  background_color_contenitore VARCHAR(255) NOT NULL DEFAULT  '',
	  font VARCHAR(255) NOT NULL DEFAULT  '',
	  font_size VARCHAR(255) NOT NULL DEFAULT  '',
	  font_color VARCHAR(255) NOT NULL DEFAULT  '',
	  font_color_links VARCHAR(255) NOT NULL DEFAULT  '',
	  font_color_links_hover VARCHAR(255) NOT NULL DEFAULT  '',
	  seo_titolo VARCHAR(255) NOT NULL DEFAULT  '',
	  seo_descrizione VARCHAR(255) NOT NULL DEFAULT  '',
	  seo_robots VARCHAR(255) NOT NULL DEFAULT  '',
	  css_editor TEXT NOT NULL DEFAULT  '',
	  google_editor TEXT NOT NULL DEFAULT  '',
	  data_insert INT(10) NOT NULL DEFAULT '0',
	  data_update INT(10) NOT NULL DEFAULT '0',
	  active tinyint(1) NOT NULL DEFAULT  '0',
	  PRIMARY KEY (`id`)
	);";
	
	$sql2 = "CREATE TABLE IF NOT EXISTS " . $table_name2 . " (
	  box_id mediumint(9) NOT NULL AUTO_INCREMENT,
	  box_titolo VARCHAR(255) NOT NULL DEFAULT  '',
	  box_tipo VARCHAR(255) NOT NULL DEFAULT  '',
	  value TEXT NOT NULL DEFAULT  '',
	  box_width VARCHAR(255) NOT NULL DEFAULT  '',
	  box_height VARCHAR(255) NOT NULL DEFAULT  '',
	  box_ordine INT(10) NOT NULL DEFAULT  '0',
	  box_background VARCHAR(255) NOT NULL DEFAULT  '',
	  box_background_img VARCHAR(255) NOT NULL DEFAULT  '',
	  box_border_size INT(2) NOT NULL DEFAULT  '0',
	  box_border_color VARCHAR(255) NOT NULL DEFAULT  '',
	  parametri TEXT NOT NULL DEFAULT  '',
	  box_data_insert INT(10) NOT NULL DEFAULT '0',
	  box_data_update INT(10) NOT NULL DEFAULT '0',
	  box_active tinyint(1) NOT NULL DEFAULT  '0',
	  PRIMARY KEY (`box_id`)
	);";
	
	$sql3 = "CREATE TABLE IF NOT EXISTS " . $table_name3 . " (
	  toolpage_id INT(10) NOT NULL DEFAULT '0',
	  box_id INT(10) NOT NULL DEFAULT '0',
	  ordine_relazioni INT(10) NOT NULL DEFAULT '0'
	);";
	
	$sql4 = "CREATE TABLE IF NOT EXISTS " . $table_name4 . " (
	  nome VARCHAR(255) NOT NULL DEFAULT '',
	  valore VARCHAR(255) NOT NULL DEFAULT ''
	);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	dbDelta($sql2);
	dbDelta($sql3);
	dbDelta($sql4);
	
	//$wpdb->print_error(); $wpdb->show_errors();
}

/* START REWRITE - AGGIUNGI IN install() */
add_action( 'init', 'toolpage_init_internal' );
function toolpage_init_internal()
{
	//add_rewrite_rule( 'front.php$', 'index.php?toolpage_id=1', 'top');
	add_rewrite_rule( 'toolpage/(.+?)/?$', 'index.php?toolpage_id=$matches[1]', 'top');
}

add_filter( 'query_vars', 'toolpage_query_vars' );
function toolpage_query_vars( $query_vars )
{
	$query_vars[] = 'toolpage_id';
	return $query_vars;
}

add_action( 'parse_request', 'toolpage_parse_request' );
function toolpage_parse_request( &$wp )
{
	if ( array_key_exists( 'toolpage_id', $wp->query_vars ) ) {
		
		include PLUGIN_PATH.'/front_'.getTheme($wp->query_vars['toolpage_id']).'.php';
		exit();
	}
	return;
}
/* END REWRITE - AGGIUNGI IN install() */


add_action( 'wp_dashboard_setup', 'toolpage_dashboard_setup' );
function toolpage_dashboard_setup() {
    wp_add_dashboard_widget(
        'toolpage-dashboard-widget',
        '<img src="'.WP_CONTENT_URL.'/plugins/toolpage/imgs/icon.png" align="left" />&nbsp;'.__('My ToolPage', 'toolpage'),
        'toolpage_dashboard_content',
        $control_callback = null
    );
}

function toolpage_dashboard_content() {
    global $wpdb;
	$table_name = $wpdb->prefix . "toolpage"; 
    echo '<ol>';
	
	$r = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC LIMIT 10");
	foreach ($r as $data) {
		echo '<li><a href="admin.php?page=gestione-toolpage&id='.$data->id.'"><strong>'.$data->titolo.'</strong></a> <small>['.__('Status:', 'toolpage').' <img src="'.WP_CONTENT_URL.'/plugins/toolpage/imgs/icon/status_'.$data->active.'.png" /> -&nbsp;&nbsp;'.__('Home/Front:', 'toolpage').' <img src="'.WP_CONTENT_URL.'/plugins/toolpage/imgs/icon/status_'.$data->is_home.'.png" />]</small></li>';
	}
	
    echo '</ol>';
	
	echo '<br />
		  <a class="button" href="admin.php?page=toolpage"><strong>'.__('View all ToolPage', 'toolpage').'</strong></a>';
}
?>