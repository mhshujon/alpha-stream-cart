<?php
if (!defined('ABSPATH')) exit;

$slug = ALPHA_STREAM_CART_SLUG;

$tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$tab = !empty( $tab ) ? $tab : 'live-stream';
?>

<div class="wrap alpha-streamcart-admin">
    <h1><?php _e('StreamCart Dashboard', 'alpha-stream-cart'); ?></h1>

    <div class="alpha-streamcart-tabs">
        <nav class="nav-tab-wrapper">
            <a href="<?php echo esc_url( admin_url( "admin.php?page={$slug}&tab=live-stream" ) ) ?>"
               class="nav-tab <?php echo 'live-stream' === $tab ? 'nav-tab-active' : ''; ?>"
            >
                <?php _e( 'Live Stream', 'alpha-stream-cart' ); ?>
            </a>
            <a href="<?php echo esc_url( admin_url( "admin.php?page={$slug}&tab=stream-connect" ) ) ?>"
               class="nav-tab <?php echo 'stream-connect' === $tab ? 'nav-tab-active' : ''; ?>"
            >
                <?php _e( 'Stream Connect', 'alpha-stream-cart' ); ?>
            </a>
        </nav>

        <div class="tab-content">
            <?php include_once( "partials/{$tab}.php" ); ?>
        </div>
    </div>
</div>