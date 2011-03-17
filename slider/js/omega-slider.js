/**
 * 
 */
var omegaSlider;

(function ($) {
		
	/**
	 * Setting up the variables
	 */
	var $left = $('#omega-left');
	var $right = $('#omega-right');
	var $inside = $('#omega-insider');
	var $sliding_speed = 1000;
	var $slides_2jump = parseInt( $('#omega-inside .slide:first').width() );
	var $slider_inside_width = (slide_has_slides() * $slides_2jump);
	var $slide_animate = true;
	
	var $sliding_left = false;
	var $sliding_right = false;
	
	/**
	 * 
	 * @return
	 */
	function slide_initialize()
	{
		$(document).ready(function(){
			$('#omega-inside').fadeIn(400, function() {
				$('#omega-right').fadeIn(400, function() {
					$('#omega-left').fadeIn(400, function() {
						slider_load();
					});
			    });
		    });
		});
		
	}
	
	slide_initialize();
	
	/**
	 * 
	 */
	function slider_load()
	{
		$left.css('color','#cccccc');
		
		$right.mousedown(slide_left_start).mouseup(slide_left_stop).mouseout(slide_left_stop).blur(slide_left_stop);
		$left.mousedown(slide_right_start).mouseup(slide_right_stop).mouseout(slide_right_stop).blur(slide_right_stop);
		
		$slides_2jump = parseInt( $('#omega-inside .slide:first').width() );
		$slider_inside_width = (slide_has_slides() * $slides_2jump);
		if (slide_has_slides()) $inside.css('width', $slider_inside_width);
	}
	
	/**
	 * 
	 * @return
	 */
	function slide_left_start()
	{
		$sliding_left = true;
		
		slide_left();
	}
	
	/**
	 * 
	 * @return
	 */
	function slide_left_stop()
	{
		 $sliding_left = false;
	}
	 
	/**
	 * 
	 * @return
	 */
	function slide_left()
	{
		slide_set_color();
		if (!$sliding_left || !slide_has_slides()) return false;
		var left_margin = parseInt($inside.css('margin-left'));
		if (!left_margin) left_margin = 0;
		
		if (!$slide_animate)
		{
			$inside.css('margin-left', left_margin-$slides_2jump);
			setTimeout(slide_left,$sliding_speed);
		}
		else
		{
			$inside.animate({
			    'margin-left': (left_margin - $slides_2jump)+"px"
			  }, $sliding_speed, function() {
			    // Animation complete.
			  });
		}
		
	}
	
	/**
	 * 
	 * @return
	 */
	function slide_right_start()
	{
		$sliding_right = true;
		
		slide_right();
	}
	
	/**
	 * 
	 * @return
	 */
	function slide_right_stop()
	{
		 $sliding_right = false;
	}
	
	/**
	 * 
	 * @return
	 */
	function slide_right()
	{
		 slide_set_color();
		 if (!$sliding_right || !slide_has_slides()) return false;
		 var left_margin = parseInt($inside.css('margin-left'));
		 if (!left_margin) left_margin = 0;
		 
		 if (!$slide_animate)
		 {
			 $inside.css('margin-left', left_margin + $slides_2jump);
			 setTimeout(slide_right,$sliding_speed);
		 }
		 else
		 {
			$inside.animate({
			    'margin-left': (left_margin + $slides_2jump)+"px"
			  }, $sliding_speed, function() {
			    // Animation complete.
			  });
		 }
	}

	/**
	 * 
	 * @return
	 */
	function slide_set_color()
	{	
		var left_margin = parseInt($inside.css('margin-left'));
		var slide = 0 - (left_margin / $slides_2jump) + 1;
		
		if ($sliding_right)
		{
			$right.css('color','#777777');
		}
		if ($sliding_left)
		{
			$left.css('color','#777777');
		}
		
		if ($sliding_left && slide+1 == slide_has_slides())
		{
			$right.css('color','#cccccc');
			return;
		}
		else if (slide == slide_has_slides())
		{
			$sliding_left = false;
			return;
		}
		else
		{
			$right.css('color','#777777');
		}
		
		if ($sliding_right && slide-1 == 1)
		{
			$left.css('color','#cccccc');
			return;
		}
		else if (slide == 1)
		{
			$sliding_right = false;
			return;
		}
		else
		{
			$left.css('color','#777777');
			return;
		}
	}
	 
	/**
	 * 
	 * @return
	 */
	function slide_has_slides()
	{
		 return $inside.children().length;
	}
 
	/**
	 * 
	 * @return
	 */
	function slider_width()
	{
		 return parseInt($inside.width());
	}
	 
	/**
	 * Disable text selection
	 * 
	 * @param e
	 * @return
	 */
	function disableselect(e){ return false; }
	function reEnable(){ return true; }
	document.onselectstart = new Function ("return false");
	if (window.sidebar){ document.onmousedown = disableselect; }
	
})(jQuery);
