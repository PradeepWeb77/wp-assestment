<?php
/**
 * Plugin Name: WordPress Voting Plugin
 * Plugin URI: https://wordpress.org
 * Description: User will have option to provide positive and negative feedback to the individual post
 * Version: 1.0.0
 * Author: Pradip
 * Author URI: https://wordpress.org
 * Text Domain: pvote
 * Domain Path: languages
 *
 * @package WordPress Voting Plugin
 */

/**
 * Basic plugin definitions
 *
 * @package WordPress Voting Plugin
 * @since 1.0.0
 */
if ( ! defined( 'PVOTE_DIR' ) ) {
	define( 'PVOTE_DIR', dirname( __FILE__ ) ); // Plugin dir.
}
if ( ! defined( 'PVOTE_VERSION' ) ) {
	define( 'PVOTE_VERSION', '1.0.0' ); // Plugin Version.
}
if ( ! defined( 'PVOTE_URL' ) ) {
	define( 'PVOTE_URL', plugin_dir_url( __FILE__ ) ); // Plugin url.
}
if ( ! defined( 'PVOTE_INC_DIR' ) ) {
	define( 'PVOTE_INC_DIR', PVOTE_DIR . '/includes' ); // Plugin include dir.
}
if ( ! defined( 'PVOTE_INC_URL' ) ) {
	define( 'PVOTE_INC_URL', PVOTE_URL . 'includes' ); // Plugin include url.
}
if ( ! defined( 'PVOTE_ADMIN_DIR' ) ) {
	define( 'PVOTE_ADMIN_DIR', PVOTE_INC_DIR . '/admin' ); // Plugin admin dir.
}
if ( ! defined( 'PVOTE_PREFIX' ) ) {
	define( 'PVOTE_PREFIX', 'pvote' ); // Plugin Prefix.
}
if ( ! defined( 'PVOTE_VAR_PREFIX' ) ) {
	define( 'PVOTE_VAR_PREFIX', '_pvote_' ); // Variable Prefix.
}

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package WordPress Voting Plugin
 * @since 1.0.0
 */
load_plugin_textdomain( 'pvote', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Common function to get overview voting result for the post.
 *
 * @param integer $post_id post id.
 * @package WordPress Voting Plugin
 * @since 1.0.0
 */
function pvote_get_vote_perentage( $post_id ) {
	$vote_results   = array();
	$postive_count  = get_post_meta( $post_id, '_pvote_positive', true );
	$negative_count = get_post_meta( $post_id, '_pvote_negative', true );

	$postive_count  = empty( $postive_count ) ? 0 : $postive_count;
	$negative_count = empty( $negative_count ) ? 0 : $negative_count;

	$total_count = $postive_count + $negative_count;

	$vote_results['postive_percentage']  = ( $total_count > 0 ) ? round( ( $postive_count * 100 ) / $total_count, 2 ) : 0;
	$vote_results['postive_count']       = $postive_count;
	$vote_results['negative_percentage'] = ( $total_count > 0 ) ? round( ( $negative_count * 100 ) / $total_count, 2 ) : 0;
	$vote_results['negative_count']      = $negative_count;
	return $vote_results;
}



// Global variables.
global $pvote_scripts, $pvote_admin, $pvote_public;

// Script class handles most of script functionalities of plugin.
require_once PVOTE_INC_DIR . '/class-pvote-scripts.php';
$pvote_scripts = new Pvote_Scripts();
$pvote_scripts->add_hooks();

// Admin class handles most of admin panel functionalities of plugin.
require_once PVOTE_ADMIN_DIR . '/class-pvote-admin.php';
$pvote_admin = new Pvote_Admin();
$pvote_admin->add_hooks();

// Public class handles most of frontside functionalities of plugin.
require_once PVOTE_INC_DIR . '/class-pvote-public.php';
$pvote_public = new Pvote_Public();
$pvote_public->add_hooks();
