<?php get_header(); ?>

	<div class="post-title col-full">

		<?php 
		//Woo Settings
		$woo_calendar_formatting = get_option('woo_calendar_formatting');
		$woo_booking_form = get_option('woo_booking_form');
		?>
		<?php if (have_posts()) : $count = 0; ?>
		<?php while (have_posts()) : the_post(); $count++; ?>
			
			<?php if (in_category( get_option('woo_events_category') )) { $is_event = true; } ?> 
			<?php 
			//Post Meta
			$event_start_date = get_post_meta($post->ID,'event_start_date',true);
			$event_end_date = get_post_meta($post->ID,'event_end_date',true);
			$event_start_time = get_post_meta($post->ID,'event_start_time',true);
			$event_end_time = get_post_meta($post->ID,'event_end_time',true);
			$event_location = get_post_meta($post->ID,'event_location',true);
			?>
			<?php if ($is_event) { ?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
		
					jQuery('.add-calendar').each(function(){
						jQuery(this).parent().find('ul').hide();
						jQuery(this).click(function() {
								jQuery(this).parent().find('ul').toggle();
						});
						jQuery(this).parent().find('ul li').each(function() {	
								jQuery(this).find('a').click(function() {
									jQuery(this).parent().parent().hide();
							});
						});
					});
				});
			</script>
			<?php if ($woo_booking_form == 'disabled') { ?>
			<style type="text/css">
				#events-calendar .event .buttons ul li.tip {
					left:18% !important;
				}
			</style>
			<?php } ?>
			<?php $js_formatting = stripslashes($woo_calendar_formatting); ?>
				<?php switch ($js_formatting) {
					/*case "mm/dd/yy" :
						$php_formatting = "m\/d\/Y";
						break;
					case "yy-mm-dd" :
						$php_formatting = "Y\-m\-d";
						break;
					case "d M, y" :
						$php_formatting = "d M, Y";
						break;
					case "d MM, y" :
						$php_formatting = "d F Y";
						break;
					case "DD, d MM, yy" :
						$php_formatting = "l, d F, Y";
						break;
					case "'day' d 'of' MM 'in the year' yy" :
						$php_formatting = "\\d\a\y d \\o\\f F \\i\\n \\t\h\e \\y\e\a\\r Y";
						break;*/
					default :
						$php_formatting = "m\/d\/Y";
						break;	
				} ?>
			<?php } ?>
			
		<div class="fl event-name">
		
			<h1 class="title"><?php the_title(); ?></h1>
			<?php $custom_formatting = $php_formatting;  ?>	
			<?php if ($is_event) { ?>
			<p class="date">
				<span class="startdate hide"><?php _e('Dates', 'woothemes'); ?>: <?php echo date($php_formatting,strtotime($event_start_date)); ?></span><span class="enddate hide"><?php if ( (date($php_formatting,strtotime($event_end_date))) > (date($php_formatting,strtotime($event_start_date))) ) { ?> - <?php echo date($php_formatting,strtotime($event_end_date)); } ?></span>
				<span class="startdateoutput"><?php _e('Dates', 'woothemes'); ?>: <?php echo date($custom_formatting,strtotime($event_start_date)); ?></span><span class="enddateoutput"><?php if ( (date($custom_formatting,strtotime($event_end_date))) > (date($custom_formatting,strtotime($event_start_date))) ) { ?> - <?php echo date($custom_formatting,strtotime($event_end_date)); } ?></span>
				<?php if ($event_start_time != '') { ?><span class="starttime"><?php _e('Times', 'woothemes'); ?>: <?php echo $event_start_time; ?></span><span class="endtime"><?php if ( strtotime($event_end_time) > strtotime($event_start_time) ) { ?> - <?php echo $event_end_time; } ?></span><?php } ?>
				<?php if ($event_location != 'Unknown') { ?><span class="location"><?php _e('Location', 'woothemes'); ?>: <?php echo $event_location; ?></span><?php } ?>
			</p> 
			<?php } ?>
		
		</div>
		
		<?php if ($is_event) { ?>
		<?php if ($woo_booking_form == 'disabled' && get_option('woo_events_ical_export') == 'false') { } else { ?>
		
		<div class="event fr">
			<div class="buttons">
				<?php if ($woo_booking_form == 'disabled') { } else { ?>
					<a href="<?php if ($woo_booking_form == 'bookingurl') { echo get_option('woo_booking_form_external_url'); } else { echo get_bloginfo('url').'/'.get_option('woo_booking_form_page').'/?event_id='.$post->ID; } ?>" class="button book-tickets"><?php _e('Book Tickets', 'woothemes'); ?></a>
				<?php } ?>
				<?php if (get_option('woo_events_ical_export') == 'true') { ?>
				<a onclick="" class="button add-calendar"><?php _e('Add to Calendar', 'woothemes'); ?></a>
				<?php $icalurl = woo_get_ical($post->ID,$php_formatting); ?>
				<ul>
					<li class="outlook"><a href="<?php echo get_bloginfo('template_url'); ?>/download.php?calendar=<?php echo $icalurl['ical']; ?>" title="Microsoft Outlook">Microsoft Outlook</a></li>
					<li class="ical"><a href="<?php echo get_bloginfo('template_url'); ?>/download.php?calendar=<?php echo $icalurl['ical']; ?>" title="Apple iCal">Apple iCal</a></li>
					<li class="google"><a href="<?php echo $icalurl['google']; ?>" target="_blank" title="Google Calendar">Google Calendar</a></li>
					<li class="tip">&nbsp;</li>
				</ul>
					
				<?php } ?>
			</div>
		</div>
		
		<?php } ?>
				
		
		<?php } ?>
	
	</div>

       
    <div id="content" class="col-full">
        
	<div id="main" class="col-left">

				<div <?php post_class(); ?>>

                    <?php if ( $GLOBALS['thumb_single'] == "true" ) woo_get_image('image',$GLOBALS['single_w'],$GLOBALS['single_h'],'thumbnail alignright'); ?>
                   	 
	    			
                    <div class="entry">
                    
                    	<?php $video = woo_embed('width=525&height=300'); ?>
        	 				<?php 
        	 				if (!empty($video)){ ?>
        	 				<div class="video <?php echo $GLOBALS['single_align']; ?>">
        	 					<?php echo $video; ?>
        	 				</div><!-- /.image -->
                    	<?php } ?>
                    	
                    	<?php 
$session_description = get_post_meta( $post->ID, '_lr_session_description', true );
$session_category = get_post_meta( $post->ID, '_lr_session_category', true );
$session_audience = get_post_meta( $post->ID, '_lr_session_audience', true );
$session_format = get_post_meta( $post->ID, '_lr_session_format', true );
$leader_1_name = get_post_meta( $post->ID, '_lr_leader_1_name', true );
$leader_1_bio = get_post_meta( $post->ID, '_lr_leader_1_bio', true );
$leader_2_name = get_post_meta( $post->ID, '_lr_leader_2_name', true );
$leader_2_bio = get_post_meta( $post->ID, '_lr_leader_2_bio', true );
$leader_3_name = get_post_meta( $post->ID, '_lr_leader_3_name', true );
$leader_3_bio = get_post_meta( $post->ID, '_lr_leader_3_bio', true );
$leader_4_name = get_post_meta( $post->ID, '_lr_leader_4_name', true );
$leader_4_bio = get_post_meta( $post->ID, '_lr_leader_4_bio', true );

echo '<p>' . $session_description . '</p>';
echo '<h3 class="session_category">Session Category</h3>';
echo '<p class="session_category">' . $session_category . '</p>';
echo '<h3 class="session_audience">Session Audience</h3>';
echo '<p class="session_audience">' . $session_audience . '</p>';
echo '<h3 class="session_leader">Session Leader(s)</h3>';
echo '<p class="session_leader_name">' . $leader_1_name . '</p>';
echo '<p class="session_leader_bio">' . $leader_1_bio . '</p>';

                    	 ?>
					</div>
					
					<!-- Event Map -->
					<?php include (TEMPLATEPATH . "/includes/featured-single.php"); ?>
					<!-- Event Map end -->
										
					<?php the_tags('<p class="tags">Tags: ', ', ', '</p>'); ?>

                    <?php woo_postnav(); ?>
                    
                </div><!-- /.post -->
                
                <?php $comm = get_option('woo_comments'); if ( 'open' == $post->comment_status && ($comm == "post" || $comm == "both") ) : ?>
	                <?php comments_template('', true); ?>
                <?php endif; ?>
                                                    
			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
  				</div><!-- /.post -->             
           	<?php endif; ?>  
        
		</div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>