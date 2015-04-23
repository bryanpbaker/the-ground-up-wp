var MYMAP = new Array();
var wpgmzaTable = new Array();

var directionsDisplay = new Array();
var directionsService = new Array();
var infoWindow;
var store_locator_marker = new Array();
var cityCircle = new Array();
var infoWindow_poly = new Array();
var polygon_center = new Array();
var WPGM_Path_Polygon = new Array();
var WPGM_Path = new Array();
var marker_array = new Array();
var marker_array2 = new Array();
var marker_sl_array = new Array();
var wpgmza_controls_active = new Array();
var wpgmza_adv_styling_json = new Array();
var lazyload;
var autoplay;
var items;
var default_items;
var pagination;
var navigation;


var retina = window.devicePixelRatio > 1;


var click_from_list = false;
            
autoheight = true;
autoplay = 6000;
lazyload = true;
pagination = false;
navigation = true;
items = 6;

 if (typeof Array.prototype.forEach != 'function') {
    Array.prototype.forEach = function(callback){
      for (var i = 0; i < this.length; i++){
        callback.apply(this, [this[i], i, this]);
      }
    };
}

for (var entry in wpgmaps_localize) {
    if ('undefined' === typeof window.jQuery) {
        document.getElementById('wpgmza_map_'+wpgmaps_localize[entry]['id']).innerHTML = 'Error: In order for WP Google Maps to work, jQuery must be installed. A check was done and jQuery was not present. Please see the <a href="http://www.wpgmaps.com/documentation/troubleshooting/jquery-troubleshooting/" title="WP Google Maps - jQuery Troubleshooting">jQuery troubleshooting section of our site</a> for more information.';
    }
    
    
}


var wpgmza_retina_width;
var wpgmza_retina_height;

if ("undefined" !== typeof wpgmaps_localize_global_settings['wpgmza_settings_retina_width']) { wpgmza_retina_width = parseInt(wpgmaps_localize_global_settings['wpgmza_settings_retina_width']); } else { wpgmza_retina_width = 31; }
if ("undefined" !== typeof wpgmaps_localize_global_settings['wpgmza_settings_retina_height']) { wpgmza_retina_height = parseInt(wpgmaps_localize_global_settings['wpgmza_settings_retina_height']); } else { wpgmza_retina_height = 45; }


var user_location;

function InitMap(map_id,cat_id,reinit) {
    
    if ('undefined' !== typeof wpgmaps_localize_shortcode_data) {
        if (wpgmaps_localize_shortcode_data[map_id]['lat'] !== false && wpgmaps_localize_shortcode_data[map_id]['lng'] !== false) {
            wpgmaps_localize[map_id]['map_start_lat'] = wpgmaps_localize_shortcode_data[map_id]['lat'];
            wpgmaps_localize[map_id]['map_start_lng'] = wpgmaps_localize_shortcode_data[map_id]['lng'];

        }
    }
    
    
    if ('undefined' === cat_id || cat_id === '' || !cat_id || cat_id === 0 || cat_id === "0") { cat_id = 'all'; }
    
    var myLatLng = new window.google.maps.LatLng(wpgmaps_localize[map_id]['map_start_lat'],wpgmaps_localize[map_id]['map_start_lng']);
    google = window.google;
    if (reinit === false) {
        MYMAP[map_id].init("#wpgmza_map_"+map_id, myLatLng, parseInt(wpgmaps_localize[map_id]['map_start_zoom']), wpgmaps_localize[map_id]['type'],map_id);
    }
   
    
   

    
    

    UniqueCode=Math.round(Math.random()*10000);
    if ('undefined' !== typeof wpgmaps_localize_shortcode_data) {
        if (wpgmaps_localize_shortcode_data[map_id]['lat'] !== false && wpgmaps_localize_shortcode_data[map_id]['lng'] !== false) {
            /* we're using custom fields to create, only show the one marker */
            var point = new google.maps.LatLng(parseFloat(wpgmaps_localize_shortcode_data[map_id]['lat']),parseFloat(wpgmaps_localize_shortcode_data[map_id]['lng']));
            var marker = new google.maps.Marker({
                position: point,
                map: MYMAP[map_id].map
            });

        }
    } else {
        if (typeof wpgmaps_map_mashup[map_id] !== "undefined" && wpgmaps_map_mashup[map_id] === true) {

            wpgmaps_localize_mashup_ids[map_id].forEach(function(entry_mashup) {
                if (typeof wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] !== "undefined" && wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] === 1) { 
                    /* dont show markers */
                } else if (typeof wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] !== "undefined" && wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] === 2) { 
                    MYMAP[map_id].placeMarkers(wpgmaps_markerurl+entry_mashup+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
                } else if (typeof wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] === "undefined") { 
                    MYMAP[map_id].placeMarkers(wpgmaps_markerurl+entry_mashup+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
                } else {
                    MYMAP[map_id].placeMarkers(wpgmaps_markerurl+entry_mashup+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
                }
                
            });
        } else {
            if (typeof wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] !== "undefined" && wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] === 1) { 
                /* dont show markers */
            } else if (typeof wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] !== "undefined" && wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] === 2) { 
                MYMAP[map_id].placeMarkers(wpgmaps_markerurl+map_id+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
            } else if (typeof wpgmaps_localize[map_id]['other_settings']['store_locator_hide_before_search'] === "undefined") { 
                MYMAP[map_id].placeMarkers(wpgmaps_markerurl+map_id+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
            } else {
                MYMAP[map_id].placeMarkers(wpgmaps_markerurl+map_id+'markers.xml?u='+UniqueCode,map_id,cat_id,null,null,null);
            }
            
        }
    }
};

function resetLocations(map_id) {
  if (typeof jQuery("#addressInput_"+map_id) === "object") { jQuery("#addressInput_"+map_id).val(''); }
  if (typeof jQuery("#nameInput_"+map_id) === "object") { jQuery("#nameInput_"+map_id).val(''); }
  reset_marker_lists(map_id);
  InitMap(map_id,'all',true);
  MYMAP[map_id].map.setZoom(parseInt(wpgmaps_localize[map_id]['map_start_zoom']));

}

function searchLocations(map_id) {
    if (document.getElementById("addressInput_"+map_id) === null) { var address = null; } else { var address = document.getElementById("addressInput_"+map_id).value; }
    if (document.getElementById("nameInput_"+map_id) === null) { var search_title = null; } else { var search_title = document.getElementById("nameInput_"+map_id).value; }
    
    var checkedCatValues = jQuery('.wpgmza_checkbox:checked').map(function() {
        return this.value;
    }).get();
    if (checkedCatValues === "" || checkedCatValues.length < 1 || checkedCatValues === 0 || checkedCatValues === "0") { checkedCatValues = 'all'; }

    if (address === null || address === "") {
         var map_center = MYMAP[map_id].map.getCenter();
        searchLocationsNear(map_id,checkedCatValues,map_center,search_title);
    } else {
        var geocoder = new google.maps.Geocoder();

        if (typeof wpgmaps_localize[map_id]['other_settings']['wpgmza_store_locator_restrict'] !== "undefined" && wpgmaps_localize[map_id]['other_settings']['wpgmza_store_locator_restrict'] != "") {
            geocoder.geocode({address: address,componentRestrictions: {country: wpgmaps_localize[map_id]['other_settings']['wpgmza_store_locator_restrict']}}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    searchLocationsNear(map_id,checkedCatValues,results[0].geometry.location,search_title);
                } else {
                    alert(address + ' not found');
                }
            });
        } else {
            geocoder.geocode({address: address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    searchLocationsNear(map_id,checkedCatValues,results[0].geometry.location,search_title);
                } else {
                    alert(address + ' not found');
                }
            });
        } 
                

          
    }
  }


function clearLocations() {
    infoWindow.close();
}




function searchLocationsNear(mapid,category,center_searched,search_title) {
    clearLocations();
    var distance_type = document.getElementById("wpgmza_distance_type_"+mapid).value;
    var radius = document.getElementById('radiusSelect_'+mapid).value;
    if (parseInt(category) === 0) { category = 'all'; }
    if (category === "0") { category = 'all'; }
    if (category === "Not found") { category = 'all'; }
    if (category === null) { category = 'all'; }
    if (category.length < 1) { category = 'all'; }

    if (distance_type === "1") {
        if (radius === "1") { zoomie = 14; }
        else if (radius === "5") { zoomie = 12; }
        else if (radius === "10") { zoomie = 11; }
        else if (radius === "25") { zoomie = 9; }
        else if (radius === "50") { zoomie = 8; }
        else if (radius === "75") { zoomie = 8; }
        else if (radius === "100") { zoomie = 7; }
        else if (radius === "150") { zoomie = 7; }
        else if (radius === "200") { zoomie = 6; }
        else if (radius === "300") { zoomie = 6; }
        else { zoomie = 14; }
    } else {
        if (radius === "1") { zoomie = 14; }
        else if (radius === "5") { zoomie = 12; }
        else if (radius === "10") { zoomie = 11; }
        else if (radius === "25") { zoomie = 10; }
        else if (radius === "50") { zoomie = 9; }
        else if (radius === "75") { zoomie = 9; }
        else if (radius === "100") { zoomie = 8; }
        else if (radius === "150") { zoomie = 8; }
        else if (radius === "200") { zoomie = 7; }
        else if (radius === "300") { zoomie = 7; }
        else { zoomie = 14; }
    }
    

    MYMAP[mapid].map.setCenter(center_searched);
    MYMAP[mapid].map.setZoom(zoomie);
    


    
    
    if (typeof wpgmaps_map_mashup[mapid] !== "undefined" && wpgmaps_map_mashup[mapid] === true) {
        wpgmaps_localize_mashup_ids[mapid].forEach(function(entry_mashup) {

            MYMAP[mapid].placeMarkers(wpgmaps_markerurl+entry_mashup+'markers.xml?u='+UniqueCode,mapid,category,radius,center_searched,distance_type,search_title);
        });
    } else {
        MYMAP[mapid].placeMarkers(wpgmaps_markerurl+mapid+'markers.xml?u='+UniqueCode,mapid,category,radius,center_searched,distance_type,search_title);
    }
    if (jQuery("#wpgmza_marker_holder_"+mapid).length > 0) {
        /* ensure that the marker list is showing (this is if the admin has chosen to hide the markers until a store locator search is done */
        jQuery("#wpgmza_marker_holder_"+mapid).show();
    }
    
}

function toRad(Value) {
    /** Converts numeric degrees to radians */
    return Value * Math.PI / 180;
}   

function wpgmza_getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
var wpgmza_open_marker = wpgmza_getUrlVars()["markerid"];
var wpgmza_open_marker_zoom = wpgmza_getUrlVars()["mzoom"];


            
function wpgmza_reinitialisetbl(map_id) {
    jQuery('#wpgmza_marker_holder_'+map_id).show();
    if (wpgmaps_localize[map_id]['order_markers_by'] === "1") { wpgmaps_order_by = parseInt(0); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "2") { wpgmaps_order_by = parseInt(2); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "3") { wpgmaps_order_by = parseInt(4); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "4") { wpgmaps_order_by = parseInt(5); } 
    else if (wpgmaps_localize[map_id]['order_markers_by'] === "5") { wpgmaps_order_by = parseInt(3); } 
    else { wpgmaps_order_by = 0; }
    if (wpgmaps_localize[map_id]['order_markers_choice'] === "1") { wpgmaps_order_by_choice = "asc"; } 
    else { wpgmaps_order_by_choice = "desc"; }
    wpgmzaTable[map_id].fnClearTable( 0 );
    wpgmzaTable[map_id] = jQuery('#wpgmza_table_'+map_id).dataTable({
        "bProcessing": true,"aaSorting" : [],
        responsive: true,
        
        "oLanguage": {
                "sLengthMenu": wpgm_dt_sLengthMenu,
                "sZeroRecords": wpgm_dt_sZeroRecords,
                "sInfo": wpgm_dt_sInfo,
                "sInfoEmpty": wpgm_dt_sInfoEmpty,
                "sInfoFiltered": wpgm_dt_sInfoFiltered,
                "sSearch": wpgm_dt_sSearch,
                "oPaginate" : {
                    "sFirst": wpgm_dt_sFirst,
                    "sLast": wpgm_dt_sLast,
                    "sNext": wpgm_dt_sNext,
                    "sPrevious": wpgm_dt_sPrevious,
                   "sSearch": wpgm_dt_sSearch
                }
        }

    });


}

 function wpgmza_filter_marker_lists_by_array(map_id,marker_sl_array) {
    /* update datatables (only if using datatables) */
    if (typeof jQuery("#wpgmza_table_"+map_id) === "object") { 
        var data = {
                action: 'wpgmza_datatables_sl',
                security: wpgmaps_pro_nonce,
                map_id: map_id,
                marker_array: marker_sl_array
        };
        jQuery.post(ajaxurl, data, function(response) {

                jQuery("#wpgmza_table_"+map_id+"").html(response);
                wpgmzaTable[map_id] = jQuery('#wpgmza_table_'+map_id).dataTable({
                        "bDestroy":true,
                        responsive: true,
                        "bProcessing": true,"aaSorting" : [],
                        "oLanguage": {
                                "sLengthMenu": wpgm_dt_sLengthMenu,
                                "sZeroRecords": wpgm_dt_sZeroRecords,
                                "sInfo": wpgm_dt_sInfo,
                                "sInfoEmpty": wpgm_dt_sInfoEmpty,
                                "sInfoFiltered": wpgm_dt_sInfoFiltered,
                                "sSearch": wpgm_dt_sSearch,
                                "oPaginate" : {
                                    "sFirst": wpgm_dt_sFirst,
                                    "sLast": wpgm_dt_sLast,
                                    "sNext": wpgm_dt_sNext,
                                    "sPrevious": wpgm_dt_sPrevious,
                                   "sSearch": wpgm_dt_sSearch
                                }
                        }

                    });

        });
    }
    if (typeof jQuery("#wpgmza_marker_list_container_"+map_id) === "object" && jQuery("#wpgmza_marker_list_container_"+map_id).length > 0) {
        if (jQuery("#wpgmza_marker_list_container_"+map_id).hasClass('wpgmza_marker_carousel')) {
            /* carousel listing */
            var data = {
                    action: 'wpgmza_sl_carousel',
                    security: wpgmaps_pro_nonce,
                    map_id: map_id,
                    marker_array: marker_sl_array
            };
            jQuery.post(ajaxurl, data, function(response) {
                    items = default_items;
                    jQuery("#wpgmza_marker_list_container_"+map_id+"").html(response);
                    if (marker_sl_array.length < items) { items = marker_sl_array.length; } else { items = default_items; }
                    if (items < 1) { items = 1; }

                    jQuery("#wpgmza_marker_list_"+map_id+"").owlCarousel({
                        autoPlay: autoplay,
                        lazyLoad : lazyload,
                        autoHeight : autoheight,
                        pagination : pagination,
                        navigation : navigation,
                        items : items
                    });

            });
        }
    }
    else if (typeof jQuery("#wpgmza_marker_list_"+map_id) === "object") {
        if (jQuery("#wpgmza_marker_list_"+map_id).hasClass('wpgmza_basic_list')) { 
            /* we're using the basic list marker listing */
            var data = {
                    action: 'wpgmza_sl_basiclist',
                    security: wpgmaps_pro_nonce,
                    map_id: map_id,
                    marker_array: marker_sl_array
            };
            jQuery.post(ajaxurl, data, function(response) {
                    items = default_items;
                    jQuery("#wpgmza_marker_list_"+map_id+"").html(response);

            });
        } else  { 
            /* we must be using the basic table listing */
            var data = {
                    action: 'wpgmza_sl_basictable',
                    security: wpgmaps_pro_nonce,
                    map_id: map_id,
                    marker_array: marker_sl_array
            };
            /* basic marker listing listing */
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_marker_list_"+map_id+"").html(response);
                    

            });    

        }





    }







}


function wpgmza_filter_marker_lists(wpgmza_map_id,selectedValue) {
    if (typeof jQuery("#wpgmza_table_"+wpgmza_map_id) === "object") { 
        if (selectedValue === 0 || selectedValue === "All" || selectedValue === "0") {
            
            /* update datatables */
            var data = {
                    action: 'wpgmza_datatables',
                    security: wpgmaps_pro_nonce,
                    map_id: wpgmza_map_id,
                    category_data: 'all'
            };
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_table_"+wpgmza_map_id+"").html(response);
                    wpgmzaTable[wpgmza_map_id] = jQuery('#wpgmza_table_'+wpgmza_map_id).dataTable({
                        "bDestroy":true,
                        responsive: true,
                        "bProcessing": true,"aaSorting" : [],
                        "oLanguage": {
                                "sLengthMenu": wpgm_dt_sLengthMenu,
                                "sZeroRecords": wpgm_dt_sZeroRecords,
                                "sInfo": wpgm_dt_sInfo,
                                "sInfoEmpty": wpgm_dt_sInfoEmpty,
                                "sInfoFiltered": wpgm_dt_sInfoFiltered,
                                "sSearch": wpgm_dt_sSearch,
                                "oPaginate" : {
                                    "sFirst": wpgm_dt_sFirst,
                                    "sLast": wpgm_dt_sLast,
                                    "sNext": wpgm_dt_sNext,
                                    "sPrevious": wpgm_dt_sPrevious,
                                   "sSearch": wpgm_dt_sSearch
                                }
                        }

                    });

            });
        } else { 
            
            /* update datatables */
            var data = {
                    action: 'wpgmza_datatables',
                    security: wpgmaps_pro_nonce,
                    map_id: wpgmza_map_id,
                    category_data: selectedValue
            };
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_table_"+wpgmza_map_id+"").html(response);
                    wpgmzaTable[wpgmza_map_id] = jQuery('#wpgmza_table_'+wpgmza_map_id).dataTable({
                        "bDestroy":true,
                        responsive: true,
                        "bProcessing": true,"aaSorting" : [],
                        "oLanguage": {
                                "sLengthMenu": wpgm_dt_sLengthMenu,
                                "sZeroRecords": wpgm_dt_sZeroRecords,
                                "sInfo": wpgm_dt_sInfo,
                                "sInfoEmpty": wpgm_dt_sInfoEmpty,
                                "sInfoFiltered": wpgm_dt_sInfoFiltered,
                                "sSearch": wpgm_dt_sSearch,
                                "oPaginate" : {
                                    "sFirst": wpgm_dt_sFirst,
                                    "sLast": wpgm_dt_sLast,
                                    "sNext": wpgm_dt_sNext,
                                    "sPrevious": wpgm_dt_sPrevious,
                                   "sSearch": wpgm_dt_sSearch
                                }
                        }

                    });

            });
            
        }

    } 
    if (jQuery("#wpgmza_marker_list_"+wpgmza_map_id).length > 0) {
       
        /* check whether we are using carousel or normal marker listing */

        if (jQuery("#wpgmza_marker_list_"+wpgmza_map_id).hasClass('wpgmza_marker_carousel')) {

            if (selectedValue === 0 || selectedValue === "All" || selectedValue === "0") {
                
                var data = {
                        action: 'wpgmza_carousel_update',
                        security: wpgmaps_pro_nonce,
                        map_id: wpgmza_map_id,
                        category_data: 'all'
                };
            } else {
                
                var data = {
                        action: 'wpgmza_carousel_update',
                        security: wpgmaps_pro_nonce,
                        map_id: wpgmza_map_id,
                        category_data: selectedValue
                };
            }
             /* carousel listing */
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_marker_list_container_"+wpgmza_map_id+"").html(response);
                    jQuery("#wpgmza_marker_list_"+wpgmza_map_id+"").owlCarousel({
                        autoPlay: autoplay,
                        lazyLoad : lazyload,
                        autoHeight : autoheight,
                        pagination : pagination,
                        navigation : navigation,
                        items : items
                    });

            });
        } else if (jQuery("#wpgmza_marker_list_"+wpgmza_map_id).hasClass('wpgmza_basic_list')) { 
            /* we're using the basic list marker listing */
            if (selectedValue === 0 || selectedValue === "All" || selectedValue === "0") {
                var data = {
                        action: 'wpgmza_basiclist_update',
                        security: wpgmaps_pro_nonce,
                        map_id: wpgmza_map_id,
                        category_data: 'all'
                };
            } else {
                var data = {
                        action: 'wpgmza_basiclist_update',
                        security: wpgmaps_pro_nonce,
                        map_id: wpgmza_map_id,
                        category_data: selectedValue
                };
            }
             /* basic marker listing listing */
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_marker_list_"+wpgmza_map_id+"").html(response);
                    

            });    

        } else { 
            /* we must be using the basic table listing */
            if (selectedValue === 0 || selectedValue === "All" || selectedValue === "0") {
                var data = {
                        action: 'wpgmza_basictable_update',
                        security: wpgmaps_pro_nonce,
                        map_id: wpgmza_map_id,
                        category_data: 'all'
                };
            } else {
                var data = {
                        action: 'wpgmza_basictable_update',
                        security: wpgmaps_pro_nonce,
                        map_id: wpgmza_map_id,
                        category_data: selectedValue
                };
            }
             /* basic marker listing listing */
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_marker_list_"+wpgmza_map_id+"").html(response);
                    

            });                        
        }


       
    }


}




function reset_marker_lists(wpgmza_map_id) {

    if (typeof jQuery("#wpgmza_table_"+wpgmza_map_id) === "object" && jQuery("#wpgmza_table_"+wpgmza_map_id).length > 0) {
            /* update datatables */
            var data = {
                    action: 'wpgmza_datatables',
                    security: wpgmaps_pro_nonce,
                    map_id: wpgmza_map_id,
                    category_data: 'all'
            };
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_table_"+wpgmza_map_id+"").html(response);
                    wpgmzaTable[wpgmza_map_id] = jQuery('#wpgmza_table_'+wpgmza_map_id).dataTable({
                        "bDestroy":true,
                        responsive: true,
                        "bProcessing": true,"aaSorting" : [],
                        "oLanguage": {
                                "sLengthMenu": wpgm_dt_sLengthMenu,
                                "sZeroRecords": wpgm_dt_sZeroRecords,
                                "sInfo": wpgm_dt_sInfo,
                                "sInfoEmpty": wpgm_dt_sInfoEmpty,
                                "sInfoFiltered": wpgm_dt_sInfoFiltered,
                                "sSearch": wpgm_dt_sSearch,
                                "oPaginate" : {
                                    "sFirst": wpgm_dt_sFirst,
                                    "sLast": wpgm_dt_sLast,
                                    "sNext": wpgm_dt_sNext,
                                    "sPrevious": wpgm_dt_sPrevious,
                                   "sSearch": wpgm_dt_sSearch
                                }
                        }

                    });

            });

    } 

    if (jQuery("#wpgmza_marker_list_"+wpgmza_map_id).length > 0) {
       
        /* check whether we are using carousel or normal marker listing */

        if (jQuery("#wpgmza_marker_list_"+wpgmza_map_id).hasClass('wpgmza_marker_carousel')) {

            var data = {
                    action: 'wpgmza_carousel_update',
                    security: wpgmaps_pro_nonce,
                    map_id: wpgmza_map_id,
                    category_data: 'all'
            };
        
             /* carousel listing */
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_marker_list_container_"+wpgmza_map_id+"").html(response);
                    jQuery("#wpgmza_marker_list_"+wpgmza_map_id+"").owlCarousel({
                        autoPlay: autoplay,
                        lazyLoad : lazyload,
                        autoHeight : autoheight,
                        pagination : pagination,
                        navigation : navigation,
                        items : default_items
                    });

            });
        } else if (jQuery("#wpgmza_marker_list_"+wpgmza_map_id).hasClass('wpgmza_basic_list')) { 
            /* we're using the basic list marker listing */
            
            
            
            var data = {
                    action: 'wpgmza_basiclist_update',
                    security: wpgmaps_pro_nonce,
                    map_id: wpgmza_map_id,
                    category_data: 'all'
            };
        
             /* basic marker listing listing */
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_marker_list_"+wpgmza_map_id+"").html(response);
                    

            });    

        } else { 
            /* we must be using the basic table listing */
            
            var data = {
                    action: 'wpgmza_basictable_update',
                    security: wpgmaps_pro_nonce,
                    map_id: wpgmza_map_id,
                    category_data: 'all'
            };
             /* basic marker listing listing */
            jQuery.post(ajaxurl, data, function(response) {
                    jQuery("#wpgmza_marker_list_"+wpgmza_map_id+"").html(response);
                    

            });                        
        }


       
    }


}

jQuery(function() {

    jQuery(document).ready(function(){

        for (var entry in wpgmaps_localize) {

           if ("undefined" !== typeof wpgmaps_localize[entry]['other_settings'] && "undefined" !== typeof wpgmaps_localize[entry]['other_settings']['list_markers_by'] && wpgmaps_localize[entry]['other_settings']['list_markers_by'] === "3") {
                if ("undefined" !== typeof wpgmaps_localize_global_settings['carousel_lazyload'] && wpgmaps_localize_global_settings['carousel_lazyload'] === "yes") { lazyload = true; } else { lazyload = false; }
                if ("undefined" === typeof wpgmaps_localize_global_settings['carousel_lazyload']) { lazyload = true; }

                if ("undefined" !== typeof wpgmaps_localize_global_settings['carousel_autoplay']) { autoplay = parseInt(wpgmaps_localize_global_settings['carousel_autoplay']); } else { autoplay = false; }
                if ("undefined" === typeof wpgmaps_localize_global_settings['carousel_autoplay']) { autoplay = 6000; }

                if ("undefined" !== typeof wpgmaps_localize_global_settings['carousel_autoheight'] && wpgmaps_localize_global_settings['carousel_autoheight'] === "yes") { autoheight = true; } else { autoheight = false; }
                if ("undefined" === typeof wpgmaps_localize_global_settings['carousel_autoheight']) { autoheight = true; }

                if ("undefined" !== typeof wpgmaps_localize_global_settings['carousel_pagination'] && wpgmaps_localize_global_settings['carousel_pagination'] === "yes") { pagination = true; } else { pagination = false; }
                if ("undefined" === typeof wpgmaps_localize_global_settings['carousel_pagination']) { pagination = false; }

                if ("undefined" !== typeof wpgmaps_localize_global_settings['carousel_navigation'] && wpgmaps_localize_global_settings['carousel_navigation'] === "yes") { navigation = true; } else { navigation = false; }
                if ("undefined" === typeof wpgmaps_localize_global_settings['carousel_navigation']) { navigation = true; }

                if ("undefined" !== typeof wpgmaps_localize_global_settings['carousel_items']) { items = parseInt(wpgmaps_localize_global_settings['carousel_items']); } else { items = 5; }
                if ("undefined" === typeof wpgmaps_localize_global_settings['carousel_items']) { items = 6; }
                default_items = items;

                if (wpgmaps_localize[entry]['total_markers'] < items) { items = wpgmaps_localize[entry]['total_markers']; }
                jQuery("#wpgmza_marker_list_"+wpgmaps_localize[entry]['id']).owlCarousel({
                    autoPlay: autoplay,
                    lazyLoad : lazyload,
                    autoHeight : autoheight,
                    pagination : pagination,
                    navigation : navigation,
                    items : items
                });
                    
            } 
        }
        
        
        
        if (/1\.(0|1|2|3|4|5|6|7)\.(0|1|2|3|4|5|6|7|8|9)/.test(jQuery.fn.jquery)) {
            for(var entry in wpgmaps_localize) {
                document.getElementById('wpgmza_map_'+wpgmaps_localize[entry]['id']).innerHTML = 'Error: Your version of jQuery is outdated. WP Google Maps requires jQuery version 1.7+ to function correctly. Go to Maps->Settings and check the box that allows you to over-ride your current jQuery to try eliminate this problem.';
            }
        } else {


            jQuery("body").on("click", ".wpgmaps_mlist_row", function() {
                var wpgmza_markerid = jQuery(this).attr("mid");
                var wpgmza_mapid = jQuery(this).attr("mapid");
                openInfoWindow(wpgmza_markerid,wpgmza_mapid,true);
                location.hash = "#marker" + wpgmza_markerid;
            });
            jQuery("body").on("click", ".wpgmaps_blist_row", function() {
                var wpgmza_markerid = jQuery(this).attr("mid");
                var wpgmza_mapid = jQuery(this).attr("mapid");
                openInfoWindow(wpgmza_markerid,wpgmza_mapid,true);
                
            });
            jQuery("body").on("change", "#wpgmza_filter_select", function() {
                
                var selectedValue = jQuery(this).find(":selected").val();
                var wpgmza_map_id = jQuery(this).attr("mid");
                InitMap(wpgmza_map_id,selectedValue);
                wpgmza_filter_marker_lists(wpgmza_map_id,selectedValue);
                

            });      
            jQuery("body").on("click", ".wpgmza_checkbox", function() {
                /* do nothing if user has enabled store locator */
                var wpgmza_map_id = jQuery(this).attr("mid");
                if (jQuery("#addressInput_"+wpgmza_map_id).length > 0) { } else {
                     var checkedCatValues = jQuery('.wpgmza_checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    if (checkedCatValues[0] === "0" || typeof checkedCatValues === 'undefined' || checkedCatValues.length < 1) {
                        InitMap(wpgmza_map_id,'all');
                        wpgmza_filter_marker_lists(wpgmza_map_id,'all');
                    } else {
                        InitMap(wpgmza_map_id,checkedCatValues);
                        wpgmza_filter_marker_lists(wpgmza_map_id,checkedCatValues);
                    }

                }
            });                
            
        

            jQuery("body").on("click", ".sl_use_loc", function() {
                var wpgmza_map_id = jQuery(this).attr("mid");
                jQuery('#addressInput_'+wpgmza_map_id).val(wpgmaps_lang_getting_location);

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': user_location}, function(results, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                      jQuery('#addressInput_'+wpgmza_map_id).val(results[0].formatted_address);
                    }
                  }
                });
            });       
            jQuery("body").on("click", "#wpgmza_use_my_location_from", function() {
                var wpgmza_map_id = jQuery(this).attr("mid");
                jQuery('#wpgmza_input_from_'+wpgmza_map_id).val(wpgmaps_lang_getting_location);

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': user_location}, function(results, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                      jQuery('#wpgmza_input_from_'+wpgmza_map_id).val(results[0].formatted_address);
                    }
                  }
                });
            });              
            jQuery("body").on("click", "#wpgmza_use_my_location_to", function() {
                var wpgmza_map_id = jQuery(this).attr("mid");
                jQuery('#wpgmza_input_to_'+wpgmza_map_id).val(wpgmaps_lang_getting_location);
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': user_location}, function(results, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                      jQuery('#wpgmza_input_to_'+wpgmza_map_id).val(results[0].formatted_address);
                    }
                  }
                });
            });

            jQuery('body').on('tabsactivate', function(event, ui) {
                for(var entry in wpgmaps_localize) {
                    InitMap(wpgmaps_localize[entry]['id'],'all',true);
                }
            });
            
            /* tab compatibility */
            jQuery('body').on('click', '.tp-tabs li a', function(event, ui) {
                for(var entry in wpgmaps_localize) {
                    InitMap(wpgmaps_localize[entry]['id'],'all',true);
                }
            });
            jQuery('body').on('click', '.nav-tabs li a', function(event, ui) {
                for(var entry in wpgmaps_localize) {
                    InitMap(wpgmaps_localize[entry]['id'],'all',true);
                }
            });
            
            
            /* compatibility for Elegant Builder tabs */
            jQuery('body').on('click', '.et_pb_tabs_controls li', function(event, ui) {
                for(var entry in wpgmaps_localize) {
                    InitMap(wpgmaps_localize[entry]['id'],'all',true);
                }
            });
            
            
                


            
            
            for(var entry in wpgmaps_localize) {
                jQuery("#wpgmza_map_"+wpgmaps_localize[entry]['id']).css({
                    height:wpgmaps_localize[entry]['map_height']+''+wpgmaps_localize[entry]['map_height_type'],
                    width:wpgmaps_localize[entry]['map_width']+''+wpgmaps_localize[entry]['map_width_type']

                });            
            }
            
    
            for(var entry in wpgmaps_localize) {
                InitMap(wpgmaps_localize[entry]['id'],wpgmaps_localize_cat_ids[wpgmaps_localize[entry]['id']],false);
            }

            for(var entry in wpgmaps_localize) {

                /*
                removed in 5.54 as we are sorting via PHP first
                 */
                /*
                if (wpgmaps_localize[entry]['order_markers_by'] === "1") { wpgmaps_order_by = parseInt(0); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "2") { wpgmaps_order_by = parseInt(2); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "3") { wpgmaps_order_by = parseInt(4); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "4") { wpgmaps_order_by = parseInt(5); } 
                else if (wpgmaps_localize[entry]['order_markers_by'] === "5") { wpgmaps_order_by = parseInt(3); } 
                else { wpgmaps_order_by = 0; }
                if (wpgmaps_localize[entry]['order_markers_choice'] === "1") { wpgmaps_order_by_choice = "asc"; } 
                else { wpgmaps_order_by_choice = "desc"; }
                */
                if (wpgmaps_localize_global_settings['wpgmza_default_items'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_default_items']) { wpgmza_settings_default_items = 10; } else { wpgmza_settings_default_items = parseInt(wpgmaps_localize_global_settings['wpgmza_default_items']);  }
                
                if (jQuery('#wpgmza_table_'+wpgmaps_localize[entry]['id']).length === 0) { } else { 
                    
                    wpgmzaTable[wpgmaps_localize[entry]['id']] = jQuery('#wpgmza_table_'+wpgmaps_localize[entry]['id']).dataTable({
                        "bProcessing": true,"aaSorting" : [],
                        "iDisplayLength": wpgmza_settings_default_items,
                        responsive: true,
                        "oLanguage": {
                            "sLengthMenu": wpgm_dt_sLengthMenu,
                            "sZeroRecords": wpgm_dt_sZeroRecords,
                            "sInfo": wpgm_dt_sInfo,
                            "sInfoEmpty": wpgm_dt_sInfoEmpty,
                            "sInfoFiltered": wpgm_dt_sInfoFiltered,
                            "sSearch": wpgm_dt_sSearch,
                            "oPaginate" : {
                                "sFirst": wpgm_dt_sFirst,
                                "sLast": wpgm_dt_sLast,
                                "sNext": wpgm_dt_sNext,
                                "sPrevious": wpgm_dt_sPrevious,
                               "sSearch": wpgm_dt_sSearch
                            }
                        }
                     });

                    
                    if (typeof wpgmza_controls_active[entry] !== 'undefined' && wpgmza_controls_active[entry]) {
                        /* hide certain elements */
                        jQuery("#wpgmza_table_"+[entry]+"_length").hide();
                    }
                     
                     if (typeof wpgmaps_localize[entry]['other_settings']['store_locator_hide_before_search'] !== "undefined" && wpgmaps_localize[entry]['other_settings']['store_locator_hide_before_search'] === 1) { 
                         jQuery('#wpgmza_marker_holder_'+wpgmaps_localize[entry]['id']).hide();
                     }
    
                     
                }
            }

        
        }
        
        

    
    
         
        

    });
    
    
    
    
    
    
    
    
    for(var entry in wpgmaps_localize) {

    /* general directions settings and variables */
    directionsDisplay[wpgmaps_localize[entry]['id']];
    directionsService[wpgmaps_localize[entry]['id']] = new google.maps.DirectionsService();
    var currentDirections = null;
    var oldDirections = [];
    var new_gps;

    if (wpgmaps_localize[entry]['styling_json'] !== '' && wpgmaps_localize[entry]['styling_enabled'] === "1") {
        wpgmza_adv_styling_json[wpgmaps_localize[entry]['id']] = jQuery.parseJSON(wpgmaps_localize[entry]['styling_json']);
    } else {
        wpgmza_adv_styling_json[wpgmaps_localize[entry]['id']] = "";
    }


    MYMAP[wpgmaps_localize[entry]['id']] = {
        map: null,
        bounds: null,
        mc: null
    };

    
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_draggable'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_draggable']) { wpgmza_settings_map_draggable = true; } else { wpgmza_settings_map_draggable = false;  }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_clickzoom'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_clickzoom']) { wpgmza_settings_map_clickzoom = false; } else { wpgmza_settings_map_clickzoom = true; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_scroll'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_scroll']) { wpgmza_settings_map_scroll = true; } else { wpgmza_settings_map_scroll = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_zoom'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_zoom']) { wpgmza_settings_map_zoom = true; } else { wpgmza_settings_map_zoom = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_pan'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_pan']) { wpgmza_settings_map_pan = true; } else { wpgmza_settings_map_pan = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_type'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_type']) { wpgmza_settings_map_type = true; } else { wpgmza_settings_map_type = false; }
    if (wpgmaps_localize_global_settings['wpgmza_settings_map_streetview'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_streetview']) { wpgmza_settings_map_streetview = true; } else { wpgmza_settings_map_streetview = false; }


    if ('undefined' === typeof wpgmaps_localize[entry]['other_settings']['map_max_zoom'] || wpgmaps_localize[entry]['other_settings']['map_max_zoom'] === "") { wpgmza_max_zoom = 0; } else { wpgmza_max_zoom = parseInt(wpgmaps_localize[entry]['other_settings']['map_max_zoom']); }


    
    MYMAP[wpgmaps_localize[entry]['id']].init = function(selector, latLng, zoom, maptype, mapid) {
        if (typeof wpgmaps_localize_map_types !== "undefined") {
            var override_type = wpgmaps_localize_map_types[mapid];
        } else {
            var override_type = "";
        }
        
        if (override_type !== "") {
            if (override_type === "ROADMAP") { 
                
                var myOptions = {
                        zoom:zoom,
                        minZoom: wpgmza_max_zoom,
                        maxZoom: 21,
                        center: latLng,
                        draggable: wpgmza_settings_map_draggable,
                        disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                        scrollwheel: wpgmza_settings_map_scroll,
                        zoomControl: wpgmza_settings_map_zoom,
                        panControl: wpgmza_settings_map_pan,
                        mapTypeControl: wpgmza_settings_map_type,
                        streetViewControl: wpgmza_settings_map_streetview,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                };
            }
            if (override_type === "SATELLITE") { 
                var myOptions = {
                        zoom:zoom,
                        minZoom: wpgmza_max_zoom,
                        maxZoom: 21,
                        center: latLng,
                        draggable: wpgmza_settings_map_draggable,
                        disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                        scrollwheel: wpgmza_settings_map_scroll,
                        zoomControl: wpgmza_settings_map_zoom,
                        panControl: wpgmza_settings_map_pan,
                        mapTypeControl: wpgmza_settings_map_type,
                        streetViewControl: wpgmza_settings_map_streetview,
                        mapTypeId: google.maps.MapTypeId.SATELLITE
                };
            }
            if (override_type === "HYBRID") { 
                var myOptions = {
                        zoom:zoom,
                        minZoom: wpgmza_max_zoom,
                        maxZoom: 21,
                        center: latLng,
                        draggable: wpgmza_settings_map_draggable,
                        disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                        scrollwheel: wpgmza_settings_map_scroll,
                        zoomControl: wpgmza_settings_map_zoom,
                        panControl: wpgmza_settings_map_pan,
                        mapTypeControl: wpgmza_settings_map_type,
                        streetViewControl: wpgmza_settings_map_streetview,
                        mapTypeId: google.maps.MapTypeId.HYBRID
                };
            }
            if (override_type === "TERRAIN") { 
                var myOptions = {
                        zoom:zoom,
                        minZoom: wpgmza_max_zoom,
                        maxZoom: 21,
                        center: latLng,
                        draggable: wpgmza_settings_map_draggable,
                        disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                        scrollwheel: wpgmza_settings_map_scroll,
                        zoomControl: wpgmza_settings_map_zoom,
                        panControl: wpgmza_settings_map_pan,
                        mapTypeControl: wpgmza_settings_map_type,
                        streetViewControl: wpgmza_settings_map_streetview,
                        mapTypeId: google.maps.MapTypeId.TERRAIN
                };
            } else {
                if (override_type === "ROADMAP") { 

                var myOptions = {
                        zoom:zoom,
                        minZoom: wpgmza_max_zoom,
                        maxZoom: 21,
                        center: latLng,
                        draggable: wpgmza_settings_map_draggable,
                        disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                        scrollwheel: wpgmza_settings_map_scroll,
                        zoomControl: wpgmza_settings_map_zoom,
                        panControl: wpgmza_settings_map_pan,
                        mapTypeControl: wpgmza_settings_map_type,
                        streetViewControl: wpgmza_settings_map_streetview,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                };
            }

            }
        } else {
            if (maptype === "1") { 
                var myOptions = {
                    zoom:zoom,
                    minZoom: wpgmza_max_zoom,
                    maxZoom: 21,
                    center: latLng,
                    draggable: wpgmza_settings_map_draggable,
                    disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                    scrollwheel: wpgmza_settings_map_scroll,
                    zoomControl: wpgmza_settings_map_zoom,
                    panControl: wpgmza_settings_map_pan,
                    mapTypeControl: wpgmza_settings_map_type,
                    streetViewControl: wpgmza_settings_map_streetview,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                  };
            }
            else if (maptype === "2") { 
                var myOptions = {
                    zoom:zoom,
                    minZoom: wpgmza_max_zoom,
                    maxZoom: 21,
                    center: latLng,
                    draggable: wpgmza_settings_map_draggable,
                    disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                    scrollwheel: wpgmza_settings_map_scroll,
                    zoomControl: wpgmza_settings_map_zoom,
                    panControl: wpgmza_settings_map_pan,
                    mapTypeControl: wpgmza_settings_map_type,
                    streetViewControl: wpgmza_settings_map_streetview,
                    mapTypeId: google.maps.MapTypeId.SATELLITE
                  };

            }
            else if (maptype === "3") { 
                var myOptions = {
                    zoom:zoom,
                    minZoom: wpgmza_max_zoom,
                    maxZoom: 21,
                    center: latLng,
                    draggable: wpgmza_settings_map_draggable,
                    disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                    scrollwheel: wpgmza_settings_map_scroll,
                    zoomControl: wpgmza_settings_map_zoom,
                    panControl: wpgmza_settings_map_pan,
                    mapTypeControl: wpgmza_settings_map_type,
                    streetViewControl: wpgmza_settings_map_streetview,
                    mapTypeId: google.maps.MapTypeId.HYBRID
                  };


            }
            else if (maptype === "4") { 
                var myOptions = {
                    zoom:zoom,
                    minZoom: wpgmza_max_zoom,
                    maxZoom: 21,
                    center: latLng,
                    draggable: wpgmza_settings_map_draggable,
                    disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                    scrollwheel: wpgmza_settings_map_scroll,
                    zoomControl: wpgmza_settings_map_zoom,
                    panControl: wpgmza_settings_map_pan,
                    mapTypeControl: wpgmza_settings_map_type,
                    streetViewControl: wpgmza_settings_map_streetview,
                    mapTypeId: google.maps.MapTypeId.TERRAIN
                  };

            }
            else { 
                var myOptions = {
                    zoom:zoom,
                    minZoom: wpgmza_max_zoom,
                    maxZoom: 21,
                    center: latLng,
                    draggable: wpgmza_settings_map_draggable,
                    disableDoubleClickZoom: wpgmza_settings_map_clickzoom,
                    scrollwheel: wpgmza_settings_map_scroll,
                    zoomControl: wpgmza_settings_map_zoom,
                    panControl: wpgmza_settings_map_pan,
                    mapTypeControl: wpgmza_settings_map_type,
                    streetViewControl: wpgmza_settings_map_streetview,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                  };


            }
        }
        
        

        if (wpgm_g_e === true) {
            if (wpgmza_adv_styling_json[mapid] !== "") {
                var WPGMZA_STYLING = new google.maps.StyledMapType(wpgmza_adv_styling_json[mapid],{name: "WPGMZA STYLING"});
            }

            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);

            if (wpgmza_adv_styling_json[mapid] !== "") {
                this.map.mapTypes.set('WPGMZA STYLING', WPGMZA_STYLING);
                this.map.setMapTypeId('WPGMZA STYLING');
            }
        } else {
            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
        }
        if (override_type === "STREETVIEW") {
            var panoramaOptions = {
                position: latLng
              };
            var panorama = new google.maps.StreetViewPanorama(jQuery(selector)[0], panoramaOptions);
            this.map.setStreetView(panorama);
        }

        

        this.bounds = new google.maps.LatLngBounds();
        directionsDisplay[mapid] = new google.maps.DirectionsRenderer({
             'map': this.map,
             'preserveViewport': true,
             'draggable': true
         });
        directionsDisplay[mapid].setPanel(document.getElementById("directions_panel_"+mapid));
        
        
        google.maps.event.addListener(directionsDisplay[mapid], 'directions_changed',
          function() {
              if (currentDirections) {
                  oldDirections.push(currentDirections);
              }
              currentDirections = directionsDisplay[mapid].getDirections();
              jQuery("#directions_panel_"+mapid).show();
              jQuery("#wpgmaps_directions_notification_"+mapid).hide();
              jQuery("#wpgmaps_directions_reset_"+mapid).show();
          });
                
                
                
        /* insert polygon and polyline functionality */
        if (wpgmaps_localize_polygon_settings !== null) {
            if (typeof wpgmaps_localize_polygon_settings[mapid] !== "undefined") {
                  for(var poly_entry in wpgmaps_localize_polygon_settings[mapid]) {
                    add_polygon(mapid,poly_entry);
                  }
            }
        }
        if (wpgmaps_localize_polyline_settings !== null) {
            if (typeof wpgmaps_localize_polyline_settings[mapid] !== "undefined") {
                  for(var poly_entry in wpgmaps_localize_polyline_settings[mapid]) {
                    add_polyline(mapid,poly_entry);
                  }
            }
        }
    
        
        /*
        if (wpgmaps_localize_polyline_settings !== null) {
            if (wpgmaps_localize_polyline_settings[mapid] !== null) { 
                for(var poly_entry in wpgmaps_localize_polyline_settings[mapid]) {
                    var tmp_data = wpgmaps_localize_polyline_settings[mapid];

                    var tmp_polydata = tmp_data[poly_entry]['polydata'];
                     var WPGM_PathData = new Array();
                     for (tmp_entry2 in tmp_polydata) {
                         WPGM_PathData.push(new google.maps.LatLng(tmp_polydata[tmp_entry2][0], tmp_polydata[tmp_entry2][1]));

                     }
                    if (tmp_data[poly_entry]['lineopacity'] === null || tmp_data[poly_entry]['lineopacity'] === "") {
                        tmp_data[poly_entry]['lineopacity'] = 1;
                    }
                    
                    var WPGM_Path = new google.maps.Polyline({
                     path: WPGM_PathData,
                     strokeColor: "#"+tmp_data[poly_entry]['linecolor'],
                     strokeOpacity: tmp_data[poly_entry]['opacity'],
                     fillColor: "#"+tmp_data[poly_entry]['fillcolor'],
                     strokeWeight: tmp_data[poly_entry]['linethickness']
                   });
                   WPGM_Path.setMap(MYMAP[mapid].map);

                }
             }
        }
        */
                
        if (wpgmaps_localize[entry]['bicycle'] === "1") {
            var bikeLayer = new google.maps.BicyclingLayer();
            bikeLayer.setMap(MYMAP[mapid].map);
        }        
        if (wpgmaps_localize[entry]['traffic'] === "1") {
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(MYMAP[mapid].map);
        }        
        if ("undefined" !== typeof wpgmaps_localize[mapid]['other_settings']['weather_layer'] && wpgmaps_localize[mapid]['other_settings']['weather_layer'] === 1) {
            if ("undefined" === typeof google.maps.weather) { } else {
                if ("undefined" !== typeof wpgmaps_localize[mapid]['other_settings']['weather_layer_temp_type'] && wpgmaps_localize[mapid]['other_settings']['weather_layer_temp_type'] === 2) {
                    var weatherLayer = new google.maps.weather.WeatherLayer({ 
                        temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT
                    });
                    weatherLayer.setMap(MYMAP[mapid].map);
                } else {
                    var weatherLayer = new google.maps.weather.WeatherLayer({ 
                        temperatureUnits: google.maps.weather.TemperatureUnit.CELSIUS
                    });
                    weatherLayer.setMap(MYMAP[mapid].map);
                }
            }
        }        
        if ("undefined" !== typeof wpgmaps_localize[mapid]['other_settings']['cloud_layer'] && wpgmaps_localize[mapid]['other_settings']['cloud_layer'] === 1) {
            if ("undefined" === typeof google.maps.weather) { } else {
                var cloudLayer = new google.maps.weather.CloudLayer();
                cloudLayer.setMap(MYMAP[mapid].map);
            }
        }        
        if ("undefined" !== typeof wpgmaps_localize[mapid]['other_settings']['transport_layer'] && wpgmaps_localize[mapid]['other_settings']['transport_layer'] === 1) {
                var transitLayer = new google.maps.TransitLayer();
                transitLayer.setMap(MYMAP[mapid].map);
        }        
        if (wpgmaps_localize[entry]['kml'] !== "") {
            var wpgmaps_d = new Date();
            var wpgmaps_ms = wpgmaps_d.getTime();
            
            arr = wpgmaps_localize[mapid]['kml'].split(',');
            arr.forEach(function(entry) {
                var georssLayer = new google.maps.KmlLayer(entry+'?tstamp='+wpgmaps_ms,{preserveViewport: true});
                georssLayer.setMap(MYMAP[mapid].map);
            });


            
        }        
        if (wpgmaps_localize[mapid]['fusion'] !== "") {
            var fusionlayer = new google.maps.FusionTablesLayer(wpgmaps_localize[mapid]['fusion'], {
                  suppressInfoWindows: false
            });
            fusionlayer.setMap(MYMAP[mapid].map);
        }        

        if (typeof wpgmaps_localize[mapid]['other_settings']['push_in_map'] !== 'undefined' && wpgmaps_localize[mapid]['other_settings']['push_in_map'] === "1") {


            if (typeof wpgmaps_localize[mapid]['other_settings']['wpgmza_push_in_map_width'] !== 'undefined') {
                var wpgmza_con_width = wpgmaps_localize[mapid]['other_settings']['wpgmza_push_in_map_width'];
            } else {
                var wpgmza_con_width = "30%";
            }
            if (typeof wpgmaps_localize[mapid]['other_settings']['wpgmza_push_in_map_height'] !== 'undefined') {
                var wpgmza_con_height = wpgmaps_localize[mapid]['other_settings']['wpgmza_push_in_map_height'];
            } else {
                var wpgmza_con_height = "50%";
            }

            if (jQuery('#wpgmza_marker_holder_'+mapid).length) {
                var legend = document.getElementById('wpgmza_marker_holder_'+mapid);
                jQuery(legend).width(wpgmza_con_width);
                jQuery(legend).css('margin','15px');
                jQuery(legend).addClass('wpgmza_innermap_holder');
                jQuery(legend).addClass('wpgmza-shadow');
                jQuery('#wpgmza_table_'+mapid).addClass('');
                wpgmza_controls_active[mapid] = true;
            } else if (jQuery('#wpgmza_marker_list_container_'+mapid).length) {
                var legend_tmp = document.getElementById('wpgmza_marker_list_container_'+mapid);
                
                jQuery('#wpgmza_marker_list_container_'+mapid).wrap("<div id='wpgmza_marker_list_parent_"+mapid+"'></div>");
                var legend = document.getElementById('wpgmza_marker_list_parent_'+mapid);
                jQuery(legend).width(wpgmza_con_width);
                jQuery(legend).height(wpgmza_con_height);

                jQuery(legend).css('margin','15px');
                jQuery(legend).css('overflow','auto');

                /* check if we're using the carousel option */
                if (jQuery(legend_tmp).hasClass("wpgmza_marker_carousel")) { } else {
                    jQuery(legend).addClass('wpgmza_innermap_holder');
                    jQuery(legend).addClass('wpgmza-shadow');
                }

                jQuery('#wpgmza_marker_list_'+mapid).addClass('');
                wpgmza_controls_active[mapid] = true;

            } else if (jQuery('#wpgmza_marker_list_'+mapid).length) {
                var legend_tmp = document.getElementById('wpgmza_marker_list_'+mapid);
                
                jQuery('#wpgmza_marker_list_'+mapid).wrap("<div id='wpgmza_marker_list_parent_"+mapid+"'></div>");
                var legend = document.getElementById('wpgmza_marker_list_parent_'+mapid);
                jQuery(legend).width(wpgmza_con_width);
                jQuery(legend).height(wpgmza_con_height);

                jQuery(legend).css('margin','15px');
                jQuery(legend).css('overflow','auto');

                /* check if we're using the carousel option */
                if (jQuery(legend_tmp).hasClass("wpgmza_marker_carousel")) { } else {
                    jQuery(legend).addClass('wpgmza_innermap_holder');
                    jQuery(legend).addClass('wpgmza-shadow');
                }

                jQuery('#wpgmza_marker_list_'+mapid).addClass('');
                wpgmza_controls_active[mapid] = true;
            }

            if (typeof legend !== 'undefined') { 
                if (typeof wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] !== 'undefined') {
                    if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "1") { MYMAP[mapid].map.controls[google.maps.ControlPosition.TOP_CENTER].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "2") { MYMAP[mapid].map.controls[google.maps.ControlPosition.TOP_LEFT].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "3") { MYMAP[mapid].map.controls[google.maps.ControlPosition.TOP_RIGHT].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "4") { MYMAP[mapid].map.controls[google.maps.ControlPosition.LEFT_TOP].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "5") { MYMAP[mapid].map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "6") { MYMAP[mapid].map.controls[google.maps.ControlPosition.LEFT_CENTER].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "7") { MYMAP[mapid].map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "8") { MYMAP[mapid].map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "9") { MYMAP[mapid].map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "10") { MYMAP[mapid].map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "11") { MYMAP[mapid].map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(legend); }
                    else if (wpgmaps_localize[mapid]['other_settings']['push_in_map_placement'] === "12") { MYMAP[mapid].map.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(legend); }
                    else { MYMAP[mapid].map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend); }  

                } else { MYMAP[mapid].map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend); }  
            } 
        
        }
    };    

    
    infoWindow = new google.maps.InfoWindow();
    if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']) {
        wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width'] = '250';
    }
    infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});



    google.maps.event.addDomListener(window, 'resize', function() {
        var myLatLng = new google.maps.LatLng(wpgmaps_localize[entry]['map_start_lat'],wpgmaps_localize[entry]['map_start_lng']);
        
        if ('undefined' !== typeof MYMAP[wpgmaps_localize[entry]['id']].map) {
            MYMAP[wpgmaps_localize[entry]['id']].map.setCenter(myLatLng);
        }
    });
    
    



    MYMAP[wpgmaps_localize[entry]['id']].placeMarkers = function(filename,map_id,cat_id,radius,searched_center,distance_type,search_title) {
        


        if (typeof marker_array[map_id] !== "undefined") {
            for (var i = 0; i < marker_array[map_id].length; i++) {
                /* remove any instance of a marker first tio avoid using a full reinit which causes the map to flicker */
                if (typeof marker_array[map_id][i] !== 'undefined') { 
                    
                    marker_array[map_id][i].setMap(null);
                    /* Check which map we are working on, and only reset the correct markers. (Store locator, etc) */
                }
            }
        }

        /* reset store locator circle */
        if (typeof cityCircle[map_id] !== "undefined") {
            cityCircle[map_id].setMap(null);
        }

        /* reset store locator icons if any */
        if (typeof store_locator_marker[map_id] !== "undefined") {
            store_locator_marker[map_id].setMap(null);
        }

        marker_array[map_id] = new Array(); 
        marker_sl_array[map_id] = new Array(); 
        marker_array2[map_id] = new Array(); 
        var check1 = 0;

        if (wpgmaps_localize_global_settings['wpgmza_settings_image_width'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_image_width']) { wpgmaps_localize_global_settings['wpgmza_settings_image_width'] = 'auto'; } else { wpgmaps_localize_global_settings['wpgmza_settings_image_width'] = wpgmaps_localize_global_settings['wpgmza_settings_image_width']+'px'; }
        if (wpgmaps_localize_global_settings['wpgmza_settings_image_height'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_image_height']) { wpgmaps_localize_global_settings['wpgmza_settings_image_height'] = 'auto'; } else { wpgmaps_localize_global_settings['wpgmza_settings_image_height'] = wpgmaps_localize_global_settings['wpgmza_settings_image_height']+'px'; }


        if (marker_pull === '1') {
        
        
        
            jQuery.get(filename, function(xml){

                jQuery(xml).find("marker").each(function(){
                    var wpgmza_def_icon = wpgmaps_localize[map_id]['default_marker'];
                    var wpmgza_map_id = jQuery(this).find('map_id').text();
                    var wpmgza_marker_id = jQuery(this).find('marker_id').text();
                    var wpmgza_title = jQuery(this).find('title').text();
                    var wpgmza_orig_title = wpmgza_title;
                    if (wpmgza_title !== "") {
                        var wpmgza_title = '<p class="wpgmza_infowindow_title">'+jQuery(this).find('title').text()+'</p>';
                    }
                    var wpmgza_address = jQuery(this).find('address').text();
                    if (wpmgza_address !== "") {
                        var wpmgza_show_address = '<p class="wpgmza_infowindow_address">'+wpmgza_address+'</p>';
                    } else {
                        var wpmgza_show_address = '';
                    }

                    var wpmgza_mapicon = jQuery(this).find('icon').text();
                    var wpmgza_image = jQuery(this).find('pic').text();
                    var wpmgza_desc  = jQuery(this).find('desc').text();
                    var wpgmza_orig_desc = wpmgza_desc;
                    if (wpmgza_desc !== "") {
                        var wpmgza_desc = '<p class="wpgmza_infowindow_description">'+jQuery(this).find('desc').text()+'</p>';
                    }
                    var wpmgza_linkd = jQuery(this).find('linkd').text();
                    var wpmgza_linkd_orig = wpmgza_linkd;
                    var wpmgza_anim  = jQuery(this).find('anim').text();
                    var wpmgza_retina  = jQuery(this).find('retina').text();
                    var wpmgza_category  = jQuery(this).find('category').text();
                    var current_lat = jQuery(this).find('lat').text();
                    var current_lng = jQuery(this).find('lng').text();
                    var show_marker_radius = true;
                    var show_marker_title_string = true;



                    if (radius !== null) {


                        if (check1 > 0 ) { } else { 
                            var sl_stroke_color = wpgmaps_localize[map_id]['other_settings']['sl_stroke_color'];
                            if (sl_stroke_color !== "" || sl_stroke_color !== null) { } else { sl_stroke_color = 'FF0000'; }
                            var sl_stroke_opacity = wpgmaps_localize[map_id]['other_settings']['sl_stroke_opacity'];
                            if (sl_stroke_opacity !== "" || sl_stroke_opacity !== null) { } else { sl_stroke_opacity = '0.25'; }
                            var sl_fill_opacity = wpgmaps_localize[map_id]['other_settings']['sl_fill_opacity'];
                            if (sl_fill_opacity !== "" || sl_fill_opacity !== null) { } else { sl_fill_opacity = '0.15'; }
                            var sl_fill_color = wpgmaps_localize[map_id]['other_settings']['sl_fill_color'];
                            if (sl_fill_color !== "" || sl_fill_color !== null) { } else { sl_fill_color = 'FF0000'; }

                            var point = new google.maps.LatLng(parseFloat(searched_center.lat()),parseFloat(searched_center.lng()));
                            MYMAP[map_id].bounds.extend(point);

                            if (wpgmaps_localize[map_id]['other_settings']['store_locator_bounce'] === 1) {
                                if (wpgmza_def_icon === null || wpgmza_def_icon === "" || wpgmza_def_icon === 0 || wpgmza_def_icon === "0") {
                                    store_locator_marker[map_id] = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            animation: google.maps.Animation.BOUNCE
                                    });

                                } else {
                                    store_locator_marker[map_id] = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            icon: wpgmza_def_icon,
                                            animation: google.maps.Animation.BOUNCE
                                    });
                                }
                                
                            } else {
                                /* do nothing */
                            }
                            if (distance_type === "1") {
                                var populationOptions = {
                                        strokeColor: '#'+sl_stroke_color,
                                        strokeOpacity: sl_stroke_opacity,
                                        strokeWeight: 2,
                                        fillColor: '#'+sl_fill_color,
                                        fillOpacity: sl_fill_opacity,
                                        map: MYMAP[map_id].map,
                                        center: point,
                                        radius: parseInt(radius / 0.000621371)
                                      };
                              } else {
                                  var populationOptions = {
                                        strokeColor: '#'+sl_stroke_color,
                                        strokeOpacity: sl_stroke_opacity,
                                        strokeWeight: 2,
                                        fillColor: '#'+sl_fill_color,
                                        fillOpacity: sl_fill_opacity,
                                        map: MYMAP[map_id].map,
                                        center: point,
                                        radius: parseInt(radius / 0.001)
                                      };
                              }
                            /* Add the circle for this city to the map. */
                            cityCircle[map_id] = new google.maps.Circle(populationOptions);
                            check1 = check1 + 1;
                        }

                        if (distance_type === "1") {
                            R = 3958.7558657440545; /* Radius of earth in Miles  */
                        } else {
                            R = 6378.16; /* Radius of earth in kilometers  */
                        }
                        var dLat = toRad(searched_center.lat()-current_lat);
                        var dLon = toRad(searched_center.lng()-current_lng); 
                        var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(toRad(current_lat)) * Math.cos(toRad(searched_center.lat())) * Math.sin(dLon/2) * Math.sin(dLon/2); 
                        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                        var d = R * c;
                        
                        if (d < radius) { show_marker_radius = true; } else { show_marker_radius = false; }


                        /* check if they have done a title search too */
                        if (search_title === null || search_title === "") { show_marker_title_string = true; }
                        else {
                            var x = wpgmza_orig_title.toLowerCase().search(search_title.toLowerCase());
                            var y = wpgmza_orig_desc.toLowerCase().search(search_title.toLowerCase());
                            if (x >= 0 || y >= 0) {
                                show_marker_title_string = true;
                            } else {
                                show_marker_title_string = false;
                            }

                        }



                    }
                    var cat_is_cat;
                    cat_is_cat = false;
                    if( Object.prototype.toString.call( cat_id ) === '[object Array]' ) {
                        /* work with category array */
                        if (cat_id[0] === '0') { cat_id === "all"; }
                        for (var tmp_val in cat_id) {
                            /* only one category sent through to show */
                            if(wpmgza_category.indexOf(',') === -1) {
                                if (cat_id[tmp_val] === wpmgza_category) { 
                                    cat_is_cat = true;
                                }
                            } else { 
                                var array = JSON.parse("[" + wpmgza_category + "]");
                                array.forEach(function(entry) {
                                    if (parseInt(cat_id[tmp_val]) === parseInt(entry)) {
                                        cat_is_cat = true;
                                    }
                                });
                            } 


                        }
                    } else {

                        /* only one category sent through to show */
                        if(wpmgza_category.indexOf(',') === -1) {
                            if (cat_id === wpmgza_category) {
                                cat_is_cat = true;
                            }
                        } else { 
                            var array = JSON.parse("[" + wpmgza_category + "]");
                            array.forEach(function(entry) {
                                if (parseInt(cat_id) === parseInt(entry)) {
                                    cat_is_cat = true;
                                }
                            });
                        } 
                    }  

                    if (cat_id === 'all' || cat_is_cat) {

                        var wpmgza_infoopen  = jQuery(this).find('infoopen').text();
                        

                        if (wpmgza_image !== "") {
                            



                            /* timthumb completely removed in 5.54 */
                            /*if (wpgmaps_localize_global_settings['wpgmza_settings_use_timthumb'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_use_timthumb']) {
                                    wpmgza_image = "<img src=\""+wpgmaps_plugurl+"/timthumb.php?src="+wpmgza_image+"&h="+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"&w="+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"&zc=1\" title=\"\" class=\"wpgmza_infowindow_image\" width=\""+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"\" height=\""+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"\" style=\"float:right; width:"+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"px; height:"+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"px;\" />";
                            } else {*/
                                if ('undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_image_resizing'] || wpgmaps_localize_global_settings['wpgmza_settings_image_resizing'] === "yes") {

                                    wpmgza_image = "<img src=\""+wpmgza_image+"\" title=\"\" class=\"wpgmza_infowindow_image\" alt=\"\" style=\"float:right; width:"+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"; height:"+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"; max-width:"+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+"px !important;\" />";

                                } else {
                                    wpmgza_image = "<img src=\""+wpmgza_image+"\" class=\"wpgmza_infowindow_image wpgmza_map_image\" style=\"float:right; margin:5px; max-width:"+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+"px !important;\" />";
                                }
                            /*}*/


                        } else { wpmgza_image = ""; }


                        if (wpmgza_linkd !== "") {
                            if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_links'] === "yes") { wpgmza_iw_links_target = "target='_BLANK'";  }
                            else { wpgmza_iw_links_target = ''; }
                            wpmgza_linkd = "<p class=\"wpgmza_infowindow_link\"><a class=\"wpgmza_infowindow_link\" href=\""+wpmgza_linkd+"\" "+wpgmza_iw_links_target+" title=\""+wpgmaps_lang_more_details+"\">"+wpgmaps_lang_more_details+"</a></p>";
                        }

                        if (wpmgza_mapicon === "" || !wpmgza_mapicon) { if (wpgmza_def_icon !== "") { wpmgza_mapicon = wpgmaps_localize[map_id]['default_marker']; } }

                        var wpgmza_optimized = true;
                        if (wpmgza_retina === "1" && wpmgza_mapicon !== "0") {
                            wpmgza_mapicon = new google.maps.MarkerImage(wpmgza_mapicon, null, null, null, new google.maps.Size(wpgmza_retina_width,wpgmza_retina_height));
                            wpgmza_optimized = false;
                        }



                        var lat = jQuery(this).find('lat').text();
                        var lng = jQuery(this).find('lng').text();
                        var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                        MYMAP[map_id].bounds.extend(point);

                        


                        if (show_marker_radius === true && show_marker_title_string === true) {
                            if (wpmgza_anim === "1") {
                                if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                    var marker = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            animation: google.maps.Animation.BOUNCE
                                    });
                                } else {
                                    var marker = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            icon: wpmgza_mapicon,
                                            animation: google.maps.Animation.BOUNCE,
                                            optimized: wpgmza_optimized

                                    });
                                }
                            }
                            else if (wpmgza_anim === "2") {
                                if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                    var marker = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            animation: google.maps.Animation.DROP
                                    });

                                } else {

                                    var marker = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            icon: wpmgza_mapicon,
                                            animation: google.maps.Animation.DROP,
                                            optimized: wpgmza_optimized
                                    });
                                }
                            }
                            else {
                                if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                    var marker = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            optimized: wpgmza_optimized
                                    });

                                } else {
                                    var marker = new google.maps.Marker({
                                            position: point,
                                            map: MYMAP[map_id].map,
                                            icon: wpmgza_mapicon,
                                            optimized: wpgmza_optimized
                                    });
                                }
                            }

                            

                            if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_address'] === "yes") {
                                wpmgza_show_address = "";
                            }
                            if (wpgmaps_localize[map_id]['directions_enabled'] === "1") {
                                wpmgza_dir_enabled = '<p><a href="javascript:void(0);" id="'+map_id+'" class="wpgmza_gd" wpgm_addr_field="'+wpmgza_address+'" gps="'+parseFloat(lat)+','+parseFloat(lng)+'">'+wpgmaps_lang_get_dir+'</a></p>';
                            } else {
                                wpmgza_dir_enabled = '';
                            }
                            if (radius !== null) {                                 
                                if (distance_type === "1") {
                                    d_string = "<p>"+Math.round(d,2)+' '+wpgmaps_lang_m_away+"</p>"; 
                                } else {
                                    d_string = "<p>"+Math.round(d,2)+' '+wpgmaps_lang_km_away+"</p>"; 
                                }
                            } else { d_string = ''; }

                            if (wpmgza_image !== "") {
                                    var html='<div class="wpgmza_markerbox scrollFix" style="min-width:'+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+'px;">'+
                                    wpmgza_image+
                                    wpmgza_title+
                                    wpmgza_show_address+
                                    wpmgza_desc+
                                    wpmgza_linkd+
                                    d_string+
                                    wpmgza_dir_enabled+
                                    '</div>';

                            } else {
                                    var html='<div class="wpgmza_markerbox scrollFix" style="min-width:'+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+'px;">'+                                
                                
                                    wpmgza_image+
                                    wpmgza_title+
                                    wpmgza_show_address+
                                    wpmgza_desc+
                                    wpmgza_linkd+
                                    d_string+
                                    wpmgza_dir_enabled+
                                    '</div>';

                            }



                            if (wpmgza_infoopen === "1") {
                                infoWindow.setContent(html);
                                infoWindow.open(MYMAP[map_id].map, marker);
                            }

                            /* do they want to open a marker from a GET variable? */
                            if (typeof wpgmza_open_marker !== "underfined") {
                                if (wpgmza_open_marker === wpmgza_marker_id) { 
                                    infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                    infoWindow.setContent(html);
                                    infoWindow.open(MYMAP[map_id].map, marker);
                                    MYMAP[map_id].map.setCenter(point);
                                    if (typeof wpgmza_open_marker_zoom !== "undefined") {
                                        MYMAP[map_id].map.setZoom(parseInt(wpgmza_open_marker_zoom));
                                    }
                                }
                            }

                            if (typeof wpgmaps_localize[map_id]['other_settings']['click_open_link'] !== "undefined" && wpgmaps_localize[map_id]['other_settings']['click_open_link'] === 1 && typeof wpmgza_linkd_orig !== "undefined" && wpmgza_linkd_orig !== "") {
                                google.maps.event.addListener(marker, 'click', function(evt) {
                                    location = wpmgza_linkd_orig;
                               }); 
                            }
                            if (wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] || wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === '1') { 
                                google.maps.event.addListener(marker, 'click', function(evt) {
                                    infoWindow.close();
                                    infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                    infoWindow.setContent(html);
                                    if (click_from_list) {
                                        MYMAP[map_id].map.panTo(marker.position);
                                        MYMAP[map_id].map.setZoom(13);
                                    }
                                    click_from_list = false;                                    
                                    infoWindow.open(MYMAP[map_id].map, marker);
                                }); 
                            } else {
                                google.maps.event.addListener(marker, 'mouseover', function(evt) {
                                    infoWindow.close();
                                    infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                    infoWindow.setContent(html);
                                    if (click_from_list) {
                                        MYMAP[map_id].map.panTo(marker.position);
                                        MYMAP[map_id].map.setZoom(13);
                                    }
                                    click_from_list = false;
                                    infoWindow.open(MYMAP[map_id].map, marker);
                                    
                                }); 
                            }
                            marker_array[map_id][wpmgza_marker_id] = marker;
                            marker_array2[map_id].push(marker);
                            marker_sl_array[map_id].push(wpmgza_marker_id);

                        }
                    } 

                });
                if (typeof wpgm_g_e !== "undefined" && wpgm_g_e === true) {
                    var mcOptions = {
                        gridSize: 20,
                        maxZoom: 15,
                        styles: [{
                            height: 53,
                            url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png",
                            width: 53
                        },
                        {
                            height: 56,
                            url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m2.png",
                            width: 56
                        },
                        {
                            height: 66,
                            url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m3.png",
                            width: 66
                        },
                        {
                            height: 78,
                            url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m4.png",
                            width: 78
                        },
                        {
                            height: 90,
                            url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m5.png",
                            width: 90
                        }] 
                    };
                    if (wpgmaps_localize[map_id]['mass_marker_support'] === "1" || wpgmaps_localize[map_id]['mass_marker_support'] === null) { 
                        MYMAP[map_id].mc = new MarkerClusterer(MYMAP[map_id].map, marker_array2[map_id], mcOptions);
                    }
                }


                if (radius !== null) {

                    wpgmza_filter_marker_lists_by_array(map_id,marker_sl_array[map_id]);

                }

            });
        
        } else { 
            /* DB method */
            jQuery.each(wpgmaps_localize_marker_data[map_id], function(i, val) {
                
                
                var wpgmza_def_icon = wpgmaps_localize[map_id]['default_marker'];
                

                /*
                    removed due to mashup incompatibilities. If used, it tries to push the marker to the markers original ID instead of the MASHUP MAP ID.
                    var wpmgza_map_id = val.map_id;
                
                */ 
                var wpmgza_map_id = map_id;
                

                var wpmgza_marker_id = val.marker_id;

                var wpmgza_title = val.title;
                var wpgmza_orig_title = wpmgza_title;
                if (wpmgza_title !== "") {
                    var wpmgza_title = '<p class="wpgmza_infowindow_title">'+val.title+'</p>';
                }
                var wpmgza_address = val.address;
                if (wpmgza_address !== "") {
                    var wpmgza_show_address = '<p class="wpgmza_infowindow_address">'+wpmgza_address+'</p>';
                } else {
                    var wpmgza_show_address = '';
                }
                var wpmgza_mapicon = val.icon;
                var wpmgza_image = val.pic;
                var wpmgza_desc  = val.desc;
                var wpgmza_orig_desc = wpmgza_desc;
                if (wpmgza_desc !== "") {
                    var wpmgza_desc = '<p class="wpgmza_infowindow_description">'+val.desc;+'</p>';
                }
                var wpmgza_linkd = val.linkd;
                var wpmgza_linkd_orig = wpmgza_linkd;

                var wpmgza_anim  = val.anim;
                var wpmgza_retina  = val.retina;
                var wpmgza_category  = val.category;
                var current_lat = val.lat;
                var current_lng = val.lng;
                var show_marker_radius = true;
                var show_marker_title_string = true;


                if (radius !== null) {


                    if (check1 > 0 ) { } else { 
                        var sl_stroke_color = wpgmaps_localize[map_id]['other_settings']['sl_stroke_color'];
                        if (sl_stroke_color !== "" || sl_stroke_color !== null) { } else { sl_stroke_color = 'FF0000'; }
                        var sl_stroke_opacity = wpgmaps_localize[map_id]['other_settings']['sl_stroke_opacity'];
                        if (sl_stroke_opacity !== "" || sl_stroke_opacity !== null) { } else { sl_stroke_opacity = '0.25'; }
                        var sl_fill_opacity = wpgmaps_localize[map_id]['other_settings']['sl_fill_opacity'];
                        if (sl_fill_opacity !== "" || sl_fill_opacity !== null) { } else { sl_fill_opacity = '0.15'; }
                        var sl_fill_color = wpgmaps_localize[map_id]['other_settings']['sl_fill_color'];
                        if (sl_fill_color !== "" || sl_fill_color !== null) { } else { sl_fill_color = 'FF0000'; }

                        var point = new google.maps.LatLng(parseFloat(searched_center.lat()),parseFloat(searched_center.lng()));
                        MYMAP[map_id].bounds.extend(point);

                        if (wpgmaps_localize[map_id]['other_settings']['store_locator_bounce'] === 1) {
                            if (wpgmza_def_icon === null || wpgmza_def_icon === "" || wpgmza_def_icon === 0 || wpgmza_def_icon === "0") {
                                store_locator_marker[map_id] = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        animation: google.maps.Animation.BOUNCE
                                });

                            } else {
                                store_locator_marker[map_id] = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        icon: wpgmza_def_icon,
                                        animation: google.maps.Animation.BOUNCE
                                });
                            }
                            
                            
                        } else {
                            /* do nothing */
                        }
                        if (distance_type === "1") {
                            var populationOptions = {
                                    strokeColor: '#'+sl_stroke_color,
                                    strokeOpacity: sl_stroke_opacity,
                                    strokeWeight: 2,
                                    fillColor: '#'+sl_fill_color,
                                    fillOpacity: sl_fill_opacity,
                                    map: MYMAP[map_id].map,
                                    center: point,
                                    radius: parseInt(radius / 0.000621371)
                                  };
                          } else {
                              var populationOptions = {
                                    strokeColor: '#'+sl_stroke_color,
                                    strokeOpacity: sl_stroke_opacity,
                                    strokeWeight: 2,
                                    fillColor: '#'+sl_fill_color,
                                    fillOpacity: sl_fill_opacity,
                                    map: MYMAP[map_id].map,
                                    center: point,
                                    radius: parseInt(radius / 0.001)
                                  };
                          }
                        cityCircle[map_id] = new google.maps.Circle(populationOptions);
                        check1 = check1 + 1;
                    }

                    if (distance_type === "1") {
                        R = 3958.7558657440545;
                    } else {
                        R = 6378.16;
                    }
                    var dLat = toRad(searched_center.lat()-current_lat);
                    var dLon = toRad(searched_center.lng()-current_lng); 
                    var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(toRad(current_lat)) * Math.cos(toRad(searched_center.lat())) * Math.sin(dLon/2) * Math.sin(dLon/2); 
                    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                    var d = R * c;
                    
                    if (d < radius) { show_marker_radius = true; } else { show_marker_radius = false; }


                    /* check if they have done a title search too */
                    if (search_title === null || search_title === "") { show_marker_title_string = true; }
                    else {
                        var x = wpgmza_orig_title.toLowerCase().search(search_title.toLowerCase());
                        var y = wpgmza_orig_desc.toLowerCase().search(search_title.toLowerCase());
                        if (x >= 0 || y >= 0) {
                            show_marker_title_string = true;
                        } else {
                            show_marker_title_string = false;
                        }

                    }



                }

                var cat_is_cat;
                cat_is_cat = false;
                if( Object.prototype.toString.call( cat_id ) === '[object Array]' ) {

                    /* work with category array */
                    if (cat_id[0] === '0') { cat_id === "all"; }
                    for (var tmp_val in cat_id) {
                        /* only one category sent through to show */
                        if(wpmgza_category.indexOf(',') === -1) {
                            if (cat_id[tmp_val] === wpmgza_category) { 
                                cat_is_cat = true;
                            }
                        } else { 
                            var array = JSON.parse("[" + wpmgza_category + "]");
                            array.forEach(function(entry) {
                                if (parseInt(cat_id[tmp_val]) === parseInt(entry)) {
                                    cat_is_cat = true;
                                }
                            });
                        } 


                    }
                } else {

                    /* only one category sent through to show */
                   if(typeof wpmgza_category !== 'undefined') {
                       if (wpmgza_category.indexOf(',') === -1) {
                            if (cat_id === wpmgza_category) {
                                cat_is_cat = true;
                            }
                        } else { 
                            var array = JSON.parse("[" + wpmgza_category + "]");
                            array.forEach(function(entry) {
                                if (parseInt(cat_id) === parseInt(entry)) {
                                    cat_is_cat = true;
                                }
                            });
                        } 
                    } else {

                        
                    }
                }  
                if (cat_id === 'all' || cat_is_cat) {
                    
                    var wpmgza_infoopen  = val.infoopen;
                    if (wpmgza_image !== "") {

                        /* timthumb completely removed in 5.54 */
                        /*if (wpgmaps_localize_global_settings['wpgmza_settings_use_timthumb'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_use_timthumb']) {
                                wpmgza_image = "<img src=\""+wpgmaps_plugurl+"/timthumb.php?src="+wpmgza_image+"&h="+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"&w="+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"&zc=1\" title=\"\" class=\"wpgmza_infowindow_image\" width=\""+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"\" height=\""+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"\" style=\"float:right; width:"+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"px; height:"+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"px;\" />";
                        } else {*/
                            if ('undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_image_resizing'] || wpgmaps_localize_global_settings['wpgmza_settings_image_resizing'] === "yes") {
                                    wpmgza_image = "<img src=\""+wpmgza_image+"\" title=\"\" class=\"wpgmza_infowindow_image\" alt=\"\" style=\"float:right; width:"+wpgmaps_localize_global_settings['wpgmza_settings_image_width']+"; height:"+wpgmaps_localize_global_settings['wpgmza_settings_image_height']+"; max-width:"+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+"px !important;\" />";

                                } else {
                                    wpmgza_image = "<img src=\""+wpmgza_image+"\" class=\"wpgmza_infowindow_image wpgmza_map_image\" style=\"float:right; margin:5px; max-width:"+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+"px !important;\" />";
                            }
                        /*}*/
                    }

                    if (wpmgza_linkd !== "") {
                        if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_links'] === "yes") { wpgmza_iw_links_target = "target='_BLANK'";  }
                        else { wpgmza_iw_links_target = ''; }
                        wpmgza_linkd = "<p class=\"wpgmza_infowindow_link\"><a class=\"wpgmza_infowindow_link\" href=\""+wpmgza_linkd+"\" "+wpgmza_iw_links_target+" title=\""+wpgmaps_lang_more_details+"\">"+wpgmaps_lang_more_details+"</a></p>";
                    }

                    if (wpmgza_mapicon === "" || !wpmgza_mapicon) { if (wpgmza_def_icon !== "") { wpmgza_mapicon = wpgmaps_localize[entry]['default_marker']; } }
                    var wpgmza_optimized = true;
                    if (wpmgza_retina === "1" && wpmgza_mapicon !== "0") {
                        wpmgza_mapicon = new google.maps.MarkerImage(wpmgza_mapicon, null, null, null, new google.maps.Size(wpgmza_retina_width,wpgmza_retina_height));
                        wpgmza_optimized = false;
                    }


                    var lat = val.lat;
                    var lng = val.lng;
                    var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                    MYMAP[map_id].bounds.extend(point);

                    
                    

                    if (show_marker_radius === true && show_marker_title_string === true) {
                        if (wpmgza_anim === "1") {
                            if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        animation: google.maps.Animation.BOUNCE
                                });
                            } else {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        icon: wpmgza_mapicon,
                                        animation: google.maps.Animation.BOUNCE,
                                        optimized: wpgmza_optimized

                                });
                            }
                        }
                        else if (wpmgza_anim === "2") {
                            if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        animation: google.maps.Animation.DROP
                                });

                            } else {

                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        icon: wpmgza_mapicon,
                                        animation: google.maps.Animation.DROP,
                                        optimized: wpgmza_optimized
                                });
                            }
                        }
                        else {
                            if (wpmgza_mapicon === null || wpmgza_mapicon === "" || wpmgza_mapicon === 0 || wpmgza_mapicon === "0") {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        optimized: wpgmza_optimized
                                });

                            } else {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP[map_id].map,
                                        icon: wpmgza_mapicon,
                                        optimized: wpgmza_optimized
                                });
                            }
                        }
                        

                        if (wpgmaps_localize_global_settings['wpgmza_settings_infowindow_address'] === "yes") {
                            wpmgza_show_address = "";
                        }
                        if (wpgmaps_localize[entry]['directions_enabled'] === "1") {
                            wpmgza_dir_enabled = '<p><a href="javascript:void(0);" id="'+map_id+'" class="wpgmza_gd" wpgm_addr_field="'+wpmgza_address+'" gps="'+parseFloat(lat)+','+parseFloat(lng)+'">'+wpgmaps_lang_get_dir+'</a></p>';
                        } else {
                            wpmgza_dir_enabled = '';
                        }
                        if (radius !== null) {                                 
                            if (distance_type === "1") {
                                d_string = "<p>"+Math.round(d,2)+' '+wpgmaps_lang_m_away+"</p>"; 
                            } else {
                                d_string = "<p>"+Math.round(d,2)+' '+wpgmaps_lang_km_away+"</p>"; 
                            }
                        } else { d_string = ''; }
                        if (wpmgza_image !== "") {
                            var html='<div class="wpgmza_markerbox scrollFix" style="min-width:'+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+'px;">'+
                                wpmgza_image+
                                wpmgza_title+
                                wpmgza_show_address+
                                wpmgza_desc+
                                wpmgza_linkd+
                                d_string+
                                wpmgza_dir_enabled+
                                '</div>';

                        } else {
                            var html='<div class="wpgmza_markerbox scrollFix" style="min-width:'+wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']+'px;">'+
                                wpmgza_image+
                                wpmgza_title+
                                wpmgza_show_address+
                                wpmgza_desc+
                                wpmgza_linkd+
                                d_string+
                                wpmgza_dir_enabled+
                                '</div>';

                        }



                        if (wpmgza_infoopen === "1") {
                            
                            infoWindow.setContent(html);
                            infoWindow.open(MYMAP[map_id].map, marker);
                        }
                        /* do they want to open a marker from a GET variable? */
                        if (typeof wpgmza_open_marker !== "underfined") {
                            if (wpgmza_open_marker === wpmgza_marker_id) { 
                                infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                infoWindow.setContent(html);
                                infoWindow.open(MYMAP[map_id].map, marker);
                                MYMAP[map_id].map.setCenter(point);
                                if (typeof wpgmza_open_marker_zoom !== "undefined") {
                                    MYMAP[map_id].map.setZoom(parseInt(wpgmza_open_marker_zoom));
                                }
                            }
                        }
                        if (typeof wpgmaps_localize[map_id]['other_settings']['click_open_link'] !== "undefined" && wpgmaps_localize[map_id]['other_settings']['click_open_link'] === 1 && typeof wpmgza_linkd_orig !== "undefined" && wpmgza_linkd_orig !== "") {
                            google.maps.event.addListener(marker, 'click', function(evt) {
                                location = wpmgza_linkd_orig;
                            }); 
                        }
                        

                        if (wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] || wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === '1') { 
                            google.maps.event.addListener(marker, 'click', function(evt) {
                                infoWindow.close();
                                infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                infoWindow.setContent(html);
                                if (click_from_list) {
                                    MYMAP[map_id].map.panTo(marker.position);
                                    MYMAP[map_id].map.setZoom(13);
                                }
                                click_from_list = false;

                                infoWindow.open(MYMAP[map_id].map, marker);
                                

                            }); 
                        } else {
                            google.maps.event.addListener(marker, 'mouseover', function(evt) {
                                infoWindow.close();
                                infoWindow.setOptions({maxWidth:wpgmaps_localize_global_settings['wpgmza_settings_infowindow_width']});
                                infoWindow.setContent(html);
                                if (click_from_list) {
                                    MYMAP[map_id].map.panTo(marker.position);
                                    MYMAP[map_id].map.setZoom(13);
                                }
                                click_from_list = false;
                                infoWindow.open(MYMAP[map_id].map, marker);
                                

                            }); 
                        }
                        
                        marker_array[map_id][wpmgza_marker_id] = marker;
                        marker_array2[map_id].push(marker);
                        marker_sl_array[map_id].push(wpmgza_marker_id);
                        

                    }
                } 

                
            });

            
            if (wpgm_g_e === true) {
                var mcOptions = {
                    gridSize: 20,
                    maxZoom: 15,
                    styles: [{
                        height: 53,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m1.png",
                        width: 53
                    },
                    {
                        height: 56,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m2.png",
                        width: 56
                    },
                    {
                        height: 66,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m3.png",
                        width: 66
                    },
                    {
                        height: 78,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m4.png",
                        width: 78
                    },
                    {
                        height: 90,
                        url: "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m5.png",
                        width: 90
                    }] 
                };
                if (wpgmaps_localize[entry]['mass_marker_support'] === "1" || wpgmaps_localize[entry]['mass_marker_support'] === null) { 
                    MYMAP[map_id].mc = new MarkerClusterer(MYMAP[map_id].map, marker_array2[map_id], mcOptions);
                }
            }


            if (radius !== null) {
                wpgmza_filter_marker_lists_by_array(map_id,marker_sl_array[map_id]);
            }
        }
        
        if (wpgmaps_localize[entry]['show_user_location'] === "1") {
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                  user_location = new google.maps.LatLng(position.coords.latitude,
                                                   position.coords.longitude);

                  var marker = new google.maps.Marker({
                          position: user_location,
                          map: MYMAP[wpgmaps_localize[entry]['id']].map,
                          animation: google.maps.Animation.DROP
                  });     
                  google.maps.event.addListener(marker, 'click', function(evt) {
                          infoWindow.close();
                          infoWindow.setContent(wpgmaps_lang_my_location);
                          infoWindow.open(MYMAP[wpgmaps_localize[entry]['id']].map, marker);
                      });
                  
                  marker_array[map_id][marker_array+1] = marker;

                });
             } else {
              /* Browser doesn't support Geolocation */
            }       
        }

    };
    
    
    
    function add_polygon(mapid,polygonid) {
        var tmp_data = wpgmaps_localize_polygon_settings[mapid][polygonid];
         var current_poly_id = polygonid;
         var tmp_polydata = tmp_data['polydata'];
         var WPGM_PathData = new Array();
         for (tmp_entry2 in tmp_polydata) {
             if (typeof tmp_polydata[tmp_entry2][0] !== "undefined") {
                
                WPGM_PathData.push(new google.maps.LatLng(tmp_polydata[tmp_entry2][0], tmp_polydata[tmp_entry2][1]));
            }
         }
         if (tmp_data['lineopacity'] === null || tmp_data['lineopacity'] === "") {
             tmp_data['lineopacity'] = 1;
         }
         
         var bounds = new google.maps.LatLngBounds();
         for (i = 0; i < WPGM_PathData.length; i++) {
           bounds.extend(WPGM_PathData[i]);
         }

        WPGM_Path_Polygon[polygonid] = new google.maps.Polygon({
             path: WPGM_PathData,
             clickable: true, /* must add option for this */ 
             strokeColor: "#"+tmp_data['linecolor'],
             fillOpacity: tmp_data['opacity'],
             strokeOpacity: tmp_data['lineopacity'],
             fillColor: "#"+tmp_data['fillcolor'],
             strokeWeight: 2,
             map: MYMAP[mapid].map
       });
       WPGM_Path_Polygon[polygonid].setMap(MYMAP[mapid].map);

        polygon_center = bounds.getCenter();

        if (tmp_data['title'] !== "") {
         infoWindow_poly[polygonid] = new google.maps.InfoWindow();
         google.maps.event.addListener(WPGM_Path_Polygon[polygonid], 'click', function(event) {
             infoWindow_poly[polygonid].setPosition(event.latLng);
             content = "";
             if (tmp_data['link'] !== "") {
                 var content = "<a href='"+tmp_data['link']+"'>"+tmp_data['title']+"</a>";
             } else {
                 var content = tmp_data['title'];
             }
             infoWindow_poly[polygonid].setContent(content);
             infoWindow_poly[polygonid].open(MYMAP[mapid].map,this.position);
         }); 
        }


       google.maps.event.addListener(WPGM_Path_Polygon[polygonid], "mouseover", function(event) {
             this.setOptions({fillColor: "#"+tmp_data['ohfillcolor']});
             this.setOptions({fillOpacity: tmp_data['ohopacity']});
             this.setOptions({strokeColor: "#"+tmp_data['ohlinecolor']});
             this.setOptions({strokeWeight: 2});
             this.setOptions({strokeOpacity: 0.9});
       });
       google.maps.event.addListener(WPGM_Path_Polygon[polygonid], "click", function(event) {

             this.setOptions({fillColor: "#"+tmp_data['ohfillcolor']});
             this.setOptions({fillOpacity: tmp_data['ohopacity']});
             this.setOptions({strokeColor: "#"+tmp_data['ohlinecolor']});
             this.setOptions({strokeWeight: 2});
             this.setOptions({strokeOpacity: 0.9});
       });
       google.maps.event.addListener(WPGM_Path_Polygon[polygonid], "mouseout", function(event) {
             this.setOptions({fillColor: "#"+tmp_data['fillcolor']});
             this.setOptions({fillOpacity: tmp_data['opacity']});
             this.setOptions({strokeColor: "#"+tmp_data['linecolor']});
             this.setOptions({strokeWeight: 2});
             this.setOptions({strokeOpacity: tmp_data['lineopacity']});
       });


           
        
        
    }
    function add_polyline(mapid,polyline) {
        
        
        var tmp_data = wpgmaps_localize_polyline_settings[mapid][polyline];

        var current_poly_id = polyline;
        var tmp_polydata = tmp_data['polydata'];
        var WPGM_Polyline_PathData = new Array();
        for (tmp_entry2 in tmp_polydata) {
            if (typeof tmp_polydata[tmp_entry2][0] !== "undefined" && typeof tmp_polydata[tmp_entry2][1] !== "undefined") {
                var lat = tmp_polydata[tmp_entry2][0].replace(')', '');
                lat = lat.replace('(','');
                var lng = tmp_polydata[tmp_entry2][1].replace(')', '');
                lng = lng.replace('(','');
                WPGM_Polyline_PathData.push(new google.maps.LatLng(lat, lng));
            }
             
             
        }
         if (tmp_data['lineopacity'] === null || tmp_data['lineopacity'] === "") {
             tmp_data['lineopacity'] = 1;
         }

        WPGM_Path[polyline] = new google.maps.Polyline({
             path: WPGM_Polyline_PathData,
             strokeColor: "#"+tmp_data['linecolor'],
             strokeOpacity: tmp_data['opacity'],
             strokeWeight: tmp_data['linethickness'],
             map: MYMAP[mapid].map
       });
       WPGM_Path[polyline].setMap(MYMAP[mapid].map);
        
        
    }
    
  
    

}






});




function openInfoWindow(marker_id,map_id,by_list) {
    if (by_list) {
        click_from_list = true;
    } else {
        click_from_list = false;
    }

    if (wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === "" || 'undefined' === typeof wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] || wpgmaps_localize_global_settings['wpgmza_settings_map_open_marker_by'] === '1') { 
        google.maps.event.trigger(marker_array[map_id][marker_id], 'click');
    } else {
        google.maps.event.trigger(marker_array[map_id][marker_id], 'mouseover');
    }
}






function calcRoute(start,end,mapid,travelmode,avoidtolls,avoidhighways) {
    var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.DirectionsTravelMode[travelmode],
        avoidHighways: avoidhighways,
        avoidTolls: avoidtolls
    };
    dirflg = "c";
    if (travelmode === "DRIVING") { dirflg = "c"; }
    else if (travelmode === "WALKING") { dirflg = "w"; }
    else if (travelmode === "BICYCLING") { dirflg = "b"; }
    else { dirflg = "c"; }
    directionsService[mapid].route(request, function(response, status) {
      if (status === google.maps.DirectionsStatus.OK) {
        directionsDisplay[mapid].setDirections(response);
      }
    });
    
    jQuery("#wpgmaps_print_directions_"+mapid).attr('href','https://maps.google.com/maps?saddr='+encodeURIComponent(start)+'&daddr='+encodeURIComponent(end)+'&pw=2&dirflg='+dirflg+'&om=1');
  }
function wpgmza_show_options(wpgmzamid) {

      jQuery("#wpgmza_options_box_"+wpgmzamid).show();
      jQuery("#wpgmza_show_options_"+wpgmzamid).hide();
      jQuery("#wpgmza_hide_options_"+wpgmzamid).show();
  }
function wpgmza_hide_options(wpgmzamid) {
      jQuery("#wpgmza_options_box_"+wpgmzamid).hide();
      jQuery("#wpgmza_show_options_"+wpgmzamid).show();
      jQuery("#wpgmza_hide_options_"+wpgmzamid).hide();
  }
function wpgmza_reset_directions(wpgmzamid) {

    jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).show();
    jQuery("#directions_panel_"+wpgmzamid).hide();
    jQuery("#wpgmaps_directions_notification_"+wpgmzamid).hide();
    jQuery("#wpgmaps_directions_reset_"+wpgmzamid).hide();
  }

jQuery("body").on("click", ".wpgmza_gd", function() {

    var wpgmzamid = jQuery(this).attr("id");
    var end = jQuery(this).attr("wpgm_addr_field");
    var latLong = jQuery(this).attr("gps");
    /* pelicanpaul updates for mobile */
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        
        if( (navigator.platform.indexOf("iPhone") != -1)
        || (navigator.platform.indexOf("iPod") != -1)
        || (navigator.platform.indexOf("iPad") != -1))
        window.open("maps://maps.google.com/maps?daddr="+latLong+"&ll=");
        else
        window.open("http://maps.google.com/maps?daddr="+latLong+"&ll=");
    } else {

        jQuery("#wpgmaps_directions_edit_"+wpgmzamid).show();
        jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).show();
        jQuery("#wpgmza_input_to_"+wpgmzamid).val(end);
        jQuery("#wpgmza_input_from_"+wpgmzamid).focus().select();
    }


});

jQuery("body").on("click", ".wpgmaps_get_directions", function() {

     var wpgmzamid = jQuery(this).attr("id");

     var avoidtolls = jQuery('#wpgmza_tolls_'+wpgmzamid).is(':checked');
     var avoidhighways = jQuery('#wpgmza_highways_'+wpgmzamid).is(':checked');


     var wpgmza_dir_type = jQuery("#wpgmza_dir_type_"+wpgmzamid).val();
     var wpgmaps_from = jQuery("#wpgmza_input_from_"+wpgmzamid).val();
     var wpgmaps_to = jQuery("#wpgmza_input_to_"+wpgmzamid).val();
     if (wpgmaps_from === "" || wpgmaps_to === "") { alert(wpgmaps_lang_error1); }
     else { calcRoute(wpgmaps_from,wpgmaps_to,wpgmzamid,wpgmza_dir_type,avoidtolls,avoidhighways); jQuery("#wpgmaps_directions_editbox_"+wpgmzamid).hide("slow"); jQuery("#wpgmaps_directions_notification_"+wpgmzamid).show("slow");  }
});



jQuery("body").on("keypress",".addressInput", function(event) {
  if ( event.which == 13 ) {
    var mid = jQuery(this).attr("mid");
     jQuery('.wpgmza_sl_search_button_'+mid).trigger('click');
  }
});

