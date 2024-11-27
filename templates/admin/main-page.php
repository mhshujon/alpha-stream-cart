<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap streamcart-admin">
    <h1><?php _e('StreamCart Dashboard', 'streamcart'); ?></h1>

    <div class="streamcart-tabs">
        <nav class="nav-tab-wrapper">
            <a href="#stream" class="nav-tab nav-tab-active"><?php _e('Live Stream', 'streamcart'); ?></a>
            <a href="#products" class="nav-tab"><?php _e('Products', 'streamcart'); ?></a>
            <a href="#settings" class="nav-tab"><?php _e('Settings', 'streamcart'); ?></a>
        </nav>

        <div class="tab-content">
            <div id="stream" class="tab-pane active">
                <div class="stream-controls">
                    <button class="button button-primary" id="start-stream">
                        <?php _e('Start Stream', 'streamcart'); ?>
                    </button>
                    <button class="button" id="stop-stream" disabled>
                        <?php _e('Stop Stream', 'streamcart'); ?>
                    </button>
                </div>

                <div class="stream-preview">
                    <div id="video-preview"></div>
                    <div class="stream-stats">
                        <span class="viewers">👥 <span id="viewer-count">0</span></span>
                        <span class="likes">❤️ <span id="like-count">0</span></span>
                    </div>
                </div>
            </div>

            <div id="products" class="tab-pane">
                <h2><?php _e('Select Products for Stream', 'streamcart'); ?></h2>
                <div id="product-list"></div>
            </div>

            <div id="settings" class="tab-pane">
                <form id="streamcart-settings">
                    <h2><?php _e('Facebook Integration', 'streamcart'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><label for="fb_app_id"><?php _e('App ID', 'streamcart'); ?></label></th>
                            <td>
                                <input type="text" id="fb_app_id" name="fb_app_id" 
                                    value="<?php echo esc_attr(get_option('streamcart_fb_app_id')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th><label for="fb_app_secret"><?php _e('App Secret', 'streamcart'); ?></label></th>
                            <td>
                                <input type="password" id="fb_app_secret" name="fb_app_secret" 
                                    value="<?php echo esc_attr(get_option('streamcart_fb_app_secret')); ?>" />
                            </td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
        </div>
    </div>
</div>