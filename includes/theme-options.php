<?php

add_action('init','woo_options');  
function woo_options(){
	
// VARIABLES
$themename = "Diarise";
$manualurl = 'http://www.woothemes.com/support/theme-documentation/diarise/';
$shortname = "woo";

$GLOBALS['template_path'] = get_bloginfo('template_directory');

//Access the WordPress Categories via an Array
$woo_categories = array();  
$woo_categories_obj = get_categories('hide_empty=0');
foreach ($woo_categories_obj as $woo_cat) {
    $woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}
$categories_tmp = array_unshift($woo_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$woo_pages = array();
$woo_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($woo_pages_obj as $woo_page) {
    $woo_pages[$woo_page->ID] = $woo_page->post_name; }
$woo_pages_tmp = array_unshift($woo_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

//Testing 
$options_select = array("one","two","three","four","five");
$options_radio = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
$options_bookings = array("disabled" => "Disabled","bookingform" => "Use Booking Form","bookingurl" => "Use External Booking URL"); 

//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//Calendar formatting and default ranges
$startdate = date("m/d/Y");
$threemonthsbeforenow = mktime(0, 0, 0, date("m")-3, date("d"), date("Y"));
$threemonthsfromnow = mktime(0, 0, 0, date("m")+3, date("d"), date("Y"));
$startdate = date("m/d/Y", $threemonthsbeforenow);
$enddate = date("m/d/Y", $threemonthsfromnow);
update_option('woo_calendar_formatting','mm/dd/yy');

//More Options
$all_uploads_path = get_bloginfo('home') . '/wp-content/uploads/';
$all_uploads = get_option('woo_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$calendar_date_format = array("mm/dd/yy"/*,"yy-mm-dd","d M, y","d MM, y","DD, d MM, yy","'day' d 'of' MM 'in the year' yy"*/);

// THIS IS THE DIFFERENT FIELDS
$options = array();   

$options[] = array( "name" => "General Settings",
					"icon" => "general",
                    "type" => "heading");
                        
$options[] = array( "name" => "Theme Stylesheet",
					"desc" => "Select your themes alternative color scheme.",
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify an image URL directly.",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");    
                                                                                     
$options[] = array( "name" => "Text Title",
					"desc" => "Enable if you want Blog Title and Tagline to be text-based. Setup title/tagline in WP -> Settings -> General.",
					"id" => $shortname."_texttitle",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px <a href='http://www.faviconr.com/'>ico image</a> that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 
                                               
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");        

$options[] = array( "name" => "RSS URL",
					"desc" => "Enter your preferred RSS URL. (Feedburner or other)",
					"id" => $shortname."_feed_url",
					"std" => "",
					"type" => "text");
                    
$options[] = array( "name" => "E-Mail URL",
					"desc" => "Enter your preferred E-mail subscription URL. (Feedburner or other)",
					"id" => $shortname."_subscribe_email",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Contact Form E-Mail",
					"desc" => "Enter your E-mail address to use on the Contact Form Page Template. Add the contact form by adding a new page and selecting 'Contact Form' as page template.",
					"id" => $shortname."_contactform_email",
					"std" => "",
					"type" => "text");



$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");

$options[] = array( "name" => "Post/Page Comments",
					"desc" => "Select if you want to enable/disable comments on posts and/or pages. ",
					"id" => $shortname."_comments",
					"type" => "select2",
					"options" => array("post" => "Posts Only", "page" => "Pages Only", "both" => "Pages / Posts", "none" => "None") );                                                          

$options[] = array( "name" => "Enable Widgetized Footer",
					"desc" => "Show the footer panel on the front page.",
					"id" => $shortname."_footer_panel",
					"std" => "true",
					"type" => "checkbox");  
					    
$options[] = array( "name" => "Styling Options",
					"icon" => "styling",
					"type" => "heading");    

$options[] = array( "name" =>  "Link Color",
					"desc" => "Pick a custom color for links or add a hex color code e.g. #697e09",
					"id" => "woo_link_color",
					"std" => "",
					"type" => "color");   

$options[] = array( "name" =>  "Link Hover Color",
					"desc" => "Pick a custom color for links hover or add a hex color code e.g. #697e09",
					"id" => "woo_link_hover_color",
					"std" => "",
					"type" => "color");                    

$options[] = array( "name" =>  "Button Color",
					"desc" => "Pick a custom color for buttons or add a hex color code e.g. #697e09",
					"id" => "woo_button_color",
					"std" => "",
					"type" => "color"); 
					
$options[] = array( "name" =>  "Background Color",
					"desc" => "Pick a custom color for site background or add a hex color code e.g. #e6e6e6",
					"id" => $shortname."_style_bg",
					"std" => "",
					"type" => "color");   

$options[] = array( "name" => "Background Image",
					"desc" => "Upload a background image, or specify the image address of your image. (http://yoursite.com/image.png)",
					"id" => $shortname."_style_bg_image",
					"std" => "",
					"type" => "upload");    

$options[] = array( "name" => "Background Image Repeat",
					"desc" => "Select how you want your background image to display.",
					"id" => $shortname."_style_bg_image_repeat",
					"type" => "select",
					"options" => array("No Repeat" => "no-repeat", "Repeat" => "repeat","Repeat Horizontally" => "repeat-x", "Repeat Vertically" => "repeat-y",) ); 
					
$options[] = array( "name" => "Event Calendar",
					"icon" => "misc",
                    "type" => "heading");
                    
$options[] = array( "name" => "Enable Event Calendar",
					"desc" => "Show the events calendar on the front page.",
					"id" => $shortname."_events_calendar",
					"std" => "false",
					"type" => "checkbox"); 

$options[] = array( "name" => "Allow iCal Export of Events",
					"desc" => "Enable this feature",
					"id" => $shortname."_events_ical_export",
					"std" => "true",
					"type" => "checkbox"); 

$options[] = array( "name" => "Events Category",
					"desc" => "Select the category that you would like to use for Events.",
					"id" => $shortname."_events_category",
					"std" => "Select a category:",
					"type" => "select",
					"options" => $woo_categories);  
					
$options[] = array( "name" => "Upcoming Events Entries",
                    "desc" => "Select the number of Upcoming Events that should appear on the Home Page.",
                    "id" => $shortname."_upcoming_events",
                    "std" => "2",
                    "type" => "select",
                    "options" => $other_entries);   
					
$options[] = array( "name" => "Show Events from this Date",
					"desc" => "Select a date from the Calendar.",
					"id" => $shortname."_start_calendar_range",
					"std" => $startdate,
					"type" => "calendar"); 
					
$options[] = array( "name" => "Show Events until this Date",
					"desc" => "Select a date from the Calendar.",
					"id" => $shortname."_end_calendar_range",
					"std" => $enddate,
					"type" => "calendar"); 
                    					
$options[] = array( "name" => "Featured Panel",
					"icon" => "featured",
					"type" => "heading"); 
					
$options[] = array( "name" => "Enable Featured Panel",
					"desc" => "Show the featured panel on the front page.",
					"id" => $shortname."_featured",
					"std" => "false",
					"type" => "checkbox");  

$options[] = array( "name" => "Featured Panel Title",
                    "desc" => "Include a short title for your featured panel on the home page, e.g. Highlights of Past Events.",
                    "id" => $shortname."_featured_header",
                    "std" => "",
                    "type" => "text");
                    
$options[] = array( "name" => "Featured Tag",
                    "desc" => "Add comma separated list for the tags that you would like to have displayed in the featured section on your homepage. For example, if you add 'tag1, tag3' here, then all posts tagged with either 'tag1' or 'tag3' will be shown in the featured area.",
                    "id" => $shortname."_featured_tags",
                    "std" => "",
                    "type" => "text");

$options[] = array(    "name" => "Featured Entries",
                    "desc" => "Select the number of entries that should appear in the Featured panel.",
                    "id" => $shortname."_featured_entries",
                    "std" => "3",
                    "type" => "select",
                    "options" => $other_entries);   

$options[] = array(    "name" => "Auto Start",
                    "desc" => "Set the slider to start sliding automatically. Adjust the speed of sliding underneath.",
                    "id" => $shortname."_slider_auto",
                    "std" => "false",
                    "type" => "checkbox");   

$options[] = array(    "name" => "Animation Speed",
                    "desc" => "The time in <b>seconds</b> the animation between frames will take e.g. 0.6",
                    "id" => $shortname."_slider_speed",
                    "std" => 0.6,
                    "type" => "text");
                    
$options[] = array(    "name" => "Auto Slide Interval",
                    "desc" => "The time in <b>seconds</b> each slide pauses for, before sliding to the next. Only when using Auto Start option above.",
                    "id" => $shortname."_slider_interval",
                    "std" => 4.0,
                    "type" => "text");              

$options[] = array( "name" => "Blog",
					"icon" => "main",
					"type" => "heading");    

$options[] = array( "name" => "Enable Blog Section",
					"desc" => "Show the blog panel on the front page.",
					"id" => $shortname."_blog_panel",
					"std" => "true",
					"type" => "checkbox"); 

$options[] = array( "name" => "Exclude Event Posts from blog",
					"desc" => "Exclude posts in the Events Category from showing in the blog on the homepage and blog template.",
					"id" => $shortname."_event_exclude",
					"std" => "true",
					"type" => "checkbox"); 
					
$options[] = array( "name" => "Exclude Featured Panel Posts from blog",
					"desc" => "Posts that show in the featured panel will not be part of the blog.",
					"id" => $shortname."_blog_featured_exclude",
					"std" => "true",
					"type" => "checkbox"); 

$options[] = array( "name" => "Exclude Categories from Blog",
					"desc" => "Enter a comma-separated list of ID's that you'd like to exclude from the blog on the homepage and blog template. (e.g. 12,23,27,44)",
					"id" => $shortname."_blog_cat_exclude",
					"std" => "",
					"type" => "text"); 
					
$options[] = array( "name" => "Show Full Content Home",
					"desc" => "Check this if you want to show the full post content on homepage.",
					"id" => $shortname."_post_content_home",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => "Show Full Content Archive",
					"desc" => "Check this if you want to show the full post content on archive pages.",
					"id" => $shortname."_post_content_archives",
					"std" => "false",
					"type" => "checkbox");
										
$options[] = array( "name" => "Booking Form",
					"icon" => "misc",
                    "type" => "heading");

$options[] = array( "name" => "Allow Bookings",
					"desc" => "Link Events to your Booking Form page or to an External URL.",
					"id" => $shortname."_booking_form",
					"std" => "disabled",
					"type" => "radio",
					"options" => $options_bookings); 
										                    
$options[] = array( "name" => "Booking Form Page",
                    "desc" => "Select the page that your Booking Form is on. Remember to apply the Booking Form page template to this page.",
                    "id" => $shortname."_booking_form_page",
                    "std" => "",
                    "type" => "select",
                    "options" => $woo_pages);                    

$options[] = array( "name" => "External Booking Form Link",
                    "desc" => "Add the external booking form URL here for .",
                    "id" => $shortname."_booking_form_external_url",
                    "std" => "",
                    "type" => "text");

$options[] = array( "name" => "Booking Form E-Mail",
					"desc" => "Enter your E-mail address to use on the Booking Form Page Template. Add the booking form by adding a new page and selecting 'Booking Form' as page template.",
					"id" => $shortname."_bookingform_email",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Maps",
					"icon" => "maps",
				    "type" => "heading");    

$options[] = array( "name" => "Google Maps API Key",
					"desc" => "Enter your Google Maps API key before using any of Diarise's mapping functionality. <a href='http://code.google.com/apis/maps/signup.html'>Signup for an API key here</a>.",
					"id" => $shortname."_maps_apikey",
					"std" => "",
					"type" => "text"); 
					
$options[] = array( "name" => "Disable Mousescroll",
					"desc" => "Turn off the mouse scroll action for all the Google Maps on the site. This could improve usability on your site.",
					"id" => $shortname."_maps_scroll",
					"std" => "",
					"type" => "checkbox");

$options[] = array( "name" => "Single Page Map Height",
					"desc" => "Height in pixels for the maps displayed on Single.php pages.",
					"id" => $shortname."_maps_single_height",
					"std" => "250",
					"type" => "text");

$options[] = array( "name" => "Enable Latitude & Longitude Coordinates:",
					"desc" => "Enable or disable coordinates in the head of single posts pages.",
					"id" => $shortname."_coords",
					"std" => "true",
					"type" => "checkbox");
										                    
$options[] = array( "name" => "Dynamic Images",
					"type" => "heading",
					"icon" => "image");    
				    				   
$options[] = array( "name" => "Enable WordPress Post Thumbnail Support",
					"desc" => "Use WordPress post thumbnail support to assign a post thumbnail.",
					"id" => $shortname."_post_image_support",
					"std" => "true",
					"class" => "collapsed",
					"type" => "checkbox"); 

$options[] = array( "name" => "Dynamically Resize Post Thumbnail",
					"desc" => "The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>",
					"id" => $shortname."_pis_resize",
					"std" => "true",
					"class" => "hidden",
					"type" => "checkbox"); 									   
					
$options[] = array( "name" => "Hard Crop Post Thumbnail",
					"desc" => "The image will be cropped to match the target aspect ratio.",
					"id" => $shortname."_pis_hard_crop",
					"std" => "true",
					"class" => "hidden last",
					"type" => "checkbox"); 									   

$options[] = array( "name" => "Enable Dynamic Image Resizer",
					"desc" => "This will enable the thumb.php script which dynamically resizes images on your site.",
					"id" => $shortname."_resize",
					"std" => "true",
					"type" => "checkbox");    
                    
$options[] = array( "name" => "Automatic Image Thumbs",
					"desc" => "If no image is specified in the 'image' custom field then the first uploaded post image is used.",
					"id" => $shortname."_auto_img",
					"std" => "false",
					"type" => "checkbox"); 
					
$options[] = array( "name" => "Events Calendar Featured Image alignment",
					"desc" => "Select how to align your images with featured posts.",
					"id" => $shortname."_feat_align",
					"std" => "alignleft",
					"type" => "radio",
					"options" => $options_radio); 

$options[] = array( "name" => "Events Calendar Image Dimensions",
					"desc" => "Enter an integer value i.e. 200 for the image size. Max width is 510.",
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_feat_w',
											'type' => 'text',
											'std' => 495,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_feat_h',
											'type' => 'text',
											'std' => 200,
											'meta' => 'Height')
								  )); 
								  
$options[] = array( "name" => "Featured Panel Image Alignment",
					"desc" => "Select how to align your images with featured posts.",
					"id" => $shortname."_slider_align",
					"std" => "alignleft",
					"type" => "radio",
					"options" => $options_radio); 

$options[] = array( "name" => "Featured Panel Image Dimensions",
					"desc" => "Enter an integer value i.e. 200 for the image size. Max width is 495.",
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_slider_w',
											'type' => 'text',
											'std' => 495,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_slider_h',
											'type' => 'text',
											'std' => 200,
											'meta' => 'Height')
								  )); 
                                                                                                
$options[] = array( "name" => "Thumbnail Image alignment",
					"desc" => "Select how to align your thumbnails with posts.",
					"id" => $shortname."_thumb_align",
					"std" => "alignleft",
					"type" => "radio",
					"options" => $options_thumb_align); 
					
$options[] = array( "name" => "Thumbnail Image Dimensions",
					"desc" => "Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.",
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_thumb_w',
											'type' => 'text',
											'std' => 100,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_thumb_h',
											'type' => 'text',
											'std' => 100,
											'meta' => 'Height')
								  ));

$options[] = array( "name" => "Show thumbnail in Single Posts",
					"desc" => "Show the attached image in the single post page.",
					"id" => $shortname."_thumb_single",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Single Image Dimensions",
					"desc" => "Enter an integer value i.e. 250 for the image size. Max width is 576.",
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_single_w',
											'type' => 'text',
											'std' => 200,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_single_h',
											'type' => 'text',
											'std' => 200,
											'meta' => 'Height')
								  ));

$options[] = array( "name" => "Add thumbnail to RSS feed",
					"desc" => "Add the the image uploaded via your Custom Settings to your RSS feed",
					"id" => $shortname."_rss_thumb",
					"std" => "false",
					"type" => "checkbox");    

//Advertising
$options[] = array( "name" => "Ads - Top Ad (468x60px)",
					"icon" => "ads",
                    "type" => "heading");

$options[] = array( "name" => "Enable Ad",
					"desc" => "Enable the ad space",
					"id" => $shortname."_ad_top",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Adsense code",
					"desc" => "Enter your adsense code (or other ad network code) here.",
					"id" => $shortname."_ad_top_adsense",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Image Location",
					"desc" => "Enter the URL to the banner ad image location.",
					"id" => $shortname."_ad_top_image",
					"std" => "http://www.woothemes.com/ads/468x60b.jpg",
					"type" => "upload");
					
$options[] = array( "name" => "Destination URL",
					"desc" => "Enter the URL where this banner ad points to.",
					"id" => $shortname."_ad_top_url",
					"std" => "http://www.woothemes.com",
					"type" => "text");                        
                                              

update_option('woo_template',$options);      
update_option('woo_themename',$themename);   
update_option('woo_shortname',$shortname);
update_option('woo_manual',$manualurl);

                                     
// Woo Metabox Options

$woo_metaboxes = array(

        "event_start" => array (
            "name"  => "event_start_date",
            "std"	=> $startdate,
            "label" => "Start Date",
            "type" => "calendar",
            "desc" => "Select a Start Date"
        ),
         "event_end" => array (
            "name"  => "event_end_date",
            "std"	=> $startdate,
            "label" => "End Date",
            "type" => "calendar",
            "desc" => "Select an End Date"
        ),
        "event_start_time" => array (
            "name"  => "event_start_time",
            "label" => "Start Time",
            "type" => "time",
            "desc" => "Select a Starting Time. Format - 24 hours (eg. 24:32)."
        ),
        "event_end_time" => array (
            "name"  => "event_end_time",
            "label" => "End Time",
            "type" => "time",
            "desc" => "Select an Ending Time. Format - 24 hours (eg. 24:32)."
        ),
        "event_location" => array (
            "name"  => "event_location",
            "std"  => "Unknown",
            "label" => "Event Location",
            "type" => "text",
            "desc" => "Enter the location of the Event"
        ),
        "image" => array (
            "name"  => "image",
            "std"  => "",
            "label" => "Custom Thumbnail Image",
            "type" => "upload",
            "desc" => "Upload an image to show with your post."
        ),
        "embed" => array (
            "name"  => "embed",
            "std"  => "",
            "label" => "Embed Code",
            "type" => "textarea",
            "desc" => "Enter the video embed code for your video (YouTube, Vimeo or similar)"
        )
    );
    
update_option('woo_custom_template',$woo_metaboxes);       

}

?>