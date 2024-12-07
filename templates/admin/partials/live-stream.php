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

    <?php
    // Define the RTMP URL
//    $rtmp_url = "rtmps://live-api-s.facebook.com:443/rtmp/8857978674248493?s_bc=1&s_bed=1&s_bl=1&s_bsr=1&s_psm=1&s_pub=1&s_sw=0&s_tids=1&s_vt=api-s&a=AbyB_Qnp3g6doaNl";
//
//    // Define the command to run
//    $command = '/opt/homebrew/bin/ffmpeg -f avfoundation -framerate 30 -i "0:0" -c:v libx264 -preset veryfast -b:v 3000k -maxrate 3000k -bufsize 6000k -c:a aac -ar 44100 -b:a 128k -f flv "' . $rtmp_url . '"';
//    $command = escapeshellcmd('../../../../../uploads/bin/ffmpeg/ffmpeg' . ' -version');
////    $output = shell_exec($command);
//    $output = shell_exec('ls');
//    exec( ALPHA_STREAM_CART_DIR . '/bin/ffmpeg/ffmpeg -version', $output, $return_var);
//    error_log(print_r(is_executable(ALPHA_STREAM_CART_DIR . '/bin/ffmpeg/ffmpeg' ), 1));
//    error_log(print_r(ini_get('disable_functions'), 1));
//    error_log(print_r($output, 1));
//    error_log(print_r($return_var, 1));
    // Execute the command
//    exec($command, $output, $return_var);
//    error_log(print_r($return_var, 1));
//    error_log(print_r($output, 1));

    //     Output results
    echo "<pre>";
//    print_r($output);
    echo "</pre>";
    ?>
</div>

<div id="video-container">
    <video id="local-video" autoplay muted></video>
    <button id="start-streaming">Start Streaming</button>
    <button id="stop-streaming">Stop Streaming</button>
</div>