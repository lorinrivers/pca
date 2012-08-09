
<div id="loopedSlider">
    <?php $woo_featured_tags = get_option('woo_featured_tags'); if ( ($woo_featured_tags != '') && (isset($woo_featured_tags)) ) { ?>
    <?php
		$featposts = get_option('woo_featured_entries'); // Number of featured entries to be shown
		$GLOBALS['feat_tags_array'] = explode(',',get_option('woo_featured_tags')); // Tags to be shown
        foreach ($GLOBALS['feat_tags_array'] as $tags){ 
			$tag = get_term_by( 'name', trim($tags), 'post_tag', 'ARRAY_A' );
			if ( $tag['term_id'] > 0 )
				$tag_array[] = $tag['term_id'];
		}
    ?>
	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $featposts)); ?>
    <?php if (have_posts()) : $count = 0; ?>

	<div class="featured-nav">
	
		<h2><?php echo stripslashes(get_option('woo_featured_header')); ?></h2>
		
        <ul class="pagination">
			<?php while (have_posts()) : the_post();  $GLOBALS['shownposts'][$count] = $post->ID; $count++; ?>
            <li>
            	<a href="#">
					<?php woo_get_image('image',48,48,'thumbnail',90,$post->ID,'img'); ?>                
                    <em><?php the_title(); ?></em>
                    <span class="meta"><?php echo woo_excerpt( get_the_excerpt(), '80'); ?></span>
                </a>
                <div style="clear:both"></div>
            </li>
          	<?php endwhile; ?>      
        </ul>      
    </div> 
        
	<?php endif; $wp_query = $saved; ?>      

	<?php $saved = $wp_query; query_posts(array('tag__in' => $tag_array, 'showposts' => $featposts)); ?>
	<?php if (have_posts()) : $count = 0; ?>

    <div class="container">
    
        <div class="slides">
        
            <?php while (have_posts()) : the_post(); $count++; ?>
            
            <div id="slide-<?php echo $count; ?>" class="slide">                
				
				<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
                <div class="post">
        
                   <?php woo_get_image('image',$GLOBALS['slider_w'],$GLOBALS['slider_h'],'thumbnail '.$GLOBALS['slider_align']); ?> 

                    <div class="entry">
                    
                    	<?php $video = woo_embed('width=510&height=291'); ?>
                    			<?php 
                    			if (!empty($video)){ ?>
                    			<div class="video <?php echo $GLOBALS['single_align']; ?>">
                    				<?php echo $video; ?>
                    			</div><!-- /.image -->
                    	<?php } ?>
                        
                        <?php the_excerpt(); ?>
                                
                    </div>
                    
                    <div class="fix"></div>
                    
                    <div class="post-bottom">
	                   
	                    <p class="post-meta">
	                        <span class="fl"><img src="<?php bloginfo('template_directory'); ?>/images/ico-time.png" alt="" /><?php _e('Posted on','woothemes'); ?> <?php the_time(get_option('date_format')); ?> <span class="cat"><?php _e('in','woothemes'); ?> <?php the_category(', ') ?></span></span>
	                        <span class="fr"><span class="comments"><img src="<?php bloginfo('template_directory'); ?>/images/ico-comment.png" alt="" /><?php comments_popup_link(__('0 Comments', 'woothemes'), __('1 Comment', 'woothemes'), __('% Comments', 'woothemes')); ?></span></span>                     
	                    <div class="fix"></div>  
	                    </p>
                        
                    </div>

                </div><!-- /.post -->
                
                        
            </div>
            
		<?php endwhile; ?> 

        </div><!-- /.slides -->        
    </div><!-- /.container -->
	<div class="fix"></div>
    
    <?php endif; $wp_query = $saved; ?> 
    <?php if (get_option('woo_exclude') <> $GLOBALS['shownposts']) update_option("woo_exclude", $GLOBALS['shownposts']); ?>
    <?php } else { ?>    
	<p class="note"><?php _e('Please setup Featured Panel tag(s) in your options panel. You must setup tags that are used on active posts.','woothemes'); ?></p>
	<?php } ?>
</div><!-- /#loopedSlider -->
