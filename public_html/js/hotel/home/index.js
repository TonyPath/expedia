$(document).ready(function(){
	
	var city_flag = false;
	var is_selected = false;
	
	// functions for datepicker
	$(function(){
	
		$("#arrival_date").datepicker({
		      defaultDate: "+1d", 
		      numberOfMonths: 2,
		      dateFormat:"dd-mm-yy",
		      minDate: "+0d",
		      hideIfNoPrevNext:true,
		      onClose: function( selectedDate ) {
		        $( ".to" ).datepicker( "option", "minDate", selectedDate );
		      }
		});
		
		$("#departure_date").datepicker({
		      defaultDate: "+5d", 
		      numberOfMonths: 2,
		      minDate: "+0d",
		      dateFormat:"dd-mm-yy",
		      onClose: function( selectedDate ) {
		        $( ".from" ).datepicker( "option", "maxDate", selectedDate );
		      }
		});
	
	});
	
	// functions for auto-complete
	$(function(){

		$.widget( "custom.catcomplete", $.ui.autocomplete, {
			
			_renderMenu: function( ul, items ) {
				
				var that = this;
		        currentCategory = "";
		        
		        $.each( items, function( index, item ) {
		        	
		        	if ( item.category != currentCategory ) 
		        	{
		        		ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
		        		currentCategory = item.category;
		        	}
		          
		        	that._renderItemData( ul, item );
		        });
			},
			
			_renderItemData: function(ul, item){
				
				return $("<li></li>")
						.data("ui-autocomplete-item", item)
						.append("<a class='ui-corner-all'>" + item.label + "</a>")
						.appendTo(ul);
				}
		});
		
		$("#destination_string").catcomplete({
			delay: 500, 
			minLength: 3,
			source:  function (request, response) {
				
				var term = request.term.replace(/^\s+|\s+$/g, '');
				is_selected = false;
				
				$.ajax({
					data: {'s': term, 'spformat': true},
					url: "/ajaxRequestsHotel/searchDestination",
					dataType: "json",
					type: "GET",
				})
				.done(function(data){
					//console.log(data);
					var new_data = $.map(data["data"], function(item) {
						return {
							category: item.category,
			                label: item.label,
			                value: item.value,
			                id: item.id
						};
					});
					
					response(new_data);
		            is_selected = false;
				})
				.fail(function(){
					console.log('fail');
				});
			},
			select : function(event, ui) {
				
				//ui.item.value = ui.item.label.replace(/<(?:.|\n)*?>/gm, '');
				ui.item.value = ui.item.label;
				is_selected = true;
				
				$("#item_id").val(ui.item.id);
				$("#item_category").val(ui.item.category);
			}
		});
		
		$("#destination_string").on("keyup", function(e){
			var keycode;
	        
			if (window.event){
	          keycode = window.event.keyCode;
	        }
			else if (e){
	          keycode = (e.keyCode ? e.keyCode : e.which);
	        }
	        else{
	          return true;
	        }
			
			if (keycode == 13) {
				 return false;
			}
			else {
				//window.previousKeyCode = keycode;
				return true;
			}
		});
		
		$("#destination_string").on("focus", function(e){
			$("#destination_string").catcomplete("search");
		});

	});
	
	
	$("body .frmSearchHotelHomePage").on("click", "#btnSearchHotel" ,function(){
		search_submit();
	});
	
	$("body .frmSearchHotelHomePage").on("change", "#search_room" ,function(){
		
		console.log('room_change');
		
		var number_of_room = $(this).val();
		
		$(".room-group").hide();
		
		for (var i=0; i<number_of_room; i++)
		{
			
			var $room_group_div = $("#room-group-" + i);

			if ($room_group_div.length > 0){
		        $room_group_div.show();
		        continue;
		    }
			else
			{
				var $room_group_div = $("#room-group-template").clone();
				$room_group_div.attr("id", "room-group-" + i);
				$room_group_div.addClass("room-group");
				
				 var $room_field = $room_group_div.find(".room-field");
				 $room_field.html('Room ' + (i+1) + ':');
				 $("#room-group-container").append($room_group_div);
		    }
		}
	});
	
	$("body .frmSearchHotelHomePage").on("change", ".child-box" ,function(){
		
		console.log('adult_change');
		
		var number_of_children = parseInt($(this).val());
	    var $parent = $(this).parent();
	    
	    $parent.find(".age-block").hide();
	    
	    for(var i=0; i<number_of_children; i++)
	    {
	    	$parent.find("#age-block-" + i).show();
	    }
		
	});
	
	$("#search_room").trigger("change");
});

function search_submit(){
	
	if (validate_search()){
		
		var $form  = $("#btnSearchHotel").closest("form");
		var values = {};
	
		var item_id = $("#item_id").val();
	    var arrival_date = $("#arrival_date").val();
	    var departure_date = $("#departure_date").val();
	    var destination_string = $("#destination_string").val();
	    
	    var total_adults= 0;
	    var total_rooms =0;
	    var total_children = 0;
	    var $room_groups = $(".room-group:visible");
	    var rooms = [];
    
	    $.each($room_groups, function(index, ele){
        
	    	var room = {};
	    	total_rooms +=1;
        
	    	var $adults = $(ele).find("#adult-1");
        
	    	if ($adults){
	    		total_adults += parseInt($adults.val());
	    		room["adults"] = $adults.val();
	    	}
	    	else{
	    		room["adults"] = 0;
	    	}
        
	    	var $children = $(ele).find("#children-1");
        
	    	if ($children){
        	
	    		total_children += parseInt($children.val());
	    		room["children"] = $children.val();
        	
	    		var ages = [];
        	
	    		for (var i=0; i < room["children"]; i++){
        		
	    			var $age = $(ele).find("#age-" + i);
        		
	    			if ($age){
	    				ages.push($age.val());
	    			}
	    		}
        	
	    		room["ages"] = ages;
	    	}
	    	else{
	    		room["children"] = 0;
	    	}
        
	    	rooms.push(room);
	    });

	    var rooms_info = "";

	    $.each(rooms, function(index, r){
	    	rooms_info += "&room" + (index + 1) + "=" + r.adults;
	    	if (r.ages.length > 0){
	    		rooms_info += "," + (r.ages).join(",");
	    	}
	    });
	    
	    rooms_info = rooms_info.substring(1);
    
	    $("input[id='rooms']").remove();
    
	    $('<input />').attr('type', 'hidden')
    		.attr('name', "rooms")
    		.attr('id', "rooms")
    		.attr('value', rooms_info)
    		.appendTo($form);
    
	    check_multiple_location(destination_string, arrival_date, departure_date, rooms, $form);
	}
}

function check_multiple_location(destination_string, arrival_date, departure_date, rooms, $form){
	
	//console.log(rooms);
	//console.log($form.serializeArray());
	
	$form.submit();
}

function validate_search(){
	
	var arrival_date = $("#arrival_date").val();
    var departure_date = $("#departure_date").val();
    var destination_string = $("#destination_string").val();
	
	$("#no_result").hide();

	if (destination_string == ""){
		$("#blank_destination").show();
		return false;
    }
	
    return true;
}