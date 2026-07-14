<?php

namespace VIG_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Icon Search Widget — Hiển thị biểu tượng tìm kiếm dạng Dropdown popup.
 */
class Icon_Search_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'icon_search';
    }

    public function get_title()
    {
        return esc_html__('Icon Search', 'vig-elementor-addons');
    }

    public function get_icon()
    {
        return 'eicon-search';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function get_style_depends()
    {
        return ['vig-icon-search-widget'];
    }

    public function get_script_depends()
    {
        return ['vig-icon-search-widget'];
    }

    protected function register_controls()
    {

        // TAB 1: CẤU HÌNH NỘI DUNG (Content)
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Search settings', 'vig-elementor-addons'),
            ]
        );

        $this->add_control(
            'placeholder_text',
            [
                'label'       => esc_html__('Placeholder text', 'vig-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Lorem ipsum',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => esc_html__('Search button text', 'vig-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Search',
            ]
        );

        $this->add_control(
            'dropdown_align',
            [
                'label'   => esc_html__('Dropdown alignment', 'vig-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'  => esc_html__('Left', 'vig-elementor-addons'),
                    'right' => esc_html__('Right', 'vig-elementor-addons'),
                ],
            ]
        );

        $this->end_controls_section();


        // TAB 2: CẤU HÌNH THIẾT KẾ (Style Tab)
        // 1. Biểu tượng kích hoạt (Trigger Icon)
        $this->start_controls_section(
            'section_style_trigger',
            [
                'label' => esc_html__('Trigger Icon', 'vig-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'trigger_size',
            [
                'label'      => esc_html__('Icon size (px)', 'vig-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 60,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 22,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .header-search-trigger svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_trigger_color');

        $this->start_controls_tab(
            'tab_trigger_normal',
            [
                'label' => esc_html__('Normal', 'vig-elementor-addons'),
            ]
        );

        $this->add_control(
            'trigger_color',
            [
                'label'     => esc_html__('Icon color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#066955',
                'selectors' => [
                    '{{WRAPPER}} .header-search-trigger svg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_trigger_hover',
            [
                'label' => esc_html__('Hover', 'vig-elementor-addons'),
            ]
        );

        $this->add_control(
            'trigger_color_hover',
            [
                'label'     => esc_html__('Icon color on hover', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#004d3e',
                'selectors' => [
                    '{{WRAPPER}} .header-search-trigger:hover svg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // 2. Thiết kế Hộp Dropdown bên ngoài (Dropdown Card)
        $this->start_controls_section(
            'section_style_dropdown',
            [
                'label' => esc_html__('Dropdown box', 'vig-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'dropdown_bg',
            [
                'label'     => esc_html__('Box background color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .header-search-dropdown' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dropdown_border_color',
            [
                'label'     => esc_html__('Border color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .header-search-dropdown' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dropdown_border_width',
            [
                'label'      => esc_html__('Border width (px)', 'vig-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .header-search-dropdown' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
                ],
            ]
        );

        $this->add_responsive_control(
            'dropdown_padding',
            [
                'label'      => esc_html__('Inner padding', 'vig-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'      => '20',
                    'bottom'   => '20',
                    'left'     => '24',
                    'right'    => '24',
                    'unit'     => 'px',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .header-search-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'dropdown_shadow',
                'selector' => '{{WRAPPER}} .header-search-dropdown',
            ]
        );

        $this->end_controls_section();


        // 3. Khung nhập dạng con nhộng (Input Pill)
        $this->start_controls_section(
            'section_style_input',
            [
                'label' => esc_html__('Input field', 'vig-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_width',
            [
                'label'      => esc_html__('Search box width (px)', 'vig-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 200,
                        'max' => 600,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 320,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-input-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label'     => esc_html__('Pill border color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .search-input-wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label'     => esc_html__('Input text color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .search-field' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_icon_color',
            [
                'label'     => esc_html__('Inner magnifier color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#066955',
                'selectors' => [
                    '{{WRAPPER}} .input-search-icon svg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        // 4. Nút bấm Tìm kiếm (Submit Button)
        $this->start_controls_section(
            'section_style_submit',
            [
                'label' => esc_html__('Search Button', 'vig-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_submit_color');

        $this->start_controls_tab(
            'tab_submit_normal',
            [
                'label' => esc_html__('Normal', 'vig-elementor-addons'),
            ]
        );

        $this->add_control(
            'submit_bg',
            [
                'label'     => esc_html__('Button background color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#066955',
                'selectors' => [
                    '{{WRAPPER}} .search-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_text_color',
            [
                'label'     => esc_html__('Text color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .search-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_submit_hover',
            [
                'label' => esc_html__('Hover', 'vig-elementor-addons'),
            ]
        );

        $this->add_control(
            'submit_bg_hover',
            [
                'label'     => esc_html__('Background color on hover', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#004d3e',
                'selectors' => [
                    '{{WRAPPER}} .search-submit:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'submit_typography',
                'label'    => esc_html__('Button typography', 'vig-elementor-addons'),
                'selector' => '{{WRAPPER}} .search-submit',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings  = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $align_class = 'dropdown-align-' . esc_attr($settings['dropdown_align']);
?>
        <div class="header-search-widget-wrapper">
            <!-- Nút Trigger Kính Lúp -->
            <button class="header-search-trigger" id="trigger-<?php echo esc_attr($widget_id); ?>" aria-label="Open Search">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <circle cx="11" cy="11" r="7" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </button>

            <!-- Khung Dropdown xuất hiện bên dưới -->
            <div class="header-search-dropdown <?php echo esc_attr($align_class); ?>" id="dropdown-<?php echo esc_attr($widget_id); ?>">
                <form role="search" method="get" class="header-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-input-wrapper">
                        <!-- Kính lúp con phụ bên trái -->
                        <div class="input-search-icon">
                            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <circle cx="11" cy="11" r="7" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </div>

                        <!-- Ô nhập liệu của WordPress -->
                        <input type="search" class="search-field" placeholder="<?php echo esc_attr($settings['placeholder_text']); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" required />

                        <!-- Nút gửi -->
                        <button type="submit" class="search-submit">
                            <?php echo esc_html($settings['button_text']); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
