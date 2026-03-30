<?php
/**
 * Bootstrap: loads dependencies and starts the plugin.
 *
 * @package Extend_Elements_For_Elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once EEFE_PLUGIN_PATH . 'includes/widget-manager.php';

add_action( 'plugins_loaded', array( 'EEFE\Widget_Manager', 'init' ) );
