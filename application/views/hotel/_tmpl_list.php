
	<?php foreach ($hotels as $idx=>$hotel) : ?>
	
	<div  style="border:1px black solid;margin:20px;">
		<div  style="padding: 10px 0px 10px 0px; ">
        
	       	<div  style="display: inline;float: left;width: 75%;">
	                
	                <?php if (isset($hotel->thumbUrl)) :?>
	                <a target="_blank" href="#" style="float: left;margin-right: 10px;">
	                    <img src="<?php echo $hotel->thumbTypes->f90; ?>" />
	                </a>
	                <?php endif; ?>
	                
	            	<div class="informationColumn" style="display: inline;float: left;width: 77%;">
	            	
	            		<h5 style="display:block">
	                		<a target="_blank" href="#">
								<?php echo $hotel->name; ?>
	                		</a>
	            		</h5>
	                	<div class="clear"><?php echo $hotel->rating; ?></div>
	                	<div class="clear">
	                        <?php echo $hotel->locationDescription; ?>
	                    	<br>
	                    	<a href="#"><span >Εμφάνιση στο χάρτη</span></a>
	                	</div>
	            	</div>
	        </div>
        
        
	        <div  style="display: inline;float: left;width: 25%;">
                <?php if (isset($hotel->promoRoom)) : ?>
                
	                <?php if ($hotel->promoRoom->ratesInfo->isPromo) :?>
	                <a target="_blank" href="#" >
	                    <div>
	                        <?php echo $hotel->promoRoom->ratesInfo->promoDescription; ?>
	                    </div>                   
	                </a>
	 				<?php endif; ?>
	    		
	            	<div class="pricing">
	                	<span class="smallText">Σύνολο από  </span><br>
	                	<a target="_blank" href="#">

	                    	<?php if ($hotel->promoRoom->ratesInfo->isPromo == true) : ?>
	                    	<span style="text-decoration:line-through;"> € <?php echo $hotel->promoRoom->ratesInfo->allRoomsAllDays->totalBasePrice; ?></span>
	                    	<?php endif; ?>

	                    	<span style="font-size: 1.2em; font-weight: bold;">€ <?php echo $hotel->promoRoom->ratesInfo->allRoomsAllDays->totalPrice; ?></span>
	                	</a>
	                
	                	<br>
	                
	                	<a target="_blank" href="#">Επιλογή</a>
	            
	            	</div>
           
            	<?php endif; ?>
    		</div>
    	
    		<div style="clear:both;"></div>
    
    	</div>
    
	</div>

	<div style="clear:both;"></div>

	<?php endforeach; ?>


<script type="text/javascript">
g_cache_key = "<?php echo $cache_key; ?>";
g_cache_location = "<?php echo $cache_location; ?>";
g_is_more_results = "<?php echo $more_results_available; ?>";
g_total_results = "<?php echo $active_property_count; ?>";

rate_filters = <?php echo json_encode($rate_filters); ?>
</script>


