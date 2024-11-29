<?php
$stream_channels = [
	'facebook', 'youtube', 'twitch', 'periscope'
];
?>

<div id="alpha-stream-connect" class="tab-pane">
    <form id="alpha-stream-connect-settings">
        <h2><?php _e('Stream Channels', 'alpha-stream-cart'); ?></h2>

        <!-- Accordion Container -->
        <div class="accordion">
            <?php foreach ($stream_channels as $channel):?>
            <?php if ( file_exists( ALPHA_STREAM_CART_TEMPLATE_PATH . "/admin/partials/stream-content/{$channel}.php" ) ):?>
            <?php include_once("stream-content/{$channel}.php");?>
            <?php endif;?>
            <?php endforeach;?>
        </div>

        <!-- Submit Button -->
		<?php submit_button(); ?>
    </form>
</div>
