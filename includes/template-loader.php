<?php
namespace GCBB;

defined('ABSPATH') || exit;

add_filter('template_include', function ($template) {
    if (is_tax('group_category')) {
        $custom_template = GCBB_PLUGIN_DIR . 'templates/taxonomy-group_category.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    return $template;
});
