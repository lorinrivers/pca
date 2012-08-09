<?php
/*
Template Name: Image Gallery
*/
?>

<?php get_header(); ?>

	<div class="post-title col-full">

		<div class="fl event-name">
		
			<h1 class="title"><?php the_title(); ?></h1>
			
		</div>
		
	</div>
       
    <div id="content" class="page col-full">
		<div id="main" class="col-left">
                                                                            
            <div class="post">
                
				<div class="entry">
                <?php query_posts('showposts=60'); ?>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>				
                    <?php $wp_query->is_home = false; ?>

                    <?php woo_get_image('image',100,100,'thumbnail alignleft'); ?>
                
                <?php endwhile; endif; ?>	
                </div>

            </div><!-- /.post -->
            <div class="fix"></div>                
                                                            
		</div><!-- /#main -->
		
        <?php get_sidebar(); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>