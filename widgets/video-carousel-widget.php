<?php

namespace VIG_Elementor_Addon\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Video Carousel Widget — Hiển thị carousel video với lightbox.
 */
class Video_Carousel_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'video_carousel';
    }

    public function get_title()
    {
        return esc_html__('Video Carousel', 'vig-elementor-addons');
    }

    public function get_icon()
    {
        return 'eicon-video-playlist';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function register_controls()
    {

        // DANH SÁCH VIDEO CAROUSEL
        $this->start_controls_section(
            'section_carousel_items',
            [
                'label' => esc_html__('Video list', 'vig-elementor-addons'),
            ]
        );
        $this->add_control(
            'show_header_title',
            [
                'label'        => esc_html__('Show title', 'vig-elementor-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'vig-elementor-addons'),
                'label_off'    => esc_html__('Hide', 'vig-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'header_title_text',
            [
                'label'     => esc_html__('Title text', 'vig-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Media', 'vig-elementor-addons'),
                'condition' => [
                    'show_header_title' => 'yes',
                ],
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'video_caption',
            [
                'label'       => esc_html__('Short description below the video', 'vig-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Our IQF production line features a fluidized bed freezing system',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'video_url',
            [
                'label'       => esc_html__('Video link (YouTube, Vimeo or MP4)', 'vig-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'https://www.youtube.com/watch?v=xxxxxx',
                'label_block' => true,
                'default'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ]
        );

        $repeater->add_control(
            'video_thumbnail',
            [
                'label' => esc_html__('Video cover (Thumbnail)', 'vig-elementor-addons'),
                'type'  => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label'       => esc_html__('Slide list', 'vig-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'video_caption' => 'Our IQF production line features a fluidized bed freezing system',
                        'video_url'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    ],
                    [
                        'video_caption' => 'Our IQF production line features a fluidized bed freezing system',
                        'video_url'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    ],
                    [
                        'video_caption' => 'Our IQF production line features a fluidized bed freezing system',
                        'video_url'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    ],
                ],
                'title_field' => '{{{ video_caption }}}',
            ]
        );

        $this->end_controls_section();

        // TÙY CHỈNH THIẾT KẾ (Style Tab)
        $this->start_controls_section(
            'section_style_carousel',
            [
                'label' => esc_html__('Slider style', 'vig-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Main title color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#066955',
                'selectors' => [
                    '{{WRAPPER}} .carousel-header-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label'     => esc_html__('Arrow color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#066955',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-custom svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'     => esc_html__('Slide border radius (px)', 'vig-elementor-addons'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 20,
                'selectors' => [
                    '{{WRAPPER}} .video-slide-card'    => 'border-radius: {{VALUE}}px;',
                    '{{WRAPPER}} .video-slide-caption' => 'border-bottom-left-radius: {{VALUE}}px; border-bottom-right-radius: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'slide_min_height',
            [
                'label'      => esc_html__('Slide minimum height', 'vig-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 100,
                        'max'  => 800,
                        'step' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 380,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .video-slide-card' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'caption_typography',
                'label'    => esc_html__('Description typography', 'vig-elementor-addons'),
                'selector' => '{{WRAPPER}} .video-slide-caption',
            ]
        );

        $this->add_control(
            'caption_color',
            [
                'label'     => esc_html__('Description text color', 'vig-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .video-slide-caption' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings  = $this->get_settings_for_display();
        $items     = $settings['carousel_items'];
        $widget_id = $this->get_id();

        wp_enqueue_script('swiper');
        wp_enqueue_style('swiper');
?>

        <div class="video-carousel-container">
            <?php if ('yes' === $settings['show_header_title'] && ! empty($settings['header_title_text'])) : ?>
                <h2 class="carousel-header-title" style="text-align: center; font-size: 36px; font-weight: 700; margin-bottom: 40px;">
                    <?php echo esc_html($settings['header_title_text']); ?>
                </h2>
            <?php endif; ?>

            <?php if (! empty($items)) : ?>
                <div class="swiper-container swiper-<?php echo esc_attr($widget_id); ?>">
                    <div class="swiper-wrapper swiper-wrapper-custom">
                        <?php foreach ($items as $item) :
                            $thumb_url = ! empty($item['video_thumbnail']['url']) ? esc_url($item['video_thumbnail']['url']) : 'https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?auto=format&fit=crop&w=800&q=80';
                        ?>
                            <div class="swiper-slide">
                                <div class="video-slide-card" style="background-image: url('<?php echo esc_url($thumb_url); ?>');" data-video-src="<?php echo esc_url($item['video_url']); ?>">
                                    <div class="video-play-btn">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                    <div class="video-slide-caption">
                                        <?php echo esc_html($item['video_caption']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="swiper-button-custom swiper-button-custom-prev swiper-button-prev-<?php echo esc_attr($widget_id); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="41" viewBox="0 0 24 41" fill="none">
                            <path d="M22.035 38.2575L3.875 20.0975L22.035 1.9375" stroke="#646400" stroke-width="5.48" stroke-miterlimit="10" />
                        </svg>
                    </div>
                    <div class="swiper-button-custom swiper-button-custom-next swiper-button-next-<?php echo esc_attr($widget_id); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="41" viewBox="0 0 24 41" fill="none">
                            <path d="M1.9375 1.93848L20.1075 20.0985L1.9375 38.2585" stroke="#646400" stroke-width="5.48" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="custom-video-lightbox" id="vdp-lightbox-<?php echo esc_attr($widget_id); ?>">
            <span class="lightbox-close-btn">&times;</span>
            <div class="lightbox-container"></div>
        </div>

        <script>
            (function() {
                var initializeCarousel = function() {
                    if (typeof Swiper === 'undefined') {
                        setTimeout(initializeCarousel, 100);
                        return;
                    }

                    var swiperEl = document.querySelector('.swiper-<?php echo esc_attr($widget_id); ?>');
                    if (!swiperEl) return;

                    var swiper = new Swiper(swiperEl, {
                        slidesPerView: 1.2,
                        centeredSlides: true,
                        spaceBetween: 15,
                        loop: false,
                        observer: true,
                        observeParents: true,
                        navigation: {
                            nextEl: swiperEl.querySelector('.swiper-button-next-<?php echo esc_attr($widget_id); ?>'),
                            prevEl: swiperEl.querySelector('.swiper-button-prev-<?php echo esc_attr($widget_id); ?>'),
                        },
                        breakpoints: {
                            768: {
                                slidesPerView: 1.5,
                                spaceBetween: 25,
                            },
                            1024: {
                                slidesPerView: 1.6,
                                spaceBetween: 30,
                            }
                        }
                    });

                    // Lightbox — scoped theo widget ID để tránh xung đột khi có nhiều widget trên cùng trang
                    var lightbox = document.getElementById('vdp-lightbox-<?php echo esc_attr($widget_id); ?>');
                    var container = lightbox.querySelector('.lightbox-container');
                    var closeBtn = lightbox.querySelector('.lightbox-close-btn');

                    document.querySelectorAll('.swiper-<?php echo esc_attr($widget_id); ?> .video-slide-card').forEach(function(card) {
                        card.addEventListener('click', function() {
                            var videoUrl = this.getAttribute('data-video-src');
                            var embedHtml = '';

                            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                                var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                                var match = videoUrl.match(regExp);
                                if (match && match[2].length === 11) {
                                    embedHtml = '<iframe src="https://www.youtube.com/embed/' + match[2] + '?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width:100%;height:100%;border-radius:12px;"></iframe>';
                                }
                            } else if (videoUrl.includes('vimeo.com')) {
                                var regExp = /vimeo\.com\/([0-9]+)/;
                                var match = videoUrl.match(regExp);
                                if (match) {
                                    embedHtml = '<iframe src="https://player.vimeo.com/video/' + match[1] + '?autoplay=1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="width:100%;height:100%;border-radius:12px;"></iframe>';
                                }
                            } else {
                                embedHtml = '<video src="' + videoUrl + '" controls autoplay style="width:100%;height:100%;border-radius:12px;"></video>';
                            }

                            container.innerHTML = embedHtml;
                            lightbox.classList.add('active');
                        });
                    });

                    var closeLightbox = function() {
                        lightbox.classList.remove('active');
                        container.innerHTML = '';
                    };

                    closeBtn.addEventListener('click', closeLightbox);
                    lightbox.addEventListener('click', function(e) {
                        if (e.target === lightbox) {
                            closeLightbox();
                        }
                    });
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initializeCarousel);
                } else {
                    initializeCarousel();
                }
            })();
        </script>
<?php
    }
}
