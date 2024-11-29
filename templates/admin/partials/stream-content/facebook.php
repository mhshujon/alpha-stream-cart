<!-- Accordion Item 1 -->
<div class="accordion-item">
	<div class="accordion-header">
		<span><?php _e('Facebook Credentials', 'alpha-stream-cart'); ?></span>
	</div>
	<div class="accordion-content">
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
	</div>
</div>