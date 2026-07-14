<?php
namespace VIG_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Timeline_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'timeline';
    }

    public function get_title()
    {
        return esc_html__('Timeline', 'vig-elementor-addons');
    }

    public function get_icon()
    {
        return 'eicon-time-line';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function register_controls()
    {

        // SECTION 1: Cấu hình Tiêu đề chính (Timeline Header)
        $this->start_controls_section(
            'section_header',
            [
                'label' => esc_html__('Main title', 'vig-elementor-addons'),
            ]
        );

        $this->add_control(
            'show_header_title',
            [
                'label' => esc_html__('Show main title', 'vig-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'vig-elementor-addons'),
                'label_off' => esc_html__('Hide', 'vig-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'header_title_text',
            [
                'label' => esc_html__('Title text', 'vig-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Timeline', 'vig-elementor-addons'),
                'condition' => [
                    'show_header_title' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // SECTION 2: Cấu hình các mốc thời gian (Repeater Items)
        $this->start_controls_section(
            'section_timeline_items',
            [
                'label' => esc_html__('Timeline items', 'vig-elementor-addons'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'timeline_year',
            [
                'label' => esc_html__('Year', 'vig-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '2021',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'timeline_title',
            [
                'label' => esc_html__('Milestone title', 'vig-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Launching',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'timeline_desc',
            [
                'label' => esc_html__('Short description', 'vig-elementor-addons'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Detailed description of this timeline item...',
            ]
        );

        $repeater->add_control(
            'timeline_media_type',
            [
                'label' => esc_html__('Media type', 'vig-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image'   => esc_html__('Single image (Featured image)', 'vig-elementor-addons'),
                    'gallery' => esc_html__('Gallery (Certification logos)', 'vig-elementor-addons'),
                ],
            ]
        );

        $repeater->add_control(
            'timeline_image',
            [
                'label' => esc_html__('Select image', 'vig-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'timeline_media_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'timeline_gallery',
            [
                'label' => esc_html__('Select multiple logos', 'vig-elementor-addons'),
                'type' => Controls_Manager::GALLERY,
                'condition' => [
                    'timeline_media_type' => 'gallery',
                ],
            ]
        );

        $this->add_control(
            'timeline_items',
            [
                'label' => esc_html__('Timeline item list', 'vig-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'timeline_year' => '2021',
                        'timeline_title' => 'Launching',
                        'timeline_desc' => 'Founded as a division of Vinh Hoan Corporation, TNG Food launched with a mission to transform Mekong Delta harvests into premium, nourishing processed agricultural products.',
                        'timeline_media_type' => 'image',
                    ],
                    [
                        'timeline_year' => '2022',
                        'timeline_title' => 'Standardized',
                        'timeline_desc' => "We began operating at our state-of-the-art Dong Thap factory, boasting a massive 150-ton daily intake and an annual capacity of 25,000 tons.<br><br>We've mastered IQF, vacuum-frying, soft-drying technologies. Our commitment to excellence is backed by global gold standards: <strong>BRC, FSMA, FDA, BSCI, KOSHER, and HALAL</strong>",
                        'timeline_media_type' => 'gallery',
                    ],
                    [
                        'timeline_year' => '2026',
                        'timeline_title' => 'Global',
                        'timeline_desc' => 'Founded as a division of Vinh Hoan Corporation, TNG Food launched with a mission to transform Mekong Delta harvests into premium, nourishing processed agricultural products.',
                        'timeline_media_type' => 'image',
                    ],
                ],
                'title_field' => '{{{ timeline_year }}} - {{{ timeline_title }}}',
            ]
        );

        $this->end_controls_section();

        // SECTION 3: TÙY CHỈNH STYLE (Tab Style trong Elementor)
        $this->start_controls_section(
            'section_style_header',
            [
                'label' => esc_html__('Main title', 'vig-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_color',
            [
                'label' => esc_html__('Main title color', 'vig-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#066955',
                'selectors' => [
                    '{{WRAPPER}} .timeline-header-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'selector' => '{{WRAPPER}} .timeline-header-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_timeline',
            [
                'label' => esc_html__('Milestone & Content', 'vig-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'theme_color',
            [
                'label' => esc_html__('Primary color (Teal)', 'vig-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#066955',
                'selectors' => [
                    '{{WRAPPER}} .timeline-badge' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .timeline-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .timeline-dot' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label' => esc_html__('Center line color', 'vig-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .elementor-timeline-wrapper::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__('Description box background color', 'vig-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f5f3ed',
                'selectors' => [
                    '{{WRAPPER}} .timeline-content-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Milestone title typography', 'vig-elementor-addons'),
                'selector' => '{{WRAPPER}} .timeline-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => esc_html__('Description typography', 'vig-elementor-addons'),
                'selector' => '{{WRAPPER}} .timeline-content-box',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $items = $settings['timeline_items'];
        // CSS layout được tải từ assets/css/timeline-widget.css qua Plugin::enqueue_styles()
?>
        <div class="elementor-timeline-container">
            <?php if ('yes' === $settings['show_header_title'] && ! empty($settings['header_title_text'])) : ?>
                <h2 class="timeline-header-title" style="text-align: center; font-size: 36px; font-weight: 700; margin-bottom: 50px;">
                    <?php echo esc_html($settings['header_title_text']); ?>
                </h2>
            <?php endif; ?>

            <?php if (! empty($items)) : ?>
                <div class="elementor-timeline-wrapper">
                    <?php foreach ($items as $index => $item) :
                        $is_even = ($index % 2 !== 0); // Bắt đầu xen kẽ (mốc thứ 2 là Even)
                        $row_class = $is_even ? 'timeline-row-even' : 'timeline-row-odd';
                    ?>
                        <div class="timeline-row <?php echo esc_attr($row_class); ?>">
                            <div class="timeline-dot"></div>

                            <!-- Nhóm Phương tiện (Năm + Ảnh/Logos) -->
                            <div class="timeline-group-media">
                                <div class="timeline-badge-wrapper">
                                    <span class="timeline-badge"><?php echo esc_html($item['timeline_year']); ?></span>
                                </div>
                                <div class="timeline-media-container">
                                    <?php if ('image' === $item['timeline_media_type']) : ?>
                                        <?php if (! empty($item['timeline_image']['url'])) : ?>
                                            <div class="timeline-media-image">
                                                <img src="<?php echo esc_url($item['timeline_image']['url']); ?>" alt="<?php echo esc_attr($item['timeline_title']); ?>" />
                                            </div>
                                        <?php else : ?>
                                            <!-- Khung mô phỏng nhãn đỏ khi chưa upload ảnh -->
                                            <!-- <div class="timeline-media-placeholder">Ảnh đại diện</div> -->
                                        <?php endif; ?>
                                    <?php elseif ('gallery' === $item['timeline_media_type'] && ! empty($item['timeline_gallery'])) : ?>
                                        <div class="timeline-logo-grid">
                                            <?php foreach ($item['timeline_gallery'] as $gallery_img) : ?>
                                                <?php if (! empty($gallery_img['url'])) : ?>
                                                    <div class="timeline-logo-item">
                                                        <img src="<?php echo esc_url($gallery_img['url']); ?>" alt="Logo" />
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Nhóm Nội dung (Tiêu đề + Mô tả) -->
                            <div class="timeline-group-content">
                                <h3 class="timeline-title"><?php echo esc_html($item['timeline_title']); ?></h3>
                                <div class="timeline-content-box">
                                    <?php echo wp_kses_post($item['timeline_desc']); ?>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
<?php
    }
}
