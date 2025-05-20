<?php
namespace GCBB;

defined('ABSPATH') || exit;

add_action('admin_menu', function () {
    add_menu_page(
        'Group Categories',
        'Group Categories',
        'manage_options',
        'edit-tags.php?taxonomy=group_category',
        '',
        'dashicons-category',
        25
    );
});
