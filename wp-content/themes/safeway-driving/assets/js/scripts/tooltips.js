/* ========================================================================
* Scrolling Widget
* ======================================================================== */

+function ($) {
  'use strict';
  

  $('[data-toggle="tooltipScrollWidget"]').tooltip({
      position: {my: "left+15 center", at: "right-7"}
  });
  $('[data-toggle="tooltipScrollWidget"]').tooltip({
      tooltipClass: "scroll-widget-tooltip"
  });



  $('[data-toggle="tooltipTeenPackage"]').tooltip({
      position: {my: "top center", at: "top-25"}
  });
  $('[data-toggle="tooltipTeenPackage"]').tooltip({
      tooltipClass: "teen-package-tooltip"
  });



}(jQuery);
