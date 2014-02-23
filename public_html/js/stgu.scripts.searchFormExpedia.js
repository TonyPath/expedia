$(document).ready(function(){
	
	$("#arrivalDate").datepicker({
	      defaultDate: "+1d", 
	      numberOfMonths: 2,
	      dateFormat:"dd-mm-yy",
	      minDate: "+0d",
	      hideIfNoPrevNext:true,
	      onClose: function( selectedDate ) {
	        $( ".to" ).datepicker( "option", "minDate", selectedDate );
	      }
    });
	
	$("#departureDate").datepicker({
	      defaultDate: "+5d", 
	      numberOfMonths: 2,
	      minDate: "+0d",
	      dateFormat:"dd-mm-yy",
	      onClose: function( selectedDate ) {
	        $( ".from" ).datepicker( "option", "maxDate", selectedDate );
	      }
    });
 
 

	$('#rooms').change(function() {

        var roomcount = $(this).val();

        for (var i = 1; i <= roomcount; i++) {

            $('#RoomContainer' + i).show();
        }

        for (var i = ++roomcount; i <= 8; i++) {
            $('#RoomContainer' + i).hide();
        }
    });

    $('.childCount').change(function() {

        var loc = $(this).attr('rel');
        var nochild = $(this).val();

        $('#childAgeHeading' + loc).show();
        if (nochild == 0) {
            $('#childAgeHeading' + loc).hide();
        }
        for (var i = 1; i <= nochild; i++) {

            $('#childAge' + loc + i).show();

        }
        for (var i = ++nochild; i <= 3; i++) {

            $('#childAge' + loc + i).hide();
        }
    });
    
    $( "#city" ).autocomplete({
        
        source: function( request, response ) {
            
        	$.ajax({
        		url: "/hotel/search_region/",
                dataType: "json",
                data: {
                  term: request.term
                },
                success: function( data ) {
                	response( $.map( data.regions, function( item ) {
            			
                		return {
                			label: item.region_name,
                			value: item.region_name,
                			region_id: item.region_id
                		};
                	}));
                }
            });
        },
        
        select: function( event, ui) {
            this.value = ui.item.label;
            $('#regionId').val(ui.item.region_id);
        }
      });

    
});
    
    function split( val ) {
        return val.split( /,\s*/ );
      }
      function extractLast( term ) {
        return split( term ).pop();
      }    