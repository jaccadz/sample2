//OnFocus input

$(function(){

	$("#home #slider").configurableSlider({infiniteMode : true, speed : 800, easing : 'swing', naviContainer : '#slider-nav', slideCallback : function(){
		$('#header .side-bg p').html($('.slider-current-active-element .cat-description').html());
		var href = $('.slider-current-active-element a').attr('href');
		$("#header a.button").attr('href', href);
		var section = $('.slider-current-active-element').attr('id').replace('element-', 'section-');
		$("body").attr('class', section);
	}});
	$(".thumb a").lightBox();
});
