/* ========================================================================
* Content Blocks
* ======================================================================== */

+function ($) {
  'use strict';
  $(".content-block:odd").css("background-color", "#ffca18");
  $(".content-block:odd > div > div > a > button").addClass('button--alt');
  $('.content-block:odd > div > div > ul').addClass('list--alt');

}(jQuery);
