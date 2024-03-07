<?php
/**
 * Template for Voting form
 *
 * @package WordPress Voting Plugin
 */

$has_voted = get_post_meta( $post_id, '_pvote_' . $ip_address, true );
wp_nonce_field( 'pvote_user_vote', 'pvote_submit' );
?>
<div class="voting-form">
	<div class="voting-submit">
		<p><?php esc_html_e( 'Was this article helpful?', 'pvote' ); ?></p>
		<div class="voting-panel">
			<button id="positive" class="vote-button 
			<?php
			if ( 'positive' === $has_voted ) {
				echo 'active';}
			?>
			" data-post-id="<?php the_ID(); ?>" data-vote="positive"><span><img src="<?php echo esc_url( PVOTE_INC_URL . '/images/emoji-smile.svg' ); ?>" width="50"></span><?php esc_html_e( 'Yes', 'pvote' ); ?></button>
			<button id="negative" class="vote-button 
			<?php
			if ( 'negative' === $has_voted ) {
				echo 'active';}
			?>
			" data-post-id="<?php the_ID(); ?>" data-vote="negative"><span><img src="<?php echo esc_url( PVOTE_INC_URL . '/images/emoji-sad.svg' ); ?>" width="50"></span><?php esc_html_e( 'No', 'pvote' ); ?></button>
		</div>
	</div>
	<div class="voting-results 
	<?php
	if ( $has_voted ) {
		echo 'active';}
	?>
	">
		<p><?php esc_html_e( 'Thank you for your feedback.', 'pvote' ); ?></p>
		<div class="voting-panel">
			<label class="positive 
			<?php
			if ( 'positive' === $has_voted ) {
				echo 'active';}
			?>
			"><img src="<?php echo esc_url( PVOTE_INC_URL . '/images/emoji-smile.svg' ); ?>" width="50"><span class="percentage"><?php echo esc_html( $vote_results['postive_percentage'] ) . '%'; ?></span></label>
			<label class="negative 
			<?php
			if ( 'negative' === $has_voted ) {
				echo 'active';}
			?>
			"><img src="<?php echo esc_url( PVOTE_INC_URL . '/images/emoji-sad.svg' ); ?>" width="50"><span class="percentage"><?php echo esc_html( $vote_results['negative_percentage'] ) . '%'; ?></span></label>
		</div>
	</div>
</div>
