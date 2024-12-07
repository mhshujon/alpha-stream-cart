<?php

namespace Alpha\StreamCart\Admin\Channels;

use WP_Error;

/**
 * Abstract Stream class.
 *
 * This class provides an abstract class for stream classes.
 *
 * @since 1.0.0
 */
abstract class AbstractStream {

	/**
	 * Display an error notice.
	 *
	 * This method displays an error notice in the WordPress admin area.
	 *
	 * @param string|int $error_code The error code.
	 * @param string $error_message The error message.
	 *
	 * @since 1.0.0
	 */
	protected function show_error_notice( string|int $error_code, string $error_message ): void {
		echo sprintf( '<div class="alpha-stream-cart-notice notice notice-error is-dismissible"><p>%s : %s</p></div>', $error_code, $error_message );
	}

	/**
	 * Make request.
	 *
	 * This method sends a request to the specified URL with the provided parameters and headers.
	 *
	 * @param string $method The request method.
	 * @param string $url The request URL.
	 * @param array $params The request parameters.
	 * @param array $headers The request headers.
	 *
	 * @return string|array|WP_Error The response body or WP_Error object.
	 *
	 * @since 1.0.0
	 */
	public function make_request( string $method, string $url, array $params, array $headers = [ 'Content-Type' => 'application/x-www-form-urlencoded' ] ): WP_Error|array|string {
		$params = array_merge( [
			'method'  => $method,
			'headers' => $headers,
		], $params );


		$response = wp_remote_request( sanitize_url( $url ), $params );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$response_body    = wp_remote_retrieve_body( $response );
		$decoded_response = json_decode( $response_body, true );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return new WP_Error( 'json_decode_error',
				'Failed to decode JSON response',
				[ 'response_body' => $response_body ],
			);
		}

		return $decoded_response;
	}

	/**
	 * Get authorization URL.
	 *
	 * This method constructs the authorization URL with the provided base URL and query parameters.
	 *
	 * @param string $url The base URL.
	 * @param array $query_params The query parameters to append to the URL.
	 *
	 * @return string The constructed authorization URL.
	 *
	 * @since 1.0.0
	 */
	public function prepare_auth_url( string $url, array $query_params ): string {
		return sanitize_url( $url ) . '?' . http_build_query( $query_params );
	}

	/**
	 * Save access token.
	 *
	 * This method saves the access token data. If the refresh token is not present in the provided token data,
	 * it attempts to retrieve the existing refresh token from the stored access token data and includes it.
	 * It also records the current time as the token received time.
	 *
	 * @param array $token_data The access token data to save.
	 *
	 * @since 1.0.0
	 */
	public function save_access_token( array $token_data ): void {
		$token_data['token_received_time'] = time();
		update_option( ALPHA_STREAM_CART_FB_ACCESS_TOKEN, wp_json_encode( $token_data ) );
	}

	/**
	 * Get the authentication URL for the stream.
	 *
	 * @return string The authentication URL.
	 *
	 * @since 1.0.0
	 */
	abstract public function get_auth_url(): string;

	/**
	 * Start the stream.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	abstract public function start_stream(): void;

	/**
	 * Generate access token.
	 *
	 * This method generates the access token using the provided authorization code.
	 * It sends a request to the Facebook API token endpoint with the required parameters.
	 * If the request is successful, the access token is saved in the WordPress options table.
	 *
	 * @param string $code The authorization code.
	 *
	 * @since 1.0.0
	 */
	abstract public function generate_access_token( string $code ): void;

	/**
	 * Regenerate access token.
	 *
	 * This method regenerates the access token using the previous access token.
	 * It sends a request to the Facebook API token endpoint with the required parameters.
	 * If the request is successful, the new access token is saved in the WordPress options table.
	 *
	 * @param string $prev_access_token The previous access token.
	 *
	 * @since 1.0.0
	 */
	abstract public function regenerate_access_token( string $prev_access_token ): void;

	/**
	 * Check if the user is authorized.
	 *
	 * @return bool True if the user is authorized, false otherwise.
	 *
	 * @since 1.0.0
	 */
	abstract public function is_authorized(): bool;

	/**
	 * Get the access token.
	 *
	 * This method retrieves the access token data.
	 * The access token data contains the access token, the expiration time, and the time the token was received.
	 *
	 * @return array
	 */
	abstract public function get_access_token(): array;
}