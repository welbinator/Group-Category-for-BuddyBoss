<?php
namespace GCBB;

defined('ABSPATH') || exit;

add_action('init', function () {
    register_taxonomy('group_category', ['group_fake_type', 'post'], [
        'labels' => [
            'name' => 'Group Categories',
            'singular_name' => 'Group Category',
            'search_items' => 'Search Group Categories',
            'all_items' => 'All Group Categories',
            'edit_item' => 'Edit Group Category',
            'update_item' => 'Update Group Category',
            'add_new_item' => 'Add New Group Category',
            'new_item_name' => 'New Group Category Name',
            'menu_name' => 'Group Categories',
        ],
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => false,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'group-category'],
        'public' => true,
    ]);
});
