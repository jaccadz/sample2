/**
 *
 *
 * Some Comments here
 *
 */
(function($) {
    $.fn.reverse = [].reverse;
    $.configurableSlider = {};
    $.fn.configurableSlider = function(options){
        /*
         * Let's define some settings
         */
        var settings = {
            selector : this.selector,
            startPos : 0,
            infiniteMode : false,
            fillAfter : false,
            elementParent : 'ul',
            speed : 600,
            easing : 'linear',
            naviMarkup : '<div class="slider-navi"><a class="forward"></a><a class="back"></a></div>',
			naviContainer: false,
            activeItemClass : 'slider-current-active-element',
            slideCallback : function(){
                return false
            },
            whileSlideCallback : function(){
                return false
            }
        };
        var options = $.extend(settings, options);
        this.each(function(){
            var self = this;
            var elParent = $(options.elementParent, self).eq(0);
            var elements = elParent.children();
            elements.eq(0).addClass(options.activeItemClass);
            var elW = elements.outerWidth(true);
            var obj = {actualPos : options.startPos};
            elParent.css({
                left : obj.actualPos
            });
            if(options.infiniteMode){
                
            }
            
            var slide = function(direction){
                slideUnbind();
                if(options.infiniteMode){
					if(direction == 'back'){
						$("> :last", elParent).prependTo(elParent);
                    	obj.actualPos-=elW;
	                    elParent.css({
	                        left : obj.actualPos
	                    });
					};
				};
                var animateTo = obj.actualPos-(elW);
                if(direction == 'back'){
                    animateTo = obj.actualPos+(elW);
                    $('.'+options.activeItemClass).removeClass(options.activeItemClass).prev().addClass(options.activeItemClass);
                }else{
                    $('.'+options.activeItemClass).removeClass(options.activeItemClass).next().addClass(options.activeItemClass);
                }
                obj.actualPos = animateTo;
                elParent.animate({
                    left : animateTo
                }, options.speed, options.easing, function(){
                    if(options.infiniteMode && direction == 'forward'){
                        $("> :first", elParent).appendTo(elParent).css({opacity : 0}).animate({opacity : 1}, 400);
                    	obj.actualPos+=elW;
	                    elParent.css({
	                        left : obj.actualPos
	                    });
                        
                    };
                    options.slideCallback(direction);
                    slideBind();
                });
                options.whileSlideCallback(direction);
            };
           	if(!options.naviContainer){
				options.naviContainer = self;
			}else{
				options.naviContainer = $(options.naviContainer);
			}
			var slideUnbind = function(){
				$(".forward, .back, .prev, .next", options.naviContainer).unbind();
            }
            var slideBind = function(){
                $(".forward, .next", options.naviContainer).click(function(){
                    slide('forward');
                    return false;
                });
                $(".back, .prev", options.naviContainer).click(function(){
                    slide('back');
                    return false;
                });
            };
            elParent.width(elW*elements.length);
            // Init object
            $.configurableSlider[options.selector] = {};
            $.configurableSlider[options.selector] = {options : options, obj : obj};
            slideBind();
        });
        
        /*
         * Return jquery object with selection
         */
        return this;
    };
})(jQuery);