$( document ).ready(function() {
	
	$('#select_hotel').dropkick();
	$('#select_unhotel').dropkick();
	$('#select_places').dropkick();
	$('#select_events').dropkick();
	$('#select_locals').dropkick();
	$('#select_events_time').dropkick();
	
	
	$( "#bottom_explore" ).click(function() {
		  $( "#slide_explore" ).slideToggle();
		});
	
 
	
	$(function(){
		var cur = -1, prv = -1, cnt=0;
		$( "#fly" ).datepicker({
		     close:false,
		     dateFormat:"dd/mm/y",
		     numberOfMonths: [1,2],
		     
		            beforeShowDay: function ( date ) {
		                  return [true, ( (date.getTime() >= Math.min(prv, cur) && date.getTime() <= Math.max(prv, cur)) ? 'date-range-selected' : '')];
		               },
		              
		     onSelect: function ( dateText, inst ) {
		    	 			
		    	 $( "#fly_phrase" ).html('from ');
		                  var d1, d2;
		                  //$( "#fly" ).css("font-size", 20);
		                  cnt=cnt+1; 
		                  if(cnt==1){ $(this).data('datepicker').inline = true;}
		                  else {cnt=0;$(this).data('datepicker').inline = false;}
		                    
		                  
		                  prv = cur;
		                  cur = (new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)).getTime();
		                  if ( prv == -1 || prv == cur ) {
		                	   
		                     prv = cur;
		                     $('#fly').val( dateText );

		                       

		      $("#fly").datepicker( "show" );
		                  } else {
		                     d1 = $.datepicker.formatDate( 'dd/mm/y', new Date(Math.min(prv,cur)), {} );
		                     d2 = $.datepicker.formatDate( 'dd/mm/y', new Date(Math.max(prv,cur)), {} );
		                     $('#fly').val( ''+d1+' to '+d2 );
		                     $(this).css("width",290);
		                     //$(this).data('datepicker').inline = false;
		                  }
		               },
		 onClose: function(date,b){

		 var dat=$("#fly").val();
		 if(dat.length=='10'){
		 /*alert("here");
		 return false;*/
		 $("#fly").datepicker("refresh").show();
		 }
		 }
		 });
		});
	
	$(function(){
		var cur = -1, prv = -1, cnt=0;
		$( "#suggestions" ).datepicker({
		     close:false,
		     dateFormat:"dd/mm/y",
		     numberOfMonths: [1,2],
		     
		            beforeShowDay: function ( date ) {
		                  return [true, ( (date.getTime() >= Math.min(prv, cur) && date.getTime() <= Math.max(prv, cur)) ? 'date-range-selected' : '')];
		               },
		              
		     onSelect: function ( dateText, inst ) {
		    	 			
		    	  
		    	 
		                  var d1, d2;
		                  //$( "#suggestions" ).css("font-size", 20);
		                  cnt=cnt+1; 
		                  if(cnt==1){ $(this).data('datepicker').inline = true;}
		                  else {cnt=0;$(this).data('datepicker').inline = false;}
		                    
		                  
		                  prv = cur;
		                  cur = (new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)).getTime();
		                  if ( prv == -1 || prv == cur ) {
		                	   
		                     prv = cur;
		                     $('#suggestions').val( dateText );

		                       

		      $("#suggestions").datepicker( "show" );
		                  } else {
		                     d1 = $.datepicker.formatDate( 'dd/mm/y', new Date(Math.min(prv,cur)), {} );
		                     d2 = $.datepicker.formatDate( 'dd/mm/y', new Date(Math.max(prv,cur)), {} );
		                     $('#suggestions').val( d1+' - '+d2 );
		                     $(this).css("width",270);
		                     //$(this).data('datepicker').inline = false;
		                  }
		               },
		 onClose: function(date,b){

		 var dat=$("#suggestions").val();
		 if(dat.length=='10'){
		 /*alert("here");
		 return false;*/
		 $("#suggestions").datepicker("refresh").show();
		 }
		 }
		 });
		});

	
	
	
	$("#jrange4").datepicker({ 
		firstDay: 1,
		minDate: 0,
		changeMonth: false,
		numberOfMonths: [1,2],
		onSelect: function(dateText, inst) {
			
			this._updateDatepicker(inst);
			 
		}
	});
	
	
	
	$("#jrange1").datepicker({ 
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
	
	
	
  $(function() {
	  
  $( ".from" ).datepicker({
		      defaultDate: "+1w", 
		      numberOfMonths: 2,
		      dateFormat:"dd-mm-yy",
		      minDate: "+0d",
		      hideIfNoPrevNext:true,
		      onClose: function( selectedDate ) {
		        $( ".to" ).datepicker( "option", "minDate", selectedDate );
		      }
		    });
		    $( ".to" ).datepicker({
		      defaultDate: "+1w", 
		      numberOfMonths: 2,
		      minDate: "+0d",
		      dateFormat:"dd-mm-yy",
		      onClose: function( selectedDate ) {
		        $( ".from" ).datepicker( "option", "maxDate", selectedDate );
		      }
		    });
		  }); 
	  
	  
	  
	 
// AUTOCOMPLETE
	    var availableTags = [
	                         "Athens",
	                         "Paris",
	                         "Greece",
	                         "London",
	                         "Berlin",
	                         "Guatemala",
	                         "Rome",
	                         "Prague",
	                         "United Kingdom"
	                       ];
       $( "#search_text1" ).autocomplete({
         source: availableTags
       });
	                    
	  
	  
	
	
	//$('#rangeA').daterangepicker();
	
	$('#full-width-slider').royalSlider({
	    arrowsNav: true,
	    loop: true,
	    keyboardNavEnabled: true,
	    controlsInside: true,
	    imageScaleMode: 'none',
	    arrowsNavAutoHide: true, 
	    transitionSpeed:1300,
	    autoPlay: {
    		// autoplay options go gere
    		enabled: true,
    		pauseOnHover: true,
    		delay:7000
    	},
	     
	    startSlideId: 0,
	     
	    transitionType:'fade'
	  });
	
	 
	// image slider arrows
	
	$("#slider_next").click(function(event) {
		var slider = $("#full-width-slider").data('royalSlider');
		slider.next();
	});
	
	$("#slider_previous").click(function(event) {
		var slider = $("#full-width-slider").data('royalSlider');
		slider.prev();
	});
	
	$("#slider_next").hide(); 
	$("#slider_previous").hide(); 
	$("#full-width-slider, #mainsearch, #slider_previous, #slider_next, #blinds").mouseover(function() {
	    
	    $("#slider_next").show(); 
		$("#slider_previous").show();
	});    
	    
	$("#full-width-slider, #mainsearch, #slider_previous, #slider_next, #blinds").mouseout(function() {
	    
	    $("#slider_next").hide(); 
		$("#slider_previous").hide();
	}); 
	
	
	
	
	 //var nlform = new NLForm( document.getElementById( 'nl-form' ) );
	$("[id*='searchbars_1_2']").hide(); 
	$("[id*='searchbars_2_1']").hide();
	$("[id*='searchbars_3_1']").hide();
	$("[id*='searchbars_3_2']").hide();
	$("[id*='searchbars_3_3']").hide();
	
	$("[id*='tabs_']").click(function(event) {
	    event.preventDefault();
	    var block_id    = $(this).attr('id');
        var id_split    = block_id.split('_');
        //var type      = id_split[1];
        var id      = id_split[1];
        
        $("[id*='searchbars_']").hide();
	    $("#searchbars_"+id+"_1").show(); 
        
        $("[id*='tabs_']").removeClass( "theme" );
        $("[id*='tabs_']").addClass("dark_opacity");
	    $("#tabs_"+id).removeClass( "dark_opacity" )
	    $("#tabs_"+id).addClass("theme");
	     
	    $("[class*='tabsmini_']").removeClass( "theme" );
        $("[class*='tabsmini_']").addClass("dark_opacity");
        $(".tabsmini_"+id+"_1").removeClass("dark_opacity");
	});
	
	$("[id*='tabsmini_']").click(function(event) {
	    event.preventDefault();
	    var block_id    = $(this).attr('id');
        var id_split    = block_id.split('_');
        var type      = id_split[1];
        var id      = id_split[2];
        var sel      = id_split[3]; 
        $("[id*='searchbars_']").hide();
	    $("#searchbars_"+type+'_'+sel).show(); 
        //alert(type+' '+id);
        $("[class*='tabsmini_']").removeClass( "theme" );
        $("[class*='tabsmini_']").addClass("dark_opacity");
	    $(".tabsmini_"+type+"_"+sel).addClass( "dark_opacity" )
	    $(".tabsmini_"+type+"_"+sel).removeClass("dark_opacity");
	    
 
    	 
	     
	});
	
	 
});