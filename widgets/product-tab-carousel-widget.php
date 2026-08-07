<?php

namespace VIG_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Product_Tab_Carousel_Widget — Hiển thị carousel sản phẩm phân chia theo Tab danh mục từ CPT "product".
 */
class Product_Tab_Carousel_Widget extends Widget_Base
{

    public function get_name(): string
    {
        return 'vig_product_carousel_tabs';
    }

    public function get_title(): string
    {
        return esc_html__('VIG Product Carousel Tabs', 'vig-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-tabs';
    }

    public function get_categories(): array
    {
        return ['general'];
    }

    public function get_keywords(): array
    {
        return ['product', 'carousel', 'slider', 'vdp', 'tabs'];
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /** Lấy danh sách danh mục sản phẩm (product_cat) để populate SELECT2 control. */
    private function get_product_cat_options(): array
    {
        $options = [];
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

        // Section: Cài đặt Query & Tabs
        $this->start_controls_section('section_query', [
            'label' => esc_html__('Products & Tabs', 'vig-elementor-addons'),
        ]);

        $this->add_control('product_cats', [
            'label'       => esc_html__('Select categories (Tabs)', 'vig-elementor-addons'),
            'type'        => Controls_Manager::SELECT2,
            'multiple'    => true,
            'options'     => $this->get_product_cat_options(),
            'label_block' => true,
            'description' => esc_html__('Select categories to use as navigation tabs. If left empty, the widget uses all existing categories that contain products.', 'vig-elementor-addons'),
        ]);

        $this->add_control('posts_per_page', [
            'label'       => esc_html__('Max products per tab', 'vig-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 12,
            'min'         => 1,
            'max'         => 100,
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

        $this->end_controls_section();

        // Section: Carousel
        $this->start_controls_section('section_carousel', [
            'label' => esc_html__('Carousel settings', 'vig-elementor-addons'),
        ]);

        $this->add_control('slides_per_view_desktop', [
            'label'       => esc_html__('Columns — Desktop', 'vig-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 4.2,
            'min'         => 1,
            'max'         => 8,
            'step'        => 0.1,
            'description' => esc_html__('Use a decimal (e.g. 4.2) to reveal a peek of the next slide, as in the design.', 'vig-elementor-addons'),
        ]);

        $this->add_control('slides_per_view_tablet', [
            'label'       => esc_html__('Columns — Tablet', 'vig-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 2.3,
            'min'         => 1,
            'max'         => 6,
            'step'        => 0.1,
        ]);

        $this->add_control('slides_per_view_mobile', [
            'label'       => esc_html__('Columns — Mobile', 'vig-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 1.2,
            'min'         => 1,
            'max'         => 4,
            'step'        => 0.1,
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

        // Style: Tabs Điều hướng (Mới thêm)
        $this->start_controls_section('style_tabs', [
            'label' => esc_html__('Navigation tabs', 'vig-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('tab_bg_normal', [
            'label'     => esc_html__('Inactive tab background color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f5f3ed',
            'selectors' => ['{{WRAPPER}} .vdp-pc__tab-btn' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('tab_color_normal', [
            'label'     => esc_html__('Inactive tab text color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#555555',
            'selectors' => ['{{WRAPPER}} .vdp-pc__tab-btn' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('tab_bg_active', [
            'label'     => esc_html__('Active tab background color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffd65c',
            'selectors' => ['{{WRAPPER}} .vdp-pc__tab-btn.active' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('tab_color_active', [
            'label'     => esc_html__('Active tab text color', 'vig-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#066955',
            'selectors' => ['{{WRAPPER}} .vdp-pc__tab-btn.active' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'tabs_typography',
            'selector' => '{{WRAPPER}} .vdp-pc__tab-btn',
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
            'label'     => esc_html__('Card padding (px)', 'vig-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'default'   => ['size' => 30],
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
            'default'   => '#333333',
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
            'default'   => ['size' => 6],
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
            'selectors' => ['{{WRAPPER}} .vdp-pc__nav svg' => 'fill: {{VALUE}};'],
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
            'default'   => ['size' => 44],
            'range'     => ['px' => ['min' => 24, 'max' => 80, 'step' => 2]],
            'selectors' => [
                '{{WRAPPER}} .vdp-pc__nav' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
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
        $widget_id = $this->get_id();
        $uid = 'vig-pc-' . $widget_id;

        // 1. Xác định các Phân loại danh mục (Tabs) để hiển thị
        $selected_cats = ! empty($settings['product_cats']) && is_array($settings['product_cats']) ? $settings['product_cats'] : [];
        if (empty($selected_cats)) {
            // Lấy danh mục hiện có có chứa sản phẩm làm fallback
            $terms = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
            ));
            if (! is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $selected_cats[] = $term->slug;
                }
            }
        }

        // Tạo Term Objects để render tên tab điều hướng
        $active_tabs = [];
        if (! empty($selected_cats)) {
            foreach ($selected_cats as $cat_slug) {
                $term = get_term_by('slug', $cat_slug, 'product_cat');
                if ($term) {
                    $active_tabs[] = $term;
                }
            }
        }

        if (empty($active_tabs)) {
            if (current_user_can('edit_posts')) {
                printf('<p>%s</p>', esc_html__('[VIG] Please configure the categories (product_cat) in the admin area.', 'vig-elementor-addons'));
            }
            return;
        }

        // 2. Truy vấn tất cả sản phẩm thuộc các danh mục được chọn
        $query_args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => absint($settings['posts_per_page']),
            'orderby'        => sanitize_key($settings['orderby']),
            'order'          => 'DESC' === $settings['order'] ? 'DESC' : 'ASC',
            'tax_query'      => [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $selected_cats,
                ],
            ],
        ];

        $query = new \WP_Query($query_args);

        // Khởi tạo mảng phân tách sản phẩm theo từng danh mục slug trong PHP để tối ưu hiệu suất truy vấn
        $grouped_products = [];
        foreach ($selected_cats as $slug) {
            $grouped_products[$slug] = [];
        }

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                global $post;
                $post_terms = wp_get_post_terms($post->ID, 'product_cat');
                if (! is_wp_error($post_terms)) {
                    foreach ($post_terms as $term) {
                        if (in_array($term->slug, $selected_cats)) {
                            $grouped_products[$term->slug][] = [
                                'id'        => get_the_ID(),
                                'title'     => get_the_title(),
                                'permalink' => get_the_permalink(),
                                'thumbnail' => get_the_post_thumbnail(get_the_ID(), 'medium', ['alt' => get_the_title()]),
                                'has_thumb' => has_post_thumbnail(),
                            ];
                        }
                    }
                }
            }
            wp_reset_postdata();
        }

        // Luôn hiển thị đủ tab cho mọi danh mục đã chọn/tồn tại, kể cả danh mục chưa có sản phẩm.
        $valid_tabs = $active_tabs;

        // Cấu hình responsive
        $per_desktop = max(1, floatval($settings['slides_per_view_desktop']));
        $per_tablet  = max(1, floatval($settings['slides_per_view_tablet']));
        $per_mobile  = max(1, floatval($settings['slides_per_view_mobile']));
        $gap_desktop = isset($settings['slides_gap']['size'])        ? intval($settings['slides_gap']['size'])        : 24;
        $gap_tablet  = isset($settings['slides_gap_tablet']['size']) ? intval($settings['slides_gap_tablet']['size']) : $gap_desktop;
        $gap_mobile  = isset($settings['slides_gap_mobile']['size']) ? intval($settings['slides_gap_mobile']['size']) : $gap_desktop;

        $btn_url  = ! empty($settings['button_url']['url']) ? esc_url($settings['button_url']['url']) : '#';
        $btn_target = ! empty($settings['button_url']['is_external']) ? ' target="_blank" rel="noopener noreferrer"' : '';

        wp_enqueue_script('swiper');
        wp_enqueue_style('swiper');
?>

        <style>
            .vdp-pc {
                width: 100%;
                box-sizing: border-box;
            }

            .vdp-pc__title {
                text-align: center;
                font-size: 36px;
                font-weight: 700;
                margin-bottom: 40px;
                line-height: 1.2;
            }

            /* Tabs điều hướng — luôn 1 hàng, chia đều theo số lượng tab (giống nav-menu "Justify" của Elementor ở trang product_cat) */
            .vdp-pc__tabs-nav {
                display: flex;
                justify-content: space-between;
                gap: 24px;
                margin-bottom: 45px;
                flex-wrap: nowrap;
                max-width: 100%;
                width: 1200px;
                margin-left: auto;
                margin-right: auto;
            }

            .vdp-pc__tab-btn {
                background-color: #f5f3ed;
                color: #555555;
                border: none;
                padding: 16px;
                font-size: 14px;
                font-weight: 700;
                text-transform: uppercase;
                border-radius: 0;
                cursor: pointer;
                transition: all 0.3s ease;
                outline: none;
                flex: 1 1 0;
                min-width: 0;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .vdp-pc__tab-btn.active {
                background-color: #ffd65c;
                color: #066955;
            }

            /* Container & Nội dung các tab */
            .vdp-pc__carousels-container {
                position: relative;
                width: 100%;
            }

            .vdp-pc__tab-content {
                display: none;
                width: 100%;
            }

            .vdp-pc__tab-content.active {
                display: block;
            }

            .vdp-pc__empty {
                text-align: center;
                color: #888888;
                font-size: 16px;
                padding: 60px 20px;
                margin: 0;
            }

            /* Khóa hiệu ứng trên Swiper slide để tránh lỗi kẹt điều hướng */
            #<?php echo esc_attr($uid); ?>.swiper-slide {
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }

            /* Thẻ sản phẩm */
            .vdp-pc__card {
                text-decoration: none;
                display: block;
            }

            .vdp-pc__card-pr {
                background-color: #f5f3ed;
                border-radius: 16px;
                padding: 30px 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-between;
                height: 380px;
                /* Chiều cao cố định */
                box-sizing: border-box;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .vdp-pc__card:hover .vdp-pc__card-pr {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
            }

            .vdp-pc__card-img {
                flex-grow: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 220px;
                margin-bottom: 20px;
            }

            .vdp-pc__card-img img {
                max-width: 90%;
                max-height: 100%;
                object-fit: contain;
                mix-blend-mode: multiply;
            }

            .vdp-pc__name {
                font-size: 18px;
                color: #333333;
                font-weight: 700;
                text-transform: uppercase;
                text-align: center;
                margin: 0;
                line-height: 1.3;
            }

            /* Nút điều hướng mũi tên */
            .vdp-pc__nav {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 44px;
                height: 44px;
                background-color: rgb(255 255 255 / 60%);
                border: 0;
                border-radius: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10;
                transition: all 0.3s ease;
            }

            .vdp-pc__nav:hover {
                background-color: #066955;
                border-color: #066955;
            }

            .vdp-pc__nav:hover svg {
                fill: #ffffff;
            }

            .vdp-pc__prev {
                left: 20px;
            }

            .vdp-pc__next {
                right: 20px;
            }

            .vdp-pc__tab-content .vdp-pc__nav svg {
                width: 36px;
                height: 36px;
                fill: #066955;
                transition: fill 0.3s ease;
            }

            /* Nút chân trang */
            .vdp-pc__btn-wrap {
                display: flex;
                justify-content: center;
                margin-top: 45px;
            }

            .vdp-pc__btn {
                display: inline-block;
                border: 1px solid #066955;
                color: #066955;
                background-color: transparent;
                padding: 14px 40px;
                font-size: 14px;
                font-weight: 700;
                text-transform: uppercase;
                text-decoration: none;
                border-radius: 6px;
                transition: all 0.3s ease;
            }

            .vdp-pc__btn:hover {
                background-color: #066955;
                color: #ffffff;
            }

            @media (max-width: 1024px) {
                .vdp-pc__tab-btn {
                    flex: 0 0 calc(50% - 12px);
                    white-space: normal;
                }

                .vdp-pc__tabs-nav {
                    flex-wrap: wrap;
                    padding-left: 16px;
                    padding-right: 16px;
                }
            }

            @media (max-width: 768px) {
                .vdp-pc__card-pr {
                    height: 320px;
                    padding: 20px;
                }

                .vdp-pc__card-img {
                    height: 180px;
                }

                .vdp-pc__name {
                    font-size: 16px;
                }

                .vdp-pc__nav {
                    width: 36px;
                    height: 36px;
                }
            }
        </style>

        <div class="vdp-pc" id="<?php echo esc_attr($uid); ?>">

            <!-- Tiêu đề chính -->
            <?php if ('yes' === $settings['show_title'] && ! empty($settings['section_title'])) : ?>
                <h2 class="vdp-pc__title"><?php echo esc_html($settings['section_title']); ?></h2>
            <?php endif; ?>

            <!-- Navigation Tab -->
            <div class="vdp-pc__tabs-nav">
                <?php foreach ($valid_tabs as $index => $tab) : ?>
                    <button class="vdp-pc__tab-btn <?php echo $index === 0 ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($tab->slug); ?>">
                        <?php echo esc_html($tab->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Khối chứa các Slider -->
            <div class="vdp-pc__carousels-container">
                <?php foreach ($valid_tabs as $index => $tab) :
                    $tab_slug = $tab->slug;
                    $products = $grouped_products[$tab_slug];
                ?>
                    <div class="vdp-pc__tab-content <?php echo $index === 0 ? 'active' : ''; ?>" id="tab-content-<?php echo esc_attr($uid); ?>-<?php echo esc_attr($tab_slug); ?>">
                        <?php if (empty($products)) : ?>
                            <p class="vdp-pc__empty"><?php esc_html_e('Coming soon.', 'vig-elementor-addons'); ?></p>
                        <?php else : ?>
                        <div class="swiper-container swiper-container-prod" data-tab-id="<?php echo esc_attr($tab_slug); ?>">
                            <div class="swiper-wrapper">
                                <?php foreach ($products as $prod) : ?>
                                    <div class="swiper-slide">
                                        <a href="<?php echo esc_url($prod['permalink']); ?>" class="vdp-pc__card">
                                            <div class="vdp-pc__card-pr">
                                                <div class="vdp-pc__card-img">
                                                    <?php if ($prod['has_thumb']) : ?>
                                                        <?php echo $prod['thumbnail']; ?>
                                                    <?php else : ?>
                                                        <div class="vdp-pc__no-image" style="background-color: #ddd; width: 100%; height: 100%;"></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="vdp-pc__name"><?php echo esc_html($prod['title']); ?></div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Nút mũi tên định danh theo Tab để tránh xung đột -->
                            <?php if ('yes' === $settings['show_nav']) : ?>
                                <div class="vdp-pc__nav vdp-pc__prev vdp-pc__prev-<?php echo esc_attr($tab_slug); ?>">
                                    <svg aria-hidden="true" class="e-font-icon-svg e-eicon-chevron-left" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M646 125C629 125 613 133 604 142L308 442C296 454 292 471 292 487 292 504 296 521 308 533L604 854C617 867 629 875 646 875 663 875 679 871 692 858 704 846 713 829 713 812 713 796 708 779 692 767L438 487 692 225C700 217 708 204 708 187 708 171 704 154 692 142 675 129 663 125 646 125Z"></path>
                                    </svg>
                                </div>
                                <div class="vdp-pc__nav vdp-pc__next vdp-pc__next-<?php echo esc_attr($tab_slug); ?>">
                                    <svg aria-hidden="true" class="e-font-icon-svg e-eicon-chevron-right" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M696 533C708 521 713 504 713 487 713 471 708 454 696 446L400 146C388 133 375 125 354 125 338 125 325 129 313 142 300 154 292 171 292 187 292 204 296 221 308 233L563 492 304 771C292 783 288 800 288 817 288 833 296 850 308 863 321 871 338 875 354 875 371 875 388 867 400 854L696 533Z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Nút xem tất cả -->
            <?php if ('yes' === $settings['show_button'] && ! empty($settings['button_text'])) : ?>
                <div class="vdp-pc__btn-wrap">
                    <a href="<?php echo esc_url($btn_url); ?>" <?php echo $btn_target; ?> class="vdp-pc__btn">
                        <?php echo esc_html($settings['button_text']); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div><!-- .vdp-pc -->

        <script>
            (function() {
                var initTabCarousels = function() {
                    if (typeof Swiper === 'undefined') {
                        setTimeout(initTabCarousels, 100);
                        return;
                    }

                    var swiperInstances = {};

                    // Khởi tạo toàn bộ các Swiper slider theo tab
                    document.querySelectorAll('#<?php echo esc_attr($uid); ?> .swiper-container-prod').forEach(function(el) {
                        var tabId = el.getAttribute('data-tab-id');
                        var swiperInstance = new Swiper(el, {
                            slidesPerView: <?php echo esc_attr($per_mobile); ?>,
                            spaceBetween: <?php echo esc_attr($gap_mobile); ?>,
                            loop: false,
                            navigation: {
                                nextEl: '#<?php echo esc_attr($uid); ?> .vdp-pc__next-' + tabId,
                                prevEl: '#<?php echo esc_attr($uid); ?> .vdp-pc__prev-' + tabId,
                            },
                            breakpoints: {
                                768: {
                                    slidesPerView: <?php echo esc_attr($per_tablet); ?>,
                                    spaceBetween: <?php echo esc_attr($gap_tablet); ?>,
                                },
                                1024: {
                                    slidesPerView: <?php echo esc_attr($per_desktop); ?>,
                                    spaceBetween: <?php echo esc_attr($gap_desktop); ?>,
                                }
                            }
                        });
                        swiperInstances[tabId] = swiperInstance;
                    });

                    // Xử lý chuyển đổi Tab mượt mà, ép Swiper update khi hiển thị lại
                    var widget = document.getElementById('<?php echo esc_attr($uid); ?>');
                    if (widget) {
                        var buttons = widget.querySelectorAll('.vdp-pc__tab-btn');
                        var contents = widget.querySelectorAll('.vdp-pc__tab-content');

                        buttons.forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var targetTab = this.getAttribute('data-tab');

                                // Active nút tab
                                buttons.forEach(function(b) {
                                    b.classList.remove('active');
                                });
                                this.classList.add('active');

                                // Active khối nội dung
                                contents.forEach(function(content) {
                                    var contentId = content.getAttribute('id');
                                    if (contentId === 'tab-content-<?php echo esc_attr($uid); ?>-' + targetTab) {
                                        content.classList.add('active');

                                        // Ép vẽ lại Swiper
                                        if (swiperInstances[targetTab]) {
                                            swiperInstances[targetTab].update();
                                        }
                                    } else {
                                        content.classList.remove('active');
                                    }
                                });
                            });
                        });
                    }
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initTabCarousels);
                } else {
                    initTabCarousels();
                }
            })();
        </script>
<?php
    }
}
