<?php
/*
Marker Category functionality for WP Google Maps Pro


*/


function wpgmaps_menu_category_layout() {


    if (!isset($_GET['action'])) {

        if (function_exists('wpgmza_register_pro_version')) {
            echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("Marker Categories","wp-google-maps")." <a href=\"admin.php?page=wp-google-maps-menu-categories&action=new\" class=\"add-new-h2\">".__("Add New Category","wp-google-maps")."</a></h2>";
            wpgmaps_list_categories();
        } else {
            echo"<div class=\"wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>".__("Marker Categories","wp-google-maps")."</h2>";
            echo"<p><i><a href='http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=category' title='".__("Pro Version","wp-google-maps")."'>".__("Create marker categories","wp-google-maps")."</a> ".__("with the","wp-google-maps")." <a href='http://www.wpgmaps.com/purchase-professional-version/?utm_source=plugin&utm_medium=link&utm_campaign=category' title='Pro Version'>".__("Pro Version","wp-google-maps")."</a> ".__("of WP Google Maps for only","wp-google-maps")." <strong>$14.99!</strong></i></p>";


        }
        echo "</div>";
        echo"<br /><div style='float:right;'><a href='http://www.wpgmaps.com/documentation/troubleshooting/' title='WP Google Maps Troubleshooting Section'>".__("Problems with the plugin? See the troubleshooting manual.","wp-google-maps")."</a></div>";
    } else {

        if ($_GET['action'] == "trash" && isset($_GET['cat_id'])) {
            if ($_GET['s'] == "1") {
                if (wpgmaps_trash_cat($_GET['cat_id'])) {
                    echo "<script>window.location = \"".get_option('siteurl')."/wp-admin/admin.php?page=wp-google-maps-menu-categories\"</script>";
                } else {
                    _e("There was a problem deleting the category.");;
                }
            } else {
                echo "<h2>".__("Delete your Category","wp-google-maps")."</h2><p>".__("Are you sure you want to delete the category","wp-google-maps")."? <br /><a href='?page=wp-google-maps-menu-categories&action=trash&cat_id=".$_GET['cat_id']."&s=1'>".__("Yes","wp-google-maps")."</a> | <a href='?page=wp-google-maps-menu-categories'>".__("No","wp-google-maps")."</a></p>";
            }


        }
        
        if ($_GET['action'] == "new") {
            wpgmza_pro_category_new_layout();
        }
        if ($_GET['action'] == "edit") {
            wpgmza_pro_category_edit_layout($_GET['cat_id']);
        }

    }

}

if (isset($_GET['page']) && $_GET['page'] == 'wp-google-maps-menu-categories') {
    add_action('admin_print_scripts', 'wpgmaps_admin_category_scripts');
    add_action('admin_print_styles', 'wpgmaps_admin_category_styles');
}
function wpgmaps_admin_category_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('jquery-ui-core');

    if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
        wp_register_script('my-wpgmaps-upload', plugins_url('js/category_media.js', __FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('my-wpgmaps-upload');
    } else {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_register_script('my-wpgmaps-upload', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/admin_category.js', array('jquery','media-upload','thickbox'));
        wp_enqueue_script('my-wpgmaps-upload');
    }

}
function wpgmaps_admin_category_styles() {
    
}

function wpgmza_pro_category_new_layout() {
    
    $display_marker = "<img src=\"".wpgmaps_get_plugin_url()."/images/marker.png\" />";
    
    $map_ids = wpgmza_return_all_map_ids();
    
    echo "<div class='wrap'>";
    echo "  <h1>WP Google Maps</h1>";
    echo "  <div class='wide'>";
    echo "      <h2>".__("Add a Marker Category","wp-google-maps")."</h2>";
    echo "      <form action='admin.php?page=wp-google-maps-menu-categories' method='post' id='wpgmaps_add_marker_category' name='wpgmaps_add_marker_category_form'>";
    echo "      <table>";
    echo "          <tr>";
    echo "              <td><strong>".__("Category Name","wp-google-maps")."</strong>:</td>";
    echo "              <td><input type='text' name='wpgmaps_marker_category_name' id='wpgmaps_marker_category_name' value='' /></td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr style='height:20px;'>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr valign='top'>";
    echo "              <td valign='middle'><strong>".__("Category Marker","wp-google-maps")."</strong>:</td>";
    echo "              <td align='left'><span id=\"wpgmza_mm\">$display_marker</span> </td>";
    echo "              <td valign='middle'>Enter URL <input id=\"upload_default_category_marker\" name=\"upload_default_category_marker\" type='text' size='35' class='regular-text' maxlength='700' value='' /> or <input id=\"upload_default_category_marker_btn\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" /> <a href=\"javascript:void(0);\" onClick=\"document.forms['wpgmaps_add_marker_category_form'].upload_default_category_marker.value = ''; var span = document.getElementById('wpgmza_mm'); while( span.firstChild ) { span.removeChild( span.firstChild ); } span.appendChild( document.createTextNode('')); return false;\" title=\"Reset to default\">-reset-</a> <small><i>".__("Get great map markers <a href='http://mapicons.nicolasmollet.com/' target='_BLANK' title='Great Google Map Markers'>here</a>","wp-google-maps")."</i></small></td>";
    echo "          </tr>";
    echo "          <tr>";
    echo "              <td><strong>".__("Retina Ready","wp-google-maps")."</strong>:</td>";
    echo "              <td><input type='checkbox' name='wpgmaps_marker_category_retina' value='1'>".__("This marker is a retina-ready marker","wp-google-maps")."</td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr style='height:20px;'>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr>";
    echo "              <td valign='top'><strong>".__("Assigned to ","wp-google-maps")."</strong>:</td>";
    echo "              <td>";
    echo "                  <input type='checkbox' name='assigned_to_map[]' value='ALL'> All Maps <br /><br />";
    
    foreach ($map_ids as $map_id) {
        $map_data = wpgmza_get_map_data($map_id);
        echo "                  <input type='checkbox' name='assigned_to_map[]' value='".$map_id."'> ".$map_data->map_title."  (id ".$map_id.")<br />";
    }
    echo "              </td>";
    echo "          </tr>";
    
    echo "      </table>";
    
    echo "          <p class='submit'><input type='submit' name='wpgmza_save_marker_category' class='button-primary' value='".__("Save Category","wp-google-maps")." &raquo;' /></p>";
    echo "      </form>";
    echo "  </div>";
    echo "</div>";

}
function wpgmza_pro_category_edit_layout($cat_id) {

    global $wpdb;
    global $wpgmza_tblname_categories;
    
    $map_ids = wpgmza_return_all_map_ids();
    
    
    $results = $wpdb->get_results("
	  SELECT *
	  FROM $wpgmza_tblname_categories
	  WHERE `id` = '$cat_id' LIMIT 1
    ");

    
    if (isset($results[0]->category_icon) && $results[0]->category_icon != '') {
        $display_marker = "<img src='".$results[0]->category_icon."' />";
        $display_url = $results[0]->category_icon;
    } else {
        $display_marker = "<img src=\"".wpgmaps_get_plugin_url()."/images/marker.png\" />";
        $display_url = "";

    }
    
    if (isset($results[0]->retina) && intval($results[0]->retina) == 1) {
        $retina_checked = "checked='checked'";
    } else {
        $retina_checked = "";
    }

    echo "<div class='wrap'>";
    echo "  <h1>WP Google Maps</h1>";
    echo "  <div class='wide'>";
    echo "      <h2>".__("Add a Marker Category","wp-google-maps")."</h2>";
    echo "      <form action='admin.php?page=wp-google-maps-menu-categories' method='post' id='wpgmaps_add_marker_category' name='wpgmaps_edit_marker_category_form'>";

    echo "      <table>";
    echo "          <tr>";
    echo "              <td><strong>".__("Category Name","wp-google-maps")."</strong>:</td>";
    echo "              <td><input type='hidden' name='wpgmaps_marker_category_id' id='wpgmaps_marker_category_id' value='".$results[0]->id."' /><input type='text' name='wpgmaps_marker_category_name' id='wpgmaps_marker_category_name' value='".$results[0]->category_name."' /></td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr style='height:20px;'>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr valign='top'>";
    echo "              <td valign='middle'><strong>".__("Category Marker","wp-google-maps")."</strong>:</td>";
    echo "              <td align='left'><span id=\"wpgmza_mm\">$display_marker</span> </td>";
    echo "              <td valign='middle'>Enter URL <input id=\"upload_default_category_marker\" name=\"upload_default_category_marker\" type='text' size='35' class='regular-text' maxlength='700' value='$display_url' /> or <input id=\"upload_default_category_marker_btn\" type=\"button\" value=\"".__("Upload Image","wp-google-maps")."\" /> <a href=\"javascript:void(0);\" onClick=\"document.forms['wpgmaps_edit_marker_category_form'].upload_default_category_marker.value = ''; var span = document.getElementById('wpgmza_mm'); while( span.firstChild ) { span.removeChild( span.firstChild ); } span.appendChild( document.createTextNode('')); return false;\" title=\"Reset to default\">-reset-</a> <small><i>".__("Get great map markers <a href='http://mapicons.nicolasmollet.com/' target='_BLANK' title='Great Google Map Markers'>here</a>","wp-google-maps")."</i></small></td>";
    echo "          </tr>";
    echo "          <tr>";
    echo "              <td><strong>".__("Retina Ready","wp-google-maps")."</strong>:</td>";
    echo "              <td><input type='checkbox' name='wpgmaps_marker_category_retina' value='1' $retina_checked>".__("This marker is a retina-ready marker","wp-google-maps")."</td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr style='height:20px;'>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "              <td></td>";
    echo "          </tr>";
    echo "          <tr>";
    echo "              <td valign='top'><strong>".__("Assigned to ","wp-google-maps")."</strong>:</td>";
    echo "              <td>";
    echo "                  <input type='checkbox' name='assigned_to_map[]' value='ALL' ".wpgmza_check_cat_map('ALL',$cat_id)."> All Maps <br /><br />";
    
    foreach ($map_ids as $map_id) {
        $map_data = wpgmza_get_map_data($map_id);
        echo "                  <input type='checkbox' name='assigned_to_map[]' value='".$map_id."' ".wpgmza_check_cat_map($map_id,$cat_id)."> ".$map_data->map_title."  (id ".$map_id.")<br />";
    }
    echo "              </td>";
    echo "          </tr>";
    
    echo "      </table>";    
    
    
    echo "          <p class='submit'><input type='submit' name='wpgmza_edit_marker_category' class='button-primary' value='".__("Save Category","wp-google-maps")." &raquo;' /></p>";
    echo "      </form>";
    echo "  </div>";
    echo "</div>";

}


function wpgmza_check_cat_map($map_id,$cat_id) {
    global $wpdb;
    global $wpgmza_tblname_category_maps;
    if ($map_id == "ALL") {
        $sql = "SELECT COUNT(*) FROM `".$wpgmza_tblname_category_maps."` WHERE `cat_id` = '$cat_id' AND `map_id` = '0' LIMIT 1";
    } else {
        $sql = "SELECT COUNT(*) FROM `".$wpgmza_tblname_category_maps."` WHERE `cat_id` = '$cat_id' AND `map_id` = '$map_id' LIMIT 1";
    }
    $results = $wpdb->get_var($sql);
    if ($results>0) { return "checked"; } else { return ""; }
}

add_action('admin_head', 'wpgmaps_category_head');
function wpgmaps_category_head() {

    if (isset($_GET['page']) && $_GET['page'] == "wp-google-maps-menu-categories" && isset($_POST['wpgmza_save_marker_category'])) {
        if (isset($_POST['wpgmza_save_marker_category'])){
            global $wpdb;
            global $wpgmza_tblname_categories;
            global $wpgmza_tblname_category_maps;
            
            
            
            $wpgmaps_category_name = esc_attr($_POST['wpgmaps_marker_category_name']);
            $wpgmaps_category_marker = esc_attr($_POST['upload_default_category_marker']);



            
            $rows_affected = $wpdb->query( $wpdb->prepare(
                    "INSERT INTO $wpgmza_tblname_categories SET
                        category_name = %s,
                        active = %d,
                        category_icon = %s


                    ",
                    $wpgmaps_category_name,
                    0,
                    $wpgmaps_category_marker
                )
            );
            
            $cat_id = $wpdb->insert_id;
            
            
            if ($_POST['assigned_to_map'][0] == "ALL") {
                    $rows_affected = $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $wpgmza_tblname_category_maps SET
                            cat_id = %d,
                            map_id = %d
                        ",
                        $cat_id,
                        0
                    )
                    );
            } else {
                foreach ($_POST['assigned_to_map'] as $assigned_map) {

                    $rows_affected = $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $wpgmza_tblname_category_maps SET
                            cat_id = %d,
                            map_id = %d
                        ",
                        $cat_id,
                        $assigned_map
                    )
                    );
                }            
            }
            echo "<div class='updated'>";
            _e("Your category has been created.","wp-google-maps");
            echo "</div>";


        }

    }
    if (isset($_GET['page']) && $_GET['page'] == "wp-google-maps-menu-categories" && isset($_POST['wpgmza_edit_marker_category'])) {
            global $wpdb;
            global $wpgmza_tblname_categories;
            global $wpgmza_tblname_category_maps;
            $wpgmaps_cid = esc_attr($_POST['wpgmaps_marker_category_id']);
            $wpgmaps_category_name = esc_attr($_POST['wpgmaps_marker_category_name']);
            if (isset($_POST['wpgmaps_marker_category_retina'])) { $wpgmaps_category_retina = esc_attr($_POST['wpgmaps_marker_category_retina']); } else { $wpgmaps_category_retina = 0; }
            $wpgmaps_category_marker = esc_attr($_POST['upload_default_category_marker']);

            $rows_affected = $wpdb->query( $wpdb->prepare(
                "DELETE FROM $wpgmza_tblname_category_maps WHERE
                cat_id = %d"
                ,
                $wpgmaps_cid) 
            ); // remove all instances of this category in the category_maps table

            
            $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_categories SET

                category_name = %s,
                active = %d,
                category_icon = %s,
                retina = %d
                WHERE
                id = %d",
                $wpgmaps_category_name,
                0,
                $wpgmaps_category_marker,
                intval($wpgmaps_category_retina),
                $wpgmaps_cid) 
            );
            
            
            if ($_POST['assigned_to_map'][0] == "ALL") {
                    $rows_affected = $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $wpgmza_tblname_category_maps SET
                            cat_id = %d,
                            map_id = %d
                        ",
                        $wpgmaps_cid,
                        0
                    )
                    );
            } else {
                
                
                foreach ($_POST['assigned_to_map'] as $assigned_map) {

                    $rows_affected = $wpdb->query( $wpdb->prepare(
                        "INSERT INTO $wpgmza_tblname_category_maps SET
                            cat_id = %d,
                            map_id = %d
                        ",
                        $wpgmaps_cid,
                        $assigned_map
                    )
                    );
                }            
            }            

            echo "<div class='updated'>";
            _e("Your category has been saved.","wp-google-maps");
            echo "</div>";
    }
}

function wpgmza_pro_return_category_select_list($map_id) {
    global $wpdb;
    global $wpgmza_tblname_categories;
    global $wpgmza_tblname_category_maps;
    $ret_msg = "";
    $ret_msg .= "<option value=\"0\">".__("All","wp-google-maps")."</option>";
   /* 
    $sql = "SELECT * FROM `$wpgmza_tblname_category_maps` WHERE `map_id` = '$map_id' OR `map_id` = '0'";
    $results = $wpdb->get_results($sql);
*/
    $sql  = "SELECT `$wpgmza_tblname_category_maps`.`cat_id`, `$wpgmza_tblname_category_maps`.`map_id`, `$wpgmza_tblname_categories`.`category_name`";
    $sql .= " FROM `$wpgmza_tblname_category_maps`, `$wpgmza_tblname_categories` ";
    $sql .= " WHERE (`$wpgmza_tblname_category_maps`.`map_id` = '$map_id' OR `$wpgmza_tblname_category_maps`.`map_id` = '0')";
    $sql .= " AND `$wpgmza_tblname_categories`.`id` = `$wpgmza_tblname_category_maps`.`cat_id`";
    $sql .= " AND `$wpgmza_tblname_categories`.`active` = 0";
    $sql .= " ORDER BY `$wpgmza_tblname_categories`.`category_name` ASC";
    
    $results = $wpdb->get_results($sql);
    
    foreach ( $results as $result ) {
        $ret_msg .= "<option value=\"".$result->cat_id."\">".$result->category_name."</option>";
    }

    /*
    foreach ( $results as $result ) {

        $cat_id = $result->cat_id;
        $resultser = $wpdb->get_results("
            SELECT *
            FROM `$wpgmza_tblname_categories`
            WHERE `active` = 0
            AND `id` = '$cat_id'
            ORDER BY `id` DESC
            ");
        
        foreach ( $resultser as $resulter ) {
            $ret_msg .= "<option value=\"".$resulter->id."\">".$resulter->category_name."</option>";
        }
        
        
    }
    */

    return $ret_msg;

}
function wpgmza_pro_return_category_checkbox_list($map_id,$show_all = true,$array = false) {
    global $wpdb;
    global $wpgmza_tblname_categories;
    global $wpgmza_tblname_category_maps;
    if ($array) { $array_suffix = "[]"; } else { $array_suffix = ""; }
    $sql = "SELECT * FROM `$wpgmza_tblname_category_maps` WHERE `map_id` = '$map_id' OR `map_id` = '0'";
        $ret_msg = "<div style='display:block; overflow:hidden;'>";
        $ret_msg .= "<div style='display:block; float:left;'>";
        if ($show_all) { $ret_msg .= "<input type='checkbox' class='wpgmza_checkbox' id='wpgmza_cat_checkbox_0' name='wpgmza_cat_checkbox$array_suffix' mid=\"".$map_id."\" value=\"0\" />".__("All","wp-google-maps"); }
        $ret_msg .= "</div>";
    
    $results = $wpdb->get_results($sql);
    if (!$results) { return __("<em><small>No categories found</small></em>","wp-google-maps"); }
    foreach ( $results as $result ) {

        $cat_id = $result->cat_id;
    
        $results = $wpdb->get_results("
            SELECT *
            FROM `$wpgmza_tblname_categories`
            WHERE `active` = 0
            AND `id` = '$cat_id'
            ORDER BY `id` DESC
            ");
        foreach ( $results as $result ) {
            $ret_msg .= "<div style='display:block; float:left; margin-left:5px;'><input type='checkbox' class='wpgmza_checkbox' id='wpgmza_cat_checkbox_".$result->id."' name='wpgmza_cat_checkbox$array_suffix' mid=\"".$map_id."\" value=\"".$result->id."\" />".$result->category_name."</div>";
        }
    
    }    
        $ret_msg .= "</div>";
    
    return $ret_msg;

}
function wpgmza_pro_return_maps_linked_to_cat($cat_id) {
    global $wpdb;
    global $wpgmza_tblname_category_maps;
    $ret_msg = "";
    
    $sql = "SELECT * FROM `$wpgmza_tblname_category_maps` WHERE `cat_id` = '$cat_id'";
    $results = $wpdb->get_results($sql);
    $cnt = count($results);
    $cnt_i = 1;
    foreach ( $results as $result ) {
        
        $map_id = $result->map_id;
        if ($map_id == 0) {
            $ret_msg .= "<a href=\"?page=wp-google-maps-menu\">".__("All maps","wp-google-maps")."</option>";
            return $ret_msg;
        } else { 
            $map_data = wpgmza_get_map_data($map_id);
            if ($cnt_i == $cnt) { $wpgmza_com = ""; } else { $wpgmza_com = ","; }
            $ret_msg .= "<a href=\"?page=wp-google-maps-menu&action=edit&map_id=".$map_id."\">".$map_data->map_title."</a>$wpgmza_com ";
        }
        $cnt_i++;
        
    }
    

    return $ret_msg;

}
function wpgmaps_list_categories() {
    global $wpdb;
    global $wpgmza_tblname_categories;

    $results = $wpdb->get_results("
	SELECT *
	FROM `$wpgmza_tblname_categories`
        WHERE `active` = 0
        ORDER BY `id` DESC
	");

    echo "<table class=\"wp-list-table widefat fixed \" cellspacing=\"0\">";
    echo "  <thead>";
	echo "      <tr>";
    echo "          <th scope='col' width='100px' id='id' class='manage-column column-id sortable desc' style=''><span>".__("ID","wp-google-maps")."</span></th>";
    echo "          <th scope='col' id='cat_cat' class='manage-column column-map_title sortable desc'  style=''><span>".__("Category","wp-google-maps")."</span></th>";
    echo "          <th scope='col' id='cat_icon' class='manage-column column-map_width' style=\"\">".__("Icon","wp-google-maps")."</th>";
    echo "          <th scope='col' id='cat_linked' class='manage-column column-map_width' style=\"\">".__("Linked maps","wp-google-maps")."</th>";
    echo "      </tr>";
    echo "  </thead>";
    echo "<tbody id=\"the-list\" class='list:wp_list_text_link'>";

    foreach ( $results as $result ) {
        $trashlink = "| <a href=\"?page=wp-google-maps-menu-categories&action=trash&cat_id=".$result->id."\" title=\"Trash\">".__("Trash","wp-google-maps")."</a>";

        echo "<tr id=\"record_".$result->id."\">";
        echo "  <td class='id column-id'>".$result->id."</td>";
        echo "  <td class='map_title column-map_title'><strong><big><a href=\"?page=wp-google-maps-menu-categories&action=edit&cat_id=".$result->id."\" title=\"".__("Edit","wp-google-maps")."\">".$result->category_name."</a></big></strong><br /><a href=\"?page=wp-google-maps-menu-categories&action=edit&cat_id=".$result->id."\" title=\"".__("Edit","wp-google-maps")."\">".__("Edit","wp-google-maps")."</a> $trashlink</td>";
        echo "  <td class='map_width column-map_width'><img src=\"".$result->category_icon."\" style=\"max-width:100px; max-height:100px;\" /></td>";
        echo "  <td class='map_width column-map_width'>".wpgmza_pro_return_maps_linked_to_cat($result->id)."</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function wpgmaps_trash_cat($cat_id) {
    global $wpdb;
    global $wpgmza_tblname_categories;
    global $wpgmza_tblname_category_maps;
    if (isset($cat_id)) {
        $rows_affected = $wpdb->query( $wpdb->prepare( "UPDATE $wpgmza_tblname_categories SET active = %d WHERE id = %d", 1, $cat_id) );
        $rows_affected = $wpdb->query( $wpdb->prepare( "DELETE $wpgmza_tblname_category_maps WHERE cat_id = %d", $cat_id) );
        return true;
    } else {
        return false;
    }
}
