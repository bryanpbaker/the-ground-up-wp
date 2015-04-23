<?php
/*
Plugin Name: WP Google Maps - Gold Add-on
Plugin URI: http://www.wpgmaps.com
Description: This is the Gold add-on for WP Google Maps. This enables mass-marker support and advanced map styling through the wizard.
Version: 3.29
Author: WP Google Maps
Author URI: http://www.wpgmaps.com
 *
 * 3.29
 * PHP Notices fixed
 * Database option now works in Gold
 * Retina marker settings are now applied in the back end map editor
 * Retina marker custom sizes are now supported in the back end
 *
 * 3.28
 * Right click to add marker bug fixed
 * PHP Notices fixed
 * 
 * 3.27 - Low priority update
 * Changed update URL
 * 
 * 3.26
 * Fixed approve marker bug
 * 
 * 3.25
 * Added support for the new marker pull method
 * 
 * 3.24
 * Approving of VGM markers bug fixed
 * 
 * 3.23
 * Fixed bug that copied one map style to another map style if there is more than one map on a page
 * Multiple category per marker support functionality added
 * 
 * 3.22
 * Code improvement
 * 
 * 3.21
 * Small bug fixes & code improvement
 * 
 * 3.20
 * Added the option to select which API version you would like to use
 * 
 * 3.19
 * Added weather, cloud and transit layer
 * 
 * 3.18
 * Small bug fix
 * 
 * 3.17
 * Compatible with basic version 6
 * 
 * 3.16
 * Fixed small bug with resetting select boxes within the add marker section
 * 
 * 3.15
 * Fixed a bug that stopped you from deleting polylines in the Gold add-on
 * All front end JS is now included in it's own file
 * 
 * 3.14
 * Added a check to see if the Google Maps API was already loaded to avoid duplicate loading
 * Fixed the mouse scroll wheel bug
 * Fixed some SSL bugs
 * Advanced marker list now updates with category drop down selection
 *
 * 3.13
 * Fixed a small bug with the categories
 *
 * 3.12
 * Added category functionality
 * Fixed a click bug with the marker listing
 *
 * 3.11
 * You can now show your visitors location on the map
 * Added polygon functionality
 * Added polyline functionality
 * Markers can now be sorted by id,title,description or address
 * Added better support for jQuery versions
 * Adjusted the KML functionality to avoid caching
 * Fixed a bug that stopped the advanced marker listing from working
 * 
 * 3.10
 * Fixed a bug that didnt allow for multiple clicks on the marker list to bring the view back to the map
 * 
 * 3.09
 * Fixed a dataTables bug
 * 
 * 3.08
 * This version allows the plugin to update itself moving forward
 * 
 * 3.07
 * Added troubleshooting support
 * 
 * 3.06
 * Fixed some small bugs    
 * 
 * 3.05
 * Fixed a IE9 display bug
 * Added support for jQuery1.9+
 * Fixed some bugs
 * Added support for one-page-style themes.
 * 
 * 3.04
 * Fixed bug whereby you couldnt disable mass marker support
 *
 * 3.03
 * Added responsive size functionality
 * You can now enable and disable mass marker support
 * Added support code for the new WP Google Maps User Generated Markers plugin
 * Added the option for a more advanced way to list your markers below your maps
 * Added support for Fusion Tables
 * 
 * 3.02
 * Fixed the bug that caused the directions box to show above the map by default
 * Fixed the bug whereby an address was already hard-coded into the "To" field of the directions box
 * Fixed the bug that caused the traffic layer to show by default
 *
 * 3.01
 * Added the functionality to list your markers below your map
 * Added more advanced directions functionality
 * Fixed small bugs
 * Fixed a bug that caused a fatal error when trying to activate the plugin on some hosts.
 *
 * 3.0
 * Plugin now supports multiple maps on one page (there is a known issue on the Gold add-on that shows another maps markers on the map your are on when using the zoom in/out function. I am working on this.
 * Bicycle directions now added
 * Walking directions now added
 * "Avoid tolls" now added to the directions functionality
 * "Avoid highways" now added to directions functionality
 * New setting: open links in a new window
 * Added functionality to reset the default marker image if required.
 *
 * 2.8
 * Fixed the bug that was causing both the bicycle layer and traffic layer to show all the time
 *
 * 2.7
 * Added traffic layer
 * Added bicycle layer
 *
 * 2.6
 * Added additional map settings
 * Added support for KML/GeoRSS layers.
 *
 * 2.5
 * Markers now automatically close when you click on another marker.
 * Russian localization added
 * The "To" field in the directions box now shows the address and not the GPS co-ords.
 *
 * 2.4
 * Added support for localization
 *
 * 2.3
 * Fixed the bug that caused slow loading times with sites that contain a high number of maps and markers
 *
 * 2.2
 * Added functionality for 'Titles' for each marker
 *
 * 2.1
 * Added functionality for WordPress MU
 *
 * 2.0
 * Added Map Alignment functionality
 * Added Map Type functionality
 * Started using the Geocoding API Version 3  instead of Version 2 - quicker results!
 * Fixed bug that didnt import animation data for CSV files
 * fixed zoom bug
 *
 * 1.1
 * Added support for advanced styling
 * Fixed a few bugs with the jQuery script
 * Fixed the shortcode bug where the map wasnt displaying when two or more short codes were one the post/page
 * Fixed a bug that wouldnt save the icon on editing a marker in some instances
 *
 *
 * 
*/

global $wpgmza_gold_version;
global $wpgmza_t;
global $wpgmza_p;
global $wpgmza_g;
$wpgmza_gold_version = "3.29";
$wpgmza_gold_string = "gold";
$wpgmza_p = true;
$wpgmza_g = true;

global $wpgmza_count;
$wpgmza_count = 0;


register_activation_hook( __FILE__, 'wpgmaps_gold_activate' );
register_deactivation_hook( __FILE__, 'wpgmaps_gold_deactivate' );
add_action('init', 'wpgmza_register_gold_version');
add_action('admin_head', 'wpgmaps_head_gold');
//add_action('admin_footer', 'wpgmaps_reload_map_on_post_gold');

function wpgmaps_gold_activate() { wpgmza_cURL_response_gold("activate"); }
function wpgmaps_gold_deactivate() { wpgmza_cURL_response_gold("deactivate"); }


function wpgmza_register_gold_version() {
    global $wpgmza_gold_version;
    global $wpgmza_gold_string;
    if (!get_option('WPGMZA_GOLD')) {
        add_option('WPGMZA_GOLD',array("version" => $wpgmza_gold_version, "version_string" => $wpgmza_gold_string));
    }
}


function wpgmaps_admin_javascript_gold() {
    global $wpdb;
    global $wpgmza_tblname_maps;
    $ajax_nonce = wp_create_nonce("wpgmza");

    if (isset($_GET['page']) && isset($_GET['action']) && is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_marker") {
        wpgmaps_admin_edit_marker_javascript();
    }
    else if (isset($_GET['page']) && isset($_GET['action']) && is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "add_poly") {
        wpgmaps_b_admin_add_poly_javascript($_GET['map_id']);
    }
    else if (isset($_GET['page']) && isset($_GET['action']) && is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_poly") {
        wpgmaps_b_admin_edit_poly_javascript($_GET['map_id'],$_GET['poly_id']);
    }
    else if (isset($_GET['page']) && isset($_GET['action']) && is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "add_polyline") {
        wpgmaps_b_admin_add_polyline_javascript($_GET['map_id']);
    }
    else if (isset($_GET['page']) && isset($_GET['action']) && is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit_polyline") {
        wpgmaps_b_admin_edit_polyline_javascript($_GET['map_id'],$_GET['poly_id']);
    }


    else if (isset($_GET['page']) && isset($_GET['action']) && is_admin() && $_GET['page'] == 'wp-google-maps-menu' && $_GET['action'] == "edit") {
        wpgmaps_update_xml_file($_GET['map_id']);

        $res = wpgmza_get_map_data($_GET['map_id']);
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");

        $wpgmza_lat = $res->map_start_lat;
        $wpgmza_lng = $res->map_start_lng;
        $wpgmza_width = $res->map_width;
        $wpgmza_height = $res->map_height;
        $wpgmza_width_type = $res->map_width_type;
        $wpgmza_height_type = $res->map_height_type;
        $wpgmza_map_type = $res->type;
        $wpgmza_default_icon = $res->default_marker;
        $kml = $res->kml;
        $fusion = $res->fusion;
        $wpgmza_traffic = $res->traffic;
        $wpgmza_bicycle = $res->bicycle;
        $wpgmza_dbox = $res->dbox;
        $wpgmza_dbox_width = $res->dbox_width;


        $map_other_settings = maybe_unserialize($res->other_settings);
        if (isset($map_other_settings['weather_layer'])) { $weather_layer = $map_other_settings['weather_layer']; } else { $weather_layer = ""; }
        if (isset($map_other_settings['cloud_layer'])) { $cloud_layer = $map_other_settings['cloud_layer']; } else { $cloud_layer = ""; }
        if (isset($map_other_settings['transport_layer'])) { $transport_layer = $map_other_settings['transport_layer']; } else { $transport_layer = ""; }
        
        
        if ($wpgmza_default_icon == "0") { $wpgmza_default_icon = ""; }
        if (!$wpgmza_map_type || $wpgmza_map_type == "" || $wpgmza_map_type == "1") { $wpgmza_map_type = "ROADMAP"; }
        else if ($wpgmza_map_type == "2") { $wpgmza_map_type = "SATELLITE"; }
        else if ($wpgmza_map_type == "3") { $wpgmza_map_type = "HYBRID"; }
        else if ($wpgmza_map_type == "4") { $wpgmza_map_type = "TERRAIN"; }
        else { $wpgmza_map_type = "ROADMAP"; }
        $start_zoom = $res->map_start_zoom;
        if ($start_zoom < 1 || !$start_zoom) { $start_zoom = 5; }
        if (!$wpgmza_lat || !$wpgmza_lng) { $wpgmza_lat = "51.5081290"; $wpgmza_lng = "-0.1280050"; }
    
        $wpgmza_styling_enabled = $res->styling_enabled;
        $wpgmza_styling_json = $res->styling_json;
        
        // marker sorting functionality
        if ($res->order_markers_by == 1) { $order_by = 0; }
        else if ($res->order_markers_by == 2) { $order_by = 2; }
        else if ($res->order_markers_by == 3) { $order_by = 3; }
        else if ($res->order_markers_by == 4) { $order_by = 4; }
        else { $order_by = 0; }
        if ($res->order_markers_choice == 1) { $order_choice = "asc"; }
        else { $order_choice = "desc"; }    
        if (isset($wpgmza_settings['wpgmza_api_version'])) { $api_version = $wpgmza_settings['wpgmza_api_version']; } else { $api_version = ""; }
        if (isset($api_version) && $api_version != "") {
            $api_version_string = "v=$api_version&";
        } else {
            $api_version_string = "v=3.14&";
        }

        if (isset($wpgmza_settings['wpgmza_settings_marker_pull'])) { $marker_pull = $wpgmza_settings['wpgmza_settings_marker_pull']; } else { $marker_pull = "1"; }
        if (isset($marker_pull) && $marker_pull == "0") {
            $markers = json_encode(wpgmaps_return_markers_pro($_GET['map_id']));
        }
        
    ?>




     <?php

    if ($cloud_layer == 1 || $weather_layer == 1) {  ?>

    <script type="text/javascript">
        var gmapsJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
        document.write(unescape("%3Cscript src='" + gmapsJsHost + "maps.google.com/maps/api/js?<?php echo $api_version_string; ?>sensor=false&libraries=weather' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <?php } else { ?>

    <script type="text/javascript">
        var gmapsJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
        document.write(unescape("%3Cscript src='" + gmapsJsHost + "maps.google.com/maps/api/js?<?php echo $api_version_string; ?>sensor=false' type='text/javascript'%3E%3C/script%3E"));
    </script>

    <?php } ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo wpgmaps_get_plugin_url(); ?>/css/data_table.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

    <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/markerclusterer.js"></script>
    <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/jquery.dataTables.js"></script>
    <script type="text/javascript" >

    var marker_pull = '<?php echo $marker_pull; ?>';
    <?php if (isset($markers) && strlen($markers) > 0 && $markers != "[]"){ ?>var db_marker_array = JSON.stringify(<?php echo $markers; ?>);<?php } else { echo "var db_marker_array = '';"; } ?>
    jQuery(function() {


            jQuery(document).ready(function(){

                    
                    jQuery("#wpgmaps_show_advanced").click(function() {
                      jQuery("#wpgmaps_advanced_options").show();
                      jQuery("#wpgmaps_show_advanced").hide();
                      jQuery("#wpgmaps_hide_advanced").show();

                    });
                    jQuery("#wpgmaps_hide_advanced").click(function() {
                      jQuery("#wpgmaps_advanced_options").hide();
                      jQuery("#wpgmaps_show_advanced").show();
                      jQuery("#wpgmaps_hide_advanced").hide();

                    });
                    wpgmzaTable = jQuery('#wpgmza_table').dataTable({
                        "bProcessing": true,
                        "aaSorting": [[ <?php echo "$order_by";?>, "<?php echo $order_choice; ?>" ]]
                    });
                    function wpgmza_reinitialisetbl() {
                        wpgmzaTable.fnClearTable( 0 );
                        wpgmzaTable = jQuery('#wpgmza_table').dataTable({
                            "bProcessing": true,
                            "aaSorting": [[ <?php echo "$order_by";?>, "<?php echo $order_choice; ?>" ]]
                        });
                    }
                    function wpgmza_InitMap() {
                        var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                        MYMAP.init('#wpgmza_map', myLatLng, <?php echo $start_zoom; ?>);
                        UniqueCode=Math.round(Math.random()*10000);
                        MYMAP.placeMarkers('<?php echo wpgmaps_get_marker_url($_GET['map_id']); ?>?u='+UniqueCode,<?php echo $_GET['map_id']; ?>);
                    }

                    jQuery("#wpgmza_map").css({
                        height:'<?php echo $wpgmza_height; ?><?php echo $wpgmza_height_type; ?>',
                        width:'<?php echo $wpgmza_width; ?><?php echo $wpgmza_width_type; ?>'

                    });
                    var geocoder = new google.maps.Geocoder();
                    wpgmza_InitMap();




                    jQuery("body").on("click", ".wpgmza_del_btn", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'delete_marker',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                marker_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                returned_data = JSON.parse(response);
                                db_marker_array = JSON.stringify(returned_data.marker_data);
                                wpgmza_InitMap();
                                jQuery("#wpgmza_marker_holder").html(JSON.parse(response).table_html);
                                wpgmza_reinitialisetbl();
                        });

                    });
                    jQuery("body").on("click", ".wpgmza_polyline_del_btn", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'delete_polyline',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                poly_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                wpgmza_InitMap();
                                jQuery("#wpgmza_polyline_holder").html(response);
                                window.location.reload();

                        });

                    });

                    jQuery("body").on("click", ".wpgmza_edit_btn", function() {
                        var cur_id = jQuery(this).attr("id");

                        var wpgmza_edit_title = jQuery("#wpgmza_hid_marker_title_"+cur_id).val();
                        wpgmza_edit_address = jQuery("#wpgmza_hid_marker_address_"+cur_id).val();
                        wpgmza_edit_lat = jQuery("#wpgmza_hid_marker_lat_"+cur_id).val();
                        wpgmza_edit_lng = jQuery("#wpgmza_hid_marker_lng_"+cur_id).val();
                        
                        
                        var wpgmza_edit_desc = jQuery("#wpgmza_hid_marker_desc_"+cur_id).val();
                        var wpgmza_edit_pic = jQuery("#wpgmza_hid_marker_pic_"+cur_id).val();
                        var wpgmza_edit_link = jQuery("#wpgmza_hid_marker_link_"+cur_id).val();
                        var wpgmza_edit_icon = jQuery("#wpgmza_hid_marker_icon_"+cur_id).val();
                        var wpgmza_edit_anim = jQuery("#wpgmza_hid_marker_anim_"+cur_id).val();
                        var wpgmza_edit_category = jQuery("#wpgmza_hid_marker_category_"+cur_id).val();
                        var wpgmza_edit_retina = jQuery("#wpgmza_hid_marker_retina_"+cur_id).val();
                        var wpgmza_edit_infoopen = jQuery("#wpgmza_hid_marker_infoopen_"+cur_id).val();
                        jQuery("#wpgmza_edit_id").val(cur_id);
                        jQuery("#wpgmza_add_title").val(wpgmza_edit_title);
                        jQuery("#wpgmza_add_address").val(wpgmza_edit_address);
                        jQuery("#wpgmza_add_desc").val(wpgmza_edit_desc);
                        jQuery("#wpgmza_add_pic").val(wpgmza_edit_pic);
                        jQuery("#wpgmza_link_url").val(wpgmza_edit_link);
                        jQuery("#wpgmza_animation").val(wpgmza_edit_anim);
                        
                        jQuery('input[name=wpgmza_add_retina]').removeAttr('checked');
                        if (wpgmza_edit_retina === 0 || wpgmza_edit_retina === "0") { } else {
                            jQuery("#wpgmza_add_retina").prop('checked', true);
                        }

                        var cat_array = wpgmza_edit_category.split(",");
                        jQuery('input[name=wpgmza_cat_checkbox]').removeAttr('checked');
                        cat_array.forEach(function(entry) {
                            if (entry === 0) { } else {
                                jQuery("#wpgmza_cat_checkbox_"+entry).prop('checked', true);
                            }
                        });
                        
                        jQuery("#wpgmza_infoopen").val(wpgmza_edit_infoopen);
                        jQuery("#wpgmza_add_custom_marker").val(wpgmza_edit_icon);
                        if (wpgmza_edit_icon != "")
                          jQuery("#wpgmza_cmm").html("<img src='"+wpgmza_edit_icon+"' />");
                        else
                          jQuery("#wpgmza_cmm").html("&nbsp;"); 
                        jQuery("#wpgmza_addmarker_div").hide();
                        jQuery("#wpgmza_editmarker_div").show();


                    });
                    jQuery("body").on("click", ".wpgmza_approve_btn", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'approve_marker',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                marker_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                returned_data = JSON.parse(response);
                                db_marker_array = JSON.stringify(returned_data.marker_data);
                                wpgmza_InitMap();
                                jQuery("#wpgmza_marker_holder").html(JSON.parse(response).table_html);
                                wpgmza_reinitialisetbl();

                        });

                    });
                    jQuery("body").on("click", ".wpgmza_poly_del_btn", function() {
                        var cur_id = jQuery(this).attr("id");
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        var data = {
                                action: 'delete_poly',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                poly_id: cur_id
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                                wpgmza_InitMap();
                                jQuery("#wpgmza_poly_holder").html(response);
                                window.location.reload();

                        });

                    });


                    jQuery("#wpgmza_addmarker").click(function(){
                        jQuery("#wpgmza_addmarker").hide();
                        jQuery("#wpgmza_addmarker_loading").show();

                        var wpgm_title = "";
                        var wpgm_address = "0";
                        var wpgm_desc = "0";
                        var wpgm_pic = "0";
                        var wpgm_link = "0";
                        var wpgm_icon = "0";
                        var wpgm_gps = "0";

                        var wpgm_anim = "0";
                        var wpgm_category = "0";
                        var wpgm_retina = "0";
                        var wpgm_infoopen = "0";
                        var wpgm_map_id = "0";
                        if (document.getElementsByName("wpgmza_add_title").length > 0) { wpgm_title = jQuery("#wpgmza_add_title").val(); }
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
                        if (document.getElementsByName("wpgmza_add_desc").length > 0) { wpgm_desc = jQuery("#wpgmza_add_desc").val(); }
                        if (document.getElementsByName("wpgmza_add_pic").length > 0) { wpgm_pic = jQuery("#wpgmza_add_pic").val(); }
                        if (document.getElementsByName("wpgmza_link_url").length > 0) { wpgm_link = jQuery("#wpgmza_link_url").val(); }
                        if (document.getElementsByName("wpgmza_add_custom_marker").length > 0) { wpgm_icon = jQuery("#wpgmza_add_custom_marker").val(); }
                        if (document.getElementsByName("wpgmza_animation").length > 0) { wpgm_anim = jQuery("#wpgmza_animation").val(); }
                        
                        var Checked = jQuery('input[name="wpgmza_add_retina"]:checked').length > 0;
                        if (Checked) { wpgm_retina = "1"; } else { wpgm_retina = "0"; }

                        if (document.getElementsByName("wpgmza_category").length > 0) { wpgm_category = jQuery("#wpgmza_category").val(); }
                        
                    
                        var checkValues = jQuery('input[name=wpgmza_cat_checkbox]:checked').map(function() {
                            return jQuery(this).val();
                        }).get();
                        if (checkValues.length > 0) { wpgm_category = checkValues; }
                        wpgm_category.toString();
                        
                        
                        if (document.getElementsByName("wpgmza_infoopen").length > 0) { wpgm_infoopen = jQuery("#wpgmza_infoopen").val(); }
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }
                        /* first check if user has added a GPS co-ordinate */
                        checker = wpgm_address.split(",");
                        var wpgm_lat = "";
                        var wpgm_lng = "";
                        wpgm_lat = checker[0];
                        wpgm_lng = checker[1];
                        checker1 = parseFloat(checker[0]);
                        checker2 = parseFloat(checker[1]);
                        if ((wpgm_lat.match(/[a-zA-Z]/g) === null && wpgm_lng.match(/[a-zA-Z]/g) === null) && checker.length === 2 && (checker1 != NaN && (checker1 <= 90 || checker1 >= -90)) && (checker2 != NaN && (checker2 <= 90 || checker2 >= -90))) {
                            var data = {
                                action: 'add_marker',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                title: wpgm_title,
                                address: wpgm_address,
                                desc: wpgm_desc,
                                link: wpgm_link,
                                icon: wpgm_icon,
                                retina: wpgm_retina,
                                pic: wpgm_pic,
                                anim: wpgm_anim,
                                category: wpgm_category,
                                infoopen: wpgm_infoopen,
                                lat: wpgm_lat,
                                lng: wpgm_lng
                            };


                            jQuery.post(ajaxurl, data, function(response) {
                                    returned_data = JSON.parse(response);
                                    db_marker_array = JSON.stringify(returned_data.marker_data);
                                    wpgmza_InitMap();
                                    jQuery("#wpgmza_marker_holder").html(JSON.parse(response).table_html);
                                    jQuery("#wpgmza_addmarker").show();
                                    jQuery("#wpgmza_addmarker_loading").hide();

                                    jQuery("#wpgmza_add_title").val("");
                                    jQuery("#wpgmza_add_address").val("");
                                    jQuery("#wpgmza_add_desc").val("");
                                    jQuery("#wpgmza_add_pic").val("");
                                    jQuery("#wpgmza_link_url").val("");
                                    jQuery("#wpgmza_animation").val("0");
                                    jQuery("#wpgmza_add_retina").attr('checked',false);
                                    jQuery("#wpgmza_edit_id").val("");
                                    jQuery('input[name=wpgmza_cat_checkbox]').attr('checked',false);
                                    wpgmza_reinitialisetbl();
                            });
                            
                            
                        } else { 
                            geocoder.geocode( { 'address': wpgm_address}, function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    wpgm_gps = String(results[0].geometry.location);
                                    var latlng1 = wpgm_gps.replace("(","");
                                    var latlng2 = latlng1.replace(")","");
                                    var latlngStr = latlng2.split(",",2);
                                    var wpgm_lat = parseFloat(latlngStr[0]);
                                    var wpgm_lng = parseFloat(latlngStr[1]);

                                    var data = {
                                        action: 'add_marker',
                                        security: '<?php echo $ajax_nonce; ?>',
                                        map_id: wpgm_map_id,
                                        title: wpgm_title,
                                        address: wpgm_address,
                                        desc: wpgm_desc,
                                        link: wpgm_link,
                                        icon: wpgm_icon,
                                        retina: wpgm_retina,
                                        pic: wpgm_pic,
                                        anim: wpgm_anim,
                                        category: wpgm_category,
                                        infoopen: wpgm_infoopen,
                                        lat: wpgm_lat,
                                        lng: wpgm_lng
                                    };


                                    jQuery.post(ajaxurl, data, function(response) {
                                            returned_data = JSON.parse(response);
                                            db_marker_array = JSON.stringify(returned_data.marker_data);
                                            wpgmza_InitMap();
                                            jQuery("#wpgmza_marker_holder").html(JSON.parse(response).table_html);
                                            jQuery("#wpgmza_addmarker").show();
                                            jQuery("#wpgmza_addmarker_loading").hide();

                                            jQuery("#wpgmza_add_title").val("");
                                            jQuery("#wpgmza_add_address").val("");
                                            jQuery("#wpgmza_add_desc").val("");
                                            jQuery("#wpgmza_add_pic").val("");
                                            jQuery("#wpgmza_link_url").val("");
                                            jQuery("#wpgmza_animation").val("0");
                                            jQuery("#wpgmza_add_retina").attr('checked',false);
                                            jQuery("#wpgmza_edit_id").val("");
                                            jQuery('input[name=wpgmza_cat_checkbox]').attr('checked',false);
                                            wpgmza_reinitialisetbl();
                                    });

                                } else {
                                    alert("<?php _e("Geocode was not successful for the following reason","wp-google-maps"); ?>: " + status);
                                }
                            });
                        }


                    });
                    jQuery("#wpgmza_editmarker").click(function(){

                        jQuery("#wpgmza_editmarker_div").hide();
                        jQuery("#wpgmza_editmarker_loading").show();


                        var wpgm_edit_id;
                        wpgm_edit_id = parseInt(jQuery("#wpgmza_edit_id").val());
                        var wpgm_title = "";
                        var wpgm_address = "0";
                        var wpgm_desc = "0";
                        var wpgm_pic = "0";
                        var wpgm_link = "0";
                        var wpgm_anim = "0";
                        var wpgm_category = "0";
                        var wpgm_infoopen = "0";
                        var wpgm_icon = "";
                        var wpgm_retina = "0";
                        var wpgm_map_id = "0";
                        var wpgm_gps = "0";
                        if (document.getElementsByName("wpgmza_add_title").length > 0) { wpgm_title = jQuery("#wpgmza_add_title").val(); }
                        if (document.getElementsByName("wpgmza_add_address").length > 0) { wpgm_address = jQuery("#wpgmza_add_address").val(); }
                        if (document.getElementsByName("wpgmza_add_desc").length > 0) { wpgm_desc = jQuery("#wpgmza_add_desc").val(); }
                        if (document.getElementsByName("wpgmza_add_pic").length > 0) { wpgm_pic = jQuery("#wpgmza_add_pic").val(); }
                        if (document.getElementsByName("wpgmza_link_url").length > 0) { wpgm_link = jQuery("#wpgmza_link_url").val(); }
                        if (document.getElementsByName("wpgmza_animation").length > 0) { wpgm_anim = jQuery("#wpgmza_animation").val(); }
                        if (document.getElementsByName("wpgmza_category").length > 0) { wpgm_category = jQuery("#wpgmza_category").val(); }
                        var Checked = jQuery('input[name="wpgmza_add_retina"]:checked').length > 0;
                        if (Checked) { wpgm_retina = "1"; } else { wpgm_retina = "0"; }
                        
                        
                        var checkValues = jQuery('input[name=wpgmza_cat_checkbox]:checked').map(function() {
                            return jQuery(this).val();
                        }).get();
                        if (checkValues.length > 0) { wpgm_category = checkValues; }
                        wpgm_category.toString();
                        if (document.getElementsByName("wpgmza_infoopen").length > 0) { wpgm_infoopen = jQuery("#wpgmza_infoopen").val(); }
                        if (document.getElementsByName("wpgmza_add_custom_marker").length > 0) { wpgm_icon = jQuery("#wpgmza_add_custom_marker").val(); }
                        if (document.getElementsByName("wpgmza_id").length > 0) { wpgm_map_id = jQuery("#wpgmza_id").val(); }


                        var do_geocode;
                        if (wpgm_address === wpgmza_edit_address) {
                            do_geocode = false;
                            var wpgm_lat = wpgmza_edit_lat;
                            var wpgm_lng = wpgmza_edit_lng;
                        } else { 
                            do_geocode = true;
                        }

                        if (do_geocode === true) {


                        geocoder.geocode( { 'address': wpgm_address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                wpgm_gps = String(results[0].geometry.location);
                                var latlng1 = wpgm_gps.replace("(","");
                                var latlng2 = latlng1.replace(")","");
                                var latlngStr = latlng2.split(",",2);
                                var wpgm_lat = parseFloat(latlngStr[0]);
                                var wpgm_lng = parseFloat(latlngStr[1]);

                                var data = {
                                        action: 'edit_marker',
                                        security: '<?php echo $ajax_nonce; ?>',
                                        map_id: wpgm_map_id,
                                        edit_id: wpgm_edit_id,
                                        title: wpgm_title,
                                        address: wpgm_address,
                                        lat: wpgm_lat,
                                        lng: wpgm_lng,
                                        icon: wpgm_icon,
                                        retina: wpgm_retina,
                                        desc: wpgm_desc,
                                        link: wpgm_link,
                                        pic: wpgm_pic,
                                        anim: wpgm_anim,
                                        category: wpgm_category,
                                        infoopen: wpgm_infoopen
                                };

                                jQuery.post(ajaxurl, data, function(response) {
                                    returned_data = JSON.parse(response);
                                    db_marker_array = JSON.stringify(returned_data.marker_data);
                                    wpgmza_InitMap();
                                    jQuery("#wpgmza_marker_holder").html(JSON.parse(response).table_html);
                                    jQuery("#wpgmza_addmarker_div").show();
                                    jQuery("#wpgmza_editmarker_loading").hide();
                                    jQuery("#wpgmza_add_title").val("");
                                    jQuery("#wpgmza_add_address").val("");
                                    jQuery("#wpgmza_add_desc").val("");
                                    jQuery("#wpgmza_add_pic").val("");
                                    jQuery("#wpgmza_link_url").val("");
                                    jQuery("#wpgmza_edit_id").val("");
                                    jQuery("#wpgmza_add_retina").attr('checked',false);
                                    jQuery("#wpgmza_animation").val("None");
                                    jQuery("#wpgmza_cmm").html("");
                                    jQuery('input[name=wpgmza_cat_checkbox]').attr('checked',false);
                                    wpgmza_reinitialisetbl();
                                });

                            } else {
                                alert("<?php _e("Geocode was not successful for the following reason","wp-google-maps"); ?>: " + status);
                            }
                        });
                        } else {
                            /* address was the same, no need for geocoding */
                            var data = {
                                action: 'edit_marker',
                                security: '<?php echo $ajax_nonce; ?>',
                                map_id: wpgm_map_id,
                                edit_id: wpgm_edit_id,
                                title: wpgm_title,
                                address: wpgm_address,
                                lat: wpgm_lat,
                                lng: wpgm_lng,
                                icon: wpgm_icon,
                                retina: wpgm_retina,
                                desc: wpgm_desc,
                                link: wpgm_link,
                                pic: wpgm_pic,
                                anim: wpgm_anim,
                                category: wpgm_category,
                                infoopen: wpgm_infoopen
                            };

                            jQuery.post(ajaxurl, data, function(response) {
                                returned_data = JSON.parse(response);
                                db_marker_array = JSON.stringify(returned_data.marker_data);
                                wpgmza_InitMap();
                                jQuery("#wpgmza_marker_holder").html(JSON.parse(response).table_html);
                                jQuery("#wpgmza_addmarker_div").show();
                                jQuery("#wpgmza_editmarker_loading").hide();
                                jQuery("#wpgmza_add_title").val("");
                                jQuery("#wpgmza_add_address").val("");
                                jQuery("#wpgmza_add_desc").val("");
                                jQuery("#wpgmza_add_pic").val("");
                                jQuery("#wpgmza_link_url").val("");
                                jQuery("#wpgmza_add_retina").attr('checked',false);
                                jQuery("#wpgmza_edit_id").val("");
                                jQuery("#wpgmza_animation").val("None");
                                jQuery("#wpgmza_category").val("Select");
                                jQuery("#wpgmza_cmm").html("");
                                jQuery('input[name=wpgmza_cat_checkbox]').attr('checked',false);
                                wpgmza_reinitialisetbl();
                            });
                        }





                    });
            });

            });



            <?php if ($wpgmza_styling_enabled == "1" && $wpgmza_styling_json != "" && $wpgmza_styling_enabled != null) { ?>

            var wpgmza_adv_styling_json = <?php echo html_entity_decode(stripslashes($wpgmza_styling_json)); ?>;

            <?php } ?>



            var MYMAP = {
                map: null,
                bounds: null,
                mc: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
              var myOptions = {
                zoom:zoom,
                center: latLng,
                zoomControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_zoom']) && $wpgmza_settings['wpgmza_settings_map_zoom'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                panControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_pan']) && $wpgmza_settings['wpgmza_settings_map_pan'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_type']) && $wpgmza_settings['wpgmza_settings_map_type'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                streetViewControl: <?php if (isset($wpgmza_settings['wpgmza_settings_map_streetview']) && $wpgmza_settings['wpgmza_settings_map_streetview'] == "yes") { echo "false"; } else { echo "true"; } ?>,
                mapTypeId: google.maps.MapTypeId.<?php echo $wpgmza_map_type; ?>
              }
            <?php if ($wpgmza_styling_enabled == "1" && $wpgmza_styling_json != "" && $wpgmza_styling_enabled != null) { ?>
            var WPGMZA_STYLING = new google.maps.StyledMapType(wpgmza_adv_styling_json,{name: "WPGMZA STYLING"});
            <?php } ?>

            this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
            
            <?php if ($wpgmza_styling_enabled == "1" && $wpgmza_styling_json != "" && $wpgmza_styling_enabled != null) { ?>
            this.map.mapTypes.set('WPGMZA STYLING', WPGMZA_STYLING);
            this.map.setMapTypeId('WPGMZA STYLING');
            <?php } ?>

            
            <?php
                $total_poly_array = wpgmza_b_return_polygon_id_array($_GET['map_id']);
                if ($total_poly_array > 0) {
                foreach ($total_poly_array as $poly_id) {
                    $polyoptions = wpgmza_b_return_poly_options($poly_id);
                    $linecolor = $polyoptions->linecolor;
                    $fillcolor = $polyoptions->fillcolor;
                    $fillopacity = $polyoptions->opacity;
                    $lineopacity = $polyoptions->lineopacity;
                    if (!$linecolor) { $linecolor = "000000"; }
                    if (!$fillcolor) { $fillcolor = "66FF00"; }
                    if ($fillopacity == "") { $fillopacity = "0.5"; }
                    if ($lineopacity == "") { $lineopacity = "1"; }
                    $linecolor = "#".$linecolor;
                    $fillcolor = "#".$fillcolor;
            ?> 
            var WPGM_PathData_<?php echo $poly_id; ?> = [
                <?php
                $poly_array = wpgmza_b_return_polygon_array($poly_id);
                
                foreach ($poly_array as $single_poly) {
                    $poly_data_raw = str_replace(" ","",$single_poly);
                    $poly_data_raw = explode(",",$poly_data_raw);
                    $lat = $poly_data_raw[0];
                    $lng = $poly_data_raw[1];
                    ?>
                    new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),            
                    <?php
                }
                ?>
                
               
            ];
            var WPGM_Path_<?php echo $poly_id; ?> = new google.maps.Polygon({
              path: WPGM_PathData_<?php echo $poly_id; ?>,
              strokeColor: "<?php echo $linecolor; ?>",
              strokeOpacity: "<?php echo $lineopacity; ?>",
              fillOpacity: "<?php echo $fillopacity; ?>",
              fillColor: "<?php echo $fillcolor; ?>",
              strokeWeight: 2
            });

            WPGM_Path_<?php echo $poly_id; ?>.setMap(this.map);
            <?php } } ?>
                
                
                
<?php
                // polylines
                    $total_polyline_array = wpgmza_b_return_polyline_id_array($_GET['map_id']);
                    if ($total_polyline_array > 0) {
                    foreach ($total_polyline_array as $poly_id) {
                        $polyoptions = wpgmza_b_return_polyline_options($poly_id);
                        $linecolor = $polyoptions->linecolor;
                        $fillopacity = $polyoptions->opacity;
                        $linethickness = $polyoptions->linethickness;
                        if (!$linecolor) { $linecolor = "000000"; }
                        if (!$linethickness) { $linethickness = "4"; }
                        if (!$fillopacity) { $fillopacity = "0.5"; }
                        $linecolor = "#".$linecolor;
                ?> 
                var WPGM_PathLineData_<?php echo $poly_id; ?> = [
                    <?php
                    $poly_array = wpgmza_b_return_polyline_array($poly_id);

                    foreach ($poly_array as $single_poly) {
                        $poly_data_raw = str_replace(" ","",$single_poly);
                        $poly_data_raw = explode(",",$poly_data_raw);
                        $lat = $poly_data_raw[0];
                        $lng = $poly_data_raw[1];
                        ?>
                        new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),            
                        <?php
                    }
                    ?>
                ];
                var WPGM_PathLine_<?php echo $poly_id; ?> = new google.maps.Polyline({
                  path: WPGM_PathLineData_<?php echo $poly_id; ?>,
                  strokeColor: "<?php echo $linecolor; ?>",
                  strokeOpacity: "<?php echo $fillopacity; ?>",
                  strokeWeight: "<?php echo $linethickness; ?>"
                  
                });

                WPGM_PathLine_<?php echo $poly_id; ?>.setMap(this.map);
                <?php } } ?>                  
                
                
            this.bounds = new google.maps.LatLngBounds();
            google.maps.event.addListener(MYMAP.map, 'zoom_changed', function() {
                zoomLevel = MYMAP.map.getZoom();

                jQuery("#wpgmza_start_zoom").val(zoomLevel);

              });
              
              google.maps.event.addListener(MYMAP.map, 'rightclick', function(event) {
                var marker = new google.maps.Marker({
                    position: event.latLng, 
                    map: MYMAP.map
                });
                marker.setDraggable(true);
                google.maps.event.addListener(marker, 'dragend', function(event) { 
                    jQuery("#wpgmza_add_address").val(event.latLng.lat()+','+event.latLng.lng());
                } );
                jQuery("#wpgmza_add_address").val(event.latLng.lat()+', '+event.latLng.lng());
                jQuery("#wpgm_notice_message_save_marker").show();
                setTimeout(function() {
                    jQuery("#wpgm_notice_message_save_marker").fadeOut('slow')
                }, 3000);
               
            });
              
            google.maps.event.addListener(MYMAP.map, 'center_changed', function() {
                var location = MYMAP.map.getCenter();
                jQuery("#wpgmza_start_location").val(location.lat()+","+location.lng());
                jQuery("#wpgmaps_save_reminder").show();
            });

            <?php if ($wpgmza_bicycle == "1") { ?>
            var bikeLayer = new google.maps.BicyclingLayer();
            bikeLayer.setMap(this.map);
            <?php } ?>
            <?php if ($wpgmza_traffic == "1") { ?>
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(this.map);
            <?php } ?>
            <?php if ($weather_layer == 1) { ?>
            var weatherLayer = new google.maps.weather.WeatherLayer();
            weatherLayer.setMap(this.map);
            <?php } ?>
            <?php if ($cloud_layer == 1) { ?>
            var cloudLayer = new google.maps.weather.CloudLayer();
            cloudLayer.setMap(this.map);
            <?php } ?>
            <?php if ($transport_layer == 1) { ?>
            var transitLayer = new google.maps.TransitLayer();
            transitLayer.setMap(this.map);
            <?php } ?>



            <?php if ($kml != "") { ?>
            var georssLayer = new google.maps.KmlLayer('<?php echo $kml; ?>?tstamp=<?php echo time(); ?>');
            georssLayer.setMap(this.map);
            <?php } ?>
            <?php if ($fusion != "") { ?>
                var fusionlayer = new google.maps.FusionTablesLayer('<?php echo $fusion; ?>', {
                      suppressInfoWindows: false
                });
                fusionlayer.setMap(this.map);
            <?php } ?>



            }
            var infoWindow = new google.maps.InfoWindow();
            <?php
                $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                if (isset($wpgmza_settings['wpgmza_settings_infowindow_width'])) { $wpgmza_settings_infowindow_width = $wpgmza_settings['wpgmza_settings_infowindow_width']; } else { $wpgmza_settings_infowindow_width = ""; }
                if (!$wpgmza_settings_infowindow_width || !isset($wpgmza_settings_infowindow_width)) { $wpgmza_settings_infowindow_width = "200"; }
            ?>
            infoWindow.setOptions({maxWidth:<?php echo $wpgmza_settings_infowindow_width; ?>});

            google.maps.event.addDomListener(window, 'resize', function() {
                var myLatLng = new google.maps.LatLng(<?php echo $wpgmza_lat; ?>,<?php echo $wpgmza_lng; ?>);
                MYMAP.map.setCenter(myLatLng);
            });



            MYMAP.placeMarkers = function(filename,map_id) {
                marker_array = [];
                if (marker_pull === '1') {
                        jQuery.get(filename, function(xml) {
                                jQuery(xml).find("marker").each(function(){
                                        var wpgmza_def_icon = '<?php echo $wpgmza_default_icon; ?>';
                                        var wpmgza_map_id = jQuery(this).find('map_id').text();

                                        if (wpmgza_map_id == map_id) {
                                            var wpmgza_title = jQuery(this).find('title').text();
                                            var wpmgza_show_address = jQuery(this).find('address').text();
                                            var wpmgza_address = jQuery(this).find('address').text();
                                            var wpmgza_mapicon = jQuery(this).find('icon').text();
                                            var wpmgza_image = jQuery(this).find('pic').text();
                                            var wpmgza_desc  = jQuery(this).find('desc').text();
                                            var wpmgza_anim  = jQuery(this).find('anim').text();
                                            var wpmgza_retina  = jQuery(this).find('retina').text();
                                            var wpmgza_infoopen  = jQuery(this).find('infoopen').text();
                                            var wpmgza_linkd = jQuery(this).find('linkd').text();
                                            if (wpmgza_title != "") {
                                                wpmgza_title = wpmgza_title+'<br />';
                                            }

                                            /* check image */
                                            if (wpmgza_image != "") {

                                        <?php
                                            $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                            if (isset($wpgmza_settings['wpgmza_settings_infowindow_link_text'])) { $wpgmza_settings_infowindow_link_text = $wpgmza_settings['wpgmza_settings_infowindow_link_text']; } else { $wpgmza_settings_infowindow_link_text = false; }
                                            if (!$wpgmza_settings_infowindow_link_text) { $wpgmza_settings_infowindow_link_text = __("More details","wp-google-maps"); }
                                            
                                            if (isset($wpgmza_settings['wpgmza_settings_image_resizing']) && $wpgmza_settings['wpgmza_settings_image_resizing'] == 'yes') { $wpgmza_image_resizing = true; } else { $wpgmza_image_resizing = false; }
                                            if (isset($wpgmza_settings['wpgmza_settings_use_timthumb'])) { $wpgmza_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb']; } else { $wpgmza_use_timthumb = true; }
                                            if (isset($wpgmza_settings['wpgmza_settings_image_height'])) { $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height']; } else { $wpgmza_image_height = false; }
                                            if (isset($wpgmza_settings['wpgmza_settings_image_width'])) { $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width']; } else { $wpgmza_image_width = false; }
                                            if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
                                            if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }
                                            
                                            /* check if using timthumb */
                                            /* timthumb completely removed in 3.29
                                            if (!isset($wpgmza_use_timthumb) || $wpgmza_use_timthumb == "" || $wpgmza_use_timthumb == 1) { ?>
                                                wpmgza_image = "<img src='<?php echo wpgmaps_get_plugin_url(); ?>/timthumb.php?src="+wpmgza_image+"&h=<?php echo $wpgmza_image_height; ?>&w=<?php echo $wpgmza_image_width; ?>&zc=1' title='' alt='' style=\"float:right; width:"+<?php echo $wpgmza_image_width; ?>+"px; height:"+<?php echo $wpgmza_image_height; ?>+"px;\" />";
                                            <?php } else { 
                                            */
                                                
                                                /* User has chosen not to use timthumb. excellent! */
                                                if ($wpgmza_image_resizing) {
                                                    ?>
                                                    wpgmza_resize_string = "width='<?php echo $wpgmza_image_width; ?>' height='<?php echo $wpgmza_image_height; ?>'";
                                                    <?php
                                                } else {
                                                    ?>
                                                    wpgmza_resize_string = "";
                                                    <?php
                                                }
                                                ?>
                                                
                                                wpmgza_image = "<img src='"+wpmgza_image+"' class='wpgmza_map_image wpgmza_map_image_"+wpmgza_map_id+"' style='float:right;' "+wpgmza_resize_string+" />";




                                            <?php /* } */ ?>

                                            /* end check image */
                                            } else { wpmgza_image = "" }

                                            <?php
                                            if (isset($wpgmza_settings['wpgmza_settings_retina_width'])) { $wpgmza_settings_retina_width = intval($wpgmza_settings['wpgmza_settings_retina_width']); } else { $wpgmza_settings_retina_width = 31; };
                                            if (isset($wpgmza_settings['wpgmza_settings_retina_height'])) { $wpgmza_settings_retina_height = intval($wpgmza_settings['wpgmza_settings_retina_height']); } else { $wpgmza_settings_retina_height = 45; };
                                            ?>

                                            if (wpmgza_linkd != "") {
                                                    <?php
                                                        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                        if (isset($wpgmza_settings['wpgmza_settings_infowindow_links'])) { $wpgmza_settings_infowindow_links = $wpgmza_settings['wpgmza_settings_infowindow_links']; }
                                                        if (isset($wpgmza_settings_infowindow_links) && $wpgmza_settings_infowindow_links == "yes") { $wpgmza_settings_infowindow_links = "target='_BLANK'";  } else { $wpgmza_settings_infowindow_links = ""; }
                                                    ?>

                                                    wpmgza_linkd = "<a href='"+wpmgza_linkd+"' <?php echo $wpgmza_settings_infowindow_links; ?> title='<?php echo $wpgmza_settings_infowindow_link_text; ?>'><?php echo $wpgmza_settings_infowindow_link_text; ?></a>";
                                                }
                                            if (wpmgza_mapicon == "" || !wpmgza_mapicon) { if (wpgmza_def_icon != "") { wpmgza_mapicon = '<?php echo $wpgmza_default_icon; ?>'; } }
                                            var wpgmza_optimized = true;
                                            if (wpmgza_retina === "1" && wpmgza_mapicon !== "") {
                                                wpmgza_mapicon = new google.maps.MarkerImage(wpmgza_mapicon, null, null, null, new google.maps.Size(<?php echo $wpgmza_settings_retina_width; ?>,<?php echo $wpgmza_settings_retina_height; ?>));
                                                wpgmza_optimized = false;
                                            }
                                            var lat = jQuery(this).find('lat').text();
                                            var lng = jQuery(this).find('lng').text();
                                            var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                                            MYMAP.bounds.extend(point);
                                            if (wpmgza_anim == "1") {
                                            var marker = new google.maps.Marker({
                                                    position: point,
                                                    map: MYMAP.map,
                                                    icon: wpmgza_mapicon,
                                                    animation: google.maps.Animation.BOUNCE
                                            });
                                            }
                                            else if (wpmgza_anim == "2") {
                                                var marker = new google.maps.Marker({
                                                        position: point,
                                                        map: MYMAP.map,
                                                        icon: wpmgza_mapicon,
                                                        animation: google.maps.Animation.DROP
                                                });
                                            }
                                            else {
                                                var marker = new google.maps.Marker({
                                                        position: point,
                                                        map: MYMAP.map,
                                                        icon: wpmgza_mapicon
                                                });
                                            }
                                            //var html=''+wpmgza_image+'<strong>'+wpmgza_address+'</strong><br /><span style="font-size:12px;">'+wpmgza_desc+'<br />'+wpmgza_linkd+'</span>';
                                            <?php
                                                    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                                    if (isset($wpgmza_settings['wpgmza_settings_infowindow_address'])) { 
                                                        $wpgmza_settings_infowindow_address = $wpgmza_settings['wpgmza_settings_infowindow_address'];
                                                    } else { $wpgmza_settings_infowindow_address = ""; }
                                                    if ($wpgmza_settings_infowindow_address == "yes") {

                                            ?>
                                                        wpmgza_show_address = "";
                                            <?php } ?>


                                            var html='<div id="wpgmza_markerbox" style="min-width:'+<?php echo $wpgmza_settings_infowindow_width; ?>+'px;">'+wpmgza_image+'<p><strong>'+wpmgza_title+'</strong>'+wpmgza_show_address+'<br />'
                                                    +wpmgza_desc+
                                                    '<br />'
                                                    +wpmgza_linkd+
                                                    ''
                                                    +'</p></div>';
                                            if (wpmgza_infoopen == "1") {

                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP.map, marker);
                                            }

                                            <?php if ($wpgmza_open_infowindow_by == '2') { ?>
                                            google.maps.event.addListener(marker, 'mouseover', function() {
                                                infoWindow.close();
                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP.map, marker);

                                            });
                                            <?php } else { ?>
                                            google.maps.event.addListener(marker, 'click', function() {
                                                infoWindow.close();
                                                infoWindow.setContent(html);
                                                infoWindow.open(MYMAP.map, marker);

                                            });
                                            <?php } ?>


                                        }

                            });
                    });
                
                } else {
                    
                    if (db_marker_array.length > 0) {
                    var dec_marker_array = jQuery.parseJSON(db_marker_array);
                    jQuery.each(dec_marker_array, function(i, val) {


                        var wpgmza_def_icon = '<?php echo $wpgmza_default_icon; ?>';
                        var wpmgza_map_id = val.map_id;

                        if (wpmgza_map_id == map_id) {
                            var wpmgza_title = val.title;
                            var wpmgza_show_address = val.address;
                            var wpmgza_address = val.address;
                            var wpmgza_mapicon = val.icon;
                            var wpmgza_image = val.pic;
                            var wpmgza_desc  = val.desc;
                            var wpmgza_anim  = val.anim;
                            var wpmgza_retina  = val.retina;
                            var wpmgza_infoopen  = val.infoopen;
                            var wpmgza_linkd = val.linkd;
                            if (wpmgza_title != "") {
                                wpmgza_title = wpmgza_title+'<br />';
                            }
                           /* check image */
                            if (wpmgza_image != "") {

                        <?php
                            $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                            if (isset($wpgmza_settings['wpgmza_settings_infowindow_link_text'])) { $wpgmza_settings_infowindow_link_text = $wpgmza_settings['wpgmza_settings_infowindow_link_text']; } else { $wpgmza_settings_infowindow_link_text = false; }
                            if (!$wpgmza_settings_infowindow_link_text) { $wpgmza_settings_infowindow_link_text = __("More details","wp-google-maps"); }
                            
                            if (isset($wpgmza_settings['wpgmza_settings_image_resizing']) && $wpgmza_settings['wpgmza_settings_image_resizing'] == 'yes') { $wpgmza_image_resizing = true; } else { $wpgmza_image_resizing = false; }
                                if (isset($wpgmza_settings['wpgmza_settings_use_timthumb'])) { $wpgmza_use_timthumb = $wpgmza_settings['wpgmza_settings_use_timthumb']; } else { $wpgmza_use_timthumb = true; }
                            if (isset($wpgmza_settings['wpgmza_settings_image_height'])) { $wpgmza_image_height = $wpgmza_settings['wpgmza_settings_image_height']; } else { $wpgmza_image_height = false; }
                            if (isset($wpgmza_settings['wpgmza_settings_image_width'])) { $wpgmza_image_width = $wpgmza_settings['wpgmza_settings_image_width']; } else { $wpgmza_image_width = false; }
                            if (!$wpgmza_image_height || !isset($wpgmza_image_height)) { $wpgmza_image_height = "100"; }
                            if (!$wpgmza_image_width || !isset($wpgmza_image_width)) { $wpgmza_image_width = "100"; }
                            
                            /* check if using timthumb */
                            /* timthumb completely removed in 3.29
                            if (!isset($wpgmza_use_timthumb) || $wpgmza_use_timthumb == "" || $wpgmza_use_timthumb == 1) { ?>
                                wpmgza_image = "<img src='<?php echo wpgmaps_get_plugin_url(); ?>/timthumb.php?src="+wpmgza_image+"&h=<?php echo $wpgmza_image_height; ?>&w=<?php echo $wpgmza_image_width; ?>&zc=1' title='' alt='' style=\"float:right; width:"+<?php echo $wpgmza_image_width; ?>+"px; height:"+<?php echo $wpgmza_image_height; ?>+"px;\" />";
                            <?php } else { 
                            */
                                
                                /* User has chosen not to use timthumb. excellent! */
                                if ($wpgmza_image_resizing) {
                                    ?>
                                    wpgmza_resize_string = "width='<?php echo $wpgmza_image_width; ?>' height='<?php echo $wpgmza_image_height; ?>'";
                                    <?php
                                } else {
                                    ?>
                                    wpgmza_resize_string = "";
                                    <?php
                                }
                                ?>
                                
                                wpmgza_image = "<img src='"+wpmgza_image+"' class='wpgmza_map_image wpgmza_map_image_"+wpmgza_map_id+"' style='float:right;' "+wpgmza_resize_string+" />";




                            <?php /* } */ ?>

                            /* end check image */
                            } else { wpmgza_image = "" }

                            <?php
                            if (isset($wpgmza_settings['wpgmza_settings_retina_width'])) { $wpgmza_settings_retina_width = intval($wpgmza_settings['wpgmza_settings_retina_width']); } else { $wpgmza_settings_retina_width = 31; };
                            if (isset($wpgmza_settings['wpgmza_settings_retina_height'])) { $wpgmza_settings_retina_height = intval($wpgmza_settings['wpgmza_settings_retina_height']); } else { $wpgmza_settings_retina_height = 45; };
                            ?>
                            if (wpmgza_linkd != "") {
                                    <?php
                                        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                        if (isset($wpgmza_settings['wpgmza_settings_infowindow_links'])) { $wpgmza_settings_infowindow_links = $wpgmza_settings['wpgmza_settings_infowindow_links']; }
                                        if (isset($wpgmza_settings_infowindow_links) && $wpgmza_settings_infowindow_links == "yes") { $wpgmza_settings_infowindow_links = "target='_BLANK'";  } else { $wpgmza_settings_infowindow_links = ""; }
                                    ?>

                                    wpmgza_linkd = "<a href='"+wpmgza_linkd+"' <?php echo $wpgmza_settings_infowindow_links; ?> title='<?php echo $wpgmza_settings_infowindow_link_text; ?>'><?php echo $wpgmza_settings_infowindow_link_text; ?></a>";
                                }
                            if (wpmgza_mapicon == "" || !wpmgza_mapicon) { if (wpgmza_def_icon != "") { wpmgza_mapicon = '<?php echo $wpgmza_default_icon; ?>'; } }
                            var wpgmza_optimized = true;
                            if (wpmgza_retina === "1" && wpmgza_mapicon !== "") {
                                wpmgza_mapicon = new google.maps.MarkerImage(wpmgza_mapicon, null, null, null, new google.maps.Size(<?php echo $wpgmza_settings_retina_width; ?>,<?php echo $wpgmza_settings_retina_height; ?>));
                                wpgmza_optimized = false;
                            }
                            var lat = val.lat;
                            var lng = val.lng;
                            var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
                            MYMAP.bounds.extend(point);
                            if (wpmgza_anim == "1") {
                            var marker = new google.maps.Marker({
                                    position: point,
                                    map: MYMAP.map,
                                    icon: wpmgza_mapicon,
                                    animation: google.maps.Animation.BOUNCE
                            });
                            }
                            else if (wpmgza_anim == "2") {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP.map,
                                        icon: wpmgza_mapicon,
                                        animation: google.maps.Animation.DROP
                                });
                            }
                            else {
                                var marker = new google.maps.Marker({
                                        position: point,
                                        map: MYMAP.map,
                                        icon: wpmgza_mapicon
                                });
                            }
                            //var html=''+wpmgza_image+'<strong>'+wpmgza_address+'</strong><br /><span style="font-size:12px;">'+wpmgza_desc+'<br />'+wpmgza_linkd+'</span>';
                            <?php
                                    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
                                    if (isset($wpgmza_settings['wpgmza_settings_infowindow_address'])) { 
                                        $wpgmza_settings_infowindow_address = $wpgmza_settings['wpgmza_settings_infowindow_address'];
                                    } else { $wpgmza_settings_infowindow_address = ""; }
                                    if ($wpgmza_settings_infowindow_address == "yes") {

                            ?>
                                        wpmgza_show_address = "";
                            <?php } ?>

                            var html='<div id="wpgmza_markerbox" style="min-width:'+<?php echo $wpgmza_settings_infowindow_width; ?>+'px;">'+wpmgza_image+'<p><strong>'+wpmgza_title+'</strong>'+wpmgza_show_address+'<br />'
                                    +wpmgza_desc+
                                    '<br />'
                                    +wpmgza_linkd+
                                    ''
                                    +'</p></div>';
                            if (wpmgza_infoopen == "1") {

                                infoWindow.setContent(html);
                                infoWindow.open(MYMAP.map, marker);
                            }

                            <?php if ($wpgmza_open_infowindow_by == '2') { ?>
                            google.maps.event.addListener(marker, 'mouseover', function() {
                                infoWindow.close(); 
                               infoWindow.setContent(html);
                                infoWindow.open(MYMAP.map, marker);

                            });
                            <?php } else { ?>
                            google.maps.event.addListener(marker, 'click', function() {
                                infoWindow.close();
                                infoWindow.setContent(html);
                                infoWindow.open(MYMAP.map, marker);
                            });
                            <?php } ?>
                        }
                  });
                    var mcOptions = {
                        gridSize: 50,
                        maxZoom: 15
                    };
                   
                  }
                }
            }


            

        </script>
        <script type="text/javascript" src="<?php echo wpgmaps_get_plugin_url(); ?>/js/wpgmaps.js"></script>
<?php
}

}


function wpgmza_gold_addon_display() {

    $res = wpgmza_get_map_data($_GET['map_id']);

    
    if ($res->styling_enabled) { $wpgmza_adv_styling[$res->styling_enabled] = "SELECTED"; } else { $wpgmza_adv_styling[2] = "SELECTED"; }
    if ($res->mass_marker_support) { $wpgmza_adv_mass_marker_support[$res->mass_marker_support] = "SELECTED"; } else { $wpgmza_adv_mass_marker_support[2] = "SELECTED"; }
    
    for ($i=0;$i<3;$i++) {
        if (!isset($wpgmza_adv_mass_marker_support[$i])) { $wpgmza_adv_mass_marker_support[$i] = ""; }
    }
    for ($i=0;$i<3;$i++) {
        if (!isset($wpgmza_adv_styling[$i])) { $wpgmza_adv_styling[$i] = ""; }
    }
    
    
    $ret = "
        <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:35px; margin-bottom:5px;\">
            <h2 style=\"padding-top:0; margin-top:0;\">".__("Advanced Map Settings","wp-google-maps")."</h2>
            <p>".__("Use the <a href='http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html' target='_BLANK'>Google Maps API Styled Map Wizard</a> to get your style settings","wp-google-maps")."!</p>
                <form action='' method='post' id='wpgmaps_gold_option_styling'>
                    <table>
                    <input type=\"hidden\" name=\"wpgmza_map_id\" id=\"wpgmza_map_id\" value=\"".$_GET['map_id']."\" />
                        <tr style='margin-bottom:20px;'>
                            <td>".__("Enable Mass Marker Support","wp-google-maps")."?:</td>
                            <td>
                                <select id='wpgmza_adv_enable_mass_marker_support' name='wpgmza_adv_enable_mass_marker_support'>
                                    <option value=\"1\" ".$wpgmza_adv_mass_marker_support[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_adv_mass_marker_support[2].">".__("No","wp-google-maps")."</option>
                                </select>
                            </td>
                         </tr>
                        <tr style='margin-bottom:20px;'>
                            <td>".__("Enable Advanced Styling","wp-google-maps")."?:</td>
                            <td>
                                <select id='wpgmza_adv_styling' name='wpgmza_adv_styling'>
                                    <option value=\"1\" ".$wpgmza_adv_styling[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_adv_styling[2].">".__("No","wp-google-maps")."</option>
                                </select>
                            </td>
                         </tr>
                         <tr>
                            <td valign='top'>".__("Paste the JSON data here","wp-google-maps").":</td>
                            <td><textarea name=\"wpgmza_adv_styling_json\" id=\"wpgmza_adv_styling_json\" rows=\"8\" cols=\"40\">".stripslashes($res->styling_json)."</textarea></td>
                         </tr>
                     </table>
                    <p class='submit'><input type='submit' name='wpgmza_save_style_settings' value='".__("Save Style Settings","wp-google-maps")." &raquo;' /></p>
                </form>
        </div>
    ";
    return $ret;


}


$wpgmaps_gold_api_url = 'http://ccplugins.co/apid-wpgmaps/';
$wpgmaps_gold_plugin_slug = basename(dirname(__FILE__));

// Take over the update check
add_filter('pre_set_site_transient_update_plugins', 'wpgmaps_gold_check_for_plugin_update');

function wpgmaps_gold_check_for_plugin_update($checked_data) {
	global $wpgmaps_gold_api_url, $wpgmaps_gold_plugin_slug, $wp_version;
	
	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
		return $checked_data;
	
        
        
	$args = array(
		'slug' => $wpgmaps_gold_plugin_slug,
		'version' => $checked_data->checked[$wpgmaps_gold_plugin_slug .'/'. $wpgmaps_gold_plugin_slug .'.php'],
	);
	$request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	// Start checking for an update
	$raw_response = wp_remote_post($wpgmaps_gold_api_url, $request_string);
        
        
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);
	
	if (is_object($response) && !empty($response)) // Feed the update data into WP updater
		$checked_data->response[$wpgmaps_gold_plugin_slug .'/'. $wpgmaps_gold_plugin_slug .'.php'] = $response;
	
	return $checked_data;
}



add_filter('plugins_api', 'wpgmaps_gold_plugin_api_call', 10, 3);

function wpgmaps_gold_plugin_api_call($def, $action, $args) {
	global $wpgmaps_gold_plugin_slug, $wpgmaps_gold_api_url, $wp_version;
	
	if (!isset($args->slug) || ($args->slug != $wpgmaps_gold_plugin_slug))
		return false;
	
	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$wpgmaps_gold_plugin_slug .'/'. $wpgmaps_gold_plugin_slug .'.php'];
	$args->version = $current_version;
	
	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$request = wp_remote_post($wpgmaps_gold_api_url, $request_string);
	
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}
	
	return $res;
}





function wpgmaps_head_gold() {
   if (isset($_POST['wpgmza_save_style_settings'])){

        global $wpdb;
        global $wpgmza_tblname_maps;

        $map_id = $_POST['wpgmza_map_id'];
        $styling_enabled = esc_attr($_POST['wpgmza_adv_styling']);
        $styling_json = esc_attr($_POST['wpgmza_adv_styling_json']);
        $enable_mass_marker_support = esc_attr($_POST['wpgmza_adv_enable_mass_marker_support']);


        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_maps SET
                styling_enabled = %d,
                styling_json = %s,
                mass_marker_support = %d
                WHERE id = %d",

                $styling_enabled,
                $styling_json,
                $enable_mass_marker_support,
                $map_id)
        );



//    update_option('WPGMZA_GOLD', $data);
//    $wpgmza_data_gold = get_option('WPGMZA_GOLD');
    echo "
    <div class='updated'>
        Your Map Style settings have been saved.
    </div>
    ";
   }




}

function wpgmza_cURL_response_gold($action) {
    if (function_exists('curl_version')) {
        global $wpgmza_gold_version;
        global $wpgmza_gold_string;
        $request_url = "http://www.wpgmaps.com/api/rec.php?action=$action&dom=".$_SERVER['HTTP_HOST']."&ver=".$wpgmza_gold_version.$wpgmza_gold_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}
/*
add_action('init', 'wpgmaps_gold_activate_au');
function wpgmaps_gold_activate_au() {
	require_once ('wp_autoupdate.php');
        global $wpgmza_gold_version;
	$wpgmaps_plugin_remote_path = 'http://wpgmaps.com/api/update-gold.php';
	$wptuts_plugin_slug = plugin_basename(__FILE__);
	new wp_auto_update_gold ($wpgmza_gold_version, $wpgmaps_plugin_remote_path, $wptuts_plugin_slug);
}
*/

?>