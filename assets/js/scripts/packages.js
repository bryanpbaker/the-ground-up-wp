/* ========================================================================
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
