<?php
/**
 * Plugin Name: Group Categories for BuddyBoss
 * Description: Adds a "Group Category" taxonomy to BuddyBoss Groups, including image support and frontend shortcodes.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: group-categories
 */

defined('ABSPATH') || exit;

define('GCBB_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once GCBB_PLUGIN_DIR . 'includes/taxonomy.php';
require_once GCBB_PLUGIN_DIR . 'includes/group-meta.php';
require_once GCBB_PLUGIN_DIR . 'includes/taxonomy-images.php';
require_once GCBB_PLUGIN_DIR . 'includes/shortcodes.php';
require_once GCBB_PLUGIN_DIR . 'includes/admin-menu.php';
