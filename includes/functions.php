<?php
function get_version($pluginName=false) {
	static $versions=array();
	if(isset($versions[$pluginName])) return $versions[$pluginName];
	if ( ! function_exists( 'get_plugins' ) )   {
		if(file_exists(ABSPATH . 'wp-admin/includes/plugin.php')){
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
	}
	if (function_exists( 'get_plugins' ) )  {
		$pluginName='toolpage/toolpage.php';
		$pluginFile=PLUGIN_PATH_TWO.str_replace('/','/',$pluginName);
		$plugin_data = get_plugin_data( $pluginFile );
		$versions[$pluginName] = $plugin_data['Version'];
	}else{
		$versions[$pluginName]='undefined';
	}
	return $versions[$pluginName];
}

function toolpage_plugin_admin_menu() {
	add_menu_page(__('Overview', 'toolpage').' '.PLUGIN_NAME, __('My', 'toolpage').' '.PLUGIN_NAME, 'publish_posts', 'toolpage', 'toolpage_main', WP_CONTENT_URL.'/plugins/toolpage/imgs/icon.png', 66);
	
	if(isset($_GET['id'])) $_GET['id'] = $_GET['id'];
else $_GET['id'] = 0;
	
	if($_GET['id'] > 0) $str = __('Add/Edit', 'toolpage').' '.PLUGIN_NAME;
	else $str = __('New', 'toolpage').' '.PLUGIN_NAME; //fuffi
	add_submenu_page('toolpage', $str, $str, 'publish_posts', 'gestione-toolpage', 'toolpage_admin_page');
	add_submenu_page('toolpage', __('Box Library', 'toolpage').'', __('Box Library', 'toolpage').'', 'publish_posts', 'libreria-box', 'toolpage_libreria_box');
	add_submenu_page('toolpage', __('Add Box', 'toolpage').'', __('Add Box', 'toolpage').'', 'publish_posts', 'add-box', 'toolpage_add_box');
	add_submenu_page('toolpage', __('Settings', 'toolpage'), __('Settings', 'toolpage'), 'publish_posts', 'impostazioni-toolpage', 'toolpage_admin_impostazioni');
	//add_submenu_page('toolpage','Uninstall','Uninstall', 'publish_posts', 'uninstall-toolpage', 'toolpage_admin_uninstall');
	add_submenu_page('toolpage','Credits','Credits', 'publish_posts', 'credits-toolpage', 'toolpage_admin_credits');
}

function toolpage_main(){
	getHead();
	require_once PLUGIN_PATH.'/includes/start.php';
}

function toolpage_admin_page() { 
	getHead();
	require_once PLUGIN_PATH.'/includes/gestione-toolpage.php';
}

function toolpage_add_box() { 
	getHead();
	require_once PLUGIN_PATH.'/includes/add-box.php';
}

function toolpage_libreria_box() { 
	getHead();
	require_once PLUGIN_PATH.'/includes/libreria-box.php';
}

function toolpage_admin_impostazioni() { 
	getHead();
	require_once PLUGIN_PATH.'/includes/impostazioni-toolpage.php';
}

function toolpage_admin_credits() { 
	getHead();
	require_once PLUGIN_PATH.'/includes/credits-toolpage.php';
}

function getHead(){
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('wp-color-picker');
    /* CSS */
	wp_register_style('toolpage-css', WP_CONTENT_URL.'/plugins/toolpage/css/toolpage.css');
    wp_enqueue_style( 'toolpage-css');
	wp_register_style('bootstrap-css', WP_CONTENT_URL.'/plugins/toolpage/css/bootstrap.css');
    wp_enqueue_style( 'bootstrap-css');
	wp_register_style('ticker-style-css', WP_CONTENT_URL.'/plugins/toolpage/adds/jquery_news_ticker/styles/ticker-style.css');
    wp_enqueue_style( 'ticker-style-css');
	
	/* JS */
    wp_register_script('toolpage', WP_CONTENT_URL.'/plugins/toolpage/js/toolpage.js');
    wp_enqueue_script('toolpage');
    wp_register_script('bootstrap-transition', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-transition.js');
    wp_enqueue_script('bootstrap-transition');
    wp_register_script('bootstrap-alert', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-alert.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-alert');	
    wp_register_script('bootstrap-modal', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-modal.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-modal');
    wp_register_script('bootstrap-dropdown', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-dropdown.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-dropdown');
    wp_register_script('bootstrap-scrollspy', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-scrollspy.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-scrollspy');
    wp_register_script('bootstrap-tab', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-tab.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-tab');
    wp_register_script('bootstrap-tooltip', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-tooltip.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-tooltip');
    wp_register_script('bootstrap-popover', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-popover.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-popover');
    wp_register_script('bootstrap-button', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-button.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-button');
    wp_register_script('bootstrap-collapse', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-collapse.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-collapse');
    wp_register_script('bootstrap-carousel', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-carousel.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-carousel');
    wp_register_script('bootstrap-typeahead', WP_CONTENT_URL.'/plugins/toolpage/js/bootstrap-typeahead.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-typeahead');
	
    wp_register_script('jquery-ticker', WP_CONTENT_URL.'/plugins/toolpage/adds/jquery_news_ticker/includes/jquery.ticker.js', array('jquery'), false, false);
    wp_enqueue_script('jquery-ticker');
}

function tp_admin_notice_update(){
    //global $pagenow;
    if ( $_GET['page'] == 'toolpage' ) {
	echo '<div class="updated">
	 <p>Alert aggiornamento!</p>
	</div>';
    }
}

function tp_admin_notice_error(){
    /*global $pagenow;
    if ( $pagenow == 'plugins.php' ) {*/
    if ( $_GET['page'] == 'toolpage' ) {
	echo '<div class="error">
	 <p>Alert errore!</p>
	</div>';
    }
}

function getTitoloPage($table_name, $id_toolpage){
	global $wpdb;
	$r = $wpdb->get_row("SELECT titolo FROM $table_name WHERE id='".$id_toolpage."'");
	return $r->titolo;
}

function getTitoloBox($table_name_box, $box_id){
	global $wpdb;
	$r = $wpdb->get_row("SELECT box_titolo FROM $table_name_box WHERE box_id='".$box_id."'");
	return $r->box_titolo;
}

function getWidgetIdAttuale($box_id, $table_name_box){
	global $wpdb;
	$r = $wpdb->get_row("SELECT parametri FROM $table_name_box WHERE box_id='".$box_id."'");
	$r->parametri = explode("|", $r->parametri);
	$r->parametri = $r->parametri[1];
	return $r->parametri;
}

function widgetIdEsiste($widget_id, $table_name_box){
	global $wpdb;
	$wpdb->get_results("SELECT parametri FROM $table_name_box WHERE parametri LIKE '%".$widget_id."|%'");
	return $wpdb->num_rows;
}

function getBoxIdByToolpageId($toolpage_id, $table_name_box_relazioni){
	global $wpdb;
	$r = $wpdb->get_results("SELECT box_id, ordine_relazioni FROM $table_name_box_relazioni WHERE toolpage_id='".$toolpage_id."' ORDER BY $table_name_box_relazioni.ordine_relazioni ASC");
	foreach ($r as $data) {
		$ra[] = $data->box_id;
	}
	return $ra;
}

function getOrdineBoxByToolpageId($toolpage_id, $box_id, $table_name_box_relazioni){
	global $wpdb;
	$r = $wpdb->get_row("SELECT ordine_relazioni FROM $table_name_box_relazioni WHERE toolpage_id='".$toolpage_id."' AND box_id='".$box_id."'");
	
	return $r->ordine_relazioni;
}

function getTotBoxByToolpageId($toolpage_id, $table_name_box_relazioni){
	global $wpdb;
	$wpdb->get_results("SELECT toolpage_id FROM $table_name_box_relazioni WHERE toolpage_id='".$toolpage_id."'");
	
	return $wpdb->num_rows;
}

function getTotToolpage(){
	global $wpdb;
	$table_name = $wpdb->prefix . "toolpage";
	
	$wpdb->get_results("SELECT * FROM $table_name");
	
	return $wpdb->num_rows;
}

function getIsHomePage(){
	global $wpdb;
	$table_name = $wpdb->prefix . "toolpage";
	$r = $wpdb->get_row("SELECT id, url, is_home FROM $table_name WHERE is_home='1' LIMIT 1");
	
	return $r->url;
}

function getTheme($url){
	global $wpdb;
	$table_name = $wpdb->prefix . "toolpage";
	$r = $wpdb->get_row("SELECT id, url, appearance_box FROM $table_name WHERE url='".$url."' LIMIT 1");
	
	switch($r->appearance_box){
		default:
		case '1':
			$ret = 'base';
		break;
		case '2':
			$ret = 'professional';
		break;
		case '3':
			$ret = 'fashion';
		break;
	}
	
	return $ret;
}

function tp_sovrascrivihome(){
	global $wp_query;
	if(getIsHomePage() != '' && is_front_page()){
	//if(getIsHomePage() != '' && is_home()){
		header( "HTTP/1.1 301 Moved Permanently" );
		/*
		header( "Location: http://www.make23.com/toolpage/prova");*/
		$wp_query->set('ttoolpage_id', getIsHomePage());
		
		require_once(PLUGIN_PATH.'/front_'.getTheme(getIsHomePage()).'.php');
		die();
	}
}

function updateInit(){
	global $wpdb;
	$table_name = $wpdb->prefix . "toolpage";
	
	/* AGGIORNAMENTI VERSIONE */
	//if(get_version('toolpage') < '0.2'){
		//echo 'test';
		
		$result = $wpdb->query("SHOW COLUMNS FROM $table_name LIKE 'is_home'");
		if($wpdb->num_rows == 0){
			 $wpdb->query("ALTER TABLE $table_name ADD is_home VARCHAR(255) AFTER url");
			 $wpdb->query("UPDATE $table_name SET is_home='0' WHERE is_home=''");
		}
		
		$result = $wpdb->query("SHOW COLUMNS FROM $table_name LIKE 'appearance_box'");
		if($wpdb->num_rows == 0){
			 $wpdb->query("ALTER TABLE $table_name ADD appearance_box VARCHAR(255) AFTER schema_box");
		}
	//}
	
	//echo $wpdb->show_errors(); echo $wpdb->print_error();
}

function getSettingsByNome($nome){
	global $wpdb;
	$table_name_settings = $wpdb->prefix . "toolpage_settings"; 
	
	$toolpage_settings = $wpdb->get_row("SELECT valore FROM $table_name_settings WHERE nome='".$nome."'");
	
	return $toolpage_settings->valore;
}


  function toolbar_toolpage( $wp_admin_bar ) {
  
    // add a parent item
    $args = array('id' => 'parent_node', 'href' => WP_ADMIN_URL.'/admin.php?page=toolpage', 'title' => PLUGIN_NAME); 
    $wp_admin_bar->add_node($args);
    
    // add a child item to our parent item
    $args = array('id' => 'mie-toolpage', 'href' => WP_ADMIN_URL.'/admin.php?page=toolpage', 'title' => __('My', 'toolpage').' '.PLUGIN_NAME, 'parent' => 'parent_node'); 
    $wp_admin_bar->add_node($args);
    
    // add a group node with a class "first-toolbar-group"
    $args = array(
              'id' => 'first_group', 
              'parent' => 'parent_node',
              'meta' => array('class' => 'first-toolbar-group')
            );
    $wp_admin_bar->add_group($args); 
    
    // add another child item to our parent item (not to our first group)
    $args = array('id' => 'nuova-toolpage', 'href' => WP_ADMIN_URL.'/admin.php?page=gestione-toolpage', 'title' => __('New', 'toolpage').' '.PLUGIN_NAME, 'parent' => 'parent_node');
    $wp_admin_bar->add_node($args);
	
    // add another child item to our parent item (not to our first group)
    $args = array('id' => 'libreria-box', 'href' => WP_ADMIN_URL.'/admin.php?page=libreria-box', 'title' => __('Box Library', 'toolpage'), 'parent' => 'parent_node');
    $wp_admin_bar->add_node($args);
    
    // add another child item to our parent item (not to our first group)
    $args = array('id' => 'nuovo-box', 'href' => WP_ADMIN_URL.'/admin.php?page=add-box', 'title' => __('Add Box', 'toolpage'), 'parent' => 'parent_node');
    $wp_admin_bar->add_node($args);
    
    // add another child item to our parent item (not to our first group)
    $args = array('id' => 'settings', 'href' => WP_ADMIN_URL.'/admin.php?page=impostazioni-toolpage', 'title' => __('Settings', 'toolpage'), 'parent' => 'parent_node'); //fuffi
    $wp_admin_bar->add_node($args);
    
    // add an item to our group item
    $args = array('id' => 'first_grouped_node', 'href' => WP_ADMIN_URL.'/admin.php?page=credits-toolpage', 'title' => __('Credits', 'toolpage'), 'parent' => 'first_group'); 
    $wp_admin_bar->add_node($args);
    
  }
  
  function grabRss($url){
	  $doc = new DOMDocument();
	  $doc->load($url);
	  $arrFeeds = array();
	  foreach ($doc->getElementsByTagName('item') as $node) {
		$itemRSS[] = array ( 
		  'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
		  'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
		  'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
		  'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
		  );
		array_push($arrFeeds, $itemRSS);
		
		//echo $itemRSS['title'].'<br>';
		//return '<a href="'.$itemRSS['link'].'" title="'.$itemRSS['title'].'" target="_blank">'.$itemRSS['title'].'</a>';
	  }
	  return $itemRSS;
  }
?>