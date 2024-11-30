<?php
$stream_channels = function_exists( 'alpha_sc_get_channels' ) ? alpha_sc_get_channels() : [];
?>

<div id="alpha-stream-connect" class="tab-pane">
    <form id="alpha-stream-channel-settings" method="post">
        <h2><?php _e('Stream Channels', 'alpha-stream-cart'); ?></h2>

        <!-- Accordion Container -->
        <div class="accordion">
	        <?php
	        if ( is_array( $stream_channels ) && !empty( $stream_channels ) ) {
		        foreach ( $stream_channels as $channel ) {
			        $template = !empty( $channel[ 'title' ] ) ? strtolower( $channel[ 'title' ] ) : '';
			        if ( !$channel[ 'is_pro' ] ) {
				        $file_path = ALPHA_STREAM_CART_TEMPLATE_PATH . "/admin/partials/stream-content/{$template}.php";
			        } else {
				        $file_path = apply_filters(
					        'alpha-stream-cart/premium-channel-templates',
					        ALPHA_STREAM_CART_TEMPLATE_PATH . "/admin/partials/stream-content/premium-channels.php"
				        );
			        }
			        if ( file_exists( $file_path ) ) {
				        include( $file_path );
			        }
		        }
	        }
	        ?>
        </div>

        <!-- Submit Button -->
		<?php submit_button(); ?>
    </form>
</div>
