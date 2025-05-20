<?php
namespace GCBB;

defined('ABSPATH') || exit;

// Add fields to Add/Edit screens
add_action('group_category_add_form_fields', function () {
    ?>
    <div class="form-field term-group">
        <label for="group_category_image"><?php _e('Image', 'group-categories'); ?></label>
        <input type="text" id="group_category_image" name="group_category_image" value="" class="regular-text" />
        <button class="upload_image_button button"><?php _e('Upload/Add image', 'group-categories'); ?></button>
        <p class="description"><?php _e('Select an image for this group category.', 'group-categories'); ?></p>
    </div>
    <?php
});

add_action('group_category_edit_form_fields', function ($term) {
    $image = get_term_meta($term->term_id, 'group_category_image', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="group_category_image"><?php _e('Image', 'group-categories'); ?></label></th>
        <td>
            <input type="text" id="group_category_image" name="group_category_image" value="<?php echo esc_attr($image); ?>" class="regular-text" />
            <button class="upload_image_button button"><?php _e('Upload/Add image', 'group-categories'); ?></button>
            <p class="description"><?php _e('Select an image for this group category.', 'group-categories'); ?></p>
        </td>
    </tr>
    <?php
});

add_action('created_group_category', __NAMESPACE__ . '\\save_image_meta');
add_action('edited_group_category', __NAMESPACE__ . '\\save_image_meta');

function save_image_meta($term_id) {
    if (isset($_POST['group_category_image'])) {
        update_term_meta($term_id, 'group_category_image', esc_url_raw($_POST['group_category_image']));
    }
}

// Enqueue media uploader
add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, ['edit-tags.php', 'term.php'])) return;

    if (!empty($_GET['taxonomy']) && $_GET['taxonomy'] === 'group_category') {
        wp_enqueue_media();
        wp_register_script('group-category-media', '');
        wp_enqueue_script('group-category-media');

        wp_add_inline_script('group-category-media', <<<JS
jQuery(document).ready(function ($) {
    function setupUploader(button, input) {
        button.on('click', function (e) {
            e.preventDefault();
            const customUploader = wp.media({
                title: 'Choose Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            customUploader.on('select', function () {
                const attachment = customUploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
            });
            customUploader.open();
        });
    }

    setupUploader($('.upload_image_button'), $('#group_category_image'));
});
JS
        );
    }
});
