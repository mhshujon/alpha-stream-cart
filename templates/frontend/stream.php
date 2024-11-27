<?php if (!defined('ABSPATH')) exit; ?>

<div class="streamcart-container">
    <div class="stream-section">
        <div id="facebook-stream"></div>
        <div class="stream-info">
            <span class="viewer-count">👥 <span id="viewers">0</span></span>
            <span class="like-count">❤️ <span id="likes">0</span></span>
        </div>
    </div>

    <div class="products-section">
        <h3><?php _e('Featured Products', 'streamcart'); ?></h3>
        <div id="stream-products"></div>
    </div>

    <div class="comments-section">
        <h3><?php _e('Live Comments', 'streamcart'); ?></h3>
        <div id="stream-comments"></div>
    </div>

    <div class="streamcart-branding">
        <?php _e('Powered by StreamCart', 'streamcart'); ?>
    </div>
</div>