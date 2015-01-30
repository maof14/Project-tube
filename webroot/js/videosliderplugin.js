$(document).ready(function(){
	'use strict';
	jQuery(function($) {
		if($('#sliding-videos').length === 1) { 
			var $target = $('#sliding-videos').children().first();
			$target.addClass('active').show().css({
	                left: -($target.width()),
		            opacity: 0
		            }).animate({
		                left: 0,
		                opacity: 1
		            }, 1000);
		    $target.removeClass('active').fadeOut(1000);
			setInterval(function(){ 
				var $this, $next; 
				$next = $target.next();
				if($target.hasClass('active')) {
					$this = $target;
					$this.removeClass('active').fadeOut(1000);
				}
				$next.addClass('active').show().css({
	                left: -($target.width()),
		            opacity: 0
		            }).animate({
		                left: 0,
		                opacity: 1
		            }, 1000);
		        if($target.is(':last-child')) {
		        	$target = $('#sliding-videos').children().first();
		        	$target.addClass('active').show().css({
	                left: -($target.width()),
		            opacity: 0
		            }).animate({
		                left: 0,
		                opacity: 1
		            }, 1000);
		        } else {
		        	$target = $next;
		        }
			}, 5000);
		}
	});
});
