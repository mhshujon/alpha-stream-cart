<?php
if (!defined('ABSPATH')) exit;

$slug = ALPHA_STREAM_CART_SLUG;

$tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
?>

<div class="wrap alpha-streamcart-admin">
    <h1><?php _e('StreamCart Dashboard', 'alpha-stream-cart'); ?></h1>

    <div class="streamcart-tabs">
        <nav class="nav-tab-wrapper">
            <a href="<?php echo esc_url( admin_url( "admin.php?page={$slug}&tab=dashboard" ) ) ?>"
               class="nav-tab <?php echo 'dashboard' === $tab || empty( $tab ) ? 'nav-tab-active' : ''; ?>"
            >
                <?php _e( 'Live Stream', 'alpha-stream-cart' ); ?>
            </a>
            <a href="<?php echo esc_url( admin_url( "admin.php?page={$slug}&tab=products" ) ) ?>"
               class="nav-tab <?php echo 'products' === $tab ? 'nav-tab-active' : ''; ?>"
            >
                <?php _e( 'Products', 'alpha-stream-cart' ); ?>
            </a>
            <a href="<?php echo esc_url( admin_url( "admin.php?page={$slug}&tab=settings" ) ) ?>"
               class="nav-tab <?php echo 'settings' === $tab ? 'nav-tab-active' : ''; ?>"
            >
                <?php _e( 'Settings', 'alpha-stream-cart' ); ?>
            </a>
        </nav>

        <div class="tab-content">
            <div id="stream" class="tab-pane active">
                <div class="stream-controls">
                    <button class="button button-primary" id="start-stream">
                        <?php _e('Start Stream', 'alpha-stream-cart'); ?>
                    </button>
                    <button class="button" id="stop-stream" disabled>
                        <?php _e('Stop Stream', 'alpha-stream-cart'); ?>
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
                <h2><?php _e('Select Products for Stream', 'alpha-stream-cart'); ?></h2>
                <div id="product-list"></div>
            </div>

            <div id="settings" class="tab-pane">
                <form id="streamcart-settings">
                    <h2><?php _e('Facebook Integration', 'alpha-stream-cart'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><label for="fb_app_id"><?php _e('App ID', 'alpha-stream-cart'); ?></label></th>
                            <td>
                                <input type="text" id="fb_app_id" name="fb_app_id" 
                                    value="<?php echo esc_attr(get_option('streamcart_fb_app_id')); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th><label for="fb_app_secret"><?php _e('App Secret', 'alpha-stream-cart'); ?></label></th>
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