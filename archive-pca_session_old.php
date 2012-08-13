<?php
/*
Template Name: Sessions Archive
*/
?>

<?php get_header('pca_sessions'); ?>

	<div class="post-title col-full">
		
	</div>
	
    <div id="content" class="page col-full">
		<div id="main" class="fullwidth">
<?php		$args = array( 'post_type' => 'pca_sessions' );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="post">
<?php	the_title();
	echo '<div class="entry">';
	the_content();
	echo '</div><!-- /.entry -->';
	echo '</div><!-- /.post -->';
endwhile;
?>
            
        
		</div><!-- /#main -->
		
    </div><!-- /#content -->
		
<?php get_footer(); ?>