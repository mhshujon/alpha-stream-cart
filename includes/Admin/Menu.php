<?php

namespace Alpha\StreamCart\Admin;

class Menu {

	/**
	 * Admin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'init_menu' ] );
	}


	/**
	 * Init menu
	 *
	 * @since 1.0.0
	 */
	public function init_menu() {
		global $submenu;

		$slug          = ALPHA_STREAM_CART_SLUG;
		$menu_position = 50;
		$capability    = 'manage_options';

		add_menu_page( esc_attr__( 'StreamCart', 'alpha-stream-cart' ), esc_attr__( 'StreamCart', 'alpha-stream-cart' ), $capability, $slug, [ $this, 'plugin_page' ], '', $menu_position );

		if ( current_user_can( $capability ) ) {
			$submenu[ $slug ][] = [ esc_attr__( 'Streams', 'alpha-stream-cart' ), $capability, 'admin.php?page=' . $slug . '#/' ]; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}
	}


	/**
	 * Render the plugin page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function plugin_page() {
		require_once ALPHA_STREAM_CART_TEMPLATE_PATH . '/app.php';
	}
}