<?php foreach ($hotels as $idx=>$hotel) :

	$overview_url_query_params = http_build_query(array_merge($availabilityParams, array('hotelId'=>$hotel->id, 'currencyCode'=>$currencyCode)));
	$overview_url = "/hotel/overview/?" . $overview_url_query_params;
?>
	<div  style="border:1px black solid;margin:20px;" class="hotel-item" data-rating="<?php echo $hotel->rating; ?>" data-price=<?php echo round($hotel->sortedPrice); ?> >
		<div  style="padding: 10px 0px 10px 0px; ">
        
	       	<div  style="display: inline;float: left;width: 75%;">
	                
	                <?php if (isset($hotel->thumbUrl)) :?>
	                <a target="_blank" href="<?php echo $overview_url; ?>" style="float: left;margin-right: 10px;">
	                    <img src="<?php echo $hotel->thumbTypes->f90; ?>" />
	                </a>
	                <?php endif; ?>
	                
	            	<div class="informationColumn" style="display: inline;float: left;width: 77%;">
	            	
	            		<h5 style="display:block">
	                		<a target="_blank" href="<?php echo $overview_url; ?>">
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
	                <a target="_blank" href="<?php echo $overview_url; ?>" >
	                    <div>
	                        <?php echo $hotel->promoRoom->ratesInfo->promoDescription; ?>
	                    </div>                   
	                </a>
	 				<?php endif; ?>
	    		
	            	<div class="pricing">
	                	<span class="smallText">Total From  </span><br>
	                	<a target="_blank" href="<?php echo $overview_url; ?>">

	                    	<?php if ($hotel->promoRoom->ratesInfo->isPromo == true) : ?>
	                    	<span style="text-decoration:line-through;"> <?php echo $currencySign; ?> <?php echo round($hotel->promoRoom->ratesInfo->allRoomsAllDays->totalBasePrice); ?></span>
	                    	<?php endif; ?>

	                    	<span style="font-size: 1.2em; font-weight: bold;"><?php echo $currencySign; ?> <?php echo round($hotel->promoRoom->ratesInfo->allRoomsAllDays->totalPrice); ?></span>
	                	</a>
	                
	                	<br>
	                
	                	<!--  
	                	<form id="booking_form" accept-charset="UTF-8" action="<?php echo $overview_url; ?>" method="post">
	                		
	                		<input type='hidden' name='rate_key' value='<?php echo $hotel->rateKey; ?>'/>
	                		
	                		<input type='submit' class="button" value='Book now' id='book-btn'/>
	                	</form>
	                	-->
	                	
	                	<a target="_blank" href="<?php echo $overview_url; ?>">Επιλογή</a>
	            
	            	</div>
	            <?php else: ?>
           			<div class="pricing">
           			
           				<span class="smallText">Nightly Rate from  </span><br>
           				<a target="_blank" href="<?php echo $overview_url; ?>">
           					<span style="font-size: 1.2em; font-weight: bold;"><?php echo $currencySign; ?> <?php echo round($hotel->lowRate); ?></span>
           				</a>
           				
           				<br>
	                
	                	<a target="_blank" href="<?php echo $overview_url; ?>">Επιλογή</a>
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

</script>


