<?php
/**
 * @package Optimize Database after Deleting Revisions
 * @version 3.3.1
 */
/*
Plugin Name: Optimize Database after Deleting Revisions
Plugin URI: http://cagewebdev.com/index.php/optimize-database-after-deleting-revisions-wordpress-plugin/
Description: Optimizes the Wordpress Database after Cleaning it out
Author: CAGE Web Design | Rolf van Gelder, Eindhoven, The Netherlands
Author URI: http://cagewebdev.com
Version: 3.3.1
*/

$odb_version      = '3.3.1';
$odb_release_date = '04/08/2015';
// v3.3 - MULTISITE
$odb_ms_prefixes  = array();
$odb_ms_blogids   = array();


/********************************************************************************************

	ADD THE LANGUAGE SUPPORT (LOCALIZATION)
	
	Since: v2.9

*********************************************************************************************/
function rvg_odb_action_init()
{
	// TEXT DOMAIN v3.1.1: language files moved to the '/language' directory
	load_plugin_textdomain('rvg-optimize-database', false, dirname(plugin_basename(__FILE__)).'/language');
}
// INIT HOOK
add_action('init', 'rvg_odb_action_init');


/********************************************************************************************

	ADD THE 'OPTIMIZE DATABASE' ITEM TO THE TOOLS MENU

*********************************************************************************************/
function optimize_db_main()
{	if (function_exists('add_management_page'))
	{	add_management_page(
			__('Optimize Database','rvg-optimize-database'),
			__('Optimize Database','rvg-optimize-database'),
			'administrator',
			'rvg-optimize-db.php',
			'rvg_optimize_db');
    }
}
if(rvg_odb_get_option('rvg_odb_adminmenu') != "Y") add_action('admin_menu', 'optimize_db_main');


/********************************************************************************************

	'ICON MODE': ADD A LINK TO THE ADMIN MENU
	
	Since: v3.1.1

*********************************************************************************************/
function rvg_add_menu_page()
{
	if (function_exists('add_menu_page'))
	{
		add_menu_page(
			__('Optimize Database','rvg-optimize-database'),
			__('Optimize Database','rvg-optimize-database'),
			'administrator',
			'rvg-optimize-db.php',
			'rvg_optimize_db',
			plugins_url('rvg-optimize-database/images/icon.png')
		);
	}
} // rvg_add_menu_page()
if(rvg_odb_get_option('rvg_odb_adminmenu') == "Y") add_action('admin_menu', 'rvg_add_menu_page');


/********************************************************************************************

	ADD THE 'OPTIMIZE DB SETTINGS' ITEM TO THE SETTINGS MENU (v3.1.3)

*********************************************************************************************/
function rvg_odb_admin_menu()
{	
	if (function_exists('add_options_page'))
	{	add_options_page(
			__('Optimize Database', 'rvg-optimize-database'),
			__('Optimize Database', 'rvg-optimize-database'),
			'manage_options',
			'rvg_odb_admin',
			'rvg_odb_settings_page');
    }
} // rvg_odb_admin_menu()
if(rvg_odb_get_option('rvg_odb_adminmenu') != "Y") add_action('admin_menu', 'rvg_odb_admin_menu');


/********************************************************************************************

	'ICON MODE': REGISTER OPTION PAGE BUT HIDE IT FROM THE ADMIN MENU (v3.1.3)

*********************************************************************************************/
function register_odb_options()
{
	if (function_exists('add_submenu_page'))
	{	add_submenu_page(
			null,	// HIDE FROM MENU!
			__('Optimize Database', 'rvg-optimize-database'),
			__('Optimize Database', 'rvg-optimize-database'),
			'manage_options',
			'rvg_odb_admin',
			'rvg_odb_settings_page'
		);
	}
} // register_odb_options()
if(rvg_odb_get_option('rvg_odb_adminmenu') == "Y") add_action('admin_menu', 'register_odb_options');

 
/********************************************************************************************

	SHOW A LINK TO THE PLUGIN SETTINGS ON THE MAIN PLUGINS PAGE

	Since: v3.1

*********************************************************************************************/
function odb_settings_link($links)
{ 
  array_unshift($links, '<a href="options-general.php?page=rvg_odb_admin">Settings</a>'); 
  return $links;
} // odb_settings_link()
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'odb_settings_link');


/********************************************************************************************

	ADD THE '1 CLICK OPTIMIZE DATABASE' ITEM TO THE ADMIN BAR (IF ACTIVATED)

*********************************************************************************************/
function rvg_odb_admin_bar()
{	global $wp_admin_bar;
	if (!is_super_admin() || !is_admin_bar_showing()) return;
	
	$siteurl = site_url('/');
	$wp_admin_bar->add_menu(
		array(
		   'id'    => 'optimize',
		   'title' => __('Optimize DB (1 click)','rvg-optimize-database'),
		   'href'  => $siteurl.'wp-admin/tools.php?page=rvg-optimize-db.php&action=run' ));
} // rvg_odb_admin_bar()
$rvg_odb_adminbar = rvg_odb_get_option('rvg_odb_adminbar');
if($rvg_odb_adminbar == "Y") add_action('wp_before_admin_bar_render', 'rvg_odb_admin_bar');


/********************************************************************************************

	LOAD STYLE SHEETS (v3.1.1)

*********************************************************************************************/
function odb_styles()
{	wp_enqueue_style ('odb', plugin_dir_url(__FILE__) . 'css/style.css',false,'1.0','all');
} // odb_styles()
add_action( 'admin_init', 'odb_styles' );


/********************************************************************************************

	ACTIONS FOR THE SCHEDULER
	
	http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules

*********************************************************************************************/
function rvg_extra_schedules($schedules)
{	// ADD A WEEKLY SCHEDULE
	$schedules['weekly'] = array(
		'interval' => 604800,
		'display'  => __('Once Weekly')
	);
	return $schedules;
} // rvg_extra_schedules()
add_filter( 'cron_schedules', 'rvg_extra_schedules' ); 

add_action( 'rvg_optimize_database', 'rvg_optimize_db_cron' );

// REMOVE SCHEDULED TASK WHEN DEACTIVATED
register_deactivation_hook( __FILE__, 'rvg_deactivate_plugin' );
function rvg_deactivate_plugin()
{	// CLEAR CURRENT SCHEDULE (IF ANY)
	wp_clear_scheduled_hook('rvg_optimize_database');
	wp_clear_scheduled_hook('rvg_scheduled_run');
} // rvg_deactivate_plugin()

// RE-SCHEDULE TASK WHEN RE-ACTIVATED (OR AFTER UPDATE)
register_activation_hook( __FILE__, 'rvg_activate_plugin' );
function rvg_activate_plugin()
{	$rvg_odb_schedule = rvg_odb_get_option('rvg_odb_schedule');
	if($rvg_odb_schedule)
	{	// PLUGIN RE-ACTIVATED: START SCHEDULER
		if( !wp_next_scheduled( 'rvg_optimize_database' ))
			wp_schedule_event( time(), $rvg_odb_schedule, 'rvg_optimize_database' );
	}
} // rvg_activate_plugin()


/********************************************************************************************

	GET NETWORK INFORMATION (MULTISITE)
	
	Since: v3.3

*********************************************************************************************/
function rvg_odb_network_info()
{
	global $wpdb, $odb_ms_prefixes, $odb_ms_blogids;
	
	// v3.2 - GET MULTISITE INFORMATION
	$odb_ms_prefixes[0] = $wpdb->base_prefix;
	$odb_ms_blogids[0]  = 1;
	if (function_exists('is_multisite') && is_multisite())
	{	$odb_blogids = $wpdb->get_col("SELECT blog_id FROM ".$wpdb->base_prefix."blogs");
		// FOR INSTANCE: mywp_2_, mywp_3_ etc.
		for($i=1; $i<count($odb_blogids); $i++)
		{	$odb_ms_prefixes[$i] = $wpdb->base_prefix.$odb_blogids[$i].'_';
			$odb_ms_blogids[$i]  = $odb_blogids[$i];
		}
	} // if (function_exists('is_multisite') && is_multisite())
} // rvg_odb_network_info()


/********************************************************************************************

	GET AN OPTION FROM THE ROOT SITE OPTION TABLE

*********************************************************************************************/
function rvg_odb_get_option($option)
{
	global $wpdb;

	$sql = "
	SELECT `option_value`
	  FROM ".$wpdb->base_prefix."options
	 WHERE `option_name` = '".$option."'
	";
	$res = $wpdb->get_results($sql);
	
	if(isset($res[0]->option_value)) return $res[0]->option_value;
	return '';
} // rvg_odb_get_option()


/********************************************************************************************

	SAVE AN OPTION TO THE ROOT SITE OPTION TABLE

*********************************************************************************************/
function rvg_odb_update_option($option, $value)
{
	global $wpdb;
	
	$sql = "
	SELECT COUNT(*) cnt
	  FROM ".$wpdb->base_prefix."options
	 WHERE `option_name` = '".$option."'
	";
	$res = $wpdb->get_results($sql);
	
	if(isset($res[0]->cnt) && $res[0]->cnt > 0)
	{	$sql = "
		UPDATE ".$wpdb->base_prefix."options
		   SET `option_value` = '".$value."'
		 WHERE `option_name` = '".$option."'
		";
	}
	else
	{	$sql = "
		INSERT INTO ".$wpdb->base_prefix."options
		     (option_name, option_value)
			 VALUES
			 (	'".$option."',
			 	'".$value."'
			 )
		";
	}
	$wpdb->get_results($sql);
	
	return;
} // rvg_odb_update_option()


/********************************************************************************************

	CREATE THE SETTINGS PAGE

*********************************************************************************************/
function rvg_odb_settings_page()
{
	global $odb_version, $odb_release_date, $wpdb, $table_prefix, $odb_ms_prefixes;
	
	// v3.3 - GET NETWORK INFORMATION (MULTISITE)
	rvg_odb_network_info();

	// v3.3 - GET THE OPTIONS FROM THE TABLES OF THE MAIN SITE (IN CASE OF MULTISITE)
	// if(function_exists('switch_to_blog')) switch_to_blog(1);
	
	$current_datetime = Date('YmdHis');
	$current_date     = substr($current_datetime, 0, 8);
	$current_hour     = substr($current_datetime, 8, 2);	
	
	if(isset($_REQUEST['delete_log']))
		if($_REQUEST['delete_log'] == "Y") @unlink(dirname(__FILE__).'/rvg-optimize-db-log.html');
	
	// SAVE THE SETTINGS
 	if (isset($_POST['info_update']))
	{
		// v2.8.3
		check_admin_referer('odb_action', 'odb_nonce');
		
		# DELETE ALL EXCLUDED TABLES (FROM THE ROOT OPTIONS TABLE)
		$sql = "
		DELETE FROM ".$wpdb->base_prefix."options
		 WHERE `option_name` LIKE 'rvg_ex_%'
		";
		$wpdb->get_results($sql);
		
		# ADD EXCLUDED TABLES
		foreach ($_POST as $key => $value)
		{	if(substr($key,0,3) == 'cb_')
				rvg_odb_update_option('rvg_ex_'.substr($key,3).'', 'excluded');
		}

		if(isset($_POST['rvg_odb_number']))
		{	$rvg_odb_number = trim($_POST['rvg_odb_number']);
			rvg_odb_update_option('rvg_odb_number', $rvg_odb_number);
		}
		
		$rvg_clear_trash = 'N';
		if(isset($_POST['rvg_clear_trash']))
			$rvg_clear_trash = $_POST['rvg_clear_trash'];
		rvg_odb_update_option('rvg_clear_trash', $rvg_clear_trash);
		
		$rvg_clear_spam = 'N';
		if(isset($_POST['rvg_clear_spam']))
			$rvg_clear_spam = $_POST['rvg_clear_spam'];
		rvg_odb_update_option('rvg_clear_spam', $rvg_clear_spam);

		$rvg_clear_tags = 'N';
		if(isset($_POST['rvg_clear_tags']))
			$rvg_clear_tags = $_POST['rvg_clear_tags'];
		rvg_odb_update_option('rvg_clear_tags', $rvg_clear_tags);
		
		$rvg_clear_transients = 'N';
		if(isset($_POST['rvg_clear_transients']))
			$rvg_clear_transients = $_POST['rvg_clear_transients'];
		rvg_odb_update_option('rvg_clear_transients', $rvg_clear_transients);

		// v3.1
		$rvg_clear_pingbacks = 'N';
		if(isset($_POST['rvg_clear_pingbacks']))
			$rvg_clear_pingbacks = $_POST['rvg_clear_pingbacks'];
		rvg_odb_update_option('rvg_clear_pingbacks', $rvg_clear_pingbacks);

		$rvg_odb_adminbar = 'N';
		if(isset($_POST['rvg_odb_adminbar']))
			$rvg_odb_adminbar = $_POST['rvg_odb_adminbar'];
		rvg_odb_update_option('rvg_odb_adminbar', $rvg_odb_adminbar);

		// v3.1.3
		$rvg_odb_adminmenu = 'N';
		if(isset($_POST['rvg_odb_adminmenu']))
			$rvg_odb_adminmenu = $_POST['rvg_odb_adminmenu'];
		rvg_odb_update_option('rvg_odb_adminmenu', $rvg_odb_adminmenu);
		
		$rvg_odb_logging_on = 'N';
		if(isset($_POST['rvg_odb_logging_on']))
			$rvg_odb_logging_on = $_POST['rvg_odb_logging_on'];
		rvg_odb_update_option('rvg_odb_logging_on', $rvg_odb_logging_on);

		$rvg_odb_schedule = '';
		if(isset($_POST['rvg_odb_schedule']))
			$rvg_odb_schedule = $_POST['rvg_odb_schedule'];
		rvg_odb_update_option('rvg_odb_schedule', $rvg_odb_schedule);

		$rvg_odb_schedulehour = '';
		// v3.3.1
		if($rvg_odb_schedule == 'daily' || $rvg_odb_schedule == 'weekly')
		{
			if(isset($_POST['rvg_odb_schedulehour']))
				$rvg_odb_schedulehour = $_POST['rvg_odb_schedulehour'];
			rvg_odb_update_option('rvg_odb_schedulehour', $rvg_odb_schedulehour);
		}
		else
			// WIPE THE HOUR
			rvg_odb_update_option('rvg_odb_schedulehour', '');

		// CLEAR CURRENT SCHEDULE (IF ANY)
		wp_clear_scheduled_hook('rvg_optimize_database');

		// HAS TO BE SCHEDULED
		if($rvg_odb_schedule != '')		
			if( !wp_next_scheduled( 'rvg_optimize_database' ))
			{	
				$time = 0;
				if($rvg_odb_schedulehour == '')
					// 'hourly', 'twicedaily'
					$time = time();
				else
				{
					// 'daily', 'weekly'
					if($rvg_odb_schedulehour <= $current_hour)
					    // NEXT RUN TOMORROW
						$newdatetime = date('YmdHis', strtotime($current_date.$rvg_odb_schedulehour.'0000'.' + 1 day'));
					else
						// NEXT RUN TODAY
						$newdatetime = $current_date.$rvg_odb_schedulehour.'0000';
					// DATE TO UNIX TIMESTAMP (EPOCH)
					$time = strtotime($newdatetime);
				}
				// SCHEDULE THE EVENT
				wp_schedule_event( $time, $rvg_odb_schedule, 'rvg_optimize_database' );
			}
		
		// UPDATED MESSAGE
		echo "<div class='updated odb-bold'><p>".
			__('Optimize Database after Deleting Revisions SETTINGS UPDATED','rvg-optimize-database').
			" - ";
		_e('Click <a href="tools.php?page=rvg-optimize-db.php" class="odb-bold">HERE</a> to run the optimization','rvg-optimize-database');
		echo "</p></div>";
	} // if (isset($_POST['info_update']))
	
	$rvg_odb_number = rvg_odb_get_option('rvg_odb_number');
	if(!$rvg_odb_number) $rvg_odb_number = '0';
	
	$rvg_clear_trash = rvg_odb_get_option('rvg_clear_trash');
	if(!$rvg_clear_trash) $rvg_clear_trash = 'N';
	
	$rvg_clear_spam = rvg_odb_get_option('rvg_clear_spam');
	if(!$rvg_clear_spam) $rvg_clear_spam = 'N';

	$rvg_clear_tags = rvg_odb_get_option('rvg_clear_tags');
	if(!$rvg_clear_tags) $rvg_clear_tags = 'N';

	$rvg_clear_transients = rvg_odb_get_option('rvg_clear_transients');
	if(!$rvg_clear_transients) $rvg_clear_transients = 'N';

	// v3.1
	$rvg_clear_pingbacks = rvg_odb_get_option('rvg_clear_pingbacks');
	if(!$rvg_clear_pingbacks) $rvg_clear_pingbacks = 'N';
	
	$rvg_odb_logging_on = rvg_odb_get_option('rvg_odb_logging_on');
	if(!$rvg_odb_logging_on) $rvg_odb_logging_on = 'N';
	
	$rvg_odb_schedule = rvg_odb_get_option('rvg_odb_schedule');
	if(!$rvg_odb_schedule) $rvg_odb_schedule = '';
	
	$rvg_odb_schedulehour = rvg_odb_get_option('rvg_odb_schedulehour');
	
	$rvg_odb_adminbar = rvg_odb_get_option('rvg_odb_adminbar');
	if(!$rvg_odb_adminbar) $rvg_odb_adminbar = 'N';
	
	$rvg_odb_adminmenu = rvg_odb_get_option('rvg_odb_adminmenu');
	if(!$rvg_odb_adminmenu) $rvg_odb_adminmenu = 'N';
	
	?>
<script type="text/javascript">
function schedule_changed()
{	// v3.1.4
	if(jQuery("#rvg_odb_schedule").val() == 'daily' || jQuery("#rvg_odb_schedule").val() == 'weekly')
		jQuery("#schedulehour").show();
	else
		jQuery("#schedulehour").hide();
}
</script>

<div id="odb-options-form">
  <form name="options" method="post" action="">
    <?php // v2.8.3 ?>
    <?php wp_nonce_field( 'odb_action','odb_nonce' ); ?>
    <div class="wrap">
      <h2>
        <?php _e('Using Optimize Database after Deleting Revisions', 'rvg-optimize-database'); ?>
      </h2>
      <blockquote>
        <p class="odb-bold">'<span class="odb-italic">Optimize Database after Deleting Revisions</span> '
          <?php _e('is an one-click plugin to clean and optimize your WordPress database','rvg-optimize-database');?>
        </p>
        <p>
          <?php _e('Plugin version:','rvg-optimize-database');?>
          <br />
          <span class="odb-bold">v<?php echo $odb_version ?> (<?php echo $odb_release_date?>)</span></p>
        <p><span class="odb-bold">
          <?php _e('Author','rvg-optimize-database');?>
          :</span><br />
          <span class="odb-bold"><a href="http://cagewebdev.com/" target="_blank">CAGE Web Design</a> | <a href="http://rvg.cage.nl/" target="_blank">Rolf van Gelder</a></span>, Eindhoven,
          <?php _e('The Netherlands','rvg-optimize-database');?>
          <br />
          <span class="odb-bold">
          <?php _e('Plugin URL:','rvg-optimize-database');?>
          </span><br />
          <a href="http://cagewebdev.com/index.php/optimize-database-after-deleting-revisions-wordpress-plugin/" target="_blank"><span class="odb-bold">http://cagewebdev.com/index.php/optimize-database-after-deleting-revisions-wordpress-plugin/</span></a><br />
          <span class="odb-bold">
          <?php _e('Download URL:','rvg-optimize-database');?>
          </span><br />
          <span class="odb-bold"><a href="https://wordpress.org/plugins/rvg-optimize-database/" target="_blank">https://wordpress.org/plugins/rvg-optimize-database/</a></span></p>
        <p>&nbsp;</p>
      </blockquote>
      <h2>
        <?php _e('Optimize Database after Deleting Revisions - Settings','rvg-optimize-database');?>
      </h2>
      <?php
if($rvg_odb_adminbar == 'Y')  $rvg_odb_adminbar_checked  = ' checked="checked"'; else $rvg_odb_adminbar_checked = '';	
if($rvg_odb_adminmenu == 'Y')  $rvg_odb_adminmenu_checked  = ' checked="checked"'; else $rvg_odb_adminmenu_checked = '';
if($rvg_clear_trash == 'Y') $rvg_clear_trash_checked = ' checked="checked"'; else $rvg_clear_trash_checked = '';
if($rvg_clear_spam == 'Y')  $rvg_clear_spam_checked  = ' checked="checked"'; else $rvg_clear_spam_checked = '';
if($rvg_clear_tags == 'Y')  $rvg_clear_tags_checked  = ' checked="checked"'; else $rvg_clear_tags_checked = '';
if($rvg_clear_transients == 'Y')  $rvg_clear_transients_checked  = ' checked="checked"'; else $rvg_clear_transients_checked = '';
// v3.1
if($rvg_clear_pingbacks == 'Y')  $rvg_clear_pingbacks_checked  = ' checked="checked"'; else $rvg_clear_pingbacks_checked = '';
if($rvg_odb_logging_on == 'Y')  $rvg_odb_logging_on_checked  = ' checked="checked"'; else $rvg_odb_logging_on_checked = '';
?>
      <blockquote>
        <fieldset class='options'>
          <table class="editform" cellspacing="2" cellpadding="5" width="100%">
            <tr>
              <td colspan="3" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                  <tr>
                    <td width="50%" align="right" valign="top"><span class="odb-bold">
                      <?php _e('Maximum number of - most recent - revisions to keep per post / page','rvg-optimize-database');?>
                      <br />
                      <?php _e('(\'0\' means: delete <u>ALL</u> revisions)','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%" valign="top"><input type="text" size="5" name="rvg_odb_number" id="rvg_odb_number" value="<?php echo $rvg_odb_number?>" class="odb-bold odb-blue" /></td>
                  </tr>
                  <tr>
                    <td width="50%" align="right" valign="top"><span class="odb-bold">
                      <?php _e('Delete all trashed items','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%" valign="top"><input name="rvg_clear_trash" type="checkbox" value="Y" <?php echo $rvg_clear_trash_checked?> /></td>
                  </tr>
                  <tr>
                    <td width="50%" align="right" valign="top"><span class="odb-bold">
                      <?php _e('Delete all spammed items','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%" valign="top"><input name="rvg_clear_spam" type="checkbox" value="Y" <?php echo $rvg_clear_spam_checked?> /></td>
                  </tr>
                  <tr>
                    <td width="50%" align="right" valign="top"><span class="odb-bold">
                      <?php _e('Delete unused tags','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%" valign="top"><input name="rvg_clear_tags" type="checkbox" value="Y" <?php echo $rvg_clear_tags_checked?> /></td>
                  </tr>
                  <tr>
                    <td width="50%" align="right" valign="top"><span class="odb-bold">
                      <?php _e('Delete expired transients','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%" valign="top"><input name="rvg_clear_transients" type="checkbox" value="Y" <?php echo $rvg_clear_transients_checked?> /></td>
                  </tr>
                  <tr>
                    <td width="50%" align="right" valign="top"><span class="odb-bold">
                      <?php _e('Delete pingbacks and trackbacks','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%" valign="top"><input name="rvg_clear_pingbacks" type="checkbox" value="Y" <?php echo $rvg_clear_pingbacks_checked?> /></td>
                  </tr>
                  <tr>
                    <td width="50%" align="right" valign="top"><span class="odb-bold">
                      <?php _e('Keep a log','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%" valign="top"><input name="rvg_odb_logging_on" type="checkbox" value="Y" <?php echo $rvg_odb_logging_on_checked?> /></td>
                  </tr>
                  <tr>
                    <td width="50%" align="right"><span class="odb-bold">
                      <?php _e('Scheduler','rvg-optimize-database');?>
                      </span></td>
                    <td width="50%"><select name="rvg_odb_schedule" id="rvg_odb_schedule" class="odb-schedule-select" onchange="schedule_changed();">
                        <option selected="selected" value="">
                        <?php _e('NOT SCHEDULED','rvg-optimize-database');?>
                        </option>
                        <option value="hourly">
                        <?php _e('run optimization HOURLY','rvg-optimize-database');?>
                        </option>
                        <option value="twicedaily">
                        <?php _e('run optimization TWICE A DAY','rvg-optimize-database');?>
                        </option>
                        <option value="daily">
                        <?php _e('run optimization DAILY','rvg-optimize-database');?>
                        </option>
                        <option value="weekly">
                        <?php _e('run optimization WEEKLY','rvg-optimize-database');?>
                        </option>
                        <?php /*?><option value="test">run optimization TEST</option><?php */?>
                      </select>
                      <script type="text/javascript">
					jQuery("#rvg_odb_schedule").val('<?php echo $rvg_odb_schedule; ?>');
			        </script> 
                      <span id="schedulehour" class="odb-schedulehour"> <span class="odb-bold">
                      <?php _e('Time','rvg-optimize-database');?>
                      </span>
                      <select name="rvg_odb_schedulehour" id="rvg_odb_schedulehour" class="odb-schedulehour-select">
                        <?php
                    for($i=0; $i<=23; $i++)
                    {	if($i<10) $i = '0'.$i;
                    ?>
                        <option value="<?php echo $i?>"><?php echo $i.':00 '.__('hrs','rvg-optimize-database')?></option>
                        <?php	
                    }
                    ?>
                      </select>
                      <script type="text/javascript">
					jQuery("#rvg_odb_schedulehour").val('<?php echo $rvg_odb_schedulehour; ?>');
			        </script> 
                      </span> 
                      <script type="text/javascript">schedule_changed();</script></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top"><span class="odb-bold">
                      <?php _e('Show \'1-click\' link in Admin Bar','rvg-optimize-database');?>
                      </span></td>
                    <td valign="top"><input name="rvg_odb_adminbar" type="checkbox" value="Y" <?php echo $rvg_odb_adminbar_checked?> />
                      <?php _e('(change will be visible after loading the next page)','rvg-optimize-database');?></td>
                  </tr>
                  <tr>
                    <td align="right" valign="top"><span class="odb-bold">
                      <?php _e('Show an icon in the Admin Menu','rvg-optimize-database');?>
                      </span></td>
                    <td valign="top"><input name="rvg_odb_adminmenu" type="checkbox" value="Y" <?php echo $rvg_odb_adminmenu_checked?> />
                      <?php _e('(change will be visible after loading the next page)','rvg-optimize-database');?></td>
                  </tr>
                </table></td>
            </tr>
            <?php
	# v2.8.2
	$tables = $wpdb->get_results("SHOW TABLES FROM `".DB_NAME."`", ARRAY_N);
	# v2.8.3 $ replaced by jQuery
?>
            <tr>
              <td colspan="4" valign="top">
                <table id="odb-table-excludes" class="odb-table-excludes" align="center" border="0">
                  <tr>
                    <td colspan="4" align="center"><span class="odb-bold">
                      <?php _e('EXCLUDE DATABASE TABLES FROM OPTIMIZATION: <span class="odb-underline-red">CHECKED</span> TABLES <span class="odb-underline-red">WON\'T</span> BE OPTIMIZED!</span>','rvg-optimize-database');?>
                      <br />
                      <a href="javascript:;" onclick="jQuery('[id^=cb_]').attr('checked',true);">
                      <?php _e('check all tables','rvg-optimize-database');?>
                      </a> | <a href="javascript:;" onclick="jQuery('[id^=cb_]').attr('checked',false);">
                      <?php _e('uncheck all tables','rvg-optimize-database');?>
                      </a> | <a href="javascript:;" onclick="jQuery(':not([id^=cb_<?php echo $odb_ms_prefixes[0]; ?>])').filter('[id^=cb_]').attr('checked',true);">
                      <?php _e('check all NON-WordPress tables','rvg-optimize-database');?>
                      </a></td>
                  </tr>
                  <tr>
                    <?php
	$c = 0;
	$t = 0;
	# v2.8.2
	for ($i=0; $i<count($tables); $i++)
	{	$t++;
		$c++;
		if($c>4)
		{	$c = 1;
			echo '</tr>';
			echo '<tr>';
		}
		$class = '';
		// WORDPRESS TABLE? v3.3 (MULTISITE)
		for($j=0; $j<count($odb_ms_prefixes); $j++)
			if(substr($tables[$i][0], 0, strlen($odb_ms_prefixes[$j])) == $odb_ms_prefixes[$j]) $class = 'class="odb-wp-table"';
		
		$cb_checked = '';
		$excluded = rvg_odb_get_option('rvg_ex_'.$tables[$i][0].'');
		if($excluded == 'excluded') $cb_checked = ' checked';
		echo '<td width="25%" '.$class.'><input id="cb_'.$tables[$i][0].'" name="cb_'.$tables[$i][0].'" type="checkbox" value="1" '.$cb_checked.'  /> '.$tables[$i][0].'</td>'."\n";
	} # for ($i=0; $i<count($tables); $i++)
?>
                  </tr>
                </table></td>
            </tr>
          </table>
        </fieldset>
      </blockquote>
      <p class="submit">
        <input class="button-primary button-large" type='submit' name='info_update' value='<?php _e('Save Settings','rvg-optimize-database');?>' class="odb-bold" />
        &nbsp;
        <input class="button odb-normal" type="button" name="optimizer" value="<?php _e('Go To Optimizer','rvg-optimize-database');?>" onclick="self.location='tools.php?page=rvg-optimize-db.php'" />
      </p>
    </div>
  </form>
</div>
<!-- ocb-options-form -->
<?php
} // rvg_odb_settings_page()


/********************************************************************************************

	MAIN FUNCTION
	FOR DELETING UNWANTED ITEMS AND OPTIMIZING DATABASE TABLES

*********************************************************************************************/
function rvg_optimize_db()
{
	global $wpdb, $odb_version, $odb_ms_prefixes;

	// v3.3 - GET NETWORK INFORMATION (MULTISITE)
	rvg_odb_network_info();

	// PAGE LOAD COUNTER
	$time  = microtime();
	$time  = explode(' ', $time);
	$time  = $time[1] + $time[0];
	$odb_start_time = $time;

	$current_hour = Date('H:i');

	if(isset($_REQUEST['action']))
		if($_REQUEST['action'] == "delete_log")
			@unlink(dirname(__FILE__).'/rvg-optimize-db-log.html');

	/****************************************************************************************
	
		DELETE UNWANTED ITEMS
	
	******************************************************************************************/
	
	// GET SETTINGS AND SET DEFAULT VALUES
	$max_revisions = rvg_odb_get_option('rvg_odb_number');
	if(!$max_revisions)
	{	$max_revisions = 0;
		rvg_odb_update_option('rvg_odb_number', $max_revisions);
	}
	
	$clear_trash = rvg_odb_get_option('rvg_clear_trash');
	if(!$clear_trash)
	{	$clear_trash = 'N';
		rvg_odb_update_option('rvg_clear_trash', $clear_trash);
	}
	$clear_trash_yn = ($clear_trash == 'N') ? __('NO','rvg-optimize-database') : __('YES','rvg-optimize-database');
	
	$clear_spam = rvg_odb_get_option('rvg_clear_spam');
	if(!$clear_spam)
	{	$clear_spam = 'N';
		rvg_odb_update_option('rvg_clear_spam', $clear_spam);
	}
	$clear_spam_yn = ($clear_spam == 'N') ? __('NO','rvg-optimize-database') : __('YES','rvg-optimize-database');

	$clear_tags = rvg_odb_get_option('rvg_clear_tags');
	if(!$clear_tags)
	{	$clear_tags = 'N';
		rvg_odb_update_option('rvg_clear_tags', $clear_tags);
	}
	$clear_tags_yn = ($clear_tags == 'N') ? __('NO','rvg-optimize-database') : __('YES','rvg-optimize-database');

	$clear_transients = rvg_odb_get_option('rvg_clear_transients');
	if(!$clear_transients)
	{	$clear_transients = 'N';
		rvg_odb_update_option('rvg_clear_transients', $clear_transients);
	}
	$clear_transients_yn = ($clear_transients == 'N') ? __('NO','rvg-optimize-database') : __('YES','rvg-optimize-database');

	// v3.1
	$clear_pingbacks = rvg_odb_get_option('rvg_clear_pingbacks');
	if(!$clear_pingbacks)
	{	$clear_pingbacks = 'N';
		rvg_odb_update_option('rvg_clear_pingbacks', $clear_pingbacks);
	}
	$clear_pingbacks_yn = ($clear_pingbacks == 'N') ? __('NO','rvg-optimize-database') : __('YES','rvg-optimize-database');

	$rvg_odb_logging_on = rvg_odb_get_option('rvg_odb_logging_on');
	if(!$rvg_odb_logging_on)
	{	$rvg_odb_logging_on = 'N';
		rvg_odb_update_option('rvg_odb_logging_on', $rvg_odb_logging_on);
	}
	$rvg_odb_logging_on_yn = ($rvg_odb_logging_on == 'N') ? __('NO','rvg-optimize-database') : __('YES','rvg-optimize-database');
	
	$rvg_odb_schedule = rvg_odb_get_option('rvg_odb_schedule');
	if(!$rvg_odb_schedule)
	{	$rvg_odb_schedule = '';
		rvg_odb_update_option('rvg_odb_schedule', $rvg_odb_schedule);
	}

	if($rvg_odb_schedule == 'hourly')
		$rvg_odb_schedule_txt = __('ONCE HOURLY','rvg-optimize-database');
	else if($rvg_odb_schedule == 'twicedaily')
		$rvg_odb_schedule_txt = __('TWICE DAILY','rvg-optimize-database');
	else if($rvg_odb_schedule == 'daily')
		$rvg_odb_schedule_txt = __('ONCE DAILY','rvg-optimize-database');
	else if($rvg_odb_schedule == 'weekly')
		$rvg_odb_schedule_txt = __('ONCE WEEKLY','rvg-optimize-database');			
	else if($rvg_odb_schedule == 'test')
		$rvg_odb_schedule_txt = 'TEST';

	$nextrun = '';			
	if(!isset($rvg_odb_schedule_txt))
	{	$rvg_odb_schedule_txt = __('NOT SCHEDULED','rvg-optimize-database');
	}
	else
	{	$timestamp = wp_next_scheduled('rvg_optimize_database');
		$nextrun   = Date('M j, Y @ H:i', $timestamp);
	}
	
	$total_savings = rvg_odb_get_option('rvg_odb_total_savings');

	$log_url = plugins_url().'/rvg-optimize-database/rvg-optimize-db-log.html';

	$sql = "
	SELECT COUNT(*) cnt
	  FROM $wpdb->options
	 WHERE option_name LIKE 'rvg_ex_%'
	";
	$results = $wpdb->get_results($sql);
	$number_excluded = $results[0]->cnt;
?>
<div class="odb-padding-left">
  <h2>
    <?php _e('Optimize your WordPress Database','rvg-optimize-database');?>
  </h2>
  <?php
	if(isset($_REQUEST['action']))
		if($_REQUEST['action'] == "delete_log")
			echo '<div class="updated odb-updated"><p><span class="odb-bold">Optimize Database after Deleting Revisions - LOG FILE DELETED</span></p></div>';
?>
  <p><span class="odb-italic"><a href="http://cagewebdev.com/index.php/optimize-database-after-deleting-revisions-wordpress-plugin/" target="_blank" class="odb-bold">Optimize Database after Deleting Revisions v<?php echo $odb_version?></a> -
    <?php _e('A WordPress Plugin by','rvg-optimize-database');?>
    <a href="http://cagewebdev.com/" target="_blank" class="odb-bold">CAGE Web Design</a> | <a href="http://rvg.cage.nl/" target="_blank" class="odb-bold">Rolf van Gelder</a>, Eindhoven,
    <?php _e('The Netherlands','rvg-optimize-database');?>
    </span></p>
  <p>
    <?php _e('Current settings','rvg-optimize-database');?>
    :<br />
    <span class="odb-bold">
    <?php _e('Maximum number of - most recent - revisions to keep per post / page','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $max_revisions?></span><br />
    <span class="odb-bold">
    <?php _e('Delete all trashed items','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $clear_trash_yn?></span><br />
    <span class="odb-bold">
    <?php _e('Delete all spammed items','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $clear_spam_yn?></span><br />
    <span class="odb-bold">
    <?php _e('Delete unused tags','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $clear_tags_yn?></span><br />
    <span class="odb-bold">
    <?php _e('Delete expired transients','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $clear_transients_yn?></span><br />
    <span class="odb-bold">
    <?php _e('Delete pingbacks and trackbacks','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $clear_pingbacks_yn?></span><br />
    <span class="odb-bold">
    <?php _e('Keep a log','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $rvg_odb_logging_on_yn?></span><br />
    <span class="odb-bold">
    <?php _e('Number of excluded tables','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $number_excluded?></span><br />
    <span class="odb-bold">
    <?php _e('Scheduler','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $rvg_odb_schedule_txt?></span>
    <?php
	if($nextrun)
	{
?>
    <br />
    <span class="odb-bold">
    <?php _e('Next scheduled run','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo $nextrun?> hrs (current server time: <?php echo $current_hour?>)</span>
    <?php		
	}
	if($total_savings)
	{
?>
    <br />
    <span class="odb-bold">
    <?php _e('Total savings since the first run','rvg-optimize-database');?>
    :</span> <span class="odb-bold odb-blue"><?php echo rvg_format_size($total_savings); ?></span>
    <?php
	}
    ?>
  <p class="submit">
    <input class="button odb-normal" type="button" name="change_options" value="<?php _e('Change Settings','rvg-optimize-database');?>" onclick="self.location='options-general.php?page=rvg_odb_admin'" />
    <?php
	if(file_exists(dirname(__FILE__).'/rvg-optimize-db-log.html'))
	{
?>
    &nbsp;
    <input class="button odb-normal" type="button" name="view_log" value="<?php _e('View Log File','rvg-optimize-database');?>" onclick="window.open('<?php echo $log_url?>')" />
    &nbsp;
    <input class="button odb-normal" type="button" name="delete_log" value="<?php _e('Delete Log File','rvg-optimize-database');?>" onclick="self.location='tools.php?page=rvg-optimize-db.php&action=delete_log'" />
    <?php	
	}
	$action = '';
	if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
	if($action != 'run')
	{
?>
    &nbsp;
    <input class="button-primary button-large" type="button" name="start_optimization" value="<?php _e('Start Optimization','rvg-optimize-database');?>" onclick="self.location='tools.php?page=rvg-optimize-db.php&action=run'" class="odb-bold" />
    <?php		
	}
?>
  </p>
</div>
<?php
	$action = '';
	if(isset($_REQUEST['action'])) $action = $_REQUEST['action'];
	if($action != 'run') return;
?>
<h2 class="odb-padding-left">
  <?php _e('Starting Optimization','rvg-optimize-database');?>
  ...</h2>
<?php
	// GET THE SIZE OF THE DATABASE BEFORE OPTIMIZATION
	$start_size = rvg_get_db_size();

	// TIMESTAMP FOR LOG FILE
	$current_datetime = Date('m/d/YH:i:s');
	$log_arr = array("time" => substr($current_datetime, 0, 10).'<br />'.substr($current_datetime,10));

	// FIND REVISIONS
	$results = rvg_get_revisions($max_revisions);

	$total_deleted = 0;
	if(count($results)>0)
	{	// WE HAVE REVISIONS TO DELETE!
?>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td colspan="4" class="odb-bold odb-blue"><?php _e('DELETING REVISIONS','rvg-optimize-database');?>
      :</td>
  </tr>
  <tr>
    <th align="right" class="odb-border-bottom">#</th>
    <th align="left" class="odb-border-bottom"><?php _e('prefix', 'rvg-optimize-database');?></th>
    <th align="left" class="odb-border-bottom"><?php _e('post / page','rvg-optimize-database');?></th>
    <th align="left" class="odb-border-bottom"><?php _e('revision date','rvg-optimize-database');?></th>
    <th align="right" class="odb-border-bottom"><?php _e('revisions deleted','rvg-optimize-database');?></th>
  </tr>
  <?php
		// LOOP THROUGH THE REVISIONS AND DELETE THEM
  		$total_deleted = rvg_delete_revisions($results, true, $max_revisions);
	?>
  <tr>
    <td colspan="4" align="right" class="odb-border-top odb-bold"><?php _e('total number of revisions deleted','rvg-optimize-database');?></td>
    <td align="right" class="odb-border-top odb-bold"><?php echo $total_deleted?></td>
  </tr>
</table>
<?php		
	}
	else
	{
?>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td class="odb-not-found"><?php _e('No REVISIONS found to delete','rvg-optimize-database');?>
      ...</td>
  </tr>
</table>
<?php		
	} // if(count($results)>0)
	
	// NUMBER OF DELETED REVISIONS FOR LOG FILE
	$log_arr["revisions"] = $total_deleted;


	/****************************************************************************************
	
		DELETE TRASHED ITEMS
	
	******************************************************************************************/
	if($clear_trash == 'Y')
	{
		// GET TRASHED POSTS / PAGES AND COMMENTS
		$results = rvg_get_trash();

		$total_deleted = 0;		
		if(count($results)>0)
		{	// WE HAVE TRASH TO DELETE!
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td colspan="4" class="odb-found"><?php _e('DELETING TRASHED ITEMS','rvg-optimize-database');?>
      :</td>
  </tr>
  <tr>
    <th align="right" class="odb-border-bottom">#</th>
    <th align="left" class="odb-border-bottom"><?php _e('prefix', 'rvg-optimize-database');?></th>
    <th align="left" class="odb-border-bottom"><?php _e('type','rvg-optimize-database');?></th>
    <th align="left" class="odb-border-bottom"><?php _e('IP address / title','rvg-optimize-database');?></th>
    <th align="left" nowrap="nowrap" class="odb-border-bottom"><?php _e('date','rvg-optimize-database');?></th>
  </tr>
  <?php
  			// LOOP THROUGH THE TRASHED ITEMS AND DELETE THEM
  			$total_deleted = rvg_delete_trash($results, true);
?>
</table>
<?php			
		}
		else
		{
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td class="odb-not-found"><?php _e('No TRASHED ITEMS found to delete','rvg-optimize-database');?>
      ...</td>
  </tr>
</table>
<?php		
		} // if(count($results)>0)
		
		// NUMBER OF DELETED TRASH FOR LOG FILE
		$log_arr["trash"] = $total_deleted;
	} // if($clear_trash == 'Y')
	

	/****************************************************************************************
	
		DELETE SPAMMED ITEMS
	
	******************************************************************************************/
	if($clear_spam == 'Y')
	{
		// GET SPAMMED COMMENTS
		$results = rvg_get_spam();

		$total_deleted = 0;		
		if(count($results)>0)
		{	// WE HAVE SPAM TO DELETE!
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td colspan="4" class="odb-found"><?php _e('DELETING SPAMMED ITEMS','rvg-optimize-database');?>
      :</td>
  </tr>
  <tr>
    <th align="right" class="odb-border-bottom">#</th>
    <th align="left" class="odb-border-bottom"><?php _e('prefix', 'rvg-optimize-database');?></th>
    <th align="left" class="odb-border-bottom"><?php _e('comment author','rvg-optimize-database');?></th>
    <th align="left" class="odb-border-bottom"><?php _e('comment author email','rvg-optimize-database');?></th>
    <th align="left" nowrap="nowrap" class="odb-border-bottom"><?php _e('comment date','rvg-optimize-database');?></th>
  </tr>
  <?php
			// LOOP THROUGH SPAMMED ITEMS AND DELETE THEM
  			$total_deleted = rvg_delete_spam($results, true);	
?>
</table>
<?php			
		}
		else
		{
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td class="odb-not-found"><?php _e('No SPAMMED ITEMS found to delete','rvg-optimize-database');?>
      ...</td>
  </tr>
</table>
<?php		
		} // if(count($results)>0)
		
	} // if($clear_spam == 'Y')
	
	// NUMBER OF SPAM DELETED FOR LOG FILE
	$log_arr["spam"] = $total_deleted;
	

	/****************************************************************************************
	
		DELETE UNUSED TAGS
	
	******************************************************************************************/
	if($clear_tags == 'Y')
	{
		// DELETE UNUSED TAGS
		$total_deleted = rvg_delete_tags();
	
		if($total_deleted>0)
		{	// TAGS DELETED
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td><span class="odb-found">
      <?php _e('NUMBER OF UNUSED TAGS DELETED','rvg-optimize-database');?>
      :</span> <span class="odb-bold"><?php echo $total_deleted;?></span></td>
  </tr>
</table>
<?php			
		}
		else
		{
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td class="odb-not-found"><?php _e('No UNUSED TAGS found to delete','rvg-optimize-database');?>
      ...</td>
  </tr>
</table>
<?php		
		} // if(count($results)>0)
		
	} // if($clear_tags == 'Y')
	
	// NUMBER OF tags DELETED FOR LOG FILE
	$log_arr["tags"] = $total_deleted;


	/****************************************************************************************
	
		DELETE EXPIRED TRANSIENTS
	
	******************************************************************************************/
	if($clear_transients == 'Y')
	{
		// DELETE UNUSED TAGS
		$total_deleted = rvg_delete_transients();
	
		if($total_deleted>0)
		{	// TRANSIENTS DELETED
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td><span class="odb-found">
      <?php _e('NUMBER OF EXPIRED TRANSIENTS DELETED','rvg-optimize-database');?>
      :</span> <span class="odb-bold"><?php echo $total_deleted;?></span></td>
  </tr>
</table>
<?php			
		}
		else
		{
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td class="odb-not-found"><?php _e('No EXPIRED TRANSIENTS found to delete','rvg-optimize-database');?>
      ...</td>
  </tr>
</table>
<?php		
		} // if(count($results)>0)
		
	} // if($clear_transients == 'Y')
	
	// NUMBER OF transients DELETED FOR LOG FILE
	$log_arr["transients"] = $total_deleted;
	
	/****************************************************************************************
	
		DELETE PINGBACKS AND TRACKBACKS (v3.1)
	
	******************************************************************************************/
	if($clear_pingbacks == 'Y')
	{
		// DELETE UNUSED TAGS
		$total_deleted = rvg_delete_pingbacks();
	
		if($total_deleted>0)
		{	// PINGBACKS / TRACKBACKS DELETED
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td><span class="odb-found">
      <?php _e('NUMBER OF PINGBACKS AND TRACKBACKS DELETED','rvg-optimize-database');?>
      :</span> <span class="odb-bold"><?php echo $total_deleted;?></span></td>
  </tr>
</table>
<?php			
		}
		else
		{
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td class="odb-not-found"><?php _e('No PINGBACKS nor TRACKBACKS found to delete','rvg-optimize-database');?>
      ...</td>
  </tr>
</table>
<?php		
		} // if(count($results)>0)
		
	} // if($clear_pingbacks == 'Y')
	
	// NUMBER OF pingbacks / trackbacks DELETED (FOR LOG FILE)
	$log_arr["pingbacks"] = $total_deleted;	
	

	/****************************************************************************************
	
		DELETE ORPHANS
	
	******************************************************************************************/
	$total_deleted = rvg_delete_orphans(true);
	if($total_deleted)
	{
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td colspan="4"><span class="odb-found">
      <?php _e('NUMBER OF POSTMETA ORPHANS DELETED','rvg-optimize-database');?>
      :</span> <span class="odb-bold"><?php echo $total_deleted;?></span></td>
  </tr>
</table>
<?php		
	}
	else
	{
?>
<div class="odb-separator"></div>
<table border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td class="odb-not-found"><?php _e('No POSTMETA ORPHANS found to delete','rvg-optimize-database');?>
      ...</td>
  </tr>
</table>
<?php		
	}
	// FOR LOG FILE
	$log_arr["orphans"] = $total_deleted;

	/****************************************************************************************
	
		OPTIMIZE DATABASE TABLES
	
	******************************************************************************************/
?>
<div class="odb-separator"></div>
<div class="odb-optimizing-table">
  <table border="0" cellspacing="8" cellpadding="2">
    <tr>
      <td colspan="4" class="odb-bold odb-blue"><?php _e('OPTIMIZING DATABASE TABLES','rvg-optimize-database');?>
        :</td>
    </tr>
    <tr>
      <th class="odb-border-bottom" align="right">#</th>
      <th class="odb-border-bottom" align="left"><?php _e('table name','rvg-optimize-database');?></th>
      <th class="odb-border-bottom" align="left"><?php _e('optimization result','rvg-optimize-database');?></th>
      <th class="odb-border-bottom" align="left"><?php _e('engine','rvg-optimize-database');?></th>
      <th class="odb-border-bottom" align="right"><?php _e('table rows','rvg-optimize-database');?></th>
      <th class="odb-border-bottom" align="right"><?php _e('table size','rvg-optimize-database');?></th>
    </tr>
    <?php
	# OPTIMIZE THE DATABASE TABLES
	$cnt = rvg_optimize_tables(true);
?>
  </table>
  <?php
	// NUMBER OF TABLES
	$log_arr["tables"] = $cnt;
	// DATABASE SIZE BEFORE OPTIMIZATION
	$log_arr["before"] = rvg_format_size($start_size,3);
	// DATABASE SIZE AFTER OPTIMIZATION
	$end_size = rvg_get_db_size();
	$log_arr["after"] = rvg_format_size($end_size,3);
	// TOTAL SAVING
	$log_arr["savings"] = rvg_format_size(($start_size - $end_size),3);
	// WRITE RESULTS TO LOG FILE
	rvg_write_log($log_arr);

	$total_savings = rvg_odb_get_option('rvg_odb_total_savings');
	$total_savings += ($start_size - $end_size);
	rvg_odb_update_option('rvg_odb_total_savings',$total_savings);
?>
  <div class="odb-separator"></div>
  <span class="odb-bold odb-blue odb-padding-left">
  <?php _e('SAVINGS','rvg-optimize-database');?>
  </span><br />
  <table border="0" cellspacing="8" cellpadding="2">
    <tr>
      <th>&nbsp;</th>
      <th class="odb-border-bottom"><?php _e('size of the database','rvg-optimize-database');?></th>
    </tr>
    <tr>
      <td align="right"><?php _e('BEFORE optimization','rvg-optimize-database');?></td>
      <td align="right" class="odb-bold"><?php echo rvg_format_size($start_size,3); ?></td>
    </tr>
    <tr>
      <td align="right"><?php _e('AFTER optimization','rvg-optimize-database');?></td>
      <td align="right" class="odb-bold"><?php echo rvg_format_size($end_size,3); ?></td>
    </tr>
    <tr>
      <td align="right" class="odb-bold"><?php _e('SAVINGS THIS TIME','rvg-optimize-database');?></td>
      <td align="right" class="odb-border-top odb-bold"><?php echo rvg_format_size(($start_size - $end_size),3); ?></td>
    </tr>
    <tr>
      <td align="right" class="odb-bold"><?php _e('TOTAL SAVINGS SINCE THE FIRST RUN','rvg-optimize-database');?></td>
      <td align="right" class="odb-border-top odb-bold"><?php echo rvg_format_size($total_savings,3); ?></td>
    </tr>
  </table>
</div>
<div class="odb-separator"></div>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;

$total_time = round(($finish - $odb_start_time), 4);
?>
<span class="odb-bold odb-blue odb-padding-left">
<?php _e('DONE','rvg-optimize-database');?>
!</span><br />
<br />
<span class="odb-padding-left">
<?php _e('Optimization took', 'rvg-optimize-database')?>
&nbsp;<strong><?php echo $total_time;?></strong>&nbsp;
<?php _e('seconds', 'rvg-optimize-database')?>
.</span>
<?php
	if(file_exists(dirname(__FILE__).'/rvg-optimize-db-log.html'))
	{
?>
<br />
<br />
&nbsp;
<input class="button odb-normal" type="button" name="view_log" value="<?php _e('View Log File','rvg-optimize-database');?>" onclick="window.open('<?php echo $log_url?>')" />
&nbsp;
<input class="button odb-normal" type="button" name="delete_log" value="<?php _e('Delete Log File','rvg-optimize-database');?>" onclick="self.location='tools.php?page=rvg-optimize-db.php&action=delete_log'" />
<?php	
	}
} // rvg_optimize_db()


/********************************************************************************************

	EXECUTE OPTIMIZATION VIA CRON JOB

*********************************************************************************************/
function rvg_optimize_db_cron()
{
	global $wpdb, $odb_version, $odb_ms_prefixes;

	// v3.3.1 - GET NETWORK INFORMATION (MULTISITE)
	rvg_odb_network_info();

	// GET SETTINGS AND SET DEFAULT VALUES
	$max_revisions = rvg_odb_get_option('rvg_odb_number');
	if(!$max_revisions)
	{	$max_revisions = 0;
		rvg_odb_update_option('rvg_odb_number', $max_revisions);
	}

	$clear_trash = rvg_odb_get_option('rvg_clear_trash');
	if(!$clear_trash)
	{	$clear_trash = 'N';
		rvg_odb_update_option('rvg_clear_trash', $clear_trash);
	}

	$clear_spam = rvg_odb_get_option('rvg_clear_spam');
	if(!$clear_spam)
	{	$clear_spam = 'N';
		rvg_odb_update_option('rvg_clear_spam', $clear_spam);
	}
	
	$clear_tags = rvg_odb_get_option('rvg_clear_tags');
	if(!$clear_tags)
	{	$clear_tags = 'N';
		rvg_odb_update_option('rvg_clear_tags', $clear_tags);
	}
	
	$clear_transients = rvg_odb_get_option('rvg_clear_transients');
	if(!$clear_transients)
	{	$clear_transients = 'N';
		rvg_odb_update_option('rvg_clear_transients', $clear_transients);
	}
	
	// v3.1
	$clear_pingbacks = rvg_odb_get_option('rvg_clear_pingbacks');
	if(!$clear_pingbacks)
	{	$clear_pingbacks = 'N';
		rvg_odb_update_option('rvg_clear_pingbacks', $clear_pingbacks);
	}	
	
	// GET THE SIZE OF THE DATABASE BEFORE OPTIMIZATION
	$start_size = rvg_get_db_size();
	
	// TIMESTAMP FOR LOG FILE
	$log_arr = array("time" => date("m/d/Y").'<br />'.date("H:i:s"));

	// FIND THE REVISIONS
	$results = rvg_get_revisions($max_revisions);
	
	$total_deleted = 0;
	if(count($results)>0)
		// WE HAVE REVISIONS TO DELETE!
		$total_deleted = rvg_delete_revisions($results, false, $max_revisions);

	// NUMBER OF DELETED REVISIONS FOR LOG FILE
	$log_arr["revisions"] = $total_deleted;

	$total_deleted = 0;	
	if($clear_trash == 'Y')
	{	
		// GET TRASHED POSTS / PAGES AND COMMENTS
		$results = rvg_get_trash();
		
		if(count($results)>0)
			// WE HAVE TRASH TO DELETE!
			$total_deleted = rvg_delete_trash($results, false, $max_revisions);
			
	} // if($clear_trash == 'Y')

	// NUMBER OF DELETED TRASH FOR LOG FILE
	$log_arr["trash"] = $total_deleted;

	$total_deleted = 0;
	if($clear_spam == 'Y')
	{
		// GET SPAMMED COMMENTS
		$results = rvg_get_spam();
		
		if(count($results)>0)
			// WE HAVE SPAM TO DELETE!
			$total_deleted = rvg_delete_spam($results, false);
			
	} // if($clear_spam == 'Y')

	// NUMBER OF SPAM DELETED FOR LOG FILE
	$log_arr["spam"] = $total_deleted;
	
	if($clear_tags == "Y")
	{	// DELETE UNUSED TAGS
		$total_deleted = rvg_delete_tags();
	}
	
	// NUMBER OF DELETE TAGS FOR LOG FILE
	$log_arr["tags"] = $total_deleted;

	if($clear_transients == "Y")
	{	// DELETE TRANSIENTS
		$total_deleted = rvg_delete_transients();
	}
	
	// NUMBER OF DELETED TAGS FOR LOG FILE
	$log_arr["transients"] = $total_deleted;

	// PINGBACKS AND TRACKBACKS (v3.1)
	if($clear_pingbacks == "Y")
	{	// DELETE PINGBACKS AND TRACKBACKS
		$total_deleted = rvg_delete_pingbacks();
	}
	// NUMBER OF DELETED PINGBACKS AND TRACKBACKS FOR LOG FILE
	$log_arr["pingbacks"] = $total_deleted;
		
	// DELETE ORPHANS
	$total_deleted = rvg_delete_orphans(false);
	// NUMBER OF ORPHANS DELETED (FOR LOG FILE)
	$log_arr["orphans"] = $total_deleted;

	// OPTIMIZE DATABASE TABLES	
	$cnt = rvg_optimize_tables(false);
	
	// NUMBER OF TABLES
	$log_arr["tables"] = $cnt;
	// DATABASE SIZE BEFORE OPTIMIZATION
	$log_arr["before"] = rvg_format_size($start_size,3);
	// DATABASE SIZE AFTER OPTIMIZATION
	$end_size = rvg_get_db_size();
	$log_arr["after"] = rvg_format_size($end_size,3);
	// TOTAL SAVING
	$log_arr["savings"] = rvg_format_size(($start_size - $end_size),3);
	// WRITE RESULTS TO LOG FILE
	rvg_write_log($log_arr);
	
	$total_savings = rvg_odb_get_option('rvg_odb_total_savings');
	$total_savings += ($start_size - $end_size);
	rvg_odb_update_option('rvg_odb_total_savings',$total_savings);
	
} // rvg_optimize_db_cron()


/********************************************************************************************

	DELETE THE REVISIONS
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_delete_revisions($results, $display, $max_revisions)
{
	global $wpdb;
	
	$nr = 1;
	$total_deleted = 0;

	for($i=0; $i<count($results); $i++)
	{	$nr_to_delete = $results[$i]['cnt'] - $max_revisions;
		$total_deleted += $nr_to_delete;
			
		if($display)
		{
	?>
<tr>
  <td align="right" valign="top"><?php echo $nr?>.</td>
  <td align="left" valign="top"><?php echo $results[$i]['site']?></td>
  <td valign="top" class="odb-bold"><?php echo $results[$i]['post_title']?></td>
  <td valign="top"><?php
		} // if($display)
		
		$sql_get_posts = "
		  SELECT `ID`, `post_modified`
			FROM ".$results[$i]['site']."posts
		   WHERE `post_parent`=".$results[$i]['post_parent']."
			 AND `post_type`='revision'
		ORDER BY `post_modified` ASC		
		";
		
		$results_get_posts = $wpdb->get_results($sql_get_posts);
		
		for($j=0; $j<$nr_to_delete; $j++)
		{
			if($display) echo $results_get_posts[$j]->post_modified.'<br />';
			
			$sql_delete = "
			DELETE FROM ".$results[$i]['site']."posts
			 WHERE `ID` = ".$results_get_posts[$j]->ID."
			";
			$wpdb->get_results($sql_delete);
			
		} // for($j=0; $j<$nr_to_delete; $j++)
		
		$nr++;
		if($display)
		{
?></td>
  <td align="right" valign="top" class="odb-bold"><?php echo $nr_to_delete?></td>
</tr>
<?php
		} // if($display)
	} // for($i=0; $i<count($results); $i++)

	return $total_deleted;
} // rvg_delete_revisions()


/********************************************************************************************

	DELETE TRASHED POSTS AND PAGES
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_delete_trash($results, $display)
{
	global $wpdb;

	$nr = 1;
	$total_deleted = count($results);
	
	for($i=0; $i<$total_deleted; $i++)
	{	if($display)
		{
?>
<tr>
  <td align="right" valign="top"><?php echo $nr; ?></td>
  <td align="left" valign="top"><?php echo $results[$i]['site']?></td>
  <td valign="top"><?php echo $results[$i]['post_type']; ?></td>
  <td valign="top"><?php echo $results[$i]['title']; ?></td>
  <td valign="top" nowrap="nowrap"><?php echo $results[$i]['modified']; ?></td>
</tr>
<?php
		}
		
		if($results[$i]['post_type'] == 'comment')
		{	// DELETE META DATA (IF ANY...)
			$sql_delete = "
			DELETE FROM ".$results[$i]['site']."commentmeta
			 WHERE `comment_id` = ".$results[$i]['id']."
			";
			$wpdb->get_results($sql_delete);  
		}
		
		// DELETE TRASHED POSTS / PAGES
		$sql_delete = "
		DELETE FROM ".$results[$i]['site']."posts
		 WHERE `post_status` = 'trash'			
		";
		$wpdb->get_results($sql_delete);		

		// DELETE TRASHED COMMENTS
		$sql_delete = "
		DELETE FROM ".$results[$i]['site']."comments
		 WHERE `comment_approved` = 'trash'
		";
		$wpdb->get_results($sql_delete);	
		
		$nr++;
	} // for($i=0; $i<count($results); $i++)

	return $total_deleted;
	
} // rvg_delete_trash()


/********************************************************************************************

	DELETE SPAMMED ITEMS
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_delete_spam($results, $display)
{
	global $wpdb;

	$nr = 1;
	$total_deleted = count($results);
	for($i=0; $i<count($results); $i++)
	{	if($display)
		{
?>
<tr>
  <td align="right" valign="top"><?php echo $nr; ?></td>
  <td align="left" valign="top"><?php echo $results[$i]['site']?></td>
  <td valign="top"><?php echo $results[$i]['comment_author']; ?></td>
  <td valign="top"><?php echo $results[$i]['comment_author_email']; ?></td>
  <td valign="top" nowrap="nowrap"><?php echo $results[$i]['comment_date']; ?></td>
</tr>
<?php
		} // if($display)
		
		$sql_delete = "
		DELETE FROM ".$results[$i]['site']."commentmeta
		 WHERE `comment_id` = ".$results[$i]['comment_ID']."
		";
		$wpdb->get_results($sql_delete);
		
		$sql_delete = "
		DELETE FROM ".$results[$i]['site']."comments
		 WHERE `comment_approved` = 'spam'
		";
		$wpdb->get_results($sql_delete);

		$nr++;				
	} // for($i=0; $i<count($results); $i++)
	
	return $total_deleted;
	
} // rvg_delete_spam()


/********************************************************************************************

	DELETE UNUSED TAGS
	
	v3.2: MULTISITE	

*********************************************************************************************/
function rvg_delete_tags()
{
	global	$odb_ms_blogids, $odb_ms_prefixes;
		
	$total_deleted = 0;

	// LOOP THROUGH THE NETWORK
	for($i=0; $i<count($odb_ms_blogids); $i++)
	{
		if(function_exists('switch_to_blog')) switch_to_blog($odb_ms_blogids[$i]);
		
		$tags = get_terms('post_tag', array('hide_empty' => 0));
		for($j=0; $j<count($tags); $j++)
		{
			if($tags[$i]->count < 1)
			{	if(!rvg_delete_tags_is_scheduled($tags[$i]->term_id, $odb_ms_prefixes[$i]))
				{	// v3.0: TAG NOT USED IN SCHEDULED POSTS: CAN BE DELETED
					$total_deleted++;
					wp_delete_term($tags[$i]->term_id, 'post_tag');
				}
			}			
		}
	} // for($i=0; $i<count($odb_ms_blogids); $i++)
	
	// SWITCH BACK TO MAIN SITE
	// if(function_exists('switch_to_blog')) switch_to_blog(1);
	
	return $total_deleted;
} // rvg_delete_tags()


/********************************************************************************************

	IS THE UNUSED TAG USED IN ONE OR MORE SCHEDULED POSTS?
	
	Since: v3.0
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_delete_tags_is_scheduled($term_id, $odb_prefix)
{
	global $wpdb;

	$sql_get_posts = "
	SELECT p.post_status
	  FROM ".$odb_prefix."term_relationships t, ".$odb_prefix."posts p
	 WHERE t.term_taxonomy_id = '".$term_id."'
	   AND t.object_id        = p.ID
	";

	$results_get_posts = $wpdb->get_results($sql_get_posts);
	for($i=0; $i<count($results_get_posts); $i++)
		if($results_get_posts[$i]->post_status == 'future') return true;

	return false;	
	
} // rvg_delete_tags_is_scheduled()


/********************************************************************************************

	DELETE EXPIRED TRANSIENTS
	
	v3.2: MULTISITE	

*********************************************************************************************/
function rvg_delete_transients()
{
	global $wpdb, $odb_ms_prefixes;
	
	$delay = time() - 60;	// ONE MINUTE DELAY

	$total_deleted = 0;

	// LOOP THROUGH THE NETWORK
	for($i=0; $i<count($odb_ms_prefixes); $i++)
	{
		$sql = "
		SELECT *
		FROM ".$odb_ms_prefixes[$i]."options
		WHERE (
			option_name LIKE '_transient_timeout_%'
			OR option_name LIKE '_site_transient_timeout_%'
			OR option_name LIKE 'displayed_galleries_%'
		)
		AND option_value < '$delay'
		";
	
		$results = $wpdb->get_results($sql);
		$total_deleted = count($results);
	
		$sql = "
		DELETE FROM ".$odb_ms_prefixes[$i]."options
		WHERE (
			option_name LIKE '_transient_timeout_%'
			OR option_name LIKE '_site_transient_timeout_%'
			OR option_name LIKE 'displayed_galleries_%'
		)
		AND option_value < '$delay'
		";
	
		$wpdb->get_results($sql);
		
		$sql = "
		SELECT *
		FROM ".$odb_ms_prefixes[$i]."options
		WHERE (
			option_name LIKE '_transient_timeout_%'
			OR option_name LIKE '_site_transient_timeout_%'
		)
		AND option_value < '$delay'
		";
		
		$results = $wpdb->get_results($sql);
		$total_deleted += count($results);
	
		$sql = "
		DELETE FROM ".$odb_ms_prefixes[$i]."options
		WHERE (
			option_name LIKE '_transient_timeout_%'
			OR option_name LIKE '_site_transient_timeout_%'
		)
		AND option_value < '$delay'	
		";
		
		$wpdb->get_results($sql);
	}

	return $total_deleted;
} // rvg_delete_transients()


/********************************************************************************************

	DELETE PINGBACKS AND TRACKBACKS
	
	Since: v3.1
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_delete_pingbacks()
{
	global $wpdb, $odb_ms_prefixes;
	
	$total_deleted = 0;

	// LOOP THROUGH THE NETWORK
	for($i=0; $i<count($odb_ms_prefixes); $i++)
	{
		$sql = "
		SELECT `comment_ID`
		FROM ".$odb_ms_prefixes[$i]."comments
		WHERE (
			`comment_type` = 'pingback'
			OR `comment_type` = 'trackback'
		)
		";
	
		$results = $wpdb->get_results($sql);
		$total_deleted = count($results);

		for($j=0; $j<count($results); $j++)
		{	// DELETE METADATA FOR THIS COMMENT (IF ANY)
			$sql_delete_meta = "
			DELETE FROM ".$odb_ms_prefixes[$i]."commentmeta
			 WHERE `comment_id` = ".$results[$j]->comment_ID."
			";
			$wpdb->get_results($sql_delete_meta);
		}

		// DELETE COMMENTS			
		$sql_delete_comments = "
		DELETE FROM ".$odb_ms_prefixes[$i]."comments
		WHERE (
			`comment_type` = 'pingback'
			OR `comment_type` = 'trackback'
		)	
		";
		$wpdb->get_results($sql_delete_comments);
	}

	return $total_deleted;
} // rvg_delete_pingbacks()


/********************************************************************************************

	DELETE ORPHAN POSTMETA RECORDS - v3.2 MULTISITE
	
	Since: v2.2.7
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_delete_orphans($display)
{
	global $wpdb, $odb_ms_prefixes;
	
	$meta_orphans = 0;
	$post_orphans = 0;

	// LOOP THROUGH THE NETWORK
	for($i=0; $i<count($odb_ms_prefixes); $i++)
	{
		// DELETE POST ORPHANS (AUTO DRAFTS)
		$sql_delete = "
		SELECT COUNT(*) cnt
		  FROM ".$odb_ms_prefixes[$i]."posts
		 WHERE ID NOT IN (SELECT post_id FROM ".$odb_ms_prefixes[$i]."postmeta)
		   AND post_status = 'auto-draft'
		";
	
		$results = $wpdb->get_results($sql_delete);
		
		$post_orphans = $results[0]->cnt;
		
		if($post_orphans > 0)
		{	$sql_delete = "
			DELETE FROM ".$odb_ms_prefixes[$i]."posts
			 WHERE ID NOT IN (SELECT post_id FROM ".$odb_ms_prefixes[$i]."postmeta)
			   AND post_status = 'auto-draft'
			";
			$wpdb->get_results($sql_delete);		
		}
		
		// DELETE POSTMETA ORPHANS
		$sql_delete = "
		SELECT COUNT(*) cnt
		  FROM ".$odb_ms_prefixes[$i]."postmeta
		 WHERE post_id NOT IN (SELECT ID FROM ".$odb_ms_prefixes[$i]."posts)
		";
		
		$results = $wpdb->get_results($sql_delete);
		
		$meta_orphans = $results[0]->cnt;
		
		if($meta_orphans > 0)
		{	$sql_delete = "
			DELETE FROM ".$odb_ms_prefixes[$i]."postmeta
			 WHERE post_id NOT IN (SELECT ID FROM ".$odb_ms_prefixes[$i]."posts)
			";
			$wpdb->get_results($sql_delete);		
		}
	}

	return ($meta_orphans + $post_orphans);
	
} // rvg_delete_orphans()


/********************************************************************************************

	OPTIMIZE DATABASE TABLES

*********************************************************************************************/
function rvg_optimize_tables($display)
{
	global $wpdb;

	# v2.8.2
	$tables = $wpdb->get_results("SHOW TABLES FROM `".DB_NAME."`", ARRAY_N);
	// print_r($tables);	

	$cnt = 0;
	for ($i=0; $i<count($tables); $i++)
	{
		$excluded = rvg_odb_get_option('rvg_ex_'.$tables[$i][0]);
		
		if(!$excluded)
		{	# TABLE NOT EXCLUDED
			$cnt++;
	
			// v3.1.4
			$sql = "
			SELECT engine, (data_length + index_length) AS size, table_rows
			  FROM information_schema.TABLES
			 WHERE table_schema = '".DB_NAME."'
			   AND table_name   = '".$tables[$i][0]."'
			";
			$table_info = $wpdb->get_results($sql);

			// v3.1.4
			if(strtolower($table_info[0]->engine) == 'innodb')
			{	// SKIP InnoDB tables
				$msg = __('InnoDB table: skipped...', 'rvg-optimize-database');
			}
			else
			{	$query  = "OPTIMIZE TABLE ".$tables[$i][0];
				$result = $wpdb->get_results($query);
				$msg    = $result[0]->Msg_text;
				$msg = str_replace('OK', __('<span class="odb-optimized">TABLE OPTIMIZED</span>', 'rvg-optimize-database'), $msg);
				$msg = str_replace('Table is already up to date', __('Table is already up to date', 'rvg-optimize-database'), $msg);
			}
			
			if($display)
			{	// NOT FROM THE SCEDULER
?>
<tr>
  <td align="right" valign="top"><?php echo $cnt?>.</td>
  <td valign="top" class="odb-bold"><?php echo $tables[$i][0] ?></td>
  <td valign="top"><?php echo $msg ?></td>
  <td valign="top"><?php echo $table_info[0]->engine ?></td>
  <td align="right" valign="top"><?php echo $table_info[0]->table_rows ?></td>
  <td align="right" valign="top"><?php echo rvg_format_size($table_info[0]->size) ?></td>
</tr>
<?php
			} // if($display)
		} // if(!$excluded)
	} // for ($i=0; $i<count($tables); $i++)
	return $cnt;
	
} // rvg_optimize_tables()


/********************************************************************************************

	WRITE LINE TO LOG FILE

*********************************************************************************************/
function rvg_write_log($log_arr)
{
	global $odb_version;
	
	$rvg_odb_logging_on = rvg_odb_get_option('rvg_odb_logging_on');
	if(!$rvg_odb_logging_on)
	{	$rvg_odb_logging_on = 'N';
		rvg_odb_update_option('rvg_odb_logging_on', $rvg_odb_logging_on);
	}
		
	if($rvg_odb_logging_on == "Y")
	{	$file = dirname(__FILE__).'/rvg-optimize-db-log.html';
		if(!file_exists($file))
		{
			// NEW LOG FILE
			$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Optimize Database after Deleting Revisions v'.$odb_version.' - LOG</title>
<style type="text/css">
body, td, th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
th {
	border-top:solid 1px #000;
	border-bottom:solid 1px #000;
}
td {
	padding-bottom:4px;
	border-bottom:dotted 1px #CCC;
}
#header {
	margin-left:6px;
	margin-bottom:8px;
}
#header a {
	text-decoration:none;
	font-weight:bold;
}
</style>
</head>
<body>
<div id="header">
<h2><a href="https://wordpress.org/plugins/rvg-optimize-database/" target="_blank">Optimize Database after Deleting Revisions v'.$odb_version.'</a></h2>
  '.__('A WordPress Plugin by','rvg-optimize-database').' <a href="http://cagewebdev.com" target="_blank"><span class="odb-bold">CAGE Web Design</span></a> | <a href="http://rvg.cage.nl" target="_blank"><span class="odb-bold">Rolf van Gelder</span></a>, Eindhoven, '.__('The Netherlands','rvg-optimize-database').'</span>
</div>
<table width="100%" border="0" cellspacing="6" cellpadding="1">
  <tr>
    <th width="8%" align="left" valign="top">'.__('time','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('deleted<br />revisions','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('deleted<br />trash','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('deleted<br />spam','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('deleted<br />tags','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('deleted<br />transients','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('deleted<br />pingbacks<br />trackbacks','rvg-optimize-database').'</th>		  
    <th width="8%" align="right" valign="top">'.__('deleted<br />orphans','rvg-optimize-database').'</th>	  
    <th width="8%" align="right" valign="top">'.__('nr of optimized tables','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('database size BEFORE','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('database size AFTER','rvg-optimize-database').'</th>
    <th width="8%" align="right" valign="top">'.__('SAVINGS','rvg-optimize-database').'</th>
  </tr>
</table>
			';

			file_put_contents($file,$html,FILE_APPEND);
		}

		$html = '
<table width="100%" border="0" cellspacing="6" cellpadding="0">  
  <tr>
    <td width="8%" valign="top"><span class="odb-bold">'.$log_arr["time"].'</span></td>
    <td width="8%" align="right" valign="top">'.$log_arr["revisions"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["trash"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["spam"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["tags"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["transients"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["pingbacks"].'</td>	
    <td width="8%" align="right" valign="top">'.$log_arr["orphans"].'</td>	
    <td width="8%" align="right" valign="top">'.$log_arr["tables"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["before"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["after"].'</td>
    <td width="8%" align="right" valign="top">'.$log_arr["savings"].'</td>
  </tr>
</table>
		';
					
		// print_r($log_arr);
		file_put_contents($file,$html,FILE_APPEND);
	}
	
} // rvg_write_log()


/********************************************************************************************

	GET REVISIONS
	
	V3.2: MULTISITE

*********************************************************************************************/
function rvg_get_revisions($max_revisions)
{
		global $wpdb, $odb_ms_prefixes;
		
		$res_arr = array();

		$index = 0;
		for($i=0; $i<count($odb_ms_prefixes); $i++)
		{	$sql = "
			  SELECT `post_parent`, `post_title`, COUNT(*) cnt
				FROM ".$odb_ms_prefixes[$i]."posts
			   WHERE `post_type` = 'revision'
			GROUP BY `post_parent`
			  HAVING COUNT(*) > ".$max_revisions."
			ORDER BY UCASE(`post_title`)	
			";
			$res = $wpdb->get_results($sql, ARRAY_A);

			for($j=0; $j<count($res); $j++)
			{	if(isset($res[$j]))
				{	$res_arr[$index] = $res[$j];
					$res_arr[$index]['site'] = $odb_ms_prefixes[$i];				
					$index++;
				}
			}
		}
	
		return $res_arr;
		
} // rvg_get_revisions()


/********************************************************************************************

	GET TRASHED POSTS / PAGES AND COMMENTS
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_get_trash()
{
		global $wpdb, $odb_ms_prefixes;
		
		$res_arr = array();

		$index = 0;
		
		// LOOP TROUGH SITES
		for($i=0; $i<count($odb_ms_prefixes); $i++)
		{
			$sql = "
			   SELECT `ID` AS id, 'post' AS post_type, `post_title` AS title, `post_modified` AS modified
				 FROM ".$odb_ms_prefixes[$i]."posts
				WHERE `post_status` = 'trash'
			UNION ALL
			   SELECT `comment_ID` AS id, 'comment' AS post_type, `comment_author_IP` AS title, `comment_date` AS modified
				 FROM ".$odb_ms_prefixes[$i]."comments
				WHERE `comment_approved` = 'trash'
			 ORDER BY post_type, UCASE(title)		
			";
			$res = $wpdb->get_results($sql, ARRAY_A);

			if($res != null)
			{	$res_arr[$index] = $res[0];
				$res_arr[$index]['site'] = $odb_ms_prefixes[$i];				
				$index++;
			}			
		}
		
		return $res_arr;
		
} // rvg_get_trash()


/********************************************************************************************

	GET SPAMMED COMMENTS
	
	v3.2: MULTISITE

*********************************************************************************************/
function rvg_get_spam()
{
	global $wpdb, $odb_ms_prefixes;

	$res_arr = array();

	$index = 0;
	// LOOP THROUGH SITES
	for($i=0; $i<count($odb_ms_prefixes); $i++)
	{
		$sql = "
		  SELECT `comment_ID`, `comment_author`, `comment_author_email`, `comment_date`
			FROM ".$odb_ms_prefixes[$i]."comments
		   WHERE `comment_approved` = 'spam'
		ORDER BY UCASE(`comment_author`)
		";
		$res = $wpdb->get_results($sql, ARRAY_A);

		if($res != null)
		{	$res_arr[$index] = $res[0];
			$res_arr[$index]['site'] = $odb_ms_prefixes[$i];				
			$index++;
		}			
	}
	
	return $res_arr;
		
} // rvg_get_spam()


/********************************************************************************************

	CALCULATE THE SIZE OF THE WORDPRESS DATABASE (IN BYTES)

*********************************************************************************************/
function rvg_get_db_size()
{
	global $wpdb;

	// v3.1.4
	$sql = "
	  SELECT SUM(data_length + index_length) AS size
	    FROM information_schema.TABLES
	   WHERE table_schema = '".DB_NAME."'
	GROUP BY table_schema
	";	
	
	$res = $wpdb->get_results($sql);
	
	return $res[0]->size;
	
} // rvg_get_db_size()


/********************************************************************************************

	FORMAT SIZES FROM BYTES TO KB OR MB

*********************************************************************************************/
function rvg_format_size($size, $precision=1)
{
	if($size>1024*1024)
		$table_size = (round($size/(1024*1024),$precision)).' MB';
	else
		$table_size = (round($size/1024,$precision)).' KB';
		
	return $table_size;
} // rvg_format_size()
?>
