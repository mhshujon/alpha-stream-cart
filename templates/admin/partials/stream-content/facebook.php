<?php
$app_id           = get_option( ALPHA_STREAM_CART_FB_APP_ID );
$app_secret       = get_option( ALPHA_STREAM_CART_FB_APP_ID );
$ready_to_connect = ! empty( $app_id ) && ! empty( $app_secret );
$is_authorized    = get_option( ALPHA_STREAM_CART_FB_ACCESS_TOKEN );
$auth_btn_text    = $is_authorized ? __( 'CONNECTED', 'alpha-stream-cart' ) : __( 'CONNECT', 'alpha-stream-cart' );
?>

<!-- Accordion Item 1 -->
<div class="accordion-item">
	<div class="accordion-header">
		<span><?php echo $channel[ 'title' ] . ' ' . __('Credentials', 'alpha-stream-cart'); ?></span>
        <?php if ( $ready_to_connect ):?>
        <a href="https://google.com/" class="connect-btn <?php echo $is_authorized ? '' : 'not-connected'?>">
            <?php echo $auth_btn_text;?>
        </a>
        <?php endif;?>
        <span class="accordion-icon"><?php echo ALPHA_STREAM_CART_ARROW_ICON;?></span> <!-- Right-pointing arrow (▶) -->
	</div>
	<div class="accordion-content">
		<table class="form-table">
			<tr>
				<th>
                    <label for=<?php echo ALPHA_STREAM_CART_FB_APP_ID;?>><?php _e('App ID', 'alpha-stream-cart'); ?></label>
                </th>
				<td>
					<input type="text" id=<?php echo ALPHA_STREAM_CART_FB_APP_ID;?> name=<?php echo ALPHA_STREAM_CART_FB_APP_ID;?>
					       value="<?php echo esc_attr( $app_id ); ?>" />
				</td>
			</tr>
			<tr>
				<th>
                    <label for=<?php echo ALPHA_STREAM_CART_FB_APP_SECRET;?>><?php _e('App Secret', 'alpha-stream-cart'); ?></label>
                </th>
				<td>
					<input type="password" id=<?php echo ALPHA_STREAM_CART_FB_APP_SECRET;?> name=<?php echo ALPHA_STREAM_CART_FB_APP_SECRET;?>
					       value="<?php echo esc_attr( $app_secret ); ?>" />
				</td>
			</tr>
		</table>
	</div>
</div>