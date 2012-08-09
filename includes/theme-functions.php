<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Page / Post navigation
- WooTabs - Popular Posts
- WooTabs - Latest Posts
- WooTabs - Latest Comments
- Misc
- iCal Creator - Individual Post
- Custom Datepicker Validation
- Woo Google Mapping
- WordPress 3.0 New Features Support

-----------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------*/
/* Page / Post navigation */
/*-----------------------------------------------------------------------------------*/
function woo_pagenav() { 

	if (function_exists('wp_pagenavi') ) { ?>
    
<?php wp_pagenavi(); ?>
    
	<?php } else { ?>    
    
		<?php if ( get_next_posts_link() || get_previous_posts_link() ) { ?>
        
            <div class="nav-entries">
                <div class="nav-prev fl"><?php previous_posts_link(__('&laquo; Newer Entries ', 'woothemes')) ?></div>
                <div class="nav-next fr"><?php next_posts_link(__(' Older Entries &raquo;', 'woothemes')) ?></div>
                <div class="fix"></div>
            </div>	
        
		<?php } ?>
    
	<?php }   
}                	

function woo_postnav() { 

	?>
        <div class="post-entries">
            <div class="post-prev fl"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
            <div class="post-next fr"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
            <div class="fix"></div>
        </div>	

	<?php 
}                	



/*-----------------------------------------------------------------------------------*/
/* WooTabs - Popular Posts */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('woo_tabs_popular')) {
	function woo_tabs_popular( $posts = 5, $size = 35 ) {
		global $post;
		$popular = get_posts('orderby=comment_count&posts_per_page='.$posts);
		foreach($popular as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) woo_image('height='.$size.'&width='.$size.'&class=thumbnail&single=true'); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach;
	}
}



/*-----------------------------------------------------------------------------------*/
/* WooTabs - Latest Posts */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('woo_tabs_latest')) {
	function woo_tabs_latest( $posts = 5, $size = 35 ) {
		global $post;
		$latest = get_posts('showposts='. $posts .'&orderby=post_date&order=desc');
		foreach($latest as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) woo_image('height='.$size.'&width='.$size.'&class=thumbnail&single=true'); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach; 
	}
}



/*-----------------------------------------------------------------------------------*/
/* WooTabs - Latest Comments */
/*-----------------------------------------------------------------------------------*/

function woo_tabs_comments( $posts = 5, $size = 35 ) {
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
	comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
	comment_type,comment_author_url,
	SUBSTRING(comment_content,1,50) AS com_excerpt
	FROM $wpdb->comments
	LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
	$wpdb->posts.ID)
	WHERE comment_approved = '1' AND comment_type = '' AND
	post_password = ''
	ORDER BY comment_date_gmt DESC LIMIT ".$posts;
	
	$comments = $wpdb->get_results($sql);
	
	foreach ($comments as $comment) {
	?>
	<li>
		<?php echo get_avatar( $comment, $size ); ?>
	
		<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php _e('on ', 'woothemes'); ?> <?php echo $comment->post_title; ?>">
			<?php echo strip_tags($comment->comment_author); ?>: <?php echo strip_tags($comment->com_excerpt); ?>...
		</a>
		<div class="fix"></div>
	</li>
	<?php 
	}
}

/*-----------------------------------------------------------------------------------*/
/* CUSTOM EXCERPT */
/*-----------------------------------------------------------------------------------*/

// Shorten Excerpt text for use in theme
function woo_excerpt($text, $chars = 120) {
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."...";
	return $text;
}


/*-----------------------------------------------------------------------------------*/
/* MISC */
/*-----------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------*/
/* iCal Creator - Individual Post */
/*-----------------------------------------------------------------------------------*/

function woo_get_ical($post_id,$php_formatting) {
	//Include iCal creator class
	require_once('ical/iCalcreator.class.php');
	//Get event post
	$woo_cal_post = get_post($post_id);
	//Check if post exists
	if ($woo_cal_post) {
		//Get location
		$event_location = get_post_meta($post_id,'event_location',true);
		//Start dates and times
		$event_start_year = date('Y',strtotime(get_post_meta($post_id,'event_start_date',true)));
		$event_start_month = date('m',strtotime(get_post_meta($post_id,'event_start_date',true)));
		$event_start_day = date('d',strtotime(get_post_meta($post_id,'event_start_date',true)));
		//End dates and times
		$event_end_year = date('Y',strtotime(get_post_meta($post_id,'event_end_date',true)));
		$event_end_month = date('m',strtotime(get_post_meta($post_id,'event_end_date',true)));
		$event_end_day = date('d',strtotime(get_post_meta($post_id,'event_end_date',true)));
		//Start and end Times
		$start_time = get_post_meta($post_id,'event_start_time',true);
		$end_time = get_post_meta($post_id,'event_end_time',true);
		if (($start_time != '') && ($start_time != ':')) { $event_start_time = explode(":",$start_time); }
		if (($end_time != '') && ($end_time != ':')) { $event_end_time = explode(":",$end_time); }
		// initiate new CALENDAR
		$v = new vcalendar();                          
		// initiate a new EVENT
		$e = new vevent();  
		// categorize                           
		$e->setProperty( 'categories' , 'Events' );                   
		// YY MM dd hh mm ss
		if (isset($event_start_time)) { $e->setProperty( 'dtstart' 	,  $event_start_year, $event_start_month, $event_start_day, $event_start_time[0], $event_start_time[1], 00 ); } else { $e->setProperty( 'dtstart' ,  $event_start_year, $event_start_month, $event_start_day ); }
		if (isset($event_end_time)) { $e->setProperty( 'dtend'   	,  $event_end_year, $event_end_month, $event_end_day, $event_end_time[0], $event_end_time[1], 00 );  } else { $e->setProperty( 'dtend' , $event_end_year, $event_end_month, $event_end_day );  }
		//Event description
		$e->setProperty( 'description' 	, strip_tags($woo_cal_post->post_excerpt) ); 
		//Event location  
		if (isset($event_location)) { $e->setProperty( 'location'	, $event_location ); } else { $e->setProperty( 'location'	, 'Unknown' );  }   
		//Event Summary
		$e->setProperty( 'summary'	, $woo_cal_post->post_title );                 
		// add component to calendar
		$v->addComponent( $e );                        
		//Setup URLs
		$templateurl = get_bloginfo('template_url').'/cache/';
		$siteurl = get_bloginfo('url');
		$dir = str_replace($siteurl,'',$templateurl);
		$dir = str_replace('/wp-content/','wp-content/',$dir);
		//Save file to cache folder
		$v->setConfig( 'directory', $dir ); 
		$v->setConfig( 'filename', 'event-'.$post_id.'.ics' ); 
		$v->saveCalendar(); 
		//Set iCal Output URL
		$output['ical'] = $templateurl.'event-'.$post_id.'.ics';
		//Google Timezone Conversion
		$wp_offset = get_option('gmt_offset');
		$wp_timezone_string = get_option('timezone_string');
		if ($wp_offset == '') {
			$wp_offset = wp_timezone_override_offset();
		}
		$wp_offset_array = explode('.',$wp_offset);
		//Start times conversions
		$google_start_time[0] = $event_start_time[0] - $wp_offset_array[0];
		if ( $wp_offset_array[0] < 0 ) {
			$google_start_time[1] = $event_start_time[1] + ( ($wp_offset_array[1] / 100) * 60 );
		} else {
			$google_start_time[1] = $event_start_time[1] - ( ($wp_offset_array[1] / 100) * 60 );
		}
		//check if conversion changes the start date a day before current
		//minutes
		if ( $google_start_time[1] >= 60 ) {
			$google_start_time[0] = $google_start_time[0] + 1;
			$google_start_time[1] = $google_start_time[1] - 60;	
		}
		elseif ( $google_start_time[1] < 0 ) {
			$google_start_time[0] = $google_start_time[0] - 1;
			$google_start_time[1] = 60 + $google_start_time[1];
		}
		//hours
		if ( $google_start_time[0] < 0 ) {
			$google_start_time[0] = 24 + $google_start_time[0];
			$event_start_day = $event_start_day - 1;
		}
		//check if conversion changes the start date a day after current
		elseif ( $google_start_time[0] > 24 ) {
			$google_start_time[0] = $google_start_time[0] - 24;
			$event_start_day = $event_start_day + 1;
		}
		//End times conversions
		$google_end_time[0] = $event_end_time[0] - $wp_offset_array[0];
		if ( $wp_offset_array[0] < 0 ) {
			$google_end_time[1] = $google_end_time[1] + ( ($wp_offset_array[1] / 100) * 60 );
		} else {
			$google_end_time[1] = $google_end_time[1] - ( ($wp_offset_array[1] / 100) * 60 );
		}
		//check if conversion changes the end date a day before current
		//minutes
		if ( $google_end_time[1] >= 60 ) {
			$google_end_time[0] = $google_end_time[0] + 1;
			$google_end_time[1] = '00';	
		}
		elseif ( $google_end_time[1] < 0 ) {
			$google_end_time[0] = $google_end_time[0] - 1;
			$google_end_time[1] = 60 + $google_end_time[1];
		}
		//hours
		if ( $google_end_time[0] < 0 ) {
			$google_end_time[0] = 24 + $google_end_time[0];
			$event_end_day = $event_end_day - 1;
		}
		//check if conversion changes the end date a day after current
		elseif ( $google_end_time[0] > 24 ) {
			$google_end_time[0] = $google_end_time[0] - 24;
			$event_end_day = $event_end_day + 1;
		}
		//Account for single digit result - hours
		if ($google_start_time[0] < 10) {
			$google_start_time[0] = '0'.$google_start_time[0];
		}
		if ($google_end_time[0] < 10) {
			$google_end_time[0] = '0'.$google_end_time[0];
		}
		//Account for single digit result - minutes
		if ($google_start_time[1] < 10) {
			$google_start_time[1] = '0'.$google_start_time[1];
		}
		if ($google_end_time[1] < 10) {
			$google_end_time[1] = '0'.$google_end_time[1];
		}
		//Set Google Output URL
		$google_url = "http://www.google.com/calendar/event?action=TEMPLATE";
		$google_url .= "&text=".$woo_cal_post->post_title;
		if (isset($event_start_time) && isset($event_end_time)) { $google_url .= "&dates=".$event_start_year.$event_start_month.$event_start_day."T".$google_start_time[0].$google_start_time[1]."00Z/".$event_end_year.$event_end_month.$event_end_day."T".$google_end_time[0].$google_end_time[1]."00Z"; } else { $google_url .= "&dates=".$event_start_year.$event_start_month.$event_start_day."/".$event_end_year.$event_end_month.$event_end_day; }
		$google_url .= "&sprop=website:".$siteurl;
		$google_url .= "&details=".strip_tags($woo_cal_post->post_excerpt);
		if (isset($event_location)) { $google_url .= "&location=".$event_location; } else { $google_url .= "&location=Unknown"; }
		$google_url .= "&trp=true";
		$output['google'] = $google_url;	
	}
	else {
		//Default Output URL
		$siteurl = get_bloginfo('url');
		$output['ical'] = $siteurl;
		$output['google'] = $siteurl;
	}
	return $output;
} 


/*-----------------------------------------------------------------------------------*/
/* Custom Datepicker Validation */
/*-----------------------------------------------------------------------------------*/

add_action('admin_head', 'woo_custom_date_jquery');

function woo_custom_date_jquery() {
	?>
	<script type="text/javascript" language="javascript">
	jQuery(document).ready(function(){
			
		//CUSTOM JQUERY DATEPICKER
		if (jQuery('#event_start').length) {
			jQuery('#event_start').datepicker({
				showOn: 'button', 
				buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', 
				buttonImageOnly: true,
				onSelect: function(dateText, inst) { 
					var nextDate = new Date(dateText);
					var endDate = new Date(jQuery('#event_end').datepicker('getDate'));
					if (nextDate > endDate) {
						jQuery('#event_end').datepicker('setDate', nextDate );
					}
				}
			});
		}
		if (jQuery('#event_end').length) {
			jQuery('#event_end').datepicker({
				showOn: 'button', 
				buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', 
				buttonImageOnly: true,
				onSelect: function(dateText, inst) { 
					var nextDate = new Date(dateText);
					var startDate = new Date(jQuery('#event_start').datepicker('getDate'));
					if (nextDate < startDate) {
						jQuery('#event_start').datepicker('setDate', nextDate );
					}
				}
			});
		}
		if (jQuery('#woo_start_calendar_range').length) {
			jQuery('#woo_start_calendar_range').datepicker({
				showOn: 'button', 
				buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', 
				buttonImageOnly: true,
				onSelect: function(dateText, inst) { 
					var nextDate = new Date(dateText);
					var endDate = new Date(jQuery('#woo_end_calendar_range').datepicker('getDate'));
					if (nextDate > endDate) {
						jQuery('#woo_end_calendar_range').datepicker('setDate', nextDate );
					}
				}
			});
		}
		if (jQuery('#woo_end_calendar_range').length) {
			jQuery('#woo_end_calendar_range').datepicker({
				showOn: 'button', 
				buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', 
				buttonImageOnly: true,
				onSelect: function(dateText, inst) { 
					var nextDate = new Date(dateText);
					var startDate = new Date(jQuery('#woo_start_calendar_range').datepicker('getDate'));
					if (nextDate < startDate) {
						jQuery('#woo_start_calendar_range').datepicker('setDate', nextDate );
					}
				}
			});
		}
	});
	</script>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Woo Google Mapping */
/*-----------------------------------------------------------------------------------*/
function woo_maps_single_output($address,$long,$lat,$zoom,$type){

	$key = get_option('woo_maps_apikey');
	if(empty($key)){ ?>
	 Please enter your <strong>API Key</strong> before using the maps.
    <?php
	} else {
	
	$map_height = get_option('woo_maps_single_height');
	$featured_w = get_option('woo_home_featured_w');
	$featured_h = get_option('woo_home_featured_h');
	
	if(is_home() OR is_front_page()) { $map_height = get_option('woo_home_featured_h'); }
	if(empty($map_height)) { $map_height = 250;}
	
	if(is_home() && !empty($featured_h) && !empty($featured_w)){
	?>
    <div id="single_map_canvas" style="width:<?php echo $featured_w; ?>px; height: <?php echo $featured_h; ?>px"></div>
    <?php } else { ?> 
    <div id="single_map_canvas" style="width:100%; height: <?php echo $map_height; ?>px"></div>
    <?php } ?>
    <script type="text/javascript">
		jQuery(document).ready(function(){
			function initialize() {
			  var map = new GMap2(document.getElementById("single_map_canvas"));
			  map.setUIToDefault();
			  <?php if(get_option('woo_maps_scroll') == 'true'){ ?>
			  map.disableScrollWheelZoom();
			  <?php } ?>
			  map.setMapType(<?php echo $type; ?>);
			  map.setCenter(new GLatLng(<?php echo $lat; ?>,<?php echo $long; ?>), <?php echo $zoom; ?>);
			  var point = new GLatLng(<?php echo $lat; ?>,<?php echo $long; ?>);
				map.addOverlay(new GMarker(point));
			  }
			
		
		initialize();
			
		});
	</script>
    <?php } ?>

<?php
}

function woothemes_metabox_maps_create() {
    global $post;
	$enable = get_post_meta($post->ID,'woo_maps_enable',true);
	$address = get_post_meta($post->ID,'woo_maps_address',true);
	$long = get_post_meta($post->ID,'woo_maps_long',true);
	$lat = get_post_meta($post->ID,'woo_maps_lat',true);
	$zoom = get_post_meta($post->ID,'woo_maps_zoom',true);
	$type = get_post_meta($post->ID,'woo_maps_type',true);
	
	if(empty($zoom)) $zoom = 8;
	

	
	$key = get_option('woo_maps_apikey');
	if(empty($key)){ ?>
	
	Please enter your <strong>API Key</strong> before using the maps.
    
    <?php
	} else {
	
	?>
    <p>
    <table><tr><td width="200"><b>Search for an address:</b></td>
    <td><input class="address_input" type="text" size="40" value="" name="woo_maps_search_input" id="woo_maps_search_input"/><span class="button" id="woo_maps_search">Plot</span>
    </td></tr></table>
    </p>
    <div id="map_canvas" style="width: 100%; height: 250px"></div>
    <p>
    <table><tr><td><strong>Enable map on this post:</strong></td>
    <td><input class="address_checkbox" type="checkbox" name="woo_maps_enable" id="woo_maps_enable" <?php if($enable == 'on'){ echo 'checked=""';} ?> /></td></tr>
    <tr><td width="200"><strong>Address Name:</strong></td>
    <td><input class="address_input" type="text" size="40" name="woo_maps_address" id="woo_maps_address" value="<?php echo $address; ?>" /></td></tr>
    <tr><td><strong>Latitude:</strong></td>
    <td><input class="address_input" type="text" size="40" name="woo_maps_lat" id="woo_maps_lat" value="<?php echo $lat; ?>"/></td></tr>
    <tr><td><strong>Longitude:</strong></td>
    <td><input class="address_input" type="text" size="40" name="woo_maps_long" id="woo_maps_long" value="<?php echo $long; ?>"/></td></tr>
    <tr><td><strong>Zoom Level:</strong></td>
    <td><select class="address_select" style="width:120px" name="woo_maps_zoom" id="woo_maps_zoom">
    <?php 
		for($i = 0; $i < 20; $i++) {
		if($i == $zoom){ $selected = 'selected="selected"';} else { $selected = '';}		
		 ?><option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
    <?php } ?>
    </select>
    </td></tr>
    <tr><td><strong>Map Type:</strong></td>
    <td><select class="address_select" style="width:120px" name="woo_maps_type" id="woo_maps_type">
    <?php
		$map_types = array('Normal' => 'G_NORMAL_MAP','Satellite' => 'G_SATELLITE_MAP','Hybrid' => 'G_HYBRID_MAP','Terrain' => 'G_PHYSICAL_MAP',); 
		foreach($map_types as $k => $v) {
		if($type == $v){ $selected = 'selected="selected"';} else { $selected = '';}		
		 ?><option value="<?php echo $v; ?>" <?php echo $selected; ?>><?php echo $k; ?></option>
    <?php } ?>
    </select></td></tr>
    </table>    
    <?php
	} // End kapi key check
	

}


function woothemes_metabox_maps_header(){
	global $post;  
    $pID = $post->ID; 
	$key = get_option('woo_maps_apikey');
	if(empty($key)){ // No Key
	} else {
	?>
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo $key; ?>" type="text/javascript"></script>
    <script type="text/javascript">
	jQuery(document).ready(function(){
		var map;
		var geocoder;
		var address;
	
		function initialize() {
		  map = new GMap2(document.getElementById("map_canvas"));
		  <?php 
		  $lat = get_post_meta($pID,'woo_maps_lat',true);
		  $long = get_post_meta($pID,'woo_maps_long',true);
		  
		  if(empty($long) && empty($lat)){
		  	//Defaults...
			$lat = '40.7142691';
			$long = '-74.0059729';
			$zoom = 6;
		  } else { 
		  	$zoom = 9; 
		  }
		  
		  ?>
		  map.setCenter(new GLatLng(<?php echo $lat; ?>,<?php echo $long; ?>), <?php echo $zoom; ?>);
		  map.setUIToDefault();
		  GEvent.addListener(map, "click", getAddress);
		  geocoder = new GClientGeocoder();
		}
		
		function setSavedAddress() {
		 point = new GLatLng(<?php echo $lat; ?>,<?php echo $long; ?>);
		  marker = new GMarker(point);
		  map.addOverlay(marker);
		 }
		
		function getAddress(overlay, latlng) {
		  if (latlng != null) {
			address = latlng;
			geocoder.getLocations(latlng, showAddress);
		  }
		}
	
		function showAddress(response) {
		//alert(response.Placemark[0].Point.coordinates[1]);
		  map.clearOverlays();
		  if (!response || response.Status.code != 200) {
			alert("Status Code:" + response.Status.code);
		  } else {
			place = response.Placemark[0];
			point = new GLatLng(place.Point.coordinates[1],
								place.Point.coordinates[0]);
			marker = new GMarker(point);
			map.addOverlay(marker);
			<?php /* 
			marker.openInfoWindowHtml('<div class="woo_maps_bubble_address">' + place.address + '</div>');
			map.setCenter(new GLatLng(place.Point.coordinates[1],place.Point.coordinates[0]), <?php // echo $zoom; ?>);
			marker.openInfoWindowHtml(
			'<b>orig latlng:</b>' + response.name + '<br/>' + 
			'<b>latlng:</b>' + place.Point.coordinates[1] + "," + place.Point.coordinates[0] + '<br>' +
			'<b>Status Code:</b>' + response.Status.code + '<br>' +
			'<b>Status Request:</b>' + response.Status.request + '<br>' +
			'<b>Address:</b>' + place.address + '<br>' +
			'<b>Accuracy:</b>' + place.AddressDetails.Accuracy + '<br>' +
			'<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
			*/?>
			jQuery('#woo_maps_address').attr('value',place.address);
			jQuery('#woo_maps_lat').attr('value',place.Point.coordinates[1]);
			jQuery('#woo_maps_long').attr('value',place.Point.coordinates[0]);
		  }
		}
		
		// addAddressToMap() is called when the geocoder returns an
		// answer.  It adds a marker to the map with an open info window
		// showing the nicely formatted version of the address and the country code.
		function addAddressToMap(response) {
		  map.clearOverlays();
		  if (!response || response.Status.code != 200) {
			alert("Sorry, we were unable to geocode that address");
		  } else {
			place = response.Placemark[0];
			point = new GLatLng(place.Point.coordinates[1],
								place.Point.coordinates[0]);
			marker = new GMarker(point);
			map.addOverlay(marker);
			<?php /* marker.openInfoWindowHtml(
			'<div class="woo_maps_bubble_address">' + place.address + '</div>'
			); */ ?>
			map.setCenter(new GLatLng(place.Point.coordinates[1],place.Point.coordinates[0]), <?php echo $zoom; ?>);
			jQuery('#woo_maps_address').attr('value',place.address);
			jQuery('#woo_maps_long').attr('value',place.Point.coordinates[0]);
			jQuery('#woo_maps_lat').attr('value',place.Point.coordinates[1]);
		  }
		}
	
		
		// showLocation() is called when you click on the Search button
		// in the form.  It geocodes the address entered into the form
		// and adds a marker to the map at that location.
		function showLocation() {
		  var address = jQuery('#woo_maps_search_input').attr('value');
		  geocoder.getLocations(address, addAddressToMap);
		}
		initialize();
		setSavedAddress();
		
		//Click on the "Plot" button	
		jQuery('#woo_maps_search').click(function(){
		
			showLocation();
	
		})
		
	});
    </script>
	<style type="text/css">
		#map_canvas { margin:10px 0}
		.woo_maps_bubble_address { font-size:16px}
	</style>
	
	<?php
	} // End api key check
	}



function woothemes_metabox_maps_handle(){   
    
    global $globals;  
    $pID = $_POST['post_ID'];
    $woo_map_input_names = array('woo_maps_enable','woo_maps_address','woo_maps_long','woo_maps_lat','woo_maps_zoom','woo_maps_type');
	
    
    if ($_POST['action'] == 'editpost'){                                   
        foreach ($woo_map_input_names as $name) { // On Save.. this gets looped in the header response and saves the values submitted
  
				$var = $name;
				if (isset($_POST[$var])) {            
					if( get_post_meta( $pID, $name ) == "" )
						add_post_meta($pID, $name, $_POST[$var], true );
					elseif($_POST[$var] != get_post_meta($pID, $name, true))
						update_post_meta($pID, $name, $_POST[$var]);
					elseif($_POST[$var] == "") {
					   delete_post_meta($pID, $name, get_post_meta($pID, $name, true));
					}
				}
				elseif(!isset($_POST[$var]) && $name == 'woo_maps_enable') { 
					update_post_meta($pID, $name, 'false'); 
				}     
				else {
					  delete_post_meta($pID, $name, get_post_meta($pID, $name, true)); // Deletes check boxes OR no $_POST
				}  
                
            }
        }
}

function woothemes_metabox_maps_add() {
    if ( function_exists('add_meta_box') ) {
        $plugin_page = add_meta_box('woothemes-maps',get_option('woo_themename').' Custom Maps','woothemes_metabox_maps_create','post','normal');
    
		add_action('admin_head-'. $plugin_page, 'woothemes_metabox_maps_header' );
		
		$plugin_page_page = add_meta_box('woothemes-maps',get_option('woo_themename').' Custom Maps','woothemes_metabox_maps_create','page','normal');

		add_action('admin_head-'. $plugin_page_page, 'woothemes_metabox_maps_header' );


	   //add_meta_box('woothemes-settings',get_option('woo_themename').' Custom Settings','woothemes_metabox_create','page','normal');
    }
}

add_action('edit_post', 'woothemes_metabox_maps_handle');
add_action('admin_menu', 'woothemes_metabox_maps_add'); // Triggers Woothemes_metabox_create

function woo_maps_enqueue($hook) {
  if ($hook == 'post.php' OR $hook == 'post-new.php' OR $hook == 'page.php' OR $hook == 'page-new.php') {
    add_action('admin_head', 'woothemes_metabox_maps_header');
  }
}
add_action('admin_enqueue_scripts','woo_maps_enqueue',10,1);

/*-----------------------------------------------------------------------------------*/
/* WordPress 3.0 New Features Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
	register_nav_menus( array( 'primary-menu' => __( 'Primary Menu' ) ) );
}
        
?>