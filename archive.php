<?php get_header(); ?>
       
    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
		<?php if (have_posts()) : $count = 0; ?>
        
            <?php if (is_category()) { ?>
            <span class="archive_header"><span class="fl cat"><?php _e('Archive', 'woothemes'); ?> | <?php echo single_cat_title(); ?></span> <span class="fr catrss"><?php $cat_obj = $wp_query->get_queried_object(); $cat_id = $cat_obj->cat_ID; echo '<a href="'; get_category_rss_link(true, $cat, ''); echo '">RSS feed for this section</a>'; ?></span></span>        
        
            <?php } elseif (is_day()) { ?>
            <span class="archive_header"><?php _e('Archive', 'woothemes'); ?> | <?php the_time(get_option('date_format')); ?></span>

            <?php } elseif (is_month()) { ?>
            <span class="archive_header"><?php _e('Archive', 'woothemes'); ?> | <?php the_time('F, Y'); ?></span>

            <?php } elseif (is_year()) { ?>
            <span class="archive_header"><?php _e('Archive', 'woothemes'); ?> | <?php the_time('Y'); ?></span>

            <?php } elseif (is_author()) { ?>
            <span class="archive_header"><?php _e('Archive by Author', 'woothemes'); ?></span>

            <?php } elseif (is_tag()) { ?>
            <span class="archive_header"><?php _e('Tag Archives:', 'woothemes'); ?> <?php echo single_tag_title('', true); ?></span>
            
            <?php } ?>
            
            <div class="fix"></div>
        
        <?php while (have_posts()) : the_post(); $count++; ?>
                                                                    
            <!-- Post Starts -->
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

        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>