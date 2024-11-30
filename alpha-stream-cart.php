<?php
/**
 * Plugin Name: StreamCart
 * Description: Transform your WooCommerce store with live-streaming and real-time shopping! StreamCart lets you broadcast directly to Facebook Live, showcase products, and enable viewers to add items to their carts during your live stream—boosting engagement and sales seamlessly.
 * Version: 1.0.0
 * Author: Alpha Add-ons
 * Text Domain: alpha-stream-cart
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 */

defined( 'ABSPATH' ) || exit;

final class StreamCart {
	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Plugin slug.
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	const SLUG = 'alpha-stream-cart';

	/**
	 * Holds various class instances.
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $container = [];

	/**
	 * Constructor for the PluginName class.
	 *
	 * Sets up all the appropriate hooks and actions within our plugin.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		require_once __DIR__ . '/vendor/autoload.php';
		require_once __DIR__ . '/includes/alpha-stream-cart-global-functions.php';
		require_once __DIR__ . '/includes/alpha-stream-cart-global-keys.php';

		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

		add_action( 'wp_loaded', [ $this, 'flush_rewrite_rules' ] );
		$this->init_plugin();
	}

	/**
	 * Initializes the PluginBoilerplate() class.
	 *
	 * Checks for an existing PluginBoilerplate() instance
	 * and if it doesn't find one, creates it.
	 *
	 * @return StreamCart|bool
	 * @since 1.0.0
	 *
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new StreamCart();
		}

		return $instance;
	}

	/**
	 * Magic getter to bypass referencing plugin.
	 *
	 * @param $prop
	 *
	 * @return mixed
	 * @since 1.0.0
	 *
	 */
	public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}

		return $this->{$prop};
	}

	/**
	 * Magic isset to bypass referencing plugin.
	 *
	 * @param $prop
	 *
	 * @return mixed
	 * @since 1.0.0
	 *
	 */
	public function __isset( $prop ) {
		return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
	}

	/**
	 * Define the constants.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function define_constants() {
		define( 'ALPHA_STREAM_CART_VERSION', self::VERSION );
		define( 'ALPHA_STREAM_CART_SLUG', self::SLUG );
		define( 'ALPHA_STREAM_CART_FILE', __FILE__ );
		define( 'ALPHA_STREAM_CART_DIR', __DIR__ );
		define( 'ALPHA_STREAM_CART_PATH', dirname( ALPHA_STREAM_CART_FILE ) );
		define( 'ALPHA_STREAM_CART_INCLUDES', ALPHA_STREAM_CART_PATH . '/includes' );
		define( 'ALPHA_STREAM_CART_TEMPLATE_PATH', ALPHA_STREAM_CART_PATH . '/templates' );
		define( 'ALPHA_STREAM_CART_URL', plugins_url( '', ALPHA_STREAM_CART_FILE ) );
		define( 'ALPHA_STREAM_CART_BUILD', ALPHA_STREAM_CART_URL . '/build' );
		define( 'ALPHA_STREAM_CART_ASSETS', ALPHA_STREAM_CART_URL . '/assets' );
		define( 'ALPHA_STREAM_CART_PRODUCTION', 'yes' );
		define( 'ALPHA_STREAM_CART_SL_STORE_URL', sanitize_url( 'https://rextheme.com/' ) );
		define( 'ALPHA_STREAM_CART_ITEM_ID', '387936' );
		define( 'ALPHA_STREAM_CART_INCLUDES_ASSETS', ALPHA_STREAM_CART_URL . '/includes/Assets' );
	}

	/**
	 * Load the plugin after all plugins are loaded.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function init_plugin() {
		$this->includes();
		$this->init_hooks();

		/**
		 * Fires after the plugin is loaded.
		 *
		 * @since 1.0.0
		 */
		do_action( 'alpha_stream_cart_loaded' );
	}

	/**
	 * Activating the plugin.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function activate() {
		// Run the installer to create necessary migrations.
//        $this->install();
		self::set_stream_cart_activation_transients();
		self::update_stream_cart_version();
		self::update_installed_time();
	}

	/**
	 * Set activation transients.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	private static function set_stream_cart_activation_transients() {
		if ( self::is_new_install() ) {
			set_transient( '_stream_cart_activation_redirect', 1, 30 );
		}
	}

	/**
	 * Check if the plugin is newly installed.
	 *
	 * @return bool
	 * @since 1.0.0
	 *
	 */
	public static function is_new_install() {
		return is_null( get_site_option( 'alpha_stream_cart_version', null ) );
	}

	/**
	 * Update the plugin version.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	private static function update_stream_cart_version() {
		update_site_option( 'alpha_stream_cart_version', ALPHA_STREAM_CART_VERSION );
	}


	/**
	 * Get the time when the plugin was installed.
	 *
	 * @return int
	 * @since 1.0.0
	 *
	 */
	public static function get_installed_time() {
		$installed_time = get_option( 'alpha_stream_cart_installed_time' );
		if ( ! $installed_time ) {
			$installed_time = time();
			update_site_option( 'alpha_stream_cart_installed_time', $installed_time );
		}

		return $installed_time;
	}

	/**
	 * Update the time when the plugin was installed.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public static function update_installed_time() {
		self::get_installed_time();
	}

	/**
	 * Placeholder for deactivation function.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function deactivate() {
		//
	}

	/**
	 * Flush rewrite rules after plugin is activated.
	 *
	 * Nothing being added here yet.
	 *
	 * @since 1.0.0
	 */
	public function flush_rewrite_rules() {
		// fix rewrite rules.
	}

	/**
	 * Run the installer to create necessary migrations and seeders.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	private function install() {
		// Run the installer to create necessary migrations.
	}

	/**
	 * Include the required files.
	 *
	 * @return void
	 * @since 0.2.0
	 *
	 */
	public function includes() {
		if ( $this->is_request( 'admin' ) ) {
			$this->container['admin_menu'] = new Alpha\StreamCart\Admin\Menu();
		}
		$this->container['assets'] = new Alpha\StreamCart\Assets\LoadAssets();
	}

	/**
	 * Initialize the hooks.
	 *
	 * @return void
	 * @since 0.2.0
	 *
	 */
	public function init_hooks() {
		// Init classes
		add_action( 'plugins_loaded', [ $this, 'init_classes' ] );

		// Localize our plugin
		add_action( 'init', [ $this, 'localization_setup' ] );

		// Add the plugin page links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'plugin_action_links' ] );
	}


	/**
	 * Initializes hooks for a given class.
	 *
	 * @param string $class_name The fully qualified class name.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks_for_class( $class_name ) {
		$instance = new $class_name();
		if ( method_exists( $instance, 'init_hooks' ) ) {
			$instance->init_hooks();
		}
	}

	/**
	 * Initializes classes and their hooks dynamically.
	 *
	 * This method is responsible for dynamically creating instances of classes
	 * and calling their respective `init_hooks` methods.
	 *
	 * @since 1.0.0
	 */
	public function init_classes() {
		$classes = array(
			'Alpha\StreamCart\Hooks\ManageStreamCart',
		);
		/**
		 * Filter the class names for dynamic initialization in the rex_dynamic_discount plugin.
		 *
		 * This filter allows developers to modify the array of class names before they are
		 * dynamically instantiated and their hooks are initialized using the `init_hooks_for_class` method.
		 *
		 * @param array $class_names An array of fully qualified class names.
		 *
		 * @return array Modified array of class names.
		 * @since 1.0.0
		 *
		 */
		$class_names = apply_filters( 'alpha_stream_cart_init_classes', $classes );
		foreach ( $class_names as $class_name ) {
			$this->init_hooks_for_class( $class_name );
		}
	}


	/**
	 * Initialize plugin for localization.
	 *
	 * @return void
	 * @since 0.2.0
	 *
	 * @uses load_plugin_textdomain()
	 *
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'alpha-stream-cart', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Load the React-pages translations.
		if ( is_admin() ) {
			// Load wp-script translation for plugin-name-app.
			wp_set_script_translations( 'alpha-stream-cart-app', 'alpha-stream-cart', plugin_dir_path( __FILE__ ) . 'languages/' );
		}
	}

	/**
	 * What type of request is this.
	 *
	 * @param string $type admin, ajax, cron or frontend
	 *
	 * @return bool
	 * @since 0.2.0
	 *
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();

			case 'ajax':
				return defined( 'DOING_AJAX' );

			case 'rest':
				return defined( 'REST_REQUEST' );

			case 'cron':
				return defined( 'DOING_CRON' );

			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Plugin action links
	 *
	 * @param array $links
	 *
	 * @return array
	 * @since 0.2.0
	 *
	 */
	public function plugin_action_links( $links ) {
		$links[] = '<a href="#" target="_blank">' . __( 'Documentation', 'alpha-stream-cart' ) . '</a>';
		$links[] = '<a href="#" target="_blank">' . __( 'Upgrade to Pro', 'alpha-stream-cart' ) . '</a>';

		return $links;
	}
}

/**
 * Declare plugin's compatibility with WooCommerce HPOS
 *
 * @return void
 * @since 1.0.0
 */
function alpha_sc_wc_hpos_compatibility() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__ );
	}
}
add_action( 'before_woocommerce_init', 'alpha_sc_wc_hpos_compatibility' );

/**
 * Initialize the main plugin.
 *
 * @return \StreamCart|bool
 * @since 1.0.0
 *
 */
function the_stream_cart_main_function() {
	return StreamCart::init();
}

/*
 * Kick-off the plugin.
 *
 * @since 1.0.0
 */
the_stream_cart_main_function();