<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Custom theme actions/functions
	- Add specific IE styling/hacks to HEAD
	- Add custom styling
	- Set global php variables
- Custom hook definitions

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Custom functions */
/*-----------------------------------------------------------------------------------*/

// Add specific IE styling/hacks to HEAD
add_action('wp_head','woo_IE_head');
function woo_IE_head() {
?>

<!--[if IE 6]>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/pngfix.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/menu.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ie6.css" />
<![endif]-->	

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ie7.css" />
<![endif]-->

<!--[if IE 8]>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/ie8.css" />
<![endif]-->

<?php
}

// Add custom styling
add_action('woo_head','woo_custom_styling');
function woo_custom_styling() {
	
	// Get options
	$link = get_option('woo_link_color');
	$hover = get_option('woo_link_hover_color');
	$button = get_option('woo_button_color');
	$bg = get_option('woo_style_bg');
	$bg_image = get_option('woo_style_bg_image');
	$bg_image_repeat = get_option('woo_style_bg_image_repeat');		
		
	// Add CSS to output
	if ($link)
		$output .= 'a:link, a:visited {color:'.$link.'}' . "\n";
	if ($hover)
		$output .= 'a:hover {color:'.$hover.'}' . "\n";
	if ($button)
		$output .= '.button, .reply a {background-color:'.$button.'}' . "\n";
	if ($bg)
		$output .= '#wrapper {background-color:'.$bg.'}' . "\n";
	if ($bg_image)
		$output .= '#wrapper {background-image:url('.$bg_image.')}' . "\n";
	if ($bg_image_repeat)
		$output .= '#wrapper {background-repeat:'.$bg_image_repeat.';background-position:top center;}' . "\n";
		
	// Output styles
	if (isset($output)) {
		$output = "<!-- Woo Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
		echo $output;
	}
		
} 

// Set global php variables
add_action('woo_head','woo_globals');
function woo_globals() {	
	
	// Set global Event Calendar Post thumbnail dimensions
	$GLOBALS['feat_align'] = 'alignleft'; $align = get_option('woo_feat_align'); if ($align) $GLOBALS['feat_align'] = $align; 
	
	$GLOBALS['feat_w'] = '100'; $thumb_w =  get_option('woo_feat_w'); if ($thumb_w) $GLOBALS['feat_w'] = $thumb_w;	
	$GLOBALS['feat_h'] = '100'; $thumb_h =  get_option('woo_feat_h'); if ($thumb_w) $GLOBALS['feat_h'] = $thumb_h;	
	
	// Set global Featured Panel Post thumbnail dimensions
	$GLOBALS['slider_align'] = 'aligncenter'; $align = get_option('woo_slider_align'); if ($align) $GLOBALS['slider_align'] = $align; 
	
	$GLOBALS['slider_w'] = '100'; $thumb_w =  get_option('woo_slider_w'); if ($thumb_w) $GLOBALS['slider_w'] = $thumb_w;	
	$GLOBALS['slider_h'] = '100'; $thumb_h =  get_option('woo_slider_h'); if ($thumb_w) $GLOBALS['slider_h'] = $thumb_h;

	// Set global Thumbnail dimensions and alignment
	$GLOBALS['thumb_align'] = 'alignleft'; $align = get_option('woo_thumb_align'); if ($align) $GLOBALS['thumb_align'] = $align; 		
	$GLOBALS['thumb_w'] = '100'; $thumb_w =  get_option('woo_thumb_w'); if ($thumb_w) $GLOBALS['thumb_w'] = $thumb_w;	
	$GLOBALS['thumb_h'] = '100'; $thumb_h =  get_option('woo_thumb_h'); if ($thumb_w) $GLOBALS['thumb_h'] = $thumb_h;	

	// Set global Single Post thumbnail dimensions
	$GLOBALS['thumb_single'] = 'false'; $enable =  get_option('woo_thumb_single'); if ($enable) $GLOBALS['thumb_single'] = $enable;	
	$GLOBALS['single_h'] = '150'; $single_h =  get_option('woo_single_h'); if ($thumb_w) $GLOBALS['single_h'] = $single_h;	
	$GLOBALS['single_w'] = '150'; $single_w =  get_option('woo_single_w'); if ($thumb_w) $GLOBALS['single_w'] = $single_w;	
	
	// Featured Tags
	$GLOBALS['feat_tags_array'] = array();

	// Duplicate posts 
	$GLOBALS['shownposts'] = array();

}



/*-----------------------------------------------------------------------------------*/
/* Custom Hook definition */
/*-----------------------------------------------------------------------------------*/

// Add any custom hook definitions you want here
// function woo_hook_name() { do_action( 'woo_hook_name' ); }					

?>