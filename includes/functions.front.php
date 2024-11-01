<?php
function initToolPage(){
	global $wp, $wpdb, $table_prefix, $shortcode_tags;
	
	if(get_query_var('ttoolpage_id') != ''){
		$t_id = get_query_var('ttoolpage_id');
	}
	else{
		$t_id = $wp->query_vars['toolpage_id'];
	}
	
	$toolpage = $wpdb->get_row("SELECT * FROM ".$table_prefix."toolpage WHERE url='".$t_id."' AND active='1'");
	
	return $toolpage;
}

function initToolPageBoxTipo($toolpage_id){
	global $wp, $wpdb, $table_prefix, $shortcode_tags;
	
	$tipo_box = getTipologieBox($toolpage_id, $table_prefix.'toolpage_box', $table_prefix.'toolpage_box_relazioni');
	
	return $tipo_box;
}

function initToolPageBox($toolpage_id){
	global $wp, $wpdb, $table_prefix, $shortcode_tags;
	
	$toolpage_box = $wpdb->get_results("SELECT * FROM ".$table_prefix."toolpage_box_relazioni tbr LEFT JOIN ".$table_prefix."toolpage_box tb ON tbr.box_id=tb.box_id WHERE tbr.toolpage_id='".$toolpage_id."' AND tb.box_active='1' ORDER BY tbr.ordine_relazioni ASC");
	
	return $toolpage_box;
}

function getTipologieBox($toolpage_id, $table_name_box, $table_name_box_relazioni){
	global $wpdb;
	$ds = $wpdb->get_results("SELECT tb.box_tipo FROM $table_name_box_relazioni tbr LEFT JOIN $table_name_box tb ON tbr.box_id=tb.box_id WHERE tbr.toolpage_id='".$toolpage_id."' GROUP BY tb.box_tipo");
	
	foreach($ds as $d){
		$a[] = $d->box_tipo;
	}
	
	if(isset($a)) $a = $a;
	else $a = '';
	return $a;
}

function getToolpageFooter($toolpage_id){
	global $wpdb;
	$table_name_settings = $wpdb->prefix . "toolpage_settings"; 
	$r = $wpdb->get_row("SELECT nome, valore FROM $table_name_settings WHERE nome='powered' LIMIT 1");
	
	if($r->valore ==  '1'){
		return '<div id="toolpage_footer"><a href="http://www.make23.com/"><strong>ToolPage&trade;</strong> '.__('is a Plugin Developed by Make23 &reg;', 'toolpage').'</a></div>';
	}
	else return '';
}
?>