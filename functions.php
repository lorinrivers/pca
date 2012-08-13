<?php 
ob_start(); 
$functions_path = TEMPLATEPATH . '/functions/';
$includes_path = TEMPLATEPATH . '/includes/';
require_once ($functions_path . 'admin-init.php');			// Framework Init
require_once ($includes_path . 'theme-options.php'); 		// Options panel settings and custom settings
require_once ($includes_path . 'theme-functions.php'); 		// Custom theme functions
require_once ($includes_path . 'theme-comments.php'); 		// Custom comments/pingback loop
require_once ($includes_path . 'theme-js.php');				// Load javascript in wp_head
require_once ($includes_path . 'sidebar-init.php');			// Initialize widgetized areas
require_once ($includes_path . 'theme-widgets.php');		// Theme widgets
require_once ($includes_path . 'theme-actions.php');		// Theme actions & user defined hooks

// custom metaboxes and such
// Initialize the metabox class
add_action( 'init', 'lr_initialize_cmb_meta_boxes', 9999 );
function lr_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib/metabox/init.php' );
	}
}

// Create PCA Session metaboxes
$prefix = '_lr_';
add_filter( 'cmb_meta_boxes', 'lr_create_metaboxes' );
function lr_create_metaboxes( $meta_boxes ) {
	global $prefix;
  $meta_boxes[] = array(
    'id' => 'pcasession',
    'title' => 'PCA Session',
    'pages' => array('pca_session'), 
    'context' => 'normal',
    'priority' => 'high',
    'show_names' => true, //Show field names left of input
    'fields' => array(
      array(
        'name' => 'Session Title',
        'desc' => 'Title of your session.',
        'id' => $prefix.'session_title',
        'type' => 'text'
      ),
      array(
        'name' => 'Session Description',
        'desc' => 'Write this to sell your session. Make it compelling. (Limit - 150 words)',
        'id' => $prefix.'session_description',
        'type' => 'textarea'
      ),
      array(
        'name' => 'Session Category',
        'desc' => 'Please choose the appropriate category.',
        'id' => $prefix.'session_category',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Product Strategy', 'value' => 'product_strategy', ),
					array( 'name' => 'Product Development', 'value' => 'product_development', ),
					array( 'name' => 'Opportunity Analysis', 'value' => 'opportunity_analysis', ),
					array( 'name' => 'Product Strategy', 'value' => 'product_strategy', ),
					array( 'name' => 'Prod Mgmt Careers', 'value' => 'prod_mgmt_careers', ),
					array( 'name' => 'Go-to-Market', 'value' => 'go-to-market', ),
					array( 'name' => 'Marketing Execution', 'value' => 'marketing_execution', ),
				),
      ),
      array(
        'name' => 'Session Audience',
        'desc' => 'Please choose the appropriate audience.',
        'id' => $prefix.'session_audience',
        'type' => 'select',
        'options' => array(
					array( 'name' => 'PM Essentials', 'value' => 'pm_essentials', ),
					array( 'name' => 'PM Advanced', 'value' => 'pm_advanced', ),
					array( 'name' => 'PM for Entrepreneurs', 'value' => 'pm_for_entrepreneurs', ),
				),
      ),
      array(
        'name' => 'Session Format',
        'desc' => 'Please choose the appropriate format.',
        'id' => $prefix.'session_format',
        'type' => 'select',
        'options' => array(
					array( 'name' => 'Town Hall', 'value' => 'town_hall', ),
					array( 'name' => 'Presentation', 'value' => 'presentation', ),
					array( 'name' => 'Other', 'value' => 'other', ),
					array( 'name' => 'Workshop', 'value' => 'workshop', ),
					array( 'name' => 'Roundtable Breakout', 'value' => 'roundtable_breakout', ),
				),
      ),
      array(
        'name' => 'Session Leader',
        'desc' => 'Session leader’s name',
        'id' => $prefix.'leader_1_name',
        'type' => 'text'
      ),
      array(
        'name' => 'Session Leader Bio',
        'desc' => 'Brief biography of the session leader',
        'id' => $prefix.'leader_1_bio',
        'type' => 'textarea'
      ),
      array(
        'name' => 'Session Leader 2',
        'desc' => 'Second session leader’s name',
        'id' => $prefix.'leader_2_name',
        'type' => 'text'
      ),
      array(
        'name' => 'Session Leader 2 Bio',
        'desc' => 'Brief biography of the second session leader',
        'id' => $prefix.'leader_2_bio',
        'type' => 'textarea'
      ),
      array(
        'name' => 'Session Leader 3',
        'desc' => 'Third session leader’s name',
        'id' => $prefix.'leader_3_name',
        'type' => 'text'
      ),
      array(
        'name' => 'Session Leader 3 Bio',
        'desc' => 'Brief biography of the third session leader',
        'id' => $prefix.'leader_3_bio',
        'type' => 'textarea'
      ),
      array(
        'name' => 'Session Leader 4',
        'desc' => 'Fourth session leader’s name',
        'id' => $prefix.'leader_4_name',
        'type' => 'text'
      ),
      array(
        'name' => 'Session Leader 4 Bio',
        'desc' => 'Brief biography of the fourth session leader',
        'id' => $prefix.'leader_4_bio',
        'type' => 'textarea'
      ),
    ),
  );

  return $meta_boxes;

}


// Set up PCA Sessions
add_action('init', 'lr_create_pca_sessions_post_type');

function lr_create_pca_sessions_post_type() {
register_post_type('pca_session', 
  array(
    'labels' => array(
    'name' => __('PCA Sessions'),
    'singular_name' => __('PCA Session')
  ),
    'public' => true,
    'supports' => array(''),
    'rewrite' => array('slug' => 'pca_sessions'),
    'has_archive' => true,
  )
);
}

?>

