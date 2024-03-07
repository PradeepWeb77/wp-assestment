<?php
/**
 * Manage Admin Panel Class
 *
 * @package WordPress Voting Plugin
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Class
 */
class Pvote_Admin {

	/**
	 * Script class member variable
	 *
	 * @var Script class
	 */
	public $scripts;

	/**
	 * Class constructor.
	 */
	public function __construct() {

		global $pvote_scripts;

		$this->scripts = $pvote_scripts;
	}

	/**
	 * Add metabox to the WordPress backend
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function pvote_voting_results_meta_box() {
		add_meta_box( 'pvote-results-meta-box', __( 'Voting Results', 'pvote' ), array( $this, 'pvote_display_voting_results_in_admin' ), 'post', 'normal', 'high' );
	}

	/**
	 * Display voting results in the admin area
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function pvote_display_voting_results_in_admin() {
		global $post;
		$post_id       = $post->ID;
		$voting_result = pvote_get_vote_perentage( $post_id );
		$total_count   = $voting_result['postive_count'] + $voting_result['negative_count'];

		echo '<table class="pvote-table">';
		echo '<tr><th>Total Voting</th><td>' . esc_html( $total_count ) . '</td></tr>';
		echo '<tr><th>Positive</th><td>' . esc_html( $voting_result['postive_count'] ) . ' (' . esc_html( $voting_result['postive_percentage'] ) . '%)</td></tr>';
		echo '<tr><th>Negative</th><td>' . esc_html( $voting_result['negative_count'] ) . ' (' . esc_html( $voting_result['negative_percentage'] ) . '%)</td></tr>';
		echo '</table>';
	}

	/**
	 * Adding Hooks
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function add_hooks() {
		add_action( 'add_meta_boxes', array( $this, 'pvote_voting_results_meta_box' ) );
	}
}
