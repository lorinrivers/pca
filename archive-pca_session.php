<?php get_header('pca_session'); ?>
       
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
        
  <table id="content_table">
    <thead>
      <tr>
        <th>Category</th>
        <th>Title</th>
        <th>Audience</th>
        <th>Session Leader</th>
      </tr>
    </thead>
<tbody>
        <?php while (have_posts()) : the_post(); $count++; 
        $session_description = get_post_meta( $post->ID, '_lr_session_description', true );
$session_category = get_post_meta( $post->ID, '_lr_session_category', true );
$session_audience = get_post_meta( $post->ID, '_lr_session_audience', true );
$session_format = get_post_meta( $post->ID, '_lr_session_format', true );
$leader_1_name = get_post_meta( $post->ID, '_lr_leader_1_name', true );
?>
                                                                    
            <!-- Post Starts -->
    <tr>
      <td class="category"><?php echo $session_category; ?></td>
      <td class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></td>
      <td class="audience"><?php echo $session_audience; ?></td>
      <td class="leader"><?php echo $leader_1_name; ?></td>
    </tr>


            
            
        <?php endwhile; else: ?>
            <div class="post">
                <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
            </div><!-- /.post -->
        <?php endif; ?>  
    </tbody>
</table>

			<?php woo_pagenav(); ?>
                
		</div><!-- /#main -->


    </div><!-- /#content -->
		
<?php get_footer(); ?>