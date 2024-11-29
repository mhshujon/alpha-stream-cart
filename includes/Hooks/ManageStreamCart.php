<?php

namespace Alpha\StreamCart\Hooks;

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
}
