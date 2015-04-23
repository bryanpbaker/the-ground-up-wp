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
;/* ========================================================================
* Content Blocks
* ======================================================================== */

+function ($) {
  'use strict';
  $(".content-block:odd").css("background-color", "#ffca18");
  $(".content-block:odd > div > div > a > button").addClass('button--alt');
  $('.content-block:odd > div > div > ul').addClass('list--alt');

}(jQuery);
;/* ========================================================================
* Accordion
* ======================================================================== */

+function ($) {
  'use strict';

 
  
}(jQuery);
;/* ========================================================================
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
;/* ========================================================================
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
;/* ========================================================================
* MODALS
* ======================================================================== */

+function ($) {
  'use strict';

  $('#videoLink').click(function() {
  	var youtubeId = $(this).attr('data-youtube');

  	$('.modal-content').html('<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' + youtubeId + '?autoplay=1&controls=1&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe>')
  	$('#videoModal').modal();
  });

  $('#videoModal').on('hide.bs.modal', function () {
  	$('div.modal-content').html('');
  });
  	
}(jQuery);
;/* ========================================================================
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
;/* ========================================================================
* Accordion
* ======================================================================== */

+function ($) {
  'use strict';

    $("#adult-corporate-packages__packages ul li").delegate('a', 'click', function(e){
         e.preventDefault();
         return false;
    });

    $("#adult-corporate-packages__packages").tabs();
    $('.ui-tabs-anchor').click(function() {
        evt.preventDefault();
        return false;
    });

    if ($(window).width() < 992){

        $('#adult-corporate-packages__packages__filter--select').change(function(){
                $('#adult-corporate-packages__packages__filter--select option:selected').each(function(){
                    if($(this).attr('value')=='#tabs-1'){
                        $('.adult-corporate-packages__packages__content__package-types').hide();
                        $('#tabs-1').show();
                    }
                    if($(this).attr('value')=='#tabs-2'){
                        $('.adult-corporate-packages__packages__content__package-types').hide();
                        $('#tabs-2').show();
                    }
                    if($(this).attr('value')=='#tabs-3'){
                        $('.adult-corporate-packages__packages__content__package-types').hide();
                        $('#tabs-3').show();
                    }
                    if($(this).attr('value')=='#tabs-4'){
                        $('.adult-corporate-packages__packages__content__package-types').hide();
                        $('#tabs-4').show();
                    }
                });
            }).change();
    }

}(jQuery);
;/* ========================================================================
* Scrolling Widget
* ======================================================================== */

+function ($) {
  'use strict';

  // Cache selectors
  var scrollWidget = $("#scroll-widget"),
        scrollWidgetHeight = scrollWidget.outerHeight()-90,
        // All list items
        menuItems = scrollWidget.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function(){
          var item = $($(this).attr("href"));
          if (item.length) { return item; }
        });

    // Bind to scroll
    $(window).scroll(function(){
       // Get container scroll position
       var fromTop = $(this).scrollTop()+scrollWidgetHeight;
       // Get id of current scroll item
       var cur = scrollItems.map(function(){
         if ($(this).offset().top < fromTop)
           return this;
       });
       // Get the id of the current element
       cur = cur[cur.length-1];
       var id = cur && cur.length ? cur[0].id : "";
       // Set/remove active class
       menuItems
         .parent().removeClass("active")
         .end().filter("[href=#"+id+"]").parent().addClass("active");
    });
    // Adjust anchor position, based on fixed header
    

    // Reposition Scroll Widget when page is scrolled out of hero
      $(document).scroll(function() {
        var top = $(this).scrollTop();
        if ( top > 1){
          $('#scroll-widget').addClass('floating');
        } else {
          $('#scroll-widget').removeClass('floating');
        }
      });  

}(jQuery);
;/* ========================================================================
* CAROUSEL
* ======================================================================== */

+function ($) {
  'use strict';

  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 600);
        return false;
      }
    }
  });

}(jQuery);
;/* ========================================================================
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
;/* ========================================================================
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
;/* ========================================================================
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
