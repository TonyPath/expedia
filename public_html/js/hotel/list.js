$(document).ready(function(){
	
	searchHotels(false);
	
	$(function(){
		
		//var params =  g_hashParams;
		//params["spformat"] = true;
		
		$('#hotels-list').scrollPagination({
			'contentPage': "/ajaxRequestsHotel/listHotels",
			'contentData': g_hashParams,
			'scrollTarget': $(window),
			'heightOffset': 50,
			'beforeLoad': function(){
				g_hashParams["spformat"] = true;
			},
			'afterLoad': function(elementsLoaded){
			}
		});
		
	});
	
	$("#sort-by").change(processSortBy);
	$('input[name="star-filter"]').change(processStarFilter);
	//$('input[name="rate-filter"]').change(processRateFilter);
	$("body").on("change", "input[name='rate-filter']", processRateFilter);
	
	// functions for slider range
	$(function() {
		
		$( "#slider-rate-filter" ).slider({
			range: true,
			min: 0,
			max: 1000,
			step: 10,
			values: [ 0, 1000 ],
			change: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
				
				$("#minRate").val(ui.values[ 0 ]);
				$("#maxRate").val(ui.values[ 1 ]);
				
				processRateFilter();
			}
	    });
		
	    $( "#amount" ).val( "$" + $( "#slider-rate-filter" ).slider( "values", 0 ) + " - $" + $( "#slider-rate-filter" ).slider( "values", 1 ) );
	});
	
	// functions for datepicker
	$(function(){
	
		$("#search_checkin_inline").datepicker({
		      defaultDate: "+1d", 
		      numberOfMonths: 2,
		      dateFormat:"dd-mm-yy",
		      minDate: "+0d",
		      hideIfNoPrevNext:true,
		      onClose: function( selectedDate ) {
		      }
		});
		
		$("#search_checkout_inline").datepicker({
		      defaultDate: "+5d", 
		      numberOfMonths: 2,
		      minDate: "+0d",
		      dateFormat:"dd-mm-yy",
		      onClose: function( selectedDate ) {
		      }
		});
		
		// allow delete date fields by Backspace key and Delete key
		$("#search_checkin_inline").keydown(function(event) {
			if (event.which === 8 || event.which === 46) {
				$(this).val("");
			}
		});
		
		$("#search_checkout_inline").keydown(function(event) {
			if (event.which === 8 || event.which === 46) {
				$(this).val("");
			}
	    });
		
		$("#search_checkin_inline").attr('readonly', true);
		$("#search_checkout_inline").attr('readonly', true);

	});
	
	$("#btn-change-date").on('click', function(){
		
		var arrival_date = $("#search_checkin_inline").val();
	    var departure_date = $("#search_checkout_inline").val();
	    
	    g_hashParams["arrival_date"] = arrival_date;
	    g_hashParams["departure_date"] = departure_date;
	    
	    $("#h_search_checkin_inline").val(arrival_date);
	    $("#h_search_checkout_inline").val(departure_date);
	    
	    delete g_hashParams.cacheKey;
		delete g_hashParams.cacheLocation;
	    
	    searchHotels(false);
	});
	
	$("#currency-filter").change(function(){
		searchHotels(true);
	});
	
	
});

function searchHotels(is_currency_filter){
	
	var params = g_hashParams;
	
	params["minRate"] = $( "#minRate" ).val();
	params["maxRate"] = $( "#maxRate" ).val();
	params["minStarRating"] =$("input[name='star-filter']:checked").val();
	params["sort"] = $("#sort-by").val();
	params["currencyCode"] = $("#currency-filter").val();
	params["spformat"] = true;

	if(last_request_search_hotel){
		last_request_search_hotel.abort();
	}
	
	last_request_search_hotel = $.ajax({
		url: "/ajaxRequestsHotel/listHotels",
		type: "POST",
		data: params,
		dataType: "json"
	})
	.done(function(result){
			
		last_request_search_hotel = null;
			//console.log(result);
			
		$("#hotels-list").html(result.data.hotelList);
			
		if(is_currency_filter){
			$("#rate-filter-container").empty();
				
			$.each(rate_filters, function(index, ele){
				$("#rate-filter-container").append("<input type=\"radio\" name=\"rate-filter\" value=" +  ele.value + " " + ele.selected + ">" + ele.name + "<br/>");
		       });
		}
			
		g_allow_ajax_loading = true;
	});
	
}

function processStarFilter(){
	
	g_hashParams["minStarRating"] =  $("input[name='star-filter']:checked").val();
	g_hashParams["sort"] = $("#sort-by").val();
	
	searchHotels(false);
}

function processSortBy(){
	
	g_hashParams["sort"] = $("#sort-by").val();
	
	delete g_hashParams.cacheKey;
	delete g_hashParams.cacheLocation;
	
	searchHotels(false);
}

function processRateFilter(){

	g_hashParams["minRate"] = $( "#minRate" ).val();
	g_hashParams["maxRate"] = $( "#maxRate" ).val();
	g_hashParams["sort"] = $("#sort-by").val();
	
	searchHotels(false);
	
	/*
	var filterValue = $("input[name='rate-filter']:checked").val();
	var filterValues = [];
	
	if(filterValue != "-1"){
		filterValues = filterValue.split("-");
		g_hashParams["minRate"] = filterValues[0];
		g_hashParams["maxRate"] = filterValues[1];
	}
	else{
		g_hashParams["minRate"] = null;
		g_hashParams["maxRate"] = null;
	}
	
	g_hashParams["sort"] = $("#sort-by").val();
	
	searchHotels(false);
	*/
}