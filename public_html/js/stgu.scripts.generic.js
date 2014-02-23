$(function() {
				$( '#dl-menu' ).dlmenu();
			}); 



function detectmob() { 
	 if( navigator.userAgent.match(/Android/i)
	 || navigator.userAgent.match(/webOS/i)
	 || navigator.userAgent.match(/iPhone/i)
	 || navigator.userAgent.match(/iPad/i)
	 || navigator.userAgent.match(/iPod/i)
	 || navigator.userAgent.match(/BlackBerry/i)
	 || navigator.userAgent.match(/Windows Phone/i)
	 ){
	    return true;
	  }
	 else {
	    return false;
	  }
	}



	// HIDE HEADER
	var scrollDir = (function () {
	    var previousScroll = 0;
	    var header = document.querySelector('header');
	    
	    if(detectmob()){var height = 57; }
	    else{ 
	    var height = header.clientHeight; 
		}
	    var direction='';
	    var previousDirection='';
	    
	    $(window).scroll(function(){
	       var currentScroll = $(this).scrollTop();
	 
	       if(document.querySelector('header').offsetTop==0 || document.querySelector('header').offsetTop<0) { 
	        
		       if (currentScroll <= previousScroll){ 
		    	    direction='up'; 
		    	   	if(direction!=previousDirection)  { 
				   	    $('header').stop().animate({
				   	        top: 0
				   	    }, 200);
		    	   	}
		       } else {
		    	    direction='down';  
		    	 	if(direction!=previousDirection)  {  
			    	   $('header').stop().animate({
			    	        top: -height
			    	    }, 200);
		       }
	       }
	    }
	        
	       previousDirection = direction;
	       previousScroll = currentScroll;
	    });
	}());



 

$( document ).ready(function() {
 

 
	  
$('#login_ajax').click(function(event) {
    event.preventDefault();
    $('#form').fadeOut(); 
    //$('#form').fadeIn();
}); 

// SEARCH BAR DROPDONWS

 
	function DropDown(el) {
		//var id   = $(this).attr('id');
		
		this.dd = el;
		this.placeholder = this.dd.children('span');
		this.opts = this.dd.find('ul.dropdown > li');
		this.val = '';
		this.index = -1;
		this.initEvents();
		this.flag=0;
	}
	DropDown.prototype = {
		initEvents : function() {
			var obj = this;
			
 
		
	
		obj.dd.on('mouseenter', function(event){
			//$("[class*='wrapper-dropdown']").removeClass('active');
			 //$('section').css('opacity', '0.7');
			$(this).addClass('active');
			$("[class*='wrapper-dropdown']").not(this).removeClass('active');
			
			return false;
		});
		
		obj.dd.on('mouseleave', function(event){
			//$("[class*='wrapper-dropdown']").removeClass('active');
			// $('section').css('opacity', '1');
			$(this).removeClass('active');
			//$("[class*='wrapper-dropdown']").not(this).removeClass('active');
			
			return false;
		});
		
		
		obj.dd.on('click', function(event){
			//$("[class*='wrapper-dropdown']").removeClass('active');
			 //$('section').css('opacity', '0.7');
			$(this).toggleClass('active'); 
			
			return false;
		});

		obj.opts.on('click',function(){
			//$('section').css('opacity', '1');
			var opt = $(this);
			if(opt.find("a").attr("href")!='#'){
				window.location.href = opt.find("a").attr("href");
			}
			
			
			obj.val = opt.text();
			obj.index = opt.index();
			obj.placeholder.text(obj.val); 
			
		});
	},
	getValue : function() {
		return this.val;
	},
	getIndex : function() {
		return this.index;
	}
}

	// SEARCH BAR DROPDONWS

	 
	function DropDownClick(el) {
		//var id   = $(this).attr('id');
		
		this.dd = el;
		this.placeholder = this.dd.children('span');
		this.opts = this.dd.find('ul.dropdown > li');
		this.val = '';
		this.index = -1;
		this.initEvents();
		this.flag=0;
	}
	DropDownClick.prototype = {
		initEvents : function() {
			var obj = this;
			
			obj.dd.on('click', function(event){
			 $("[class*='wrapper-dropdown']").not($(this)).removeClass('active');
			 //$('section').css('opacity', '0.7');
			$(this).toggleClass('active'); 
			
			return false;
		});

		obj.opts.on('click',function(){
			//$('section').css('opacity', '1');
			var opt = $(this);
			if(opt.find("a").attr("href")!='#'){
				window.location.href = opt.find("a").attr("href");
			}
			
			
			obj.val = opt.text();
			obj.index = opt.index();
			obj.placeholder.text(obj.val); 
			
		});
	},
	getValue : function() {
		return this.val;
	},
	getIndex : function() {
		return this.index;
	}
}
 

$(function() {
	
	var dd = new DropDown( $('#dd') );
	//var dd = new DropDown( $('#header_stay') );
	var dd = new DropDown( $("[id*='header_']"));
	
	var dd = new DropDownClick( $("#dropdown_bedrooms"));
	var dd = new DropDownClick( $("#dropdown_bathrooms"));
	var dd = new DropDownClick( $("#dropdown_guests"));
	var dd = new DropDownClick( $("#dropdown_sort"));
	var dd = new DropDown( $('#profile_menu') );
	var dd = new DropDownClick( $('#searchbar_persons') );
	var dd = new DropDownClick( $('#searchbar_persons_travel') );
	var dd = new DropDownClick( $('#searchbar_explore_events') );
	var dd = new DropDownClick( $('#searchbar_explore_places') );
	 
	var dd = new DropDownClick( $('#searchbar_explore_locals') ); 
	var dd = new DropDownClick( $('#bottom_explore') ); 
	
	new DropDownClick( $('#nl_1') );
	new DropDownClick( $('#nl_2') );                                          
	new DropDownClick( $('#nl_3') );
	new DropDownClick( $('#nl_4') );
	new DropDownClick( $('#nl_5') );
	new DropDownClick( $('#nl_6') ); 
	
	
	$(document).click(function() {
 
		 $("[class*='wrapper-dropdown']").removeClass('active');
 
	 
		// $('section').css('opacity', '1');
		
	});
	
	$('section').bind('touchstart', function(event){
		//event.isDefaultPrevented();
		//event.stopPropagation();
		 //$("[class*='wrapper-dropdown']").removeClass('active'); 
		
	})
	

});

 

});
