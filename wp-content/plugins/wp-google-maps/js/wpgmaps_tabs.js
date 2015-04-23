jQuery("document").ready(function() {
   jQuery("#wpgmaps_tabs").tabs();
   jQuery("#wpgmaps_tabs_markers").tabs(); 
   
   jQuery( "#slider-range-max" ).slider({
      range: "max",
      min: 1,
      max: 21,
      value: jQuery( "#amount" ).val(),
      slide: function( event, ui ) {
        jQuery("#wpgmza_start_zoom").val(ui.value);
        MYMAP.map.setZoom(ui.value);
        
        
      }
    });
    
    jQuery('#wpgmza_map_height_type').on('change', function() {
        if (this.value === "%") {
            jQuery("#wpgmza_height_warning").show();
        }
    }); 
    
    jQuery('.wpgmza_settings_marker_pull').on('click', function() {
        if (this.value === '1') {
            jQuery(".wpgmza_marker_dir_tr").css('visibility','visible');
            jQuery(".wpgmza_marker_dir_tr").css('display','table-row');
            jQuery(".wpgmza_marker_url_tr").css('visibility','visible');
            jQuery(".wpgmza_marker_url_tr").css('display','table-row');
        } else {
            jQuery(".wpgmza_marker_dir_tr").css('visibility','hidden');
            jQuery(".wpgmza_marker_dir_tr").css('display','none');
            jQuery(".wpgmza_marker_url_tr").css('visibility','hidden');
            jQuery(".wpgmza_marker_url_tr").css('display','none');
        }
    });
    
    
    
   
});