$( document ).ready(function() {

 

	 
	
	

// ENQUIRE TOP RIGHT
	$('.datepicker_top_right').Zebra_DatePicker({offset:[-220, 357],direction: true, pair: $('.datepicker1_top_right'),onSelect: function(dateText, inst) {
		 
		var n=dateText.split("-");  
		$('#day_date_top_right').html(n[0]+' '+n[1]);
		$('#year_top_right').html(n[2]);
		$('#day_text_top_right').html(n[3]);
		}
	});
	
	$('.datepicker1_top_right').Zebra_DatePicker({offset:[-220, 357],	direction: true,onSelect: function(dateText, inst) {
	 
		var n=dateText.split("-");  
		$('#day_date1_top_right').html(n[0]+' '+n[1]);
		$('#year1_top_right').html(n[2]);
		$('#day_text1_top_right').html(n[3]);
		}    
	});
    
    

	
	
	// CONTACT 
	$( "#contact" ).on('click', function () {
		$( "#contact_more" ).slideToggle();
		$( "#contact" ).fadeOut();
	});
	
	$( "#hide" ).on('click', function () {
		$( "#contact_more" ).slideToggle();
		$( "#contact_more" ).fadeOut();
		$( "#contact" ).fadeIn();
	});
	
	
	// CALENDAR
	
	// AJAX CALL
	$("#submit_enquire").click(function(){
		var name    = $( "#enquire_name" ).val();
		var email    = $( "#enquire_email" ).val();
		var phone    = $( "#enquire_phone" ).val();
		var message    = $( "#enquire_message" ).val();
		var duration    = $( "#enquire_duration" ).val();
		var price    = $( "#enquire_duration" ).val();
		 
		 
        $.post('/ajax/submit_enquire', { name: name, email: email, phone: phone, message: message },
        function(response) {
            if ( response.status == 0 ) {
            	$("#enquire_more").slideToggle();
    	        $("#submit_enquire_response").show().html('Enquiry not submitted');
            } else {
            	$("#enquire_more").slideToggle();
    	        $("#submit_enquire_response").show().html('Enquiry submitted');
            }
        }, 'json');
			 
        $("#enquire_more").slideToggle();
        $("#submit_enquire_response").show().html('Enquiry submitted');     
	         
	        
	});
	
	// CLICK ENQUIRE BUTTON
	$("#enquire").click(function() {
		$("#enquire_more").slideToggle();
		$("#enquire").fadeOut();
	});
	
	// CLICK CLOSE BUTTON ON POPUP
	$( "#hide_calendar_popup" ).click(function() {
		$("#calendar-modal").fadeOut().removeClass("active");
	});
	
	  
	
	// CLICK OUTSIDE POPUP
	$("body").click(function(){
	  $("#calendar-modal").fadeOut().removeClass("active");
	});
	
	$("#calendar-modal").click(function(e){
	  e.stopPropagation();
	});
	 
	 
	
	$(".datepicker2").datepicker({
		firstDay: 1,
		minDate: 0,
		changeMonth: false,
		numberOfMonths: [2,1],
		beforeShowDay: function(date) {
			var array = ["2013-03-14","2013-03-15","2013-03-16"]
			var date1 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#input1").val());
			var date2 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#input2").val());
			return [true, date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)) ? "dp-highlight" : ""];
			
			 var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		     return [ array.indexOf(string) == -1 ]
		},
		onSelect: function(dateText, inst) {
			var date1 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#input1").val());
			var date2 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#input2").val());
            var selectedDate = $.datepicker.parseDate($.datepicker._defaults.dateFormat, dateText);
            
            
            $("#submit_enquire_response").hide().html('');
            
            $('#calendar-modal').hide();
            
            
            //problem on firefox //
            e = window.event;
            
            $(window).click(function(e) {
            	//$('#calendar-modal').hide();
            });
            
            $( "#enquire_more" ).hide();
            $( "#enquire" ).show();
            
            if (!date1 || date2) {
				$("#input1").val(dateText);
				$("#input2").val("");
				$("#input11").html(dateText);
				$("#input22").html("");
				$("#enquire_duration").html("");
                $(this).datepicker();
            } else if( selectedDate < date1 ) {
            	delta_ms = date1 - selectedDate;
                delta_days = Math.round(delta_ms / (1000 * 60 * 60 * 24));
                
                $("#input2").val( $("#input1").val() );
                $("#input1").val( dateText );
                
                $("#input22").html($("#input2").val());
				$("#input11").html(dateText);
				
				$("#enquire_duration").html(delta_days+' nights');
				
				$('#calendar-modal').show().css({
                    position:  'absolute',
                    top:       $(window).scrollTop()+event.clientY-100,
                    left:      event.clientX+60
                });
				
                $(this).datepicker();
                
            } else {
            	delta_ms = selectedDate - date1;
                delta_days = Math.round(delta_ms / (1000 * 60 * 60 * 24));
				$("#input2").val(dateText);
				$("#input22").html(dateText);
                $(this).datepicker();
                $("#enquire_duration").html(delta_days);
                e = window.event;
                $('#calendar-modal').show().css({
                    position:  'absolute',
                    top:       $(window).scrollTop()+window.event.clientY-100,
                    left:      window.event.clientX+60
                });
			}
		}
	});
	
	
});