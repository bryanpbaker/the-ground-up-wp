/* ========================================================================
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
