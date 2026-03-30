<?php

/**
 * Plugin Name: Extend Elements for Elementor
 * Description: Custom Elementor widgets that can be added modularly per widget folder.
 * Version: 1.0.0
 * Author: Dev2SaifuL
 * Text Domain: extend-elements-for-elementor
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (! defined('ABSPATH')) {
	exit;
}

define('EEFE_VERSION', '1.0.0');
define('EEFE_PLUGIN_FILE', __FILE__);
define('EEFE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('EEFE_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once EEFE_PLUGIN_PATH . 'includes/loader.php';
