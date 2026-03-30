<?php
/**
 * Gradient Heading Elementor widget.
 *
 * @package Extend_Elements_For_Elementor
 */

namespace EEFE\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gradient_Heading_Widget extends Widget_Base {

	const ASSET_HANDLE = 'eefe-widget-gradient-heading';

	public function get_name() {
		return 'eefe-gradient-heading';
	}

	public function get_title() {
		return esc_html__( 'Gradient Heading', 'extend-elements-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-t-letter';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_keywords() {
		return array( 'gradient', 'heading', 'title', 'animated', 'text' );
	}

	public function get_style_depends() {
		return array( self::ASSET_HANDLE );
	}

	public function get_script_depends() {
		return array( self::ASSET_HANDLE );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'extend-elements-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'heading_text',
			array(
				'label'       => esc_html__( 'Heading Text', 'extend-elements-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Gradient Heading', 'extend-elements-for-elementor' ),
				'placeholder' => esc_html__( 'Type your heading here', 'extend-elements-for-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'heading_tag',
			array(
				'label'   => esc_html__( 'HTML Tag', 'extend-elements-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
			)
		);

		$this->add_control(
			'animation_style',
			array(
				'label'   => esc_html__( 'Animation Style', 'extend-elements-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array(
					'none'    => esc_html__( 'None', 'extend-elements-for-elementor' ),
					'shimmer' => esc_html__( 'Shimmer', 'extend-elements-for-elementor' ),
					'pulse'   => esc_html__( 'Pulse', 'extend-elements-for-elementor' ),
					'wave'    => esc_html__( 'Wave', 'extend-elements-for-elementor' ),
					'float'   => esc_html__( 'Float', 'extend-elements-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'animation_duration',
			array(
				'label'      => esc_html__( 'Animation Duration (seconds)', 'extend-elements-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 's' ),
				'range'      => array(
					's' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 0.5,
					),
				),
				'default'    => array(
					'unit' => 's',
					'size' => 4,
				),
				'condition'  => array(
					'animation_style!' => 'none',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'extend-elements-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'extend-elements-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'extend-elements-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'extend-elements-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'extend-elements-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .eefe-gradient-heading' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gradient_color_start',
			array(
				'label'     => esc_html__( 'Gradient Color 1', 'extend-elements-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#8b5cf6',
				'selectors' => array(
					'{{WRAPPER}} .eefe-gradient-heading__text' => '--eefe-color-1: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gradient_color_end',
			array(
				'label'     => esc_html__( 'Gradient Color 2', 'extend-elements-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#06b6d4',
				'selectors' => array(
					'{{WRAPPER}} .eefe-gradient-heading__text' => '--eefe-color-2: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'gradient_angle',
			array(
				'label'      => esc_html__( 'Gradient Angle', 'extend-elements-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'range'      => array(
					'deg' => array(
						'min'  => 0,
						'max'  => 360,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'deg',
					'size' => 90,
				),
				'selectors'  => array(
					'{{WRAPPER}} .eefe-gradient-heading__text' => '--eefe-angle: {{SIZE}}deg;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .eefe-gradient-heading__text',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$tag      = ! empty( $settings['heading_tag'] ) ? $settings['heading_tag'] : 'h2';
		$text     = ! empty( $settings['heading_text'] ) ? $settings['heading_text'] : '';
		$style    = ! empty( $settings['animation_style'] ) ? $settings['animation_style'] : 'none';

		$duration = 4;
		if ( ! empty( $settings['animation_duration']['size'] ) ) {
			$duration = (float) $settings['animation_duration']['size'];
		}

		$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' );
		if ( ! in_array( $tag, $allowed_tags, true ) ) {
			$tag = 'h2';
		}

		$allowed_animations = array( 'none', 'shimmer', 'pulse', 'wave', 'float' );
		if ( ! in_array( $style, $allowed_animations, true ) ) {
			$style = 'none';
		}

		$this->add_render_attribute(
			'heading_text',
			array(
				'class' => array(
					'eefe-gradient-heading__text',
					'eefe-gradient-heading--' . $style,
				),
				'style' => '--eefe-animation-duration: ' . $duration . 's;',
			)
		);

		echo '<div class="eefe-gradient-heading">';
		printf(
			'<%1$s %2$s>%3$s</%1$s>',
			esc_attr( $tag ),
			$this->get_render_attribute_string( 'heading_text' ),
			esc_html( $text )
		);
		echo '</div>';
	}
}
