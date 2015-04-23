/* ========================================================================
* Accordion
* ======================================================================== */

+function ($) {
  'use strict';
  $('#accordion').accordion({heightStyle: 'content' , collapsible: true , active: false , icons: false}); //If this needs to be collapsed by default, use active: false 
  $('#tabs').tabs({heightStyle: 'content'});

  $('.accordion__header').click(function() {
    $('.accordion__header').not(this).find('.rotate').removeClass('right');
    $(this).find('.rotate').toggleClass('right');
  });
  
  $(".ui-tabs-anchor").click(function() {
         e.preventDefault();
         return false;
    });

}(jQuery);
