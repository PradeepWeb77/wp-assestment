<?php
/**
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package WordPress Voting Plugin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Script Class
 */
class Pvote_Scripts {

	/**
	 * Enqueue Scripts on front Side
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function pvote_enqueue_scripts() {
		global $post;
		$post_id    = $post->ID;
		$ip_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$has_voted  = get_post_meta( $post_id, '_pvote_' . $ip_address, true );
		wp_enqueue_script( 'voting-script', PVOTE_INC_URL . '/js/pvote-script.js', array( 'jquery' ), '1.0', true );
		wp_localize_script(
			'voting-script',
			'voting_ajax_object',
			array(
				'ajax_url'  => admin_url( 'admin-ajax.php' ),
				'has_voted' => $has_voted,
			)
		);
	}

	/**
	 * Enqueue Style on front Side
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function pvote_enqueue_styles() {
		wp_enqueue_style( 'voting-style', PVOTE_INC_URL . '/css/pvote-style.css', array(), PVOTE_VERSION );
	}

	/**
	 * Enqueue Style on admin Side
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function pvote_enqueue_admin_styles() {
		wp_enqueue_style( 'voting-admin-style', PVOTE_INC_URL . '/css/pvote-admin-style.css', array(), PVOTE_VERSION );
	}

	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the styles and scripts.
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function add_hooks() {

		// add public scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'pvote_enqueue_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'pvote_enqueue_styles' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'pvote_enqueue_admin_styles' ) );
	}
}
