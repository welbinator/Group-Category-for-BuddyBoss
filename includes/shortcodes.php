<?php
namespace GCBB;

defined('ABSPATH') || exit;

// Display terms on group
function display_terms($group_id) {
    $term_ids = (array) groups_get_groupmeta($group_id, 'group_category_terms', true);
    if (empty($term_ids)) return 'No Group Categories assigned.';

    $terms = get_terms(['taxonomy' => 'group_category', 'include' => $term_ids, 'hide_empty' => false]);

    if (is_wp_error($terms) || empty($terms)) return 'No valid Group Categories found.';

    $output = '<ul class="group-categories">';
    foreach ($terms as $term) {
        $output .= '<li>' . esc_html($term->name) . '</li>';
    }
    $output .= '</ul>';
    return $output;
}

add_shortcode('group_categories', function ($atts) {
    $atts = shortcode_atts(['group_id' => 0], $atts);

    if (!function_exists('groups_get_groupmeta')) return '<p>BuddyBoss not active.</p>';

    $group_id = absint($atts['group_id']);

    if (!$group_id && function_exists('bp_is_group') && bp_is_group()) {
        $group = groups_get_current_group();
        $group_id = isset($group->id) ? $group->id : 0;
    }

    if (!$group_id) return '<p>Group ID not found.</p>';

    return display_terms($group_id);
});

// Grid view of all terms
add_shortcode('group_categories_grid', function ($atts) {
    $atts = shortcode_atts(['max' => 0], $atts);

    $args = ['taxonomy' => 'group_category', 'hide_empty' => false];
    if ((int) $atts['max'] > 0) {
        $args['number'] = (int) $atts['max'];
    }

    $terms = get_terms($args);
    if (empty($terms) || is_wp_error($terms)) return '<p>No group categories found.</p>';

    ob_start();
    echo '<div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; padding-block: 1.5rem;">';
    foreach ($terms as $term) {
        $term_link = get_term_link($term);
        $image_url = get_term_meta($term->term_id, 'group_category_image', true) ?: 'https://linn.crweb.design/wp-content/plugins/buddyboss-platform/bp-core/images/cover-image.png';
        $description = wp_trim_words($term->description, 40, '...');

        echo '<div class="card" style="border: 1px solid #ddd; border-radius: 0.5rem; overflow: hidden; background-color: #fff;">';
        echo '<a href="' . esc_url($term_link) . '" style="display: block; position: relative; height: 150px; background-image: url(' . esc_url($image_url) . '); background-size: cover; background-position: center;"></a>';
        echo '<div class="card-content" style="padding: 1rem;">';
        echo '<h3 style="margin: 0; font-size: 1.25rem;"><a href="' . esc_url($term_link) . '" style="text-decoration: none; color: inherit;">' . esc_html($term->name) . '</a></h3>';
        echo '<p style="margin: 0; color: #666; font-size: 0.875rem;">' . esc_html($description) . ' <a href="' . esc_url($term_link) . '" style="color: #0073aa;">Read more</a></p>';
        echo '</div></div>';
    }
    echo '</div>';
    return ob_get_clean();
});
