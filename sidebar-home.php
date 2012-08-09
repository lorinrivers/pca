<div id="sidebar" class="col-right">

	<?php if (woo_active_sidebar('home-primary')) : ?>
    <div class="primary">
		<?php woo_sidebar('home-primary'); ?>		           
	</div>        
	<?php endif; ?>

	<?php if (woo_active_sidebar('home-secondary-1') || 
			  woo_active_sidebar('home-secondary-2') ) : ?>
    <div class="secondary">
		<?php woo_sidebar('home-secondary-1'); ?>		           
	</div>        
    <div class="secondary last">
		<?php woo_sidebar('home-secondary-2'); ?>		           
	</div>        
	<?php endif; ?>
    
	
</div><!-- /#sidebar --><!-- code removed by Brian Hull -->