/* ========================================================================
* NAVBAR
* ======================================================================== */

+function ($) {
  'use strict';
  
  //Driver Login styling and functionality
  $('.driver-login').prepend('<i class="fa fa-car"></i> &nbsp &nbsp');
  $('.driver-login > a').attr('target' , '_blank');
  //Dropdown and prevent link leading to page
  $('.dropdown > a').click(function(event) {
    event.preventDefault();   
  });
  $('.dropdown > a').append(' <span class="caret"></span>').addClass('dropdown-toggle');
  $('.sub-menu').addClass('dropdown-menu dropdown-menu-left links-black');


  //Allow click to close menu on mobile
  $('.dropdown').click(function() {
  $('.dropdown-menu').slideToggle('fast', 'linear');
  });
  //Animated Menu Button
  $('.navbar-toggle').click(function() {
	    $(this).toggleClass('active');
      $('.navbar-nav > .menu-item > a').hide().fadeIn(600);
  });

  //Move Driver Login to top on mobile
  $('.mobile-utility-nav').find('.driver-login').prependTo('.mobile-utility-nav');

  //Fixed header with color change
  $(document).scroll(function() {
    var top = $(this).scrollTop();
      if ( top > 40 ) {
        if ( $(window).width() < 768 ) {
          $('.navbar').addClass('fixed');
          $('.navbar-brand > img').fadeOut('fast');
          $('.navbar-toggle').click(function() {
          $('.navbar-brand > img').toggle();
        });
        }
     } else {
      $('.navbar').removeClass('fixed');
      $('.navbar-brand > img').fadeIn('fast');
     }
  });

  // Rotate Caret on mobile dropdown
  if ($(window).width() < 992) {
    $('.dropdown > a > span.caret').addClass('right');
    $('.dropdown').click(function() {
      $('.dropdown > a > span.caret').toggleClass('right')
    });
  }
}(jQuery);
