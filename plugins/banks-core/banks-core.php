<?php
/**
 * Plugin Name: Banks Core
 * Description: Business logic for bankssolution.ng: project briefs and the Work portfolio now; the client portal, uploads, invoices, retainers and licences to follow.
 * Version: 0.2.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Author: Banks Solutions
 * Author URI: https://bankssolution.ng
 * Text Domain: banks-core
 *
 * @package Banks_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BANKS_CORE_VERSION', '0.2.0' );
define( 'BANKS_CORE_DIR', plugin_dir_path( __FILE__ ) );

require BANKS_CORE_DIR . 'includes/brief-options.php';
require BANKS_CORE_DIR . 'includes/briefs.php';
require BANKS_CORE_DIR . 'includes/briefs-admin.php';
require BANKS_CORE_DIR . 'includes/briefs-privacy.php';
require BANKS_CORE_DIR . 'includes/work.php';
