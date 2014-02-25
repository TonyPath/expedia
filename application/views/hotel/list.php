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
		
		<input type="hidden" id="minRate" value="0" />
    	<input type="hidden" id="maxRate" value="1000" />
		
		<p>
  			<label for="amount">Price range:</label>
 			 <input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;">
		</p>
 
		<div id="slider-rate-filter"></div>
		
		<div class="bold-text" style="margin-top: 15px;">
			Star Rating
        	<br />
        	<input type="radio" name="star-filter" value="1" checked>Any Star Rating<br>
			<input type="radio" name="star-filter" value="2">2 Stars (and up)<br>
			<input type="radio" name="star-filter" value="3">3 Stars (and up)<br>
			<input type="radio" name="star-filter" value="4">4 Stars (and up)<br>
			<input type="radio" name="star-filter" value="5">5 Stars (and up)<br>
        </div>
        
        <div class="bold-text" style="margin-top: 15px;" id="rate-filter-container">
			Avg. Nightly Rate
        	<br />
        	
        </div>
		
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
            		<option value="PRICE">Price (Low to High)</option>
            		<option value="PRICE_REVERSE">Price (High to Low)</option>
            		<option value="QUALITY_REVERSE">Star Rating (Low to High)</option>
            		<option value="QUALITY" selected>Star Rating (High to Low)</option>
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