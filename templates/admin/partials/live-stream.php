<div id="alpha-live-stream" class="tab-pane">
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