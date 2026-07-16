<?php
/**
 * Plugin Name: VIG Elementor Addons
 * Plugin URI:  https://vigdigital.com
 * Description: Timeline, Product Carousel, và các widget Elementor tuỳ chỉnh. Built by VIG Digital.
 * Version:     2.0.2
 * Author:      VIG Digital
 * Author URI:  https://vigdigital.com
 * License:     GPL-2.0-or-later
 * Text Domain: vig-elementor-addons
 * Requires Plugins: elementor
 * Update URI: https://github.com/vigdigital/vig-elementor-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VIG_ADDON_VERSION', '2.0.2' );
define( 'VIG_ADDON_FILE', __FILE__ );
define( 'VIG_ADDON_PATH', plugin_dir_path( __FILE__ ) );
define( 'VIG_ADDON_URL', plugin_dir_url( __FILE__ ) );

// Tự-update qua GitHub Releases (inert cho tới khi vendor PUC)
require_once VIG_ADDON_PATH . 'includes/vig-update-checker.php';
vig_setup_updates( __FILE__, 'vig-elementor-addons', 'vigdigital', true );

require_once VIG_ADDON_PATH . 'includes/Plugin.php';

VIG_Elementor_Addon\Plugin::instance();