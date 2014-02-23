// Hide/show search filters by class	
	 
	function filterByClass( id, element ) {
	     
		$( id+' input' ).change(function() {
			var a=[];
			var query;
			$( element ).hide(); 
				$( id+" input[type='checkbox']:checked").each(function() { 
			    	var selector = $(this).attr('data-filter');
			    	a.push(selector);
			    }  
			);
	 
			query = a.join(', ');	
			 
			if( query ) {
				$( query ).removeAttr('checked');   
				$( query ).fadeIn();
			}
			else {
				 

				$( element ).fadeIn();
			}
		
		});
	
	};
	


$( document ).ready(function() { 
	
 	
	
 
	filterByClass( '#filter','.element' ); 
	
	
	
	var  slider = $('#sample-serialization-example-2')
	,inp1 = slider.parent().find('[name="val1"]')
	,inp2 = slider.parent().find('[name="val2"]')

	slider.noUiSlider({
		 range: [0,900]
		,start: [300,500],
		step:10
		,serialization: {
			// provide 2 jQuery objects
			to: [inp1,inp2],
			// round to 1 decimal
			resolution: 1
		}
	// listen to the form change event
	}).parent().change(function(){
		// filter items when filter link is clicked  
		  
		
		// Form a string and report it
		 $getvalues=slider.val();
		 $('#val3').html($getvalues[0]);
		 $('#val4').html($getvalues[1]);
	});
});
	
	
