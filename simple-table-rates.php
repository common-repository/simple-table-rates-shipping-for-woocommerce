<?php
/**
 * The plugin bootstrap file
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Table Rates Shipping For WooCommerce
 * Plugin URI:        https://wordpress.org/plugin/simple-table-rates-shipping-for-woocommerce
 * Description:       The easiest way to add table rates shipping to your WooCommerce store.
 * Version:           1.0.7
 * Requires PHP:      7.0
 * Requires at least: 4.0
 * Tested up to:      6.4
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-table-rates
 * Domain Path:       /languages
 */

namespace WPRuby_Str;

use WPRuby_Str\Core\Core;

if ( ! defined( 'WPINC' ) ) {
	die;
}


class WPRuby_Simple_Table_Rates {

	protected static $_instance = null;

	/**
	 * @return self
	 */
	public static function get_instance()
	{
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct()
	{
		Core::get_instance();
	}
}

register_activation_hook( __FILE__, function () {
	$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
	$pro_slug = 'woocommerce-simple-table-rates-pro/simple-table-rates-pro.php';
	if (in_array($pro_slug, $active_plugins)) {
		deactivate_plugins($pro_slug);
	}
} );

add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );

require_once dirname(__FILE__ ) . '/includes/autoloader.php';

WPRuby_Simple_Table_Rates::get_instance();
