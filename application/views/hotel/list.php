<?php
$params = $_GET;
$copy_params = $_GET;
?>
<script type="text/javascript">

</script>

<style type="text/css">
.template {
	display:none;
}
</style>

<section style="padding-top:120px;">

	<div class="row">
	
		<div class="column_12">
			<select id="currency-filter" name="currency-filter">
            <option value="USD">USD $</option>
            <option value="EUR" selected>EUR €</option>
            <option value="GBP">GBP £</option>
            <option value="AUD">AUD A$</option>
			</select>
		</div>
		
	</div>

	<div class="row">
		<div class="column_6">
			<span class="" id="hotel_location">Hotels in <?php echo $params['destination_string']; ?></span>
	        <span id = "rooms-info"></span>
	    </div>
	    <div class="column_3" id="change_search_btn"><a>Change Search</a></div>
	    <div class="column_2"><input type="button" href="#map_canvas" class="button" value="Show map"  id="toogle_view" /></div>
	</div>
	<br/>
	
	<div style="width:18%;float:left;" class="">
        
        <fieldset id="FilterByStar">
        	<legend>Star Rating</legend>
    
   			<div id="star-range"></div>
    		<div id="slider-star-filter" class=""></div>
    
    		<input type="hidden" id="minStarRating" value="1" />
    		<input type="hidden" id="maxStarRating" value="5" />
		</fieldset>
        
        
        <fieldset id="FilterByPrice">
        	<legend>Total price</legend>
    
   			<div id="price-range"></div>
    		<div id="slider-rate-filter" class=""></div>
    
    		<input type="hidden" id="minRate" value="0" />
    		<input type="hidden" id="maxRate" value="1000" />
		</fieldset>
		
	</div>
	
	<div style="width:80%;float:right;">
	
		<div class="row">
			<div class="column_3">
				<span class="">Check in</span>
				<input type="text" id="search_checkin_inline" name="search_checkin_inline" value="<?php echo $checkin_date; ?>" />
				<input type="hidden" value="<?php echo $checkin_date; ?>" id="h_search_checkin_inline" />
			</div>
			<div class="column_3">
				<span class="">Check out</span>
				<input type="text" id="search_checkout_inline" name="search_checkout_inline" value="<?php echo $checkout_date; ?>"  />
				<input type="hidden" value="<?php echo $checkin_date; ?>" id="h_search_checkout_inline" />
			</div>
			<div class="column_2">
				<input type="button" class="button" value="Search"  id="btn-change-date" />
			</div>
			<div class="column_4">
				<span class="">Sort by:</span>
				<select class="" id="sort-by">
					<option value="OVERALL_VALUE" selected>Our Recommendations</option>
            		<option value="PRICE_AVERAGE">Price (Low to High)</option>
            		<option value="PRICE_REVERSE">Price (High to Low)</option>
            		<option value="QUALITY_REVERSE">Star Rating (Low to High)</option>
            		<option value="QUALITY">Star Rating (High to Low)</option>
            		
          		</select>
        	</div>
		</div>
		
		<br />
		
		<div id="hotels-list" style = "min-height: 100px;"></div>
	</div>

	
	<div style="clear:both;"></div>
</section>


<script type="text/javascript">
var rate_filters = null;

var g_hashParams = <?php echo json_encode($copy_params); ?>;
var g_cache_key ='';
var g_cache_location = '';
var g_is_more_results = true;
var g_total_results = 0;
var g_items_showed = 0;
var g_allow_ajax_loading =false;
var g_total_results = 0;
var g_items_showed = 0;
var last_request_search_hotel = null;
</script>