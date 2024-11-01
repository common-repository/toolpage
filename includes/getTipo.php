<?php
	echo 'Ecco: '.$_GET['t'].' -'.PLUGIN_NAME;
	
		wp_editor( '', 'content-id', array( 'textarea_name' => 'content', 'media_buttons' => true ) );

?>