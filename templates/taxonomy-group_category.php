<?php
get_header();

$term = get_queried_object();
$term_id = $term->term_id;

// Get all BuddyBoss groups associated with this group category
$group_ids = array();
$all_groups = groups_get_groups([
    'per_page' => false,
]);

foreach ($all_groups['groups'] as $group) {
    $terms = (array) groups_get_groupmeta($group->id, 'group_category_terms', true);
    if (in_array($term_id, $terms)) {
        $group_ids[] = $group->id;
    }
}

echo '<div class="wrap"><h1>' . esc_html($term->name) . '</h1>';
echo '<p>' . esc_html($term->description) . '</p>';

// Output group cards
if (!empty($group_ids)) {
    echo '<h3>Groups:</h3>';
    echo '<div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; padding-block: 1.5rem;">';

    foreach ($group_ids as $group_id) {
        $group = groups_get_group(['group_id' => $group_id]);

        $group_link = bp_get_group_permalink($group);
        $group_name = $group->name;
        $group_desc = wp_trim_words($group->description, 40);
        $group_last_active = bp_get_group_last_active($group);

        // Get cover image
        $cover_url = bp_attachments_get_attachment('url', [
            'item_id' => $group_id,
            'object_dir' => 'groups',
            'type' => 'cover-image',
        ]);

        // Get avatar
        $avatar_url = bp_core_fetch_avatar([
            'item_id' => $group_id,
            'object' => 'group',
            'type' => 'full',
            'html' => false,
        ]);

        echo '<div class="card" style="border: 1px solid #ddd; border-radius: 0.5rem; overflow: hidden; background-color: #fff;">';
        echo '<a href="' . esc_url($group_link) . '" style="display: block; position: relative; height: 150px; background-image: url(' . esc_url($cover_url) . '); background-size: cover; background-position: center;"></a>';
        echo '<div class="card-content" style="padding: 1rem;">';
        echo '<div class="flex" style="display: flex; gap: 1rem;">';
        echo '<div style="min-width:90px;">';
        echo '<a href="' . esc_url($group_link) . '" class="home-group-avatar" style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">';
        echo '<img src="' . esc_url($avatar_url) . '" alt="' . esc_attr($group_name) . '" width="50" height="50" />';
        echo '</a></div>';
        echo '<div><h3 style="margin: 0; font-size: 1.25rem;"><a href="' . esc_url($group_link) . '" style="text-decoration: none; color: inherit;">' . esc_html($group_name) . '</a></h3></div></div>';
        echo '<div><p class="text-muted" style="margin: 0; color: #666; font-size: 0.875rem;">' . esc_html($group_desc) . ' <a href="' . esc_url($group_link) . '" style="color: #0073aa; text-decoration: none;">Read more</a></p>';
        echo '</div></div>';
        echo '<div class="card-footer" style="background-color: #f9f9f9; padding: 0.5rem 1rem; font-size: 0.875rem; color: #666;">';
        echo '<p style="margin: 0;">Last activity: ' . esc_html($group_last_active) . '</p>';
        echo '</div></div>';
    }

    echo '</div>';
} else {
    echo '<p>No groups found for this category.</p>';
}

echo '</div>';
get_footer();
