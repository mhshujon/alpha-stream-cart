<?php
$app_id           = get_option( 'alpha_stream_cart_fb_app_id' );
$app_secret       = get_option( 'alpha_stream_cart_fb_app_secret' );
$ready_to_connect = ! empty( $app_id ) && ! empty( $app_secret );
$is_authorized    = get_option( 'alpha_stream_cart_fb_access_token' );
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
                    <label for="fb_app_id"><?php _e('App ID', 'alpha-stream-cart'); ?></label>
                </th>
				<td>
					<input type="text" id="fb_app_id" name="fb_app_id"
					       value="<?php echo esc_attr( $app_id ); ?>" />
				</td>
			</tr>
			<tr>
				<th>
                    <label for="fb_app_secret"><?php _e('App Secret', 'alpha-stream-cart'); ?></label>
                </th>
				<td>
					<input type="password" id="fb_app_secret" name="fb_app_secret"
					       value="<?php echo esc_attr( $app_secret ); ?>" />
				</td>
			</tr>
		</table>
	</div>
</div>