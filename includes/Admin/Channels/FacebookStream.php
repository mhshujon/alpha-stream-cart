<?php

namespace Alpha\StreamCart\Admin\Channels;

class FacebookStream extends AbstractStream {

	/**
	 * The version of the Facebook Graph API to use.
	 *
	 * @var string $graph_version The version of the Facebook Graph API to use.
	 * @since 1.0.0
	 */
	private string $graph_version = 'v21.0';

	/**
	 * Get the authentication URL for the stream.
	 *
	 * @return string The authentication URL.
	 *
	 * @since 1.0.0
	 */
	public function get_auth_url(): string {
		$scopes       = [
			'email',
			'public_profile',
			'publish_video',
			'pages_manage_metadata',
			'pages_read_engagement',
			'pages_manage_posts'
		];
		$query_params = [
			'client_id'    => get_option( ALPHA_STREAM_CART_FB_APP_ID ),
			'redirect_uri' => alpha_sc_get_redirect_url(),
			'scope'        => implode( ',', $scopes ),
			'state'        => 'facebook'
		];
		return $this->prepare_auth_url( "https://www.facebook.com/{$this->graph_version}/dialog/oauth", $query_params );
	}

	/**
	 * Generate access token.
	 *
	 * This method generates a new Facebook API access token using the provided authorization code.
	 * It sends a request to the Facebook API token endpoint with the required parameters.
	 * If the request is successful, the new access token is saved in the WordPress options table.
	 *
	 * @param string $code The authorization code.
	 *
	 * @since 1.0.0
	 */
	public function generate_access_token( string $code ): void {
		$token_url = "https://graph.facebook.com/{$this->graph_version}/oauth/access_token";
		$params = [
			'client_id'     => get_option( ALPHA_STREAM_CART_FB_APP_ID ),
			'client_secret' => get_option( ALPHA_STREAM_CART_FB_APP_SECRET ),
			'redirect_uri'  => alpha_sc_get_redirect_url(),
			'code'          => $code,
		];

		$response = $this->make_request( 'POST', $token_url, [
			'body' => http_build_query( $params ),
		] );

		if ( !empty( $response[ 'error' ][ 'type'] ) && !empty( $response[ 'error' ][ 'message' ] ) ) {
			$this->show_error_notice( $response[ 'error' ][ 'type'], $response[ 'error' ][ 'message'] );
		}

		if ( ! empty( $response['access_token'] ) && ! is_wp_error( $response ) ) {
			$this->save_access_token( $response );
		}
	}

	/**
	 * Regenerate access token.
	 *
	 * This method regenerates the Facebook API access token using the previous access token.
	 * It sends a request to the Facebook API token endpoint with the required parameters.
	 * If the request is successful, the new access token is saved in the WordPress options table.
	 *
	 * @param string $prev_access_token The previous access token.
	 *
	 * @since 1.0.0
	 */
	public function regenerate_access_token( string $prev_access_token ): void {
		$token_url = "https://graph.facebook.com/{$this->graph_version}/oauth/access_token";
		$params = [
			'grant_type'        => 'fb_exchange_token',
			'client_id'         => get_option( ALPHA_STREAM_CART_FB_APP_ID ),
			'client_secret'     => get_option( ALPHA_STREAM_CART_FB_APP_SECRET ),
			'fb_exchange_token' => $prev_access_token,
		];

		$response = $this->make_request( 'GET', $token_url, [
			'body' => http_build_query( $params ),
		] );

		if ( !empty( $response[ 'error' ][ 'type'] ) && !empty( $response[ 'error' ][ 'message' ] ) ) {
			$this->show_error_notice( $response[ 'error' ][ 'type'], $response[ 'error' ][ 'message'] );
		}

		if ( ! empty( $response['access_token'] ) && ! is_wp_error( $response ) ) {
			$this->save_access_token( $response );
		}
	}

	/**
	 * Get the access token data.
	 *
	 * This method retrieves the access token data from the WordPress options table.
	 *
	 * @return array The access token data.
	 *
	 * @since 1.0.0
	 */
	public function get_access_token(): array {
		$access_token_data = get_option( ALPHA_STREAM_CART_FB_ACCESS_TOKEN );
		if ( empty( $access_token_data ) ) {
			return [];
		}
		return json_decode( $access_token_data, true );
	}

	/**
	 * Check if the client is authorized.
	 *
	 * This method checks if the client has a valid access token.
	 *
	 * @return bool `true` if the client is authorized, `false` otherwise.
	 *
	 * @since 1.0.0
	 */
	public function is_authorized(): bool {
		$access_token_data = $this->get_access_token();
		if ( empty( $access_token_data['access_token'] ) || empty( $access_token_data['expires_in'] ) || empty( $access_token_data['token_received_time'] ) ) {
			return false;
		}

		$expires_in          = (int) $access_token_data['expires_in'];
		$token_received_time = (int) $access_token_data['token_received_time'];
		$expiration_time     = $token_received_time + $expires_in;
		$current_time        = time();

		return $current_time < $expiration_time;
	}

	/**
	 * Start the stream.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function start_stream(): void {
		$access_token = $this->get_access_token()['access_token'] ?? '';
		if (empty($access_token)) {
			$this->show_error_notice('Access Token Error', 'Access token is missing or invalid.');
			return;
		}

//		$stream_url = "https://graph.facebook.com/{$this->graph_version}/114255370443203/live_videos";
		$stream_url = "https://graph.facebook.com/{$this->graph_version}/114255370443203/live_videos";
		$params = [
			'title'        => 'Live Stream Title', // Replace with your stream title
			'description'  => 'Live Stream Description', // Replace with your stream description
			'status'       => 'LIVE_NOW',
			'privacy'      => [ 'value' => 'EVERYONE' ]
		];

		$response = $this->make_request(
			'POST',
			$stream_url,
			[ 'body' => json_encode( $params ) ],
			[ 'Authorization' => "Bearer EAA6djIofNuQBOzfrmcvhkNccq3IkNRWNkWLIGWs9NwS1PeVK32DtFI7ZAfwMdib57NZAcIAAKamBwkc6cjDbPwxIwD8uRtAFLqZB9pnEr45Ey98y5HXaeUcd907X92ilosYeA2AIL2T3t0SB4ZBnmgYGvUcthfBQQBQNbKI2LetVvYhrvht6oTZAftbHOFHgZD" , 'Content-Type' => 'application/json' ]
		);
//
		error_log(print_r($response, true));
//
		wp_die();

		// Parse the stream key from the stream URL
		$parsed_url = parse_url('rtmps://live-api-s.facebook.com:443/rtmp/8866582423388118?s_bc=1&s_bed=1&s_bl=1&s_bsr=1&s_psm=1&s_pub=1&s_sw=0&s_tids=1&s_vt=api-s&a=AbwaokmMvedkowFO');
		$path = $parsed_url['path'] ?? '';
		$segments = explode('/', $path);
		error_log(print_r($segments, true));

		if (!empty($response['error']['type']) && !empty($response['error']['message'])) {
			$this->show_error_notice($response['error']['type'], $response['error']['message']);
			return;
		}

		if (!empty($response['id'])) {
			update_option('alpha_stream_cart_fb_live_video_id', $response['id']);
//			$this->show_success_notice('Live Stream Started', 'Your live stream has started successfully.');
		} else {
			$this->show_error_notice('Live Stream Error', 'Failed to start the live stream.');
		}
	}

}