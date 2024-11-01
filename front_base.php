<?php
/* ############################################################### */
/* ############################################################### */
/* ############################################################### */
include('./wp-content/plugins/toolpage/includes/functions.front.php');
$toolpage 	  = initToolPage();
$tipo_box 	  = initToolPageBoxTipo($toolpage->id);
$toolpage_box = initToolPageBox($toolpage->id);
/* ############################################################### */
/* ############################################################### */
/* ############################################################### */

/*$wpdb->show_errors();
$wpdb->print_error();*/
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title><?php if($toolpage->seo_titolo != '') echo $toolpage->seo_titolo; else echo $toolpage->titolo; ?></title>
<meta name="description" content="<?php if($toolpage->seo_descrizione != '') echo $toolpage->seo_descrizione; else echo $toolpage->titolo; ?>" />
<?php
if($toolpage->seo_robots != ''){
?>
<meta name="robots" content="<?php echo $toolpage->seo_robots; ?>" />
<?php
}
?>
<?php //wp_head(); ?>
<style>
	html, body, div, div#toolpage p, ul.menubox, ul.box, u.toolpage_box_menu, ul.sub-menu{
		margin:0px;
		padding:0px;
	}
	body{
		font-family:<?php echo $toolpage->font; ?>;
		font-size: <?php echo $toolpage->font_size; ?>;
		color: <?php echo $toolpage->font_color; ?>;
		background:<?php echo $toolpage->background_color; ?>;
	}
	a, a:link, a:visited{
		color: <?php echo $toolpage->font_color_links; ?>;
	}
	a:hover{
		color: <?php echo $toolpage->font_color_links_hover; ?>;
	}
	div#toolpage{
		width:<?php echo str_replace("&#37;", "%", $toolpage->larghezza); ?>;
		margin:auto;
		background:<?php echo $toolpage->background_color_contenitore; ?>;
		padding-top: 10px;
		padding-left:20px;
	}
	div#toolpage_footer{
		clear:both; 
		display:block; 
		background:#333;
		color:#fff; 
		padding:10px;
		font-size:0.7em;
		text-align:right;
	}
	div#toolpage_footer a:link, div#toolpage_footer a:visited{
		color:#FFFFFF;
		text-decoration:none;
	}
	div#toolpage_footer a:hover{
		color:#999;
		text-decoration:underline;
	}
	.clear{
		clear:both;
	}
	
	.box{
		padding:10px;
		margin-bottom:10px
	}
	.box div.box_title{
		padding-top:5px;
		padding-bottom:5px;
		font-size: 1.2em;
	}
	
	div#container{ margin:0 auto }

	ul.toolpage_box_menu{
	}

	ul.toolpage_box_menu li ul.sub-menu{
		display:none;
	}
		
	ul.toolpage_box_menu li{
		list-style:none;
		float:left;
		padding-left:4px;
		padding-right:4px;
		margin-bottom:4px;
	}
<?php
if($toolpage->css_editor != ''){
?>
/* CSS Personalizzati */
/* ########################################## */
<?php echo $toolpage->css_editor; ?>
<?php
}
?>	
</style>
<script type='text/javascript' src='<?php echo includes_url(  ); ?>js/jquery/jquery.js?ver=1.8.3'></script>
<?php
if(@in_array("form", $tipo_box)){
	//echo $d->box_tipo.'---<br>';
?>
<link rel='stylesheet' id='contact-form-7-css'  href='<?php echo plugins_url(); ?>/contact-form-7/includes/css/styles.css?ver=3.3.3' type='text/css' media='all' />

<script type='text/javascript' src='<?php echo plugins_url(); ?>/contact-form-7/includes/js/jquery.form.min.js?ver=3.25.0-2013.01.18'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var _wpcf7 = {"loaderUrl":"<?php echo plugins_url(); ?>/contact-form-7\/images\/ajax-loader.gif","sending":"Invio..."};
/* ]]> */
</script>
<script type='text/javascript' src='<?php echo plugins_url(); ?>/contact-form-7/includes/js/scripts.js?ver=3.3.3'></script>
<?php
}
?>
<?php echo $toolpage->google_editor; ?>
</head>

<body>

    <div id="toolpage">        
<?php
	if(sizeof($toolpage_box) > 0){
?>
        <div id="container">
<?php
		$i = 1;
	    foreach ($toolpage_box as $data) {
			$data->value = do_shortcode($data->value);
?>
            <div class="box box_<?php echo $data->box_tipo; ?>" style="border:<?php echo $data->box_border_size; ?>px solid <?php echo $data->box_border_color.';'; ?><?php if($data->box_background != '') echo ' background-color:'.$data->box_background.';'; ?><?php if($data->box_height != '') echo ' height:'.$data->box_height.';'; ?>">
<?php
			switch($data->box_tipo){
				case 'text':
?>            	
                <div class="box_title"><?php echo $data->box_titolo; ?></div>
                
            	<?php echo $data->value; ?>
<?php
				break;
				case 'image':
?>            	
                <?php echo $data->value; ?>
                
<?php
				break;
				case 'form':
?>            	
				<br class="clear" />
                
                <div>
                <link rel='stylesheet' id='contact-form-7-css'  href='<?php echo plugins_url(); ?>/contact-form-7/includes/css/styles.css?ver=3.3.3' type='text/css' media='all' />
                
                
                <?php echo do_shortcode('[contact-form-7 id="'.$data->value.'"]'); ?>

                </div>
                
<?php
				break;
				case 'menu':
					$defaults = array(
						'theme_location'  => '',
						'menu'            => $data->value,
						//'container'       => 'div',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => 'menu menubox',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => false,
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="toolpage_box_menu %2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => ''
					);
					
					wp_nav_menu( $defaults );
				break;
				case 'twitter':
				$widget_id = explode("|", $data->parametri);
?>            	
                <div>
                	<a class="twitter-timeline" href="https://twitter.com/twitterapi" data-widget-id="<?php echo $widget_id[1]; ?>" data-theme="light" data-link-color="<?php echo $toolpage->font_color_links; ?>"  data-related="Make23Creations,apptokids" data-aria-polite="assertive" width="100%" height="<?php if($data->box_height != '') echo str_replace("px", "", $data->box_height); else echo '500'; ?>" lang="IT">Tweet di @<?php echo $data->value; ?></a>
                    <br class="clear" />
                </div>
<?php
				break;
				case 'facebook':
				$mparametri = explode("|", $data->parametri);
?>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($data->value); ?>&amp;show_faces=<?php echo $mparametri[5]; ?>&amp;colorscheme=<?php echo $mparametri[4]; ?>&amp;stream=<?php echo $mparametri[3]; ?>&amp;border_color=<?php if($mparametri[2] != '') echo str_replace("#", "%2", $mparametri[2]); else echo '%2333'; ?>&amp;header=<?php echo $mparametri[1]; ?>&amp;appId=372911329387676" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:<?php if($data->box_height != '') echo $data->box_height; else echo '590px'; ?>;" allowTransparency="true"></iframe>
<?php
				break;
				case 'youtube':
?>
					<iframe width="100%" style="min-height:<?php if($data->box_height != '') echo $data->box_height; else echo '590px'; ?>" src="<?php echo $data->value; ?>" frameborder="0" allowfullscreen></iframe>
<?php
				break;
			}
?>            	
                <br class="clear" />
            </div>
<?php
			$i++;
		}
?>
        </div>
<?php
	}
	else{
?>
		<br />
        
        <p>
			<em>Devi definire i box da visualizzare in questa ToolPage&trade;!</em>
        </p>
<?php	
	}
?>
        
        <br class="clear" />
    </div>
    
	<br class="clear" />
    
    	<?php echo getToolpageFooter($toolpage->id); ?>
    
    <script src="<?php echo plugins_url(); ?>/toolpage/js/jquery.masonry.min.js"></script>
    <script>
		  var larghezzaBox = ((jQuery("#container").width() / <?php echo $toolpage->schema_box; ?>)-30-10);
		  jQuery(".box").css("width", larghezzaBox);
		  jQuery(".box").css("overflow", "hidden");
		  //jQuery(".box").css("marginLeft", "10px");
		  //jQuery(".box").css("marginBottom", "10px");
		  
		var $container = jQuery('#container');
		$container.imagesLoaded(function(){
		  $container.masonry({
			itemSelector : '.box',
			//columnWidth : 240,
			columnWidth: function( containerWidth ) {
				//alert("---"+containerWidth<?php //echo $toolpage->schema_box; ?>);
				return containerWidth / <?php echo $toolpage->schema_box; ?>;
			},
			//isAnimated: true,
			/*animationOptions: {
			duration: 750,
			easing: 'linear',
			queue: false
			},*/
			/*
			// FLUID - set columnWidth a fraction of the container width
			columnWidth: function( containerWidth ) {
				return containerWidth / 5;
			}
			*/
			isFitWidth: true
		  });
		});
		
		  
		  //alert(jQuery("#container").width());
		  //alert(larghezzaBox);
    </script>
    
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<?php //wp_footer(); ?>
</body>
</html>