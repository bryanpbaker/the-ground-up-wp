/* ========================================================================
* Accordion
* ======================================================================== */

+function ($) {
  'use strict';

    $('.hours-scale-section').click(function(event) {
    	event.preventDefault();
    	var contentId = $(this).attr('data-show');
    	var moveArrow = $(this).attr('data-arrow');

    	$('.teen-packages__callout-section__dynamic-callout__content.active').removeClass('active');
    	$('.arrow-up').removeClass('point-to-37 point-to-27 point-to-17 point-to-10 point-to-7')
    	$(contentId).addClass('active');
    	$('.arrow-up').addClass(moveArrow);
    });
    

}(jQuery);
