<?php

namespace Alpha\StreamCart\Assets;

/**
 * Load assets class
 *
 * Responsible for managing all of the assets (CSS, JS, Images, Locales).
 */
class LoadAssets {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_all_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
	}

	/**
	 * Register all scripts and styles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_all_scripts() {
		$this->register_styles( $this->get_styles() );
		$this->register_scripts( $this->get_scripts() );
	}

	/**
	 * Get all styles.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_styles(): array {
		return [
			'alpha-stream-cart-css' => [
				'src'     => ALPHA_STREAM_CART_ASSETS . '/css/admin.css',
				'version' => ALPHA_STREAM_CART_VERSION,
				'deps'    => [],
			],
		];
	}

	/**
	 * Get all scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_scripts(): array {
		return [
			'alpha-stream-cart-app' => [
				'src'       => ALPHA_STREAM_CART_ASSETS . '/js/admin.js',
				'version'   => ALPHA_STREAM_CART_VERSION,
				'deps'      => [ 'wp-i18n', 'jquery' ],
				'in_footer' => true,
			],
			'alpha-stream-cart-rtmp-app' => [
//				'src'       => ALPHA_STREAM_CART_ASSETS . '/js/lib/rtmp.js',
				'src'       => 'https://cdn.jsdelivr.net/npm/rtmp-rtsp-stream-client-js@latest/dist/rtmp-rtsp-stream-client.min.js',
				'version'   => ALPHA_STREAM_CART_VERSION,
				'deps'      => [ 'wp-i18n', 'jquery' ],
				'in_footer' => true,
			],
			'alpha-stream-cart-stream-app' => [
				'src'       => ALPHA_STREAM_CART_ASSETS . '/js/stream.js',
				'version'   => ALPHA_STREAM_CART_VERSION,
				'deps'      => [ 'wp-i18n', 'jquery' ],
				'in_footer' => true,
			],
		];
	}

	/**
	 * Register styles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_styles( array $styles ) {
		foreach ( $styles as $handle => $style ) {
			wp_register_style( $handle, $style['src'], $style['deps'], $style['version'] );
		}
	}

	/**
	 * Register scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_scripts( array $scripts ) {
		foreach ( $scripts as $handle =>$script ) {
			wp_register_script( $handle, $script['src'], $script['deps'], $script['version'], $script['in_footer'] );
		}
	}

	/**
	 * Enqueue admin styles and scripts.
	 *
	 * @since 1.0.0
	 * @since 0.3.0 Loads the JS and CSS only on the Dynamic Discount admin page.
	 *
	 * @return void
	 */
	public function enqueue_admin_assets() {
		if ( ! is_admin() || ! isset( $_GET['page'] ) || sanitize_text_field( wp_unslash( $_GET['page'] ) ) !== 'alpha-stream-cart' ) {
			return;
		}

		wp_enqueue_style( 'alpha-stream-cart-css' );
		wp_enqueue_script( 'alpha-stream-cart-app' );
		wp_enqueue_script( 'alpha-stream-cart-stream-app' );
		wp_enqueue_script( 'alpha-stream-cart-rtmp-app' );

		$this->enqueue_localized_scripts();
	}

	/**
	 * Enqueue localized scripts.
	 *
	 * Localizes the script with data for use in the JavaScript file.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function enqueue_localized_scripts() {
		wp_localize_script(
			'alpha-stream-cart-app',
			'alphaStreamCartVars',
			[
				'ajaxNonce' => wp_create_nonce( 'alpha_stream_cart_nonce' )
			]
		);
	}
}
