<?php
/*
	Plugin Name: Toolpage&trade; your Lading Page in Box + Widget
	Plugin URI: http://www.make23.com/
	Description: Create unlimited Landing Pages for your OnLine Advertising. NEW: set a ToolPage as HomePage/FrontPage + ToolPage Widget
	Version: 1.6.1
	Author: Make23.com - Giuseppe Distefano
	Author URI: http://www.make23.com
	License: GPL v3
*/

/*  Copyright 2013  Make23.com - Giuseppe Distefano  (email : g.distefano@make23.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('PLUGIN_NAME', 'ToolPage&trade;');
define('PLUGIN_PATH', ABSPATH.'wp-content/plugins/toolpage');
define('PLUGIN_PATH_TWO', ABSPATH.'wp-content/plugins/');

define('STELLINA', '<span style="color:red"><strong>*</strong></span>');

// Definisco la path a wp-content se non è definita
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
}

// Definisco la path a wp-admin se non è definita
if (!defined('WP_ADMIN_URL')) {
	define('WP_ADMIN_URL', get_option('siteurl').'/wp-admin');
}

require_once PLUGIN_PATH.'/includes/default.settings.php';

//if($_POST['uninstalltoolpage']){
/*if (defined( 'WP_UNINSTALL_PLUGIN' ) ){
	require_once PLUGIN_PATH.'/includes/uninstall.php';
    toolpage_plugin_uninstall();
}*/

/* Installo il plugin */
register_activation_hook(__FILE__,'toolpage_plugin_install');
require_once PLUGIN_PATH.'/includes/install.php';

/* Uninstall il plugin */
register_uninstall_hook(__FILE__,'toolpage_plugin_uninstall');
require_once PLUGIN_PATH.'/includes/uninstall.php';

/* Deactive il plugin */
/*register_deactivation_hook( __FILE__, array( 'ToolPageInit', 'toolpage_plugin_deactive' ) );
require_once PLUGIN_PATH.'/includes/deactive.php';*/

/* Aggiungo il menu admin */
add_action('admin_menu', 'toolpage_plugin_admin_menu');

require_once PLUGIN_PATH.'/includes/functions.php';

function toolpage_init() {
	
 load_plugin_textdomain( 'toolpage', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
 
 /* Update/Upgrade */
 updateInit();
}
add_action('plugins_loaded', 'toolpage_init');

/* Sovrascrivi se una ToolPage is_home=1 */
add_action('template_redirect', 'tp_sovrascrivihome');


require_once PLUGIN_PATH.'/includes/widget.php';
// register ToolPage_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "toolpage_widget" );' ) );


/* Aggiungo Links alla Admin Toolbar */
add_action( 'admin_bar_menu', 'toolbar_toolpage', 999 );

/*add_action('admin_notices', 'tp_admin_notice_update');
add_action('admin_notices', 'tp_admin_notice_error');*/
?>
