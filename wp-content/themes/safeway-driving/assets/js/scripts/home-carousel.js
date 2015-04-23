/* ========================================================================
* HOME CAROUSEL
* ======================================================================== */

+function ($) {
  'use strict';

  var nextButton = $('.carousel__next');
  var prevButton = $('.carousel__prev');
  var indicatorButton = $('.carousel__indicators li');

  function carouselInit() {
    $('[data-carousel]:first-child').addClass('active');
  }

  function carouselNext() {
    if($('.active[data-carousel]').is(':last-child')) {
      var nextItem = $('[data-carousel]:first-child');
      $('[data-carousel]').removeClass('active');
      nextItem.addClass('active');
    } else {
      var nextItem = $('.active[data-carousel]').next();
      $('[data-carousel]').removeClass('active');
      nextItem.addClass('active');
    }
  }

  function carouselPrev() {
    if($('.active[data-carousel]').is(':first-child')) {
      var nextItem = $('[data-carousel]:last-child');
      $('[data-carousel]').removeClass('active');
      nextItem.addClass('active');
    } else {
      var nextItem = $('.active[data-carousel]').prev();
      $('[data-carousel]').removeClass('active');
      nextItem.addClass('active');
    }
  }

  function carouselTo() {
    var id = $(this).attr('data-carousel');
    var nextItem = $('[data-carousel='+id+']');
    $('[data-carousel]').removeClass('active');
    nextItem.addClass('active');
  }


  $(document).ready(function() {
    carouselInit();
    setInterval(carouselNext, 6000);
  });
  nextButton.click(carouselNext);
  prevButton.click(carouselPrev);
  indicatorButton.click(carouselTo);

}(jQuery);
