<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

	<div class="post-title col-full">

		<div class="fl event-name">
		
			<h1 class="title"><?php the_title(); ?></h1>
			
		</div>
		
	</div>
	
    <div id="content" class="page col-full">
		<div id="main" class="fullwidth">
            
            <?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div class="post">
                    
                    <div class="entry">
	                	<?php the_content(); ?>
	               	</div><!-- /.entry -->

                </div><!-- /.post -->
                                                    
			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                </div><!-- /.post -->
            <?php endif; ?>  
        
		</div><!-- /#main -->
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>