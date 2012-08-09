<?php get_header(); ?>

	<div class="post-title col-full">

		<div class="fl event-name">
		
			<h1 class="title"><?php _e('Search results', 'woothemes') ?>: <?php printf(the_search_query()); ?></h1>
			
		</div>
		
	</div>
	
    <div id="content" class="col-full">
		<div id="main" class="col-left">
            
			<?php if (have_posts()) : $count = 0; ?>
                
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
                
                <div class="entry">
                    <?php the_content(); ?>
                </div><!-- /.entry -->
            
                <div class="post-more">       
                    <div class="read-more fl"><?php comments_popup_link(__('Leave a Comment', 'woothemes'), __('Leave a Comment', 'woothemes'), __('Leave a Comment', 'woothemes')); ?></div>            
                    <div class="comments fr"><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comment', 'woothemes'), __('% Comments', 'woothemes')); ?></div>
                    <div class="fix"></div>
                </div> <!-- /.post-more -->                        
            
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
