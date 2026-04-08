<?php

namespace EEFE;

if (!defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

class EEFE_Slider extends Widget_Base
{
    public function get_name()
    {
        return 'eefe-slider';
    }

    public function get_title()
    {
        return __('EEFE Slider', 'extend-elements');
    }

    public function get_icon()
    {
        return 'eicon-thumbnails-down';
    }

    public function get_categories()
    {
        return ['extend-elements'];
    }

    public function get_style_depends()
    {
        return ['eefe-widget-eefe-slider'];
    }

    public function get_script_depends()
    {
        return ['eefe-widget-eefe-slider'];
    }

    protected function register_controls()
    {
        /* =============================================
		 * CONTENT TAB — Slides
		 * ============================================= */
        $this->start_controls_section(
            'section_slides',
            [
                'label' => __('Slides', 'extend-elements'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'slide_title',
            [
                'label'       => __('Slide Title', 'extend-elements'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Slide Title', 'extend-elements'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'slide_description',
            [
                'label'       => __('Slide Description', 'extend-elements'),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'extend-elements'),
            ]
        );

        $repeater->add_control(
            'slide_image',
            [
                'label'   => __('Slide Image', 'extend-elements'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'slide_link',
            [
                'label'       => __('Link (Optional)', 'extend-elements'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://example.com', 'extend-elements'),
            ]
        );

        $this->add_control(
            'slides',
            [
                'label'   => __('Slides', 'extend-elements'),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'slide_title'       => __('Slide 1', 'extend-elements'),
                        'slide_description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'extend-elements'),
                        'slide_image'       => ['url' => Utils::get_placeholder_image_src()],
                    ],
                    [
                        'slide_title'       => __('Slide 2', 'extend-elements'),
                        'slide_description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'extend-elements'),
                        'slide_image'       => ['url' => Utils::get_placeholder_image_src()],
                    ],
                    [
                        'slide_title'       => __('Slide 3', 'extend-elements'),
                        'slide_description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'extend-elements'),
                        'slide_image'       => ['url' => Utils::get_placeholder_image_src()],
                    ],
                ],
                'title_field' => '{{{ slide_title }}}',
            ]
        );

        $this->end_controls_section();

        /* =============================================
		 * CONTENT TAB — Carousel Settings
		 * ============================================= */
        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label' => __('Carousel Settings', 'extend-elements'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'slides_per_view',
            [
                'label'   => __('Slides Per View', 'extend-elements'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 10,
            ]
        );

        $this->add_control(
            'slides_space',
            [
                'label'   => __('Space Between Slides', 'extend-elements'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 20,
                'min'     => 0,
                'max'     => 100,
                'suffix'  => 'px',
            ]
        );

        $this->add_control(
            'auto_play',
            [
                'label'        => __('Auto Play', 'extend-elements'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'extend-elements'),
                'label_off'    => __('No', 'extend-elements'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'auto_play_speed',
            [
                'label'     => __('Auto Play Speed', 'extend-elements'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'min'       => 1000,
                'step'      => 1000,
                'suffix'    => 'ms',
                'condition' => ['auto_play' => 'yes'],
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label'   => __('Transition Speed', 'extend-elements'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 600,
                'min'     => 300,
                'step'    => 100,
                'suffix'  => 'ms',
            ]
        );

        $this->add_control(
            'loop_slides',
            [
                'label'        => __('Loop Slides', 'extend-elements'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'extend-elements'),
                'label_off'    => __('No', 'extend-elements'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        /* =============================================
		 * CONTENT TAB — Navigation
		 * ============================================= */
        $this->start_controls_section(
            'section_navigation',
            [
                'label' => __('Navigation', 'extend-elements'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label'        => __('Show Navigation Arrows', 'extend-elements'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'extend-elements'),
                'label_off'    => __('Hide', 'extend-elements'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'        => __('Show Pagination Dots', 'extend-elements'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'extend-elements'),
                'label_off'    => __('Hide', 'extend-elements'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_thumbnails',
            [
                'label'        => __('Show Thumbnails', 'extend-elements'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Show', 'extend-elements'),
                'label_off'    => __('Hide', 'extend-elements'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'thumbnail_trigger',
            [
                'label'   => __('Thumbnail Trigger', 'extend-elements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'click',
                'options' => [
                    'click' => __('On Click', 'extend-elements'),
                    'hover' => __('On Hover', 'extend-elements'),
                ],
                'condition' => ['show_thumbnails' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_width',
            [
                'label'      => __('Thumbnail Width', 'extend-elements'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 40, 'max' => 200, 'step' => 5]],
                'default'    => ['unit' => 'px', 'size' => 80],
                'selectors'  => ['{{WRAPPER}} .eefe-thumbnail' => 'width: {{SIZE}}{{UNIT}};'],
                'condition'  => ['show_thumbnails' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_gap',
            [
                'label'      => __('Gap Between Thumbnails', 'extend-elements'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 30, 'step' => 1]],
                'default'    => ['unit' => 'px', 'size' => 10],
                'selectors'  => ['{{WRAPPER}} .eefe-thumbnails' => 'gap: {{SIZE}}{{UNIT}};'],
                'condition'  => ['show_thumbnails' => 'yes'],
            ]
        );

        $this->end_controls_section();

        /* =============================================
		 * STYLE TAB — Slider Container
		 * ============================================= */
        $this->start_controls_section(
            'section_style_slider',
            [
                'label' => __('Slider Container', 'extend-elements'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label'      => __('Slider Height', 'extend-elements'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range'      => [
                    'px' => ['min' => 200, 'max' => 1000, 'step' => 10],
                    'vh' => ['min' => 20, 'max' => 100],
                ],
                'default'    => ['unit' => 'px', 'size' => 500],
                'selectors'  => ['{{WRAPPER}} .eefe-slider' => 'height: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->add_control(
            'slider_bg_color',
            [
                'label'     => __('Background Color', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f5f5f5',
                'selectors' => ['{{WRAPPER}} .eefe-slider' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'slider_border_radius',
            [
                'label'      => __('Border Radius', 'extend-elements'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => ['{{WRAPPER}} .eefe-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );

        $this->end_controls_section();

        /* =============================================
		 * STYLE TAB — Slide Content
		 * ============================================= */
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Slide Content', 'extend-elements'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label'   => __('Content Alignment', 'extend-elements'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Start', 'extend-elements'),
                        'icon'  => 'eicon-align-start-v',
                    ],
                    'center'     => [
                        'title' => __('Center', 'extend-elements'),
                        'icon'  => 'eicon-align-center-v',
                    ],
                    'flex-end'   => [
                        'title' => __('End', 'extend-elements'),
                        'icon'  => 'eicon-align-end-v',
                    ],
                ],
                'default' => 'center',
                'selectors' => ['{{WRAPPER}} .eefe-slide-content' => 'justify-content: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'content_bg_color',
            [
                'label'     => __('Content Background', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .eefe-slide-content' => 'background-color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'content_padding',
            [
                'label'      => __('Content Padding', 'extend-elements'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => ['{{WRAPPER}} .eefe-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label'     => __('Title', 'extend-elements'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __('Title Typography', 'extend-elements'),
                'selector' => '{{WRAPPER}} .eefe-slide-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => ['{{WRAPPER}} .eefe-slide-title' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_control(
            'description_heading',
            [
                'label'     => __('Description', 'extend-elements'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => __('Description Typography', 'extend-elements'),
                'selector' => '{{WRAPPER}} .eefe-slide-description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __('Description Color', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#666666',
                'selectors' => ['{{WRAPPER}} .eefe-slide-description' => 'color: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();

        /* =============================================
		 * STYLE TAB — Navigation
		 * ============================================= */
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __('Navigation', 'extend-elements'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label'     => __('Arrow Color', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eefe-slider-arrow' => 'color: {{VALUE}};',
                ],
                'condition' => ['show_arrows' => 'yes'],
            ]
        );

        $this->add_control(
            'arrow_bg_color',
            [
                'label'     => __('Arrow Background', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0,0,0,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .eefe-slider-arrow' => 'background-color: {{VALUE}};',
                ],
                'condition' => ['show_arrows' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'arrow_size',
            [
                'label'     => __('Arrow Size', 'extend-elements'),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'     => ['px' => ['min' => 20, 'max' => 80]],
                'default'   => ['unit' => 'px', 'size' => 40],
                'selectors' => [
                    '{{WRAPPER}} .eefe-slider-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['show_arrows' => 'yes'],
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label'     => __('Dot Color', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255,255,255,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .eefe-pagination-dot' => 'background-color: {{VALUE}};',
                ],
                'condition' => ['show_pagination' => 'yes'],
            ]
        );

        $this->add_control(
            'dot_active_color',
            [
                'label'     => __('Active Dot Color', 'extend-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eefe-pagination-dot.active' => 'background-color: {{VALUE}};',
                ],
                'condition' => ['show_pagination' => 'yes'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $slides_per_view = intval($settings['slides_per_view']) ?: 1;
        $space_between   = intval($settings['slides_space']) ?: 20;
        $auto_play       = ($settings['auto_play'] === 'yes');
        $auto_play_speed = intval($settings['auto_play_speed']) ?: 5000;
        $speed           = intval($settings['transition_speed']) ?: 600;
        $loop            = ($settings['loop_slides'] === 'yes');
        $show_arrows     = ($settings['show_arrows'] === 'yes');
        $show_pagination = ($settings['show_pagination'] === 'yes');
        $show_thumbnails = ($settings['show_thumbnails'] === 'yes');
        $thumbnail_trigger = $settings['thumbnail_trigger'] ?: 'click';
        $slides          = $settings['slides'] ?: [];

?>
        <div class="eefe-slider-wrapper"
            data-slides-per-view="<?php echo esc_attr($slides_per_view); ?>"
            data-space-between="<?php echo esc_attr($space_between); ?>"
            data-auto-play="<?php echo esc_attr($auto_play ? '1' : '0'); ?>"
            data-auto-play-speed="<?php echo esc_attr($auto_play_speed); ?>"
            data-speed="<?php echo esc_attr($speed); ?>"
            data-loop="<?php echo esc_attr($loop ? '1' : '0'); ?>"
            data-thumbnail-trigger="<?php echo esc_attr($thumbnail_trigger); ?>">

            <div class="eefe-slider">
                <div class="eefe-slides-container">
                    <?php foreach ($slides as $index => $slide) : ?>
                        <div class="eefe-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                            <?php if (!empty($slide['slide_image']['url'])) : ?>
                                <div class="eefe-slide-image">
                                    <img src="<?php echo esc_url($slide['slide_image']['url']); ?>" alt="<?php echo esc_attr($slide['slide_title']); ?>" />
                                </div>
                            <?php endif; ?>

                            <div class="eefe-slide-content">
                                <div class="eefe-slide-text">
                                    <?php if (!empty($slide['slide_title'])) : ?>
                                        <h2 class="eefe-slide-title"><?php echo wp_kses_post($slide['slide_title']); ?></h2>
                                    <?php endif; ?>

                                    <?php if (!empty($slide['slide_description'])) : ?>
                                        <div class="eefe-slide-description"><?php echo wp_kses_post($slide['slide_description']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (!empty($slide['slide_link']['url'])) : ?>
                                <a href="<?php echo esc_url($slide['slide_link']['url']); ?>" class="eefe-slide-link" target="<?php echo esc_attr($slide['slide_link']['is_external'] ? '_blank' : '_self'); ?>"></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($show_arrows) : ?>
                    <button class="eefe-slider-arrow eefe-slider-prev" aria-label="<?php esc_attr_e('Previous slide', 'extend-elements'); ?>">
                        <i class="eicon-chevron-left"></i>
                    </button>
                    <button class="eefe-slider-arrow eefe-slider-next" aria-label="<?php esc_attr_e('Next slide', 'extend-elements'); ?>">
                        <i class="eicon-chevron-right"></i>
                    </button>
                <?php endif; ?>
            </div>

            <?php if ($show_pagination) : ?>
                <div class="eefe-pagination">
                    <?php for ($i = 0; $i < count($slides); $i++) : ?>
                        <span class="eefe-pagination-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo esc_attr($i); ?>"></span>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

            <?php if ($show_thumbnails) : ?>
                <div class="eefe-thumbnails">
                    <?php foreach ($slides as $index => $slide) : ?>
                        <div class="eefe-thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo esc_attr($index); ?>">
                            <?php if (!empty($slide['slide_image']['url'])) : ?>
                                <img src="<?php echo esc_url($slide['slide_image']['url']); ?>" alt="<?php echo esc_attr($slide['slide_title']); ?>" />
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
<?php
    }
}
