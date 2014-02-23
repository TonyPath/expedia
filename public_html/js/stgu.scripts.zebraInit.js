$( document ).ready(function() {
	 
	
	
	$('#datepicker_1').Zebra_DatePicker({offset:[-170, 321],direction: true,show_other_months:false,show_select_today:false, pair: $('#datepicker_2'),onSelect: function(dateText, inst) {
		 
		var n=dateText.split("-");  
		$('#day_date1').html(n[0]+' '+n[1]);
		$('#year1').html(n[2]);
		$('#day_text1').html(n[3]);
	},
	onClear: function(dateText, inst) {
		 
  
		$('#day_date1').html('');
		$('#year1').html('');
		$('#day_text1').html('');
	}
	});
	
	$('#datepicker_2').Zebra_DatePicker({offset:[-170, 321],	direction: true,show_other_months:false,show_select_today:false, onSelect: function(dateText, inst) {
	 
		var n=dateText.split("-");  
		$('#day_date2').html(n[0]+' '+n[1]);
		$('#year2').html(n[2]);
		$('#day_text2').html(n[3]);
	},
	onClear: function(dateText, inst) {
		 
  
		$('#day_date2').html('');
		$('#year2').html('');
		$('#day_text2').html('');
	}
    
    
    });
	
	 
	
	 
	 
	
 
		
});