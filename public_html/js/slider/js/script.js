$(document).ready(function() {
		// $('.swiper-container .left').hide();
		// $('.swiper-container .right').hide();
		var mySwiper = new Swiper('.swiper-container',{
	    pagination: '.pagination',
	    paginationClickable: true,
	    slidesPerView: 1,
	    speed:400,
	    grabCursor:false,
	    freeMode:false,
	    freeModeFluid:false
	  })
		$('.swiper-container .left').click(function(){mySwiper.swipePrev()})
		$('.swiper-container .right').click(function(){mySwiper.swipeNext()})
		//$('.swiper-container').mouseover(function(){$('.swiper-container .left').fadeIn(); $('.swiper-container .right').fadeIn()})
		//$('.swiper-container').mouseout(function(){$('.swiper-container .left').fadeOut(); $('.swiper-container .right').fadeOut()})
		
		
 
		 

		
		
	});