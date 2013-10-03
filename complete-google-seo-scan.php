<?php
/*
Plugin Name: Complete Google SEO Scan
Plugin URI: http://gogretel.com/
Description: Is your website maintains google guidelines and other SEO requirements? Most of the websites misses some. See it for yourself. Go to Settings > Guides submenu page and take the quick scan for each page. <strong>It will find out SEO errors for you.</strong>
Version: 1.6
Author: Nirjhar Lo
Author URI: http://gogretel.com/about/
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/
?>
<?php

/*
*
* Setup the plugin
*
*/

defined( 'ABSPATH' ) or exit;
define( 'COMPLETE_GOOGLE_SEO_SCAN_VERSION', cgss_get_version() );
defined( 'COMPLETE_GOOGLE_SEO_SCAN_DEBUG' ) or define( 'COMPLETE_GOOGLE_SEO_SCAN_DEBUG', false );

//load plugin textdomain
add_action( 'plugins_loaded', 'cgss_textdomain_cb' );
function cgss_textdomain_cb() {
  load_plugin_textdomain( 'cgss', false, dirname( plugin_basename( __FILE__ ) ) . '/includes/ln/' );
}

//software version returning function
function cgss_get_version() {
  $version = "0.0.1";
  $plugin_file = file_get_contents( __FILE__ );
  preg_match('#^\s*Version\:\s*(.*)$#im', $plugin_file, $matches);
  if (!empty($matches[1])) {
    $version = $matches[1];
  }
  return $version;
}

//define php errors
if ( version_compare( phpversion(), '5.3', '<' ) ) {
  add_action('admin_notices', 'cgss_php_too_low');
  function cgss_php_too_low() {
    echo '<div class="error"><p>' . __( 'Complete Google SEO Scan requires PHP 5.3+ and will not be activated, your current server configuration is running PHP version&nbsp;', 'cgss' ) . phpversion() . __( 'Any PHP version less than 5.3.0 has reached "End of Life" from PHP.net and no longer receives bug fixes or security updates. The official information on how to update and why at&nbsp;', 'cgss' ) . '<a href="http://php.net/eol.php/" target="_blank">php.net/eol.php</a></p></div>';
  }
  return;
}

//add settings link to plugin page
add_filter( 'plugin_action_links', 'cgss_scan_page_link', 10, 2 );
function cgss_scan_page_link( $links, $file ) {
 static $this_plugin;
 if (!$this_plugin) {
  $this_plugin = plugin_basename(__FILE__);
 }
 if ( $file == $this_plugin ) {
  $settings_link = '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/tools.php?page=cgss-scan-page">' . __( 'Scan Now', 'cgss' ) . '</a>';
  array_unshift( $links, $settings_link );
 }
 return $links;
}

/*
*
* Functionality of the plugin
*
*/

//add settings-submenu page
add_action( 'admin_menu', 'cgss_admin_page' );
function cgss_admin_page() {
	$cgss_scan_admin = add_management_page( __( 'SEO Scan', 'gretel' ), __( 'SEO Scan', 'gretel' ), 'manage_options', 'cgss-scan-page', 'cgss_scan_page_content' );
	add_action( 'admin_print_scripts-' . $cgss_scan_admin, 'cgss_admin_base_script' );
}

//admin script callback function
function cgss_admin_base_script() {
 wp_enqueue_script( 'cgss-tooltip-script', plugins_url() . '/complete-google-seo-scan/includes/bootstrap-tooltip.min.js', array( 'jquery' ), '', FALSE );
 wp_enqueue_script( 'cgss-admin-base-script', plugins_url() . '/complete-google-seo-scan/includes/cgss-jsscript.js', array( 'jquery' ), '', FALSE );
 wp_enqueue_script( 'cgss-google-chart-js', 'https://www.google.com/jsapi/', '', '', FALSE );
 wp_enqueue_style( 'cgss-admin-base-style', plugins_url() . '/complete-google-seo-scan/includes/cgss-style.css', '', '2.0', 'all' );
}

//submenu page callback
function cgss_scan_page_content() {
	?>
   <div class="wrap">
    <div id="icon-tools" class="icon32"><br /></div>
    <h2><?php _e( 'Complete Google SEO Scan', 'cgss' ); ?></h2>
    <br />
	<?php
   if ( isset( $_POST[ 'submit-cgss-page' ] ) or isset( $_POST[ 'submit-cgss-post' ] ) or isset( $_POST[ 'submit-cgss-url' ] ) ) :
    require_once( 'lib/cgss-form-validator.php' );
    require_once( 'lib/cgss-scan-processor.php' );
    require_once( 'lib/cgss-chart-scripts.php' );
    require_once( 'lib/cgss-report-display.php' );
   else :
    require_once( 'lib/cgss-scan-form.php' );
   endif;
  ?>
    <br />
    <br />
    <div style="border-top:1px solid #d4d4d4;">
     <p><?php echo __( 'Brought to you by', 'cgss' ) . '&nbsp;<a href="http://gogretel.com/" target="_blank">' . __( 'GoGretel SEO Blog', 'cgss' ) . '</a>'; ?></p>
    </div>
   </div>
  <?php
}
?>
