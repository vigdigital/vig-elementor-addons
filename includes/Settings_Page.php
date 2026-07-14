<?php
namespace VIG_Elementor_Addon;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings Page — Trang cài đặt plugin trong wp-admin.
 * Cho phép bật/tắt từng widget Elementor riêng lẻ.
 */
class Settings_Page {

	const OPTION_KEY = 'vig_addon_settings';

	/** Danh sách widget được quản lý bởi plugin này. */
	private static array $widgets = [
		'widget_timeline' => [
			'label'       => 'Widget Timeline',
			'description' => 'Display a timeline in Elementor.',
		],
		'widget_product_carousel' => [
			'label'       => 'Widget Product Carousel',
			'description' => 'Display a product carousel from the "product" custom post type.',
		],
		'widget_video_carousel'   => [
			'label'       => 'Widget Video Carousel',
			'description' => 'Display a video carousel with lightbox (YouTube, Vimeo, MP4).',
		],
		'widget_icon_search'      => [
			'label'       => 'Widget Icon Search',
			'description' => 'Display a search icon as a dropdown popup in the header.',
		],
		'widget_product_tab_carousel' => [
			'label'       => 'Widget Product Tab Carousel',
			'description' => 'Display products by tab with a carousel slider (Swiper).',
		],
	];

	public static function init(): void {
		add_action( 'admin_menu', [ __CLASS__, 'add_menu' ] );
		add_action( 'admin_init', [ __CLASS__, 'register_settings' ] );
	}

	public static function add_menu(): void {
		\vig_toolkit_register_parent();
		add_submenu_page(
			'vig-toolkit',
			esc_html__( 'VIG Elementor Addons', 'vig-elementor-addons' ),
			esc_html__( 'Elementor Addons', 'vig-elementor-addons' ),
			'manage_options',
			'vig-elementor-addons',
			[ __CLASS__, 'render_page' ]
		);
	}

	public static function register_settings(): void {
		register_setting(
			'vig_addon_settings_group',
			self::OPTION_KEY,
			[ 'sanitize_callback' => [ __CLASS__, 'sanitize' ] ]
		);
	}

	/** Sanitize: chỉ chấp nhận '1' hoặc '0' cho mỗi key widget. */
	public static function sanitize( $input ): array {
		$output = [];
		foreach ( array_keys( self::$widgets ) as $key ) {
			$output[ $key ] = isset( $input[ $key ] ) ? '1' : '0';
		}
		return $output;
	}

	public static function render_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings = get_option( self::OPTION_KEY, [] );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'VIG Elementor Addons — Settings', 'vig-elementor-addons' ); ?></h1>
			<p><?php esc_html_e( 'Enable/disable each Elementor widget from this addon. Changes take effect after saving and reloading the Elementor page.', 'vig-elementor-addons' ); ?></p>

			<form method="post" action="options.php">
				<?php settings_fields( 'vig_addon_settings_group' ); ?>

				<table class="form-table" role="presentation">
					<tbody>
						<?php foreach ( self::$widgets as $key => $info ) :
							$is_enabled = ! isset( $settings[ $key ] ) || '1' === $settings[ $key ];
						?>
						<tr>
							<th scope="row"><?php echo esc_html( $info['label'] ); ?></th>
							<td>
								<fieldset>
									<label>
										<input
											type="checkbox"
											name="<?php echo esc_attr( self::OPTION_KEY . '[' . $key . ']' ); ?>"
											value="1"
											<?php checked( $is_enabled ); ?>
										/>
										<?php esc_html_e( 'Enable this widget', 'vig-elementor-addons' ); ?>
									</label>
									<p class="description"><?php echo esc_html( $info['description'] ); ?></p>
								</fieldset>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php submit_button( esc_html__( 'Save settings', 'vig-elementor-addons' ) ); ?>
			</form>
		</div>
		<?php
	}
}
