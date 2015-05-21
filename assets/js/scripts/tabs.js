/* ========================================================================
* TABS
* ======================================================================== */

+function ($) {
  'use strict';

  var tabLinks = $('.tabs__nav li a');
  var tabContents = $('.tabs__content__panel');

  function initTabs() {
    tabLinks.removeClass('active');
    $('.tabs__nav li:first-child a').addClass('active');
    tabContents.hide();
    $('.tabs__content__panel:first-child').show();
  }

  function goToTab(e) {
    e.preventDefault();
    var tabID = $(this).attr('data-tab');
    var newTabContent = $('[data-tab='+tabID+']');
    tabLinks.removeClass('active');
    $(this).addClass('active');
    tabContents.hide();
    newTabContent.show();
  }

  tabLinks.click(goToTab);
  $(document).ready(initTabs);


}(jQuery);
