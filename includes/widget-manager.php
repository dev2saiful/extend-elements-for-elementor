<?php

/**
 * Registers widget assets and Elementor widgets from subfolders under widgets/.
 *
 * @package Extend_Elements_For_Elementor
 */

namespace EEFE;

if (! defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Widgets_Manager;

final class Widget_Manager
{

	public static function init()
	{
		add_action('init', array(__CLASS__, 'register_widget_assets'), 20);
		add_action('admin_notices', array(__CLASS__, 'admin_notice_missing_elementor'));

		// Only hook if Elementor is active
		if (defined('ELEMENTOR_VERSION')) {
			add_action('elementor/widgets/register', array(__CLASS__, 'register_widgets'));
		}
	}

	public static function register_widget_assets()
	{
		$dirs = glob(EEFE_PLUGIN_PATH . 'widgets/*', GLOB_ONLYDIR);

		if (empty($dirs) || ! is_array($dirs)) {
			return;
		}

		foreach ($dirs as $dir) {
			$slug = basename($dir);

			if (! preg_match('/^[a-z0-9\-]+$/', $slug)) {
				continue;
			}

			$handle = 'eefe-widget-' . $slug;
			$rel    = 'widgets/' . $slug . '/';

			$style_path = $dir . '/style.css';
			if (file_exists($style_path)) {
				wp_register_style(
					$handle,
					EEFE_PLUGIN_URL . $rel . 'style.css',
					array(),
					defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? filemtime($style_path) : EEFE_VERSION
				);
			}

			$script_path = $dir . '/script.js';
			if (file_exists($script_path)) {
				wp_register_script(
					$handle,
					EEFE_PLUGIN_URL . $rel . 'script.js',
					array('jquery'),
					defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? filemtime($script_path) : EEFE_VERSION,
					true
				);
			}
		}
	}

	public static function register_widgets(Widgets_Manager $widgets_manager)
	{
		$widget_files = glob(EEFE_PLUGIN_PATH . 'widgets/*/widget.php');

		if (empty($widget_files) || ! is_array($widget_files)) {
			return;
		}

		foreach ($widget_files as $widget_file) {
			self::load_and_register_widget($widget_file, $widgets_manager);
		}
	}

	private static function load_and_register_widget($widget_file, Widgets_Manager $widgets_manager)
	{
		if (! file_exists($widget_file)) {
			return;
		}

		$before = get_declared_classes();

		require_once $widget_file;

		$after       = get_declared_classes();
		$new_classes = array_diff($after, $before);

		foreach ($new_classes as $class_name) {
			if (is_subclass_of($class_name, Widget_Base::class)) {
				$widgets_manager->register(new $class_name());
			}
		}
	}

	public static function admin_notice_missing_elementor()
	{
		if (! current_user_can('activate_plugins')) {
			return;
		}

		if (defined('ELEMENTOR_VERSION')) {
			return;
		}

		printf(
			'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
			esc_html__('Extend Elements for Elementor requires Elementor to be installed and activated.', 'extend-elements-for-elementor')
		);
	}
}
