	<?php if (get_option('woo_footer_panel') == 'true') { ?>
	<?php if ( woo_active_sidebar('footer-1') ||
			   woo_active_sidebar('footer-2') || 
			   woo_active_sidebar('footer-3') || 
			   woo_active_sidebar('footer-4') ) : ?>
	<div id="footer-widgets" class="col-full">

		<div class="block">
        	<?php woo_sidebar('footer-1'); ?>    
		</div>
		<div class="block">
        	<?php woo_sidebar('footer-2'); ?>    
		</div>
		<div class="block last">
        	<?php woo_sidebar('footer-3'); ?>    
		</div>
		<div class="fix"></div>

	</div><!-- /#footer-widgets  -->
    <?php endif; ?>
    <?php } ?>
    <div id="footer-outer">
    
		<div id="footer" class="col-full">
		
			<div id="copyright" class="col-left">
				<p>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?>. <?php _e('All Rights Reserved.', 'woothemes') ?></p>
			</div>
			
			<div id="credit" class="col-right">
				<p><?php _e('Powered by', 'woothemes') ?> <a href="http://www.wordpress.org">WordPress</a>. <?php _e('Designed by', 'woothemes') ?> <a href="http://www.woothemes.com"><img src="<?php bloginfo('template_directory'); ?>/images/woothemes.png" width="74" height="19" alt="Woo Themes" /></a></p>
			</div>
			
		</div><!-- /#footer  -->
	
	</div><!-- /#footer-outer  -->

</div><!-- /#wrapper -->
<?php wp_footer(); ?>
<?php woo_foot(); ?>
</body>
</html><!-- code removed by Brian Hull -->