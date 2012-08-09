<?php get_header(); ?>
	
	<!-- Events Calendar Starts -->
		<?php if (!$paged && get_option('woo_events_calendar') == 'true') include (TEMPLATEPATH . "/includes/events-calendar.php"); ?>
	<!-- Events Calendar Ends -->
	
	<!-- Past Events Slider Starts -->
	<?php $showfeatured = get_option('woo_featured'); if ($showfeatured <> "true") { if (get_option('woo_exclude')) update_option("woo_exclude", ""); } ?>
	<?php if ( !$paged && $showfeatured == "true" ) include ( TEMPLATEPATH . '/includes/featured.php' ); ?>
	<!-- Past Events Slider Ends -->
	
	<?php if ((get_option('woo_events_calendar') != 'true') && (get_option('woo_featured') != 'true') && (get_option('woo_blog_panel') != 'true') && (get_option('woo_footer_panel') != 'true'))  { ?>
    <div id="content" class="col-full">
    	<p class="note"><?php _e('Please set up your theme options for your theme to render correctly.','woothemes'); ?></p>
    </div>
    <?php } ?>
	
	<?php if (get_option('woo_blog_panel') == 'true') { ?>
    <div id="content" class="col-full">
    
		<div id="main" class="col-left">     
        <?php if (get_option('woo_event_exclude') == 'true') { $category_id = get_cat_ID( get_option('woo_events_category') ); if ($category_id != 0) { $exclude_cat[0] = $category_id; } else { $exclude_cat[0] = ''; }  } ?>  
        <?php $i = 1; $cat_ids = explode(',',get_option('woo_blog_cat_exclude')); foreach ($cat_ids as $cat_id){ $exclude_cat[$i] = $cat_id; $i++; } ?>
        <?php if (get_option('woo_blog_featured_exclude') == 'true') { $exclude_posts = get_option('woo_exclude'); } ?>   
        <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; $args = array( 'post__not_in' => $exclude_posts, 'category__not_in' => $exclude_cat, 'paged' => $paged ); ?>      
		<?php query_posts($args); ?>
        <?php if (have_posts()) : $count = 0; ?>
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <div class="post">

				<?php woo_get_image('image',$GLOBALS['thumb_w'],$GLOBALS['thumb_h'],'thumbnail '.$GLOBALS['thumb_align']); ?> 
                
                <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                
                <p class="post-meta">
                    <span class="small"><?php _e('by', 'woothemes') ?></span> <span class="post-author"><?php the_author_posts_link(); ?></span>
                    <span class="small"><?php _e('on', 'woothemes') ?></span> <span class="post-date"><?php the_time(get_option('date_format')); ?></span>
                    <span class="small"><?php _e('in', 'woothemes') ?></span> <span class="post-category"><?php the_category(', ') ?></span>
                </p>
                
                <?php $video = woo_embed('width=525&height=300'); ?>
                		<?php 
                		if (!empty($video)){ ?>
                		<div class="video <?php echo $GLOBALS['single_align']; ?>">
                			<?php echo $video; ?>
                		</div><!-- /.image -->
                <?php } ?>

               <?php if ( get_option('woo_post_content_archives') == "true" ) { ?>
               
                <div class="entry">
               		<?php the_content(__('Read more...', 'woothemes')); ?>
               	</div>
               	
               	<div class="post-more">       
               	    <div class="read-more fl"><?php comments_popup_link(__('Leave a Comment', 'woothemes'), __('Leave a Comment', 'woothemes'), __('Leave a Comment', 'woothemes')); ?></div>            
               	    <div class="comments fr"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comment', 'woothemes'), __('% Comments', 'woothemes')); ?></div>
               	    <div class="fix"></div>
               	</div> <!-- /.post-more -->
               	
               <?php } else { ?>
               
                <div class="entry">
               		<?php the_excerpt(); ?>
               	</div>
               	
               	<div class="post-more">       
               	    <div class="read-more fl"><a href="<?php the_permalink() ?>" title="<?php _e('Read full story','woothemes'); ?>"><?php _e('Read the full story','woothemes'); ?></a></div>            
               	    <div class="comments fr"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comment', 'woothemes'), __('% Comments', 'woothemes')); ?></div>
               	    <div class="fix"></div>
               	</div> <!-- /.post-more -->
               	
               <?php } ?>
                                       
            </div><!-- /.post -->
                                                
        <?php endwhile; else: ?>
            <div class="post">
                <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
            </div><!-- /.post -->
        <?php endif; ?>  
    
		<?php woo_pagenav(); ?>
                
		</div><!-- /#main -->

        <?php get_sidebar('home'); ?>

    </div><!-- /#content -->
	<?php } ?>
		
<?php get_footer(); ?><!-- code removed by Brian Hull -->