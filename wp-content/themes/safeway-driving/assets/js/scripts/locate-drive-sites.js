/* ========================================================================
* Accordion
* ======================================================================== */

+function ($) {
  'use strict';
  $('#wpgmza_marker_list_1').prepend('<h5><i class="fa fa-car"></i>Drive Site Locations</h5>');
  $('.wpgmza_div_title').prepend('<span class="marker-number">0</span>');
  $(".wpgmaps_blist_row").each(function(i) {
    	$(this).find("span").text(++i);
	});


}(jQuery);
