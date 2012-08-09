<?php
	
	$maps_active = get_post_meta(get_the_id(),'woo_maps_enable',true);
	$src = get_post_meta(get_the_id(),'image',true);
	
	if($maps_active == 'on') {

?>
		<div id="eventlocation">	
			<div id="eventlocation-map">
				<div class="woo_map_single_output">
				    
				    <?php 
					
                    $address = get_post_meta(get_the_id(),'woo_maps_address',true);
                    $long = get_post_meta(get_the_id(),'woo_maps_long',true);
                    $lat = get_post_meta(get_the_id(),'woo_maps_lat',true);
                    $zoom = get_post_meta(get_the_id(),'woo_maps_zoom',true);
                    $type = get_post_meta(get_the_id(),'woo_maps_type',true);
                    if(!empty($lat)){
                    	woo_maps_single_output($address,$long,$lat,$zoom,$type); 
                    }
                    
				    ?>
				</div>
			</div>
		</div>

<?php } else { echo '<div class="spacer"></div>';}
