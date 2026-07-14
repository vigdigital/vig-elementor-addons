<?php

namespace VIG_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Product Carousel Widget — Hiển thị carousel sản phẩm từ CPT "product".
 */
class Product_Carousel_Widget extends Widget_Base
{

    public function get_name(): string
    {
        return 'vig_product_carousel';
    }

    public function get_title(): string
    {
        return esc_html__('Product Carousel', 'vig-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-posts-carousel';
    }

    public function get_categories(): array
    {
        return ['general'];
    }

    public function get_keywords(): array
    {
        return ['product', 'carousel', 'slider', 'vdp'];
    }

	// -------------------------------------------------------------------------
	// Helpers
	// -------------------------------------------------------------------------

    /** Lấy danh sách danh mục sản phẩm (product_cat) để populate SELECT control. */
    private function get_product_cat_options(): array
    {
        $options = ['' => esc_html__('All products', 'vig-elementor-addons')];
        $terms   = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ]);
        if (! is_wp_error($terms)) {
            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }
        }
        return $options;
    }

    // -------------------------------------------------------------------------
    // Controls
    // -------------------------------------------------------------------------

    protected function register_controls(): void
    {

        /* ====================================================================
		 * CONTENT TAB
		 * ==================================================================== */

        // Section: Tiêu đề section
        $this->start_controls_section('section_heading', [
            'label' => esc_html__('Section title', 'vig-elementor-addons'),
        ]);

        $this->add_control('show_title', [
            'label'        => esc_html__('Show title', 'vig-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Show', 'vig-elementor-addons'),
            'label_off'    => esc_html__('Hide', 'vig-elementor-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('section_title', [
            'label'     => esc_html__('Title text', 'vig-elementor-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('Our Products', 'vig-elementor-addons'),
            'condition' => ['show_title' => 'yes'],
        ]);

        $this->end_controls_section();

        // Section: Cài đặt Query
        $this->start_controls_section('section_query', [
            'label' => esc_html__('Products', 'vig-elementor-addons'),
        ]);

        $this->add_control('posts_per_page', [
            'label'   => esc_html__('Number of products to show', 'vig-elementor-addons'),
            'type'    => Controls_Manager::NUMBER,
            'default' => 8,
            'min'     => 1,
            'max'     => 50,
        ]);

        $this->add_control('orderby', [
            'label'   => esc_html__('Order by', 'vig-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'menu_order',
            'options' => [
                'menu_order' => esc_html__('Menu order', 'vig-elementor-addons'),
                'date'       => esc_html__('Date published', 'vig-elementor-addons'),
                'title'      => esc_html__('Title', 'vig-elementor-addons'),
                'rand'       => esc_html__('Random', 'vig-elementor-addons'),
            ],
        ]);

        $this->add_control('order', [
            'label'   => esc_html__('Sort direction', 'vig-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'ASC',
            'options' => [
                'ASC'  => esc_html__('Ascending', 'vig-elementor-addons'),
                'DESC' => esc_html__('Descending', 'vig-elementor-addons'),
            ],
        ]);

        $this->add_control('product_cat', [
            'label'       => esc_html__('Product category', 'vig-elementor-addons'),
            'type'        => Controls_Manager::SELECT,
            'default'     => '',
            'options'     => $this->get_product_cat_options(),
            'description' => esc_html__('Select "All products" to show everything, or choose a specific category.', 'vig-elementor-addons'),
        ]);

        $this->end_controls_section();

        // Section: Carousel
        $this->start_controls_section('section_carousel', [
            'label' => esc_html__('Carousel', 'vig-elementor-addons'),
        ]);

        $this->add_control('slides_per_view_desktop', [
            'label'       => esc_html__('Columns — Desktop', 'vig-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 4,
            'min'         => 1,
            'max'         => 8,
            'step'        => 0.5,
            'description' => esc_html__('Supports decimals, e.g. 3.5', 'vig-elementor-addons'),
        ]);

        $this->add_control('slides_per_view_tablet', [
            'label'       => esc_html__('Columns — Tablet', 'vig-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 2,
            'min'         => 1,
            'max'         => 6,
            'step'        => 0.5,
            'description' => esc_html__('Supports decimals, e.g. 2.5', 'vig-elementor-addons'),
        ]);

        $this->add_control('slides_per_view_mobile', [
            'label'       => esc_html__('Columns — Mobile', 'vig-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 1,
            'min'         => 1,
            'max'         => 4,
            'step'        => 0.5,
            'description' => esc_html__('Supports decimals, e.g. 1.5', 'vig-elementor-addons'),
        ]);

        $this->add_control('slides_gap', [
            'label'   => esc_html__('Gap — Desktop (px)', 'vig-elementor-addons'),
            'type'    => Controls_Manager::SLIDER,
            'default' => ['size' => 24],
            'range'   => [
                'px' => ['min' => 0, 'max' => 80, 'step' => 2],
            ],
        ]);

        $this->add_control('slides_gap_tablet', [
            'label'       => esc_html__('Gap — Tablet (px)', 'vig-elementor-addons'),
            'type'        => Controls_Manager::SLIDER,
            'default'     => ['size' => 16],
            'range'       => [
                'px' => ['min' => 0, 'max' => 80, 'step' => 2],
            ],
        ]);

        $this->add_control('slides_gap_mobile', [
            'label'       => esc_html__('Gap — Mobile (px)', 'vig-elementor-addons'),
            'type'        => Controls_Manager::SLIDER,
            'default'     => ['size' => 12],
            'range'       => [
                'px' => ['min' => 0, 'max' => 80, 'step' => 2],
            ],
        ]);

        $this->add_control('show_nav', [
            'label'        => esc_html__('Show Prev/Next buttons', 'vig-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Show', 'vig-elementor-addons'),
            'label_off'    => esc_html__('Hide', 'vig-elementor-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('nav_position', [
            'label'     => esc_html__('Prev/Next button position', 'vig-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'inside',
            'options'   => [
                'inside'  => esc_html__('Inside (next to track)', 'vig-elementor-addons'),
                'outside' => esc_html__('Outside (both ends of section)', 'vig-elementor-addons'),
            ],
            'condition' => ['show_nav' => 'yes'],
        ]);

        $this->end_controls_section();

        // Section: Nút xem tất cả
        $this->start_controls_section('section_button', [
            'label' => esc_html__('"View all" Button', 'vig-elementor-addons'),
        ]);

        $this->add_control('show_button', [
            'label'        => esc_html__('Show button', 'vig-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Show', 'vig-elementor-addons'),
            'label_off'    => esc_html__('Hide', 'vig-elementor-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('button_text', [
            'label'     => esc_html__('Button text', 'vig-elementor-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('VIEW ALL PRODUCTS', 'vig-elementor-addons'),
            'condition' => ['show_button' => 'yes'],
        ]);

        $this->add_control('button_url', [
            'label'         => esc_html__('Button link', 'vig-elementor-addons'),
            'type'          => Controls_Manager::URL,
            'placeholder'   => esc_html__('https://example.com/products', 'vig-elementor-addons'),
            'show_external' => true,
            'condition'     => ['show_button' => 'yes'],
        ]);

        $this->end_controls_section();

        /* ====================================================================
		 * STYLE TAB
		 * ==================================================================== */

        // Style: Tiêu đề
        $this->start_controls_section('style_heading', [
            'label' => esc_html__('Section title', 'vig-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label'     => esc_html__('Title color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#066955',
            'selectors' => ['{{WRAPPER}} .vdp-pc__title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .vdp-pc__title',
        ]);

        $this->end_controls_section();

        // Style: Thẻ sản phẩm
        $this->start_controls_section('style_card', [
            'label' => esc_html__('Product card', 'vig-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('card_bg_color', [
            'label'     => esc_html__('Card background color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f5f3ed',
            'selectors' => ['{{WRAPPER}} .vdp-pc__card-pr' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('card_border_radius', [
            'label'      => esc_html__('Card border radius (px)', 'vig-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'default'    => ['size' => 16],
            'range'      => ['px' => ['min' => 0, 'max' => 60]],
            'selectors'  => ['{{WRAPPER}} .vdp-pc__card-pr' => 'border-radius: {{SIZE}}px;'],
        ]);

        $this->add_control('card_padding', [
            'label'     => esc_html__('Image padding in card (px)', 'vig-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'default'   => ['size' => 20],
            'range'     => ['px' => ['min' => 0, 'max' => 80]],
            'selectors' => ['{{WRAPPER}} .vdp-pc__card-pr' => 'padding: {{SIZE}}px;'],
        ]);

        $this->end_controls_section();

        // Style: Tên sản phẩm
        $this->start_controls_section('style_name', [
            'label' => esc_html__('Product name', 'vig-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('name_color', [
            'label'     => esc_html__('Name color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1a1a1a',
            'selectors' => ['{{WRAPPER}} .vdp-pc__name' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'name_typography',
            'selector' => '{{WRAPPER}} .vdp-pc__name',
        ]);

        $this->end_controls_section();

        // Style: Nút
        $this->start_controls_section('style_btn', [
            'label' => esc_html__('"View all" Button', 'vig-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('btn_text_color', [
            'label'     => esc_html__('Text color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#066955',
            'selectors' => ['{{WRAPPER}} .vdp-pc__btn' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('btn_border_color', [
            'label'     => esc_html__('Border color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#066955',
            'selectors' => ['{{WRAPPER}} .vdp-pc__btn' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('btn_border_radius', [
            'label'     => esc_html__('Border radius (px)', 'vig-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'default'   => ['size' => 40],
            'range'     => ['px' => ['min' => 0, 'max' => 100]],
            'selectors' => ['{{WRAPPER}} .vdp-pc__btn' => 'border-radius: {{SIZE}}px;'],
        ]);

        $this->add_control('btn_hover_bg_color', [
            'label'     => esc_html__('Background color on hover', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#066955',
            'selectors' => ['{{WRAPPER}} .vdp-pc__btn:hover' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('btn_hover_text_color', [
            'label'     => esc_html__('Text color on hover', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .vdp-pc__btn:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'btn_typography',
            'selector' => '{{WRAPPER}} .vdp-pc__btn',
        ]);

        $this->end_controls_section();

        // Style: Nút điều hướng
        $this->start_controls_section('style_nav', [
            'label'     => esc_html__('Prev/Next buttons', 'vig-elementor-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_nav' => 'yes'],
        ]);

        $this->add_control('nav_color', [
            'label'     => esc_html__('Icon color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#066955',
            'selectors' => ['{{WRAPPER}} .vdp-pc__nav' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('nav_bg_color', [
            'label'     => esc_html__('Nav button background color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => ['{{WRAPPER}} .vdp-pc__nav' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('nav_border_color', [
            'label'     => esc_html__('Nav button border color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#e0e0e0',
            'selectors' => ['{{WRAPPER}} .vdp-pc__nav' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('nav_size', [
            'label'     => esc_html__('Nav button size (px)', 'vig-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'default'   => ['size' => 40],
            'range'     => ['px' => ['min' => 24, 'max' => 80, 'step' => 2]],
            'selectors' => [
                '{{WRAPPER}} .vdp-pc__nav' => 'width: {{SIZE}}px; height: {{SIZE}}px; font-size: calc({{SIZE}}px * 0.6);',
            ],
        ]);

        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Render
    // -------------------------------------------------------------------------

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();

        // Query sản phẩm
        $query_args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => absint($settings['posts_per_page']),
            'orderby'        => sanitize_key($settings['orderby']),
            'order'          => 'DESC' === $settings['order'] ? 'DESC' : 'ASC',
            'no_found_rows'  => true,
        ];

        // Lọc theo danh mục nếu được chọn — dịch term sang ngôn ngữ hiện tại (Polylang)
        // để không mất sản phẩm khi xem ở ngôn ngữ khác (slug danh mục khác nhau theo ngôn ngữ).
        if (! empty($settings['product_cat'])) {
            $term    = get_term_by('slug', sanitize_text_field($settings['product_cat']), 'product_cat');
            $term_id = ($term && ! is_wp_error($term)) ? (int) $term->term_id : 0;
            if ($term_id && function_exists('pll_get_term')) {
                $translated = pll_get_term($term_id); // term_id ở ngôn ngữ hiện tại
                if ($translated) {
                    $term_id = (int) $translated;
                }
            }
            if ($term_id) {
                $query_args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ],
                ];
            }
        }

        $query = new \WP_Query($query_args);

        if (! $query->have_posts()) {
            if (current_user_can('edit_posts')) {
                printf('<p>%s</p>', esc_html__('[VDP] No posts found with the "product" post type.', 'vig-elementor-addons'));
            }
            return;
        }

        // Tính toán layout carousel động theo settings (hỗ trợ số thập phân)
        $uid         = 'vig-pc-' . $this->get_id();
        $per_desktop = max(1, floatval($settings['slides_per_view_desktop']));
        $per_tablet  = max(1, floatval($settings['slides_per_view_tablet']));
        $per_mobile  = max(1, floatval($settings['slides_per_view_mobile']));
        $gap_desktop = isset($settings['slides_gap']['size'])        ? intval($settings['slides_gap']['size'])        : 24;
        $gap_tablet  = isset($settings['slides_gap_tablet']['size']) ? intval($settings['slides_gap_tablet']['size']) : $gap_desktop;
        $gap_mobile  = isset($settings['slides_gap_mobile']['size']) ? intval($settings['slides_gap_mobile']['size']) : $gap_desktop;

        // Vị trí nút nav
        $nav_position  = $settings['nav_position'] ?? 'inside';
        $nav_outside   = ('yes' === $settings['show_nav'] && 'outside' === $nav_position);
        $nav_inside    = ('yes' === $settings['show_nav'] && ! $nav_outside);
        $row_class     = $nav_outside ? 'vdp-pc__carousel-row vdp-pc__carousel-row--nav-outside' : 'vdp-pc__carousel-row';

        $width_desktop = 100 / $per_desktop;
        $width_tablet  = 100 / $per_tablet;
        $width_mobile  = 100 / $per_mobile;

        // Button URL
        $btn_url  = ! empty($settings['button_url']['url']) ? esc_url($settings['button_url']['url']) : '#';
        $btn_target = ! empty($settings['button_url']['is_external']) ? ' target="_blank" rel="noopener noreferrer"' : '';
?>

        <style>
            #<?php echo esc_attr($uid); ?> .vdp-pc__track {
                gap: <?php echo esc_attr($gap_desktop); ?>px;
            }

            #<?php echo esc_attr($uid); ?> .vdp-pc__slide {
                flex: 0 0 calc(<?php echo esc_attr(round($width_desktop, 4)); ?>% - <?php echo esc_attr(round($gap_desktop * ($per_desktop - 1) / $per_desktop, 2)); ?>px);
            }

            @media (max-width: 1024px) {
                #<?php echo esc_attr($uid); ?> .vdp-pc__track {
                    gap: <?php echo esc_attr($gap_tablet); ?>px;
                }

                #<?php echo esc_attr($uid); ?> .vdp-pc__slide {
                    flex: 0 0 calc(<?php echo esc_attr(round($width_tablet, 4)); ?>% - <?php echo esc_attr(round($gap_tablet * ($per_tablet - 1) / $per_tablet, 2)); ?>px);
                }
            }

            @media (max-width: 767px) {
                #<?php echo esc_attr($uid); ?> .vdp-pc__track {
                    gap: <?php echo esc_attr($gap_mobile); ?>px;
                }

                #<?php echo esc_attr($uid); ?> .vdp-pc__slide {
                    flex: 0 0 calc(<?php echo esc_attr(round($width_mobile, 4)); ?>% - <?php echo esc_attr(round($gap_mobile * ($per_mobile - 1) / $per_mobile, 2)); ?>px);
                }
            }
        </style>

        <div class="vdp-pc" id="<?php echo esc_attr($uid); ?>">

            <?php if ('yes' === $settings['show_title'] && ! empty($settings['section_title'])) : ?>
                <h2 class="vdp-pc__title"><?php echo esc_html($settings['section_title']); ?></h2>
            <?php endif; ?>

            <div class="<?php echo esc_attr($row_class); ?>">

                <?php if ($nav_outside) : ?>
                    <button class="vdp-pc__nav vdp-pc__prev" aria-label="<?php esc_attr_e('Previous', 'vig-elementor-addons'); ?>">&#8249;</button>
                <?php endif; ?>

                <div class="vdp-pc__wrapper">

                    <?php if ($nav_inside) : ?>
                        <button class="vdp-pc__nav vdp-pc__prev" aria-label="<?php esc_attr_e('Previous', 'vig-elementor-addons'); ?>">&#8249;</button>
                    <?php endif; ?>

                    <div class="vdp-pc__track">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <div class="vdp-pc__slide">
                                <a href="<?php the_permalink(); ?>" class="vdp-pc__card">
                                    <div class="vdp-pc__card-pr">
                                        <div class="vdp-pc__card-img">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                                            <?php else : ?>
                                                <div class="vdp-pc__no-image"></div>
                                            <?php endif; ?>

                                        </div>
                                        <div class="vdp-pc__name"><?php the_title(); ?></div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($nav_inside) : ?>
                        <button class="vdp-pc__nav vdp-pc__next" aria-label="<?php esc_attr_e('Next', 'vig-elementor-addons'); ?>">&#8250;</button>
                    <?php endif; ?>

                </div><!-- .vdp-pc__wrapper -->

                <?php if ($nav_outside) : ?>
                    <button class="vdp-pc__nav vdp-pc__next" aria-label="<?php esc_attr_e('Next', 'vig-elementor-addons'); ?>">&#8250;</button>
                <?php endif; ?>

            </div><!-- .vdp-pc__carousel-row -->

            <?php if ('yes' === $settings['show_button'] && ! empty($settings['button_text'])) : ?>
                <div class="vdp-pc__btn-wrap">
                    <a href="<?php echo $btn_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                ?>" <?php echo $btn_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                                                                                                                        ?> class="vdp-pc__btn">
                        <?php echo esc_html($settings['button_text']); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div><!-- .vdp-pc -->

<?php
        wp_reset_postdata();
    }
}
