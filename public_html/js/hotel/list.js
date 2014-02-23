$(document).ready(function(){
	
	searchHotels();
	
	$(function(){
		
		var params = jQuery.parseJSON( g_hashParams );
		params["spformat"] = true;
		
		$('#hotels-list').scrollPagination({
			'contentPage': "/ajaxRequestsHotel/listHotels",
			'contentData': params,
			'scrollTarget': $(window),
			'heightOffset': 50,
			'beforeLoad': function(){
			},
			'afterLoad': function(elementsLoaded){
				
				//console.log(elementsLoaded);
				
				//$("#hotels-list").html(elementsLoaded.data);
				
				//$('#content').stopScrollPagination();
			}
		});
		
	});
	
	
});

function searchHotels(){
	
	var params = jQuery.parseJSON( g_hashParams );
	
	params["spformat"] = true;
	
	$.ajax({
		url: "/ajaxRequestsHotel/listHotels",
		type: "POST",
		data: params,
		dataType: "json",
		success: function(result){
			
			//console.log(result);
			
			$("#hotels-list").html(result.data);
			
			g_allow_ajax_loading = true;
		}
	});
}