<?php
namespace VIG_Elementor_Addon;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Plugin class — Singleton entry point.
 * Đăng ký widget, enqueue assets và khởi động settings page.
 */
class Plugin {

	/** @var Plugin|null */
	private static $_instance = null;

	public static function instance(): self {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init(): void {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'notice_elementor_missing' ] );
			return;
		}

		require_once VIG_ADDON_PATH . 'includes/vig-admin-menu.php';
		require_once VIG_ADDON_PATH . 'includes/Settings_Page.php';
		Settings_Page::init();

		add_action( 'elementor/widgets/register',              [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/** Đăng ký các widget được bật trong Settings. */
	public function register_widgets( $widgets_manager ): void {
		$settings = get_option( Settings_Page::OPTION_KEY, [] );

		if ( self::is_widget_enabled( $settings, 'widget_timeline' ) ) {
			require_once VIG_ADDON_PATH . 'widgets/timeline-widget.php';
			$widgets_manager->register( new Widgets\Timeline_Widget() );
		}

		if ( self::is_widget_enabled( $settings, 'widget_product_carousel' ) ) {
			require_once VIG_ADDON_PATH . 'widgets/product-carousel-widget.php';
			$widgets_manager->register( new Widgets\Product_Carousel_Widget() );
		}

		if ( self::is_widget_enabled( $settings, 'widget_video_carousel' ) ) {
			require_once VIG_ADDON_PATH . 'widgets/video-carousel-widget.php';
			$widgets_manager->register( new Widgets\Video_Carousel_Widget() );
		}

		if ( self::is_widget_enabled( $settings, 'widget_icon_search' ) ) {
			require_once VIG_ADDON_PATH . 'widgets/icon-search-widget.php';
			$widgets_manager->register( new Widgets\Icon_Search_Widget() );
		}

		if ( self::is_widget_enabled( $settings, 'widget_product_tab_carousel' ) ) {
			require_once VIG_ADDON_PATH . 'widgets/product-tab-carousel-widget.php';
			$widgets_manager->register( new Widgets\Product_Tab_Carousel_Widget() );
		}
	}

	/** Enqueue stylesheet cho frontend Elementor. */
	public function enqueue_styles(): void {
		$settings = get_option( Settings_Page::OPTION_KEY, [] );

		if ( self::is_widget_enabled( $settings, 'widget_timeline' ) ) {
			wp_enqueue_style(
				'vig-timeline-widget',
				VIG_ADDON_URL . 'assets/css/timeline-widget.css',
				[],
				VIG_ADDON_VERSION
			);
		}

		if ( self::is_widget_enabled( $settings, 'widget_product_carousel' ) ) {
			wp_enqueue_style(
				'vig-product-carousel-widget',
				VIG_ADDON_URL . 'assets/css/product-carousel-widget.css',
				[],
				VIG_ADDON_VERSION
			);
		}

		if ( self::is_widget_enabled( $settings, 'widget_video_carousel' ) ) {
			wp_enqueue_style(
				'vig-video-carousel-widget',
				VIG_ADDON_URL . 'assets/css/video-carousel-widget.css',
				[],
				VIG_ADDON_VERSION
			);
		}

		if ( self::is_widget_enabled( $settings, 'widget_icon_search' ) ) {
			wp_enqueue_style(
				'vig-icon-search-widget',
				VIG_ADDON_URL . 'assets/css/icon-search-widget.css',
				[],
				VIG_ADDON_VERSION
			);
		}
	}

	/** Enqueue script cho frontend Elementor. */
	public function enqueue_scripts(): void {
		$settings = get_option( Settings_Page::OPTION_KEY, [] );

		if ( self::is_widget_enabled( $settings, 'widget_product_carousel' ) ) {
			wp_enqueue_script(
				'vig-product-carousel-widget',
				VIG_ADDON_URL . 'assets/js/product-carousel-widget.js',
				[],
				VIG_ADDON_VERSION,
				true
			);
		}

		if ( self::is_widget_enabled( $settings, 'widget_icon_search' ) ) {
			wp_enqueue_script(
				'vig-icon-search-widget',
				VIG_ADDON_URL . 'assets/js/icon-search-widget.js',
				[],
				VIG_ADDON_VERSION,
				true
			);
		}
	}

	/** Admin notice khi Elementor chưa được kích hoạt. */
	public function notice_elementor_missing(): void {
		$message = sprintf(
			/* translators: 1: plugin name, 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'vig-elementor-addons' ),
			'<strong>' . esc_html__( 'VIG Elementor Addons', 'vig-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'vig-elementor-addons' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Trả về true nếu widget được bật (mặc định là bật nếu chưa có setting).
	 *
	 * @param array  $settings Mảng settings từ DB.
	 * @param string $key      Key của widget.
	 */
	private static function is_widget_enabled( array $settings, string $key ): bool {
		return ! isset( $settings[ $key ] ) || '1' === $settings[ $key ];
	}
}
