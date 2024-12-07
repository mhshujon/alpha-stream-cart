<?php

namespace Alpha\StreamCart\Hooks;

use Alpha\StreamCart\Admin\Channels\FacebookStream;

/**
 * Class ManageStreamCart
 *
 * This class manages hooks and actions in the WordPress admin panel for Stream Cart.
 *
 * @since 1.0.0
 */
class ManageStreamCart {
	/**
	 * ManageStreamCart constructor.
	 *
	 * Adds the action to render the premium feature modal in the admin head.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_head', [ $this, 'render_premium_feature_modal' ] );
		add_action( 'wp_ajax_alpha_sc_save_channels_credentials', [ $this, 'save_channels_credentials' ] );
		add_action( 'wp_ajax_alpha_sc_initialize_stream', [ $this, 'initialize_stream' ] );
	}

	/**
	 * Renders the modal for premium features.
	 *
	 * This function outputs the HTML for a modal that informs users about
	 * upcoming premium features.
	 *
	 * @since 1.0.0
	 */
	public function render_premium_feature_modal() {
		?>
        <div class="alpha-stream-cart premium-feat-modal-overlay"></div>
        <div class="alpha-stream-cart premium-feat-modal">
            <div class="premium-feat-modal-header">
                <span>Premium Feature</span>
                <button class="premium-feat-modal-close">&times;</button>
            </div>
            <div class="premium-feat-modal-content">
                <p><?php _e( "Our premium feature is on the way! Check back soon for details on how you can access it once it's live.", 'alpha-stream-cart' );?></p>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button class="btn-secondary modal-close">-->
<!--                    --><?php //_e( 'Cancel', 'alpha-stream-cart' );?>
<!--                </button>-->
<!--                <button class="btn-primary">-->
<!--	                --><?php //_e( 'Get Pro', 'alpha-stream-cart' );?>
<!--                </button>-->
<!--            </div>-->
        </div>
		<?php
	}

	/**
	 * Handles the AJAX request to save channel credentials.
	 *
	 * This function verifies the nonce, parses the form data, and updates the
	 * WordPress options with the provided credentials.
	 *
	 * @since 1.0.0
	 */
	public function save_channels_credentials() {
		$nonce_verified = check_ajax_referer( 'alpha_stream_cart_nonce', '_alpha_stream_cart_nonce', false );
		if ( ! $nonce_verified ) {
			wp_send_json_error( [ 'message' => __( 'Request verification failed. Please try again.', 'alpha-stream-cart' ) ] );
			wp_die();
		}

		wp_parse_str( filter_input( INPUT_POST, 'form_data' ), $form_data );

		foreach ( $form_data as $key => $value ) {
			if ( preg_match( '/^alpha_stream_cart_/', $key ) ) {
				update_option( $key, htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' ) );
			}
		}

		wp_send_json_success( [ 'message' => __( 'Credentials saved successfully.', 'alpha-stream-cart' ) ] );
		wp_die();
	}

    public function initialize_stream() {
        $stream = new FacebookStream();
        $stream->start_stream();
    }
}
