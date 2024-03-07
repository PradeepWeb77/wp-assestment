<?php
/**
 * Handles front functionality.
 *
 * @package WordPress Voting Plugin
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Public Class
 */
class Pvote_Public {

	/**
	 * Add voting form at the end of single post
	 *
	 * @param string $content post content.
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function pvote_add_voting_form_to_post_content( $content ) {

		if ( is_single() ) {
			global $post;
			$post_id      = $post->ID;
			$ip_address   = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
			$vote_results = pvote_get_vote_perentage( $post_id );
			ob_start();
			include PVOTE_DIR . '/includes/templates/voting-form.php';
			$voting_form = ob_get_clean();
			$content    .= $voting_form;
		}

		return $content;
	}

	/**
	 * Ajax callback handle to store user vote
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function pvote_submit_vote() {
		$response = array();

		if ( isset( $_POST['pvote_submit'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pvote_submit'] ) ), 'pvote_user_vote' ) ) {
			return;
		}

		if ( ! isset( $_POST['vote'] ) || ! in_array( $_POST['vote'], array( 'positive', 'negative' ) ) ) {
			$response['error'] = 'Invalid vote';
		} else {
			$post_id    = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : '';
			$vote       = isset( $_POST['vote'] ) ? sanitize_text_field( wp_unslash( $_POST['vote'] ) ) : '';
			$ip_address = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

			// Check if the user has already voted for this post.
			$has_voted = get_post_meta( $post_id, '_pvote_' . $ip_address, true );

			if ( ! $has_voted ) {
				// Update the vote count.
				$current_count = get_post_meta( $post_id, '_pvote_' . $vote, true );
				update_post_meta( $post_id, '_pvote_' . $vote, (int) $current_count + 1 );

				// Mark that the user has voted.
				update_post_meta( $post_id, '_pvote_' . $ip_address, $vote );
				$vote_results = pvote_get_vote_perentage( $post_id );

				$response['success']                = esc_html__( 'Vote submitted successfully', 'pvote' );
				$response['percentage']['positive'] = $vote_results['postive_percentage'] . '%';
				$response['percentage']['negative'] = $vote_results['negative_percentage'] . '%';
			} else {
				$response['error'] = esc_html__( 'You have already voted for this post', 'pvote' );
			}
		}

		echo wp_json_encode( $response );
		wp_die();
	}

	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the front side.
	 *
	 * @package WordPress Voting Plugin
	 * @since 1.0.0
	 */
	public function add_hooks() {
		add_filter( 'the_content', array( $this, 'pvote_add_voting_form_to_post_content' ) );
		add_action( 'wp_ajax_pvote_submit_vote', array( $this, 'pvote_submit_vote' ) );
		add_action( 'wp_ajax_nopriv_pvote_submit_vote', array( $this, 'pvote_submit_vote' ) );
	}
}
