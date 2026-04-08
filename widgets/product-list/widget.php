<?php

namespace EEFE;

if (! defined('ABSPATH')) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use WP_Query;

class EEFE_Product extends Widget_Base
{

	public function get_name()
	{
		return 'eefe-product';
	}

	public function get_title()
	{
		return __('Product List', 'extend-elements');
	}

	public function get_icon()
	{
		return 'eicon-product-upsell';
	}

	public function get_categories()
	{
		return ['extend-elements'];
	}

	public function get_style_depends()
	{
		return ['eefe-widget-product-list'];
	}

	public function get_script_depends()
	{
		return ['eefe-widget-product-list'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'section_query',
			[
				'label' => __('Query', 'extend-elements'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'query_source',
			[
				'label'   => __('Source', 'extend-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest'   => __('Latest Products', 'extend-elements'),
					'featured' => __('Featured Products', 'extend-elements'),
					'sale'     => __('Sale Products', 'extend-elements'),
					'manual'   => __('Manual Selection', 'extend-elements'),
				],
			]
		);

		$this->add_control(
			'query_filter_type',
			[
				'label'   => __('Filter By', 'extend-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'include',
				'options' => [
					'include' => __('Include', 'extend-elements'),
					'exclude' => __('Exclude', 'extend-elements'),
				],
			]
		);

		$this->add_control(
			'query_taxonomy',
			[
				'label'   => __('Taxonomy', 'extend-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'product_cat',
				'options' => [
					'product_cat' => __('Category', 'extend-elements'),
					'product_tag' => __('Tag', 'extend-elements'),
				],
			]
		);

		$this->add_control(
			'query_terms_cat',
			[
				'label'       => __('Categories', 'extend-elements'),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_product_categories(),
				'condition'   => ['query_taxonomy' => 'product_cat'],
			]
		);

		$this->add_control(
			'query_terms_tag',
			[
				'label'       => __('Tags', 'extend-elements'),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_product_tags(),
				'condition'   => ['query_taxonomy' => 'product_tag'],
			]
		);

		$this->add_control(
			'query_author',
			[
				'label'       => __('Author', 'extend-elements'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'query_orderby',
			[
				'label'   => __('Order By', 'extend-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => __('Date', 'extend-elements'),
					'title'      => __('Title', 'extend-elements'),
					'price'      => __('Price', 'extend-elements'),
					'popularity' => __('Popularity', 'extend-elements'),
					'rating'     => __('Rating', 'extend-elements'),
					'rand'       => __('Random', 'extend-elements'),
				],
			]
		);

		$this->add_control(
			'query_order',
			[
				'label'   => __('Order', 'extend-elements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __('DESC', 'extend-elements'),
					'ASC'  => __('ASC', 'extend-elements'),
				],
			]
		);

		$this->add_control(
			'query_posts_per_page',
			[
				'label'   => __('Products Per Page', 'extend-elements'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
			]
		);

		$this->end_controls_section();

		/* =============================================
		 * CONTENT TAB — Card Display Toggles
		 * ============================================= */
		$this->start_controls_section(
			'section_card_toggles',
			[
				'label' => __('Product Card', 'extend-elements'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'        => __('Show Image', 'extend-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'extend-elements'),
				'label_off'    => __('Hide', 'extend-elements'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'        => __('Show Title', 'extend-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'extend-elements'),
				'label_off'    => __('Hide', 'extend-elements'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_subtitle',
			[
				'label'        => __('Show Subtitle', 'extend-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'extend-elements'),
				'label_off'    => __('Hide', 'extend-elements'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'        => __('Show Price', 'extend-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'extend-elements'),
				'label_off'    => __('Hide', 'extend-elements'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_review',
			[
				'label'        => __('Show Review Stars', 'extend-elements'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'extend-elements'),
				'label_off'    => __('Hide', 'extend-elements'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// ── Card Element Order ────────────────────────────
		$this->add_control(
			'card_order_heading',
			[
				'label'     => __('Card Element Order', 'extend-elements'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'card_order_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('Set the display order for Image, Title, and Subtitle inside the card. Use numbers 1–3 (lower = appears first).', 'extend-elements'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'card_order_image',
			[
				'label'   => __('Image Order', 'extend-elements'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 3,
			]
		);

		$this->add_control(
			'card_order_title',
			[
				'label'   => __('Title Order', 'extend-elements'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 3,
			]
		);

		$this->add_control(
			'card_order_subtitle',
			[
				'label'   => __('Subtitle Order', 'extend-elements'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 3,
			]
		);

		$this->end_controls_section();

		/* =============================================
		 * STYLE TAB — Product List
		 * ============================================= */
		$this->start_controls_section(
			'section_style_list',
			[
				'label' => __('Product List Title', 'extend-elements'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'list_heading',
			[
				'label'       => __('Heading', 'extend-elements'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Products', 'extend-elements'),
				'label_block' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => __('Heading Typography', 'extend-elements'),
				'selector' => '{{WRAPPER}} .eefe-product-heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __('Heading Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => ['{{WRAPPER}} .eefe-product-heading' => 'color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'list_column_width',
			[
				'label'      => __('Column Width', 'extend-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range'      => ['%' => ['min' => 20, 'max' => 80, 'step' => 1]],
				'default'    => ['unit' => '%', 'size' => 55],
				'selectors'  => ['{{WRAPPER}} .eefe-product-left' => 'flex: 0 0 {{SIZE}}{{UNIT}};'],
			]
		);

		$this->end_controls_section();

		/* =============================================
		 * STYLE TAB — Product Name (List Items)
		 * ============================================= */
		$this->start_controls_section(
			'section_style_name',
			[
				'label' => __('Product Name', 'extend-elements'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'label'    => __('Typography', 'extend-elements'),
				'selector' => '{{WRAPPER}} .eefe-product-name',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => __('Default Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => ['{{WRAPPER}} .eefe-product-name' => 'color: {{VALUE}};'],
			]
		);



		$this->add_control(
			'name_active_color',
			[
				'label'     => __('Active Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#005177',
				'selectors' => ['{{WRAPPER}} .eefe-product-item.is-active .eefe-product-name' => 'color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'name_bg_color',
			[
				'label'     => __('Background Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => ['{{WRAPPER}} .eefe-product-item' => 'background-color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'name_active_bg_color',
			[
				'label'     => __('Active Background Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => ['{{WRAPPER}} .eefe-product-item.is-active' => 'background-color: {{VALUE}};'],
			]
		);

		$this->end_controls_section();

		/* =============================================
		 * STYLE TAB — Product Card (Hover Panel)
		 * ============================================= */
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => __('Product Card', 'extend-elements'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_background',
			[
				'label'     => __('Card Background', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => ['{{WRAPPER}} .eefe-product-card' => 'background-color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'      => __('Border Radius', 'extend-elements'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => ['{{WRAPPER}} .eefe-product-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label'     => __('Border Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e4e4e4',
				'selectors' => ['{{WRAPPER}} .eefe-product-card' => 'border-color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'card_box_shadow',
			[
				'label'     => __('Box Shadow', 'extend-elements'),
				'type'      => Controls_Manager::TEXT,
				'selectors' => ['{{WRAPPER}} .eefe-product-card' => 'box-shadow: {{VALUE}};'],
				'description' => __('Enter box-shadow CSS value. Example: 0 4px 24px rgba(0,0,0,0.08)', 'extend-elements'),
			]
		);

		// ── Card Image ────────────────────────────────────
		$this->add_control(
			'card_image_heading',
			[
				'label'     => __('Card Image', 'extend-elements'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['show_image' => 'yes'],
			]
		);

		$this->add_responsive_control(
			'card_image_height',
			[
				'label'      => __('Image Height', 'extend-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh', '%'],
				'range'      => [
					'px' => ['min' => 80, 'max' => 600, 'step' => 4],
					'vh' => ['min' => 10, 'max' => 80],
					'%'  => ['min' => 10, 'max' => 100, 'step' => 1],
				],
				'selectors'  => ['{{WRAPPER}} .eefe-card-image-wrap' => 'height: {{SIZE}}{{UNIT}}; aspect-ratio: unset;'],
				'condition'  => ['show_image' => 'yes'],
			]
		);

		$this->add_control(
			'card_image_fit',
			[
				'label'     => __('Image Fit', 'extend-elements'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'contain',
				'options'   => [
					'contain' => __('Contain', 'extend-elements'),
					'cover'   => __('Cover', 'extend-elements'),
					'fill'    => __('Fill', 'extend-elements'),
					'none'    => __('None', 'extend-elements'),
				],
				'selectors' => ['{{WRAPPER}} .eefe-card-image' => 'object-fit: {{VALUE}};'],
				'condition' => ['show_image' => 'yes'],
			]
		);

		$this->add_control(
			'card_image_bg_color',
			[
				'label'     => __('Image Area Background', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5f5f5',
				'selectors' => ['{{WRAPPER}} .eefe-card-image-wrap' => 'background-color: {{VALUE}};'],
				'condition' => ['show_image' => 'yes'],
			]
		);

		// ── Card Title ────────────────────────────────────
		$this->add_control(
			'card_title_heading',
			[
				'label'     => __('Card Title', 'extend-elements'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['show_title' => 'yes'],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'card_title_typography',
				'label'     => __('Title Typography', 'extend-elements'),
				'selector'  => '{{WRAPPER}} .eefe-card-title',
				'condition' => ['show_title' => 'yes'],
			]
		);

		$this->add_control(
			'card_title_color',
			[
				'label'     => __('Title Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => ['{{WRAPPER}} .eefe-card-title' => 'color: {{VALUE}};'],
				'condition' => ['show_title' => 'yes'],
			]
		);

		// ── Card Subtitle ─────────────────────────────────
		$this->add_control(
			'card_subtitle_heading',
			[
				'label'     => __('Card Subtitle', 'extend-elements'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['show_subtitle' => 'yes'],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'card_subtitle_typography',
				'label'     => __('Subtitle Typography', 'extend-elements'),
				'selector'  => '{{WRAPPER}} .eefe-card-subtitle',
				'condition' => ['show_subtitle' => 'yes'],
			]
		);

		$this->add_control(
			'card_subtitle_color',
			[
				'label'     => __('Subtitle Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => ['{{WRAPPER}} .eefe-card-subtitle' => 'color: {{VALUE}};'],
				'condition' => ['show_subtitle' => 'yes'],
			]
		);

		$this->add_responsive_control(
			'card_subtitle_spacing',
			[
				'label'      => __('Subtitle Bottom Spacing', 'extend-elements'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 0, 'max' => 40]],
				'default'    => ['unit' => 'px', 'size' => 6],
				'selectors'  => ['{{WRAPPER}} .eefe-card-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
				'condition'  => ['show_subtitle' => 'yes'],
			]
		);

		// ── Card Price ────────────────────────────────────
		$this->add_control(
			'card_price_heading',
			[
				'label'     => __('Card Price', 'extend-elements'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['show_price' => 'yes'],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'card_price_typography',
				'label'     => __('Price Typography', 'extend-elements'),
				'selector'  => '{{WRAPPER}} .eefe-card-price',
				'condition' => ['show_price' => 'yes'],
			]
		);

		$this->add_control(
			'card_price_color',
			[
				'label'     => __('Price Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => ['{{WRAPPER}} .eefe-card-price' => 'color: {{VALUE}};'],
				'condition' => ['show_price' => 'yes'],
			]
		);

		// ── Card Review ───────────────────────────────────
		$this->add_control(
			'card_review_heading',
			[
				'label'     => __('Card Review', 'extend-elements'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => ['show_review' => 'yes'],
			]
		);

		$this->add_control(
			'card_star_color',
			[
				'label'     => __('Star Color', 'extend-elements'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5a623',
				'selectors' => ['{{WRAPPER}} .eefe-card-stars .star-filled' => 'color: {{VALUE}};'],
				'condition' => ['show_review' => 'yes'],
			]
		);

		$this->end_controls_section();
	}

	/* =============================================
	 * Helper: Get Product Categories
	 * ============================================= */
	private function get_product_categories()
	{
		$options = [];
		$terms   = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
		if (! is_wp_error($terms)) {
			foreach ($terms as $term) {
				$options[$term->slug] = $term->name;
			}
		}
		return $options;
	}

	/* =============================================
	 * Helper: Get Product Tags
	 * ============================================= */
	private function get_product_tags()
	{
		$options = [];
		$terms   = get_terms(['taxonomy' => 'product_tag', 'hide_empty' => false]);
		if (! is_wp_error($terms)) {
			foreach ($terms as $term) {
				$options[$term->slug] = $term->name;
			}
		}
		return $options;
	}

	/* =============================================
	 * Helper: Build WP_Query Args
	 * ============================================= */
	private function build_query_args($settings)
	{
		$args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $settings['query_posts_per_page'] ?: 10,
			'orderby'        => $settings['query_orderby'],
			'order'          => $settings['query_order'],
		];

		// Source
		switch ($settings['query_source']) {
			case 'featured':
				$args['tax_query'] = [['taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured']];
				break;
			case 'sale':
				$args['post__in'] = array_merge([0], wc_get_product_ids_on_sale());
				break;
		}

		// Taxonomy filter
		$taxonomy = $settings['query_taxonomy'];
		$terms    = ($taxonomy === 'product_cat') ? $settings['query_terms_cat'] : $settings['query_terms_tag'];

		if (! empty($terms)) {
			$operator           = ($settings['query_filter_type'] === 'exclude') ? 'NOT IN' : 'IN';
			$existing_tax_query = isset($args['tax_query']) ? $args['tax_query'] : [];
			$args['tax_query']  = array_merge($existing_tax_query, [
				[
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms,
					'operator' => $operator,
				],
			]);
		}

		// Author
		if (! empty($settings['query_author'])) {
			$author = get_user_by('login', sanitize_text_field($settings['query_author']));
			if ($author) {
				$args['author'] = $author->ID;
			}
		}

		// Orderby price
		if ($settings['query_orderby'] === 'price') {
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = '_price';
		}

		return $args;
	}

	/* =============================================
	 * Render
	 * ============================================= */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (! class_exists('WooCommerce')) {
			echo '<p>' . esc_html__('WooCommerce is not active.', 'extend-elements') . '</p>';
			return;
		}

		$query    = new WP_Query($this->build_query_args($settings));
		$heading  = ! empty($settings['list_heading']) ? esc_html($settings['list_heading']) : '';
		$show_img = $settings['show_image']    === 'yes';
		$show_ttl = $settings['show_title']    === 'yes';
		$show_sub = $settings['show_subtitle'] === 'yes';
		$show_prc = $settings['show_price']    === 'yes';
		$show_rev = $settings['show_review']   === 'yes';

		// Card element CSS order values (defaults: image=1, title=2, subtitle=3)
		$order_image    = ! empty($settings['card_order_image'])    ? (int) $settings['card_order_image']    : 1;
		$order_title    = ! empty($settings['card_order_title'])    ? (int) $settings['card_order_title']    : 2;
		$order_subtitle = ! empty($settings['card_order_subtitle']) ? (int) $settings['card_order_subtitle'] : 3;
?>
		<div class="eefe-product-widget" data-show-image="<?php echo $show_img ? '1' : '0'; ?>"
			data-show-title="<?php echo $show_ttl ? '1' : '0'; ?>" data-show-subtitle="<?php echo $show_sub ? '1' : '0'; ?>"
			data-show-price="<?php echo $show_prc ? '1' : '0'; ?>" data-show-review="<?php echo $show_rev ? '1' : '0'; ?>">

			<div class="eefe-product-left">
				<?php if ($heading) : ?>
					<h3 class="eefe-product-heading"><?php echo $heading; ?></h3>
				<?php endif; ?>

				<div class="eefe-product-table">
					<ul class="eefe-product-list">
						<?php if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								$product   = wc_get_product(get_the_ID());
								if (! $product) continue;
								$permalink  = get_permalink();
								$title      = get_the_title();
								$img_url    = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: wc_placeholder_img_src();
								$price_html = $product->get_price_html();
								$rating     = $product->get_average_rating();
								$rev_count  = $product->get_review_count();

								// Pull subtitle from ACF custom field (field key: field_69ae6a3b14fe2)
								if (function_exists('get_field')) {
									$subtitle = get_field('product_subtitle', get_the_ID()) ?: '';
								} else {
									$subtitle = get_post_meta(get_the_ID(), 'product_subtitle', true) ?: '';
								}
						?>
								<li class="eefe-product-item" data-permalink="<?php echo esc_url($permalink); ?>"
									data-title="<?php echo esc_attr($title); ?>" data-subtitle="<?php echo esc_attr($subtitle); ?>"
									data-image="<?php echo esc_url($img_url); ?>" data-price="<?php echo esc_attr($price_html); ?>"
									data-rating="<?php echo esc_attr($rating); ?>" data-reviews="<?php echo esc_attr($rev_count); ?>">
									<a href="<?php echo esc_url($permalink); ?>" class="eefe-product-name">
										<?php echo esc_html($title); ?>
									</a>
								</li>
							<?php
							endwhile;
							wp_reset_postdata();
						else : ?>
							<li class="eefe-no-products"><?php esc_html_e('No products found.', 'extend-elements'); ?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div><!-- .eefe-product-left -->

			<div class="eefe-product-right">
				<div class="eefe-product-card">

					<?php // Image — orderable via CSS flex order 
					?>
					<div class="eefe-card-image-wrap" style="order: <?php echo esc_attr($order_image); ?>;">
						<img class="eefe-card-image" src="" alt="" />
					</div>

					<div class="eefe-card-body">
						<h4 class="eefe-card-title" style="order: <?php echo esc_attr($order_title); ?>;"></h4>
						<p class="eefe-card-subtitle" style="order: <?php echo esc_attr($order_subtitle); ?>;"></p>
						<div class="eefe-card-price"></div>
						<div class="eefe-card-stars">
							<span class="stars-inner"></span>
							<span class="eefe-card-review-count"></span>
						</div>
					</div>

				</div>
			</div><!-- .eefe-product-right -->

		</div><!-- .eefe-product-widget -->
<?php
	}
}
