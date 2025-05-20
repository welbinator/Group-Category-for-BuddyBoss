<?php
namespace GCBB;

defined('ABSPATH') || exit;

// Add metabox
add_action('bp_groups_admin_meta_boxes', function () {
    add_meta_box(
        'group_categorydiv',
        __('Group Categories', 'group-categories'),
        __NAMESPACE__ . '\\render_metabox',
        get_current_screen()->id,
        'side',
        'default'
    );
});

// Render checkbox UI
function render_metabox($item) {
    $group_id = $item->id;
    $selected_terms = (array) groups_get_groupmeta($group_id, 'group_category_terms', true);
    $terms = get_terms(['taxonomy' => 'group_category', 'hide_empty' => false]);

    if (empty($terms) || is_wp_error($terms)) {
        echo '<p>No group categories found.</p>';
        return;
    }

    echo '<ul>';
    foreach ($terms as $term) {
        $checked = in_array($term->term_id, $selected_terms) ? 'checked' : '';
        printf(
            '<li><label><input type="checkbox" name="group_category_terms[]" value="%d" %s> %s</label></li>',
            esc_attr($term->term_id),
            $checked,
            esc_html($term->name)
        );
    }
    echo '</ul>';
}

// Save selected terms to group meta
add_action('bp_group_admin_edit_after', function ($group_id) {
    if (!current_user_can('bp_moderate')) return;

    if (!empty($_POST['group_category_terms'])) {
        $term_ids = array_map('intval', $_POST['group_category_terms']);
        groups_update_groupmeta($group_id, 'group_category_terms', $term_ids);
    } else {
        groups_delete_groupmeta($group_id, 'group_category_terms');
    }
});
