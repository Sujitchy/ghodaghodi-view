<?php

/**
 * Ghodaghodi View Theme Functions
 */

define('GHODAGHODI_VERSION', '1.0.0');

if (!function_exists('ghodaghodi_setup')):
    function ghodaghodi_setup()
    {
        load_theme_textdomain('ghodaghodi-view', get_template_directory() . '/languages');

        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
        add_theme_support('custom-logo', [
            'height'      => 60,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true,
        ]);

        register_nav_menus([
            'primary' => __('Primary Menu', 'ghodaghodi-view'),
            'footer'  => __('Footer Menu', 'ghodaghodi-view'),
        ]);

        set_post_thumbnail_size(600, 400, true);
    }
endif;
add_action('after_setup_theme', 'ghodaghodi_setup');

function ghodaghodi_scripts()
{
    $theme = wp_get_theme();

    wp_enqueue_style('ghodaghodi-tailwind', get_template_directory_uri() . '/assets/css/style.css', [], $theme->get('Version'));

    wp_enqueue_style('ghodaghodi-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], '6.4.0');

    wp_enqueue_script('ghodaghodi-script', get_template_directory_uri() . '/assets/js/theme.js', [], $theme->get('Version'), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ghodaghodi_scripts');

function ghodaghodi_body_classes($classes)
{
    if (is_front_page()) {
        $classes[] = 'font-mukta bg-gray-50 text-gray-800';
    }
    return $classes;
}
add_filter('body_class', 'ghodaghodi_body_classes');

function ghodaghodi_register_slider_post_type()
{
    register_post_type('ghodaghodi_slider', [
        'labels' => [
            'name'               => __('Hero Slider', 'ghodaghodi-view'),
            'singular_name'      => __('Slide', 'ghodaghodi-view'),
            'add_new'            => __('Add Slide', 'ghodaghodi-view'),
            'add_new_item'       => __('Add New Slide', 'ghodaghodi-view'),
            'edit_item'          => __('Edit Slide', 'ghodaghodi-view'),
            'new_item'           => __('New Slide', 'ghodaghodi-view'),
            'view_item'          => __('View Slide', 'ghodaghodi-view'),
            'search_items'       => __('Search Slides', 'ghodaghodi-view'),
            'not_found'          => __('No slides found', 'ghodaghodi-view'),
            'not_found_in_trash' => __('No slides found in Trash', 'ghodaghodi-view'),
        ],
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-slides',
        'supports'           => ['title', 'editor', 'thumbnail'],
        'menu_position'      => 20,
    ]);
}
add_action('init', 'ghodaghodi_register_slider_post_type');

function ghodaghodi_slider_add_meta_boxes()
{
    add_meta_box('ghodaghodi_slide_options', __('Slide Options', 'ghodaghodi-view'), 'ghodaghodi_slide_meta_callback', 'ghodaghodi_slider', 'normal', 'high');
}
add_action('add_meta_boxes', 'ghodaghodi_slider_add_meta_boxes');

function ghodaghodi_slide_meta_callback($post)
{
    wp_nonce_field('ghodaghodi_slide_meta', 'ghodaghodi_slide_meta_nonce');
    $badge = get_post_meta($post->ID, '_slide_badge', true);
    $button_text = get_post_meta($post->ID, '_slide_button_text', true);
    $button_url = get_post_meta($post->ID, '_slide_button_url', true);
?>
    <p>
        <label for="slide_badge"><?php _e('Badge Text (e.g. विश्व रामसार क्षेत्र):', 'ghodaghodi-view'); ?></label>
        <input type="text" id="slide_badge" name="slide_badge" value="<?php echo esc_attr($badge); ?>" style="width:100%;" />
    </p>
    <p>
        <label for="slide_button_text"><?php _e('Button Text (optional):', 'ghodaghodi-view'); ?></label>
        <input type="text" id="slide_button_text" name="slide_button_text" value="<?php echo esc_attr($button_text); ?>" style="width:100%;" />
    </p>
    <p>
        <label for="slide_button_url"><?php _e('Button URL (optional):', 'ghodaghodi-view'); ?></label>
        <input type="text" id="slide_button_url" name="slide_button_url" value="<?php echo esc_attr($button_url); ?>" style="width:100%;" />
    </p>
<?php
}

function ghodaghodi_slider_save_meta($post_id)
{
    if (!isset($_POST['ghodaghodi_slide_meta_nonce']) || !wp_verify_nonce($_POST['ghodaghodi_slide_meta_nonce'], 'ghodaghodi_slide_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['slide_badge', 'slide_button_text', 'slide_button_url'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_ghodaghodi_slider', 'ghodaghodi_slider_save_meta');

function ghodaghodi_register_hotel_post_type()
{
    register_post_type('ghodaghodi_hotel', [
        'labels' => [
            'name'               => __('Hotels & Homestays', 'ghodaghodi-view'),
            'singular_name'      => __('Hotel & Homestay', 'ghodaghodi-view'),
            'add_new'            => __('Add New', 'ghodaghodi-view'),
            'add_new_item'       => __('Add New Hotel & Homestay', 'ghodaghodi-view'),
            'edit_item'          => __('Edit Hotel & Homestay', 'ghodaghodi-view'),
            'new_item'           => __('New Hotel & Homestay', 'ghodaghodi-view'),
            'view_item'          => __('View Hotel & Homestay', 'ghodaghodi-view'),
            'search_items'       => __('Search Hotels & Homestays', 'ghodaghodi-view'),
            'not_found'          => __('No hotels or homestays found', 'ghodaghodi-view'),
            'not_found_in_trash' => __('No hotels or homestays found in Trash', 'ghodaghodi-view'),
            'all_items'          => __('All Hotels & Homestays', 'ghodaghodi-view'),
            'menu_name'          => __('Hotels & Homestays', 'ghodaghodi-view'),
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-building',
        'menu_position'      => 21,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'hotel', 'with_front' => false],
        'show_in_rest'       => false,
    ]);
}
add_action('init', 'ghodaghodi_register_hotel_post_type');

add_filter('use_block_editor_for_post_type', function ($enabled, $post_type) {
    if ('ghodaghodi_hotel' === $post_type) {
        return false;
    }
    return $enabled;
}, 10, 2);

function ghodaghodi_hotel_add_meta_boxes()
{
    add_meta_box('ghodaghodi_hotel_details', __('Hotel Details', 'ghodaghodi-view'), 'ghodaghodi_hotel_meta_callback', 'ghodaghodi_hotel', 'normal', 'high');
}
add_action('add_meta_boxes', 'ghodaghodi_hotel_add_meta_boxes');

function ghodaghodi_hotel_meta_callback($post)
{
    wp_nonce_field('ghodaghodi_hotel_meta', 'ghodaghodi_hotel_meta_nonce');
    $type     = get_post_meta($post->ID, '_hotel_type', true);
    $location = get_post_meta($post->ID, '_hotel_location', true);
    $beds     = get_post_meta($post->ID, '_hotel_beds', true);
    $status   = get_post_meta($post->ID, '_hotel_status', true);
    $contact  = get_post_meta($post->ID, '_hotel_contact', true);
?>
    <style>
        #ghodaghodi_hotel_details .form-table select#hotel_status {
            min-width: 200px;
            padding: 4px 8px;
            font-weight: 600;
        }

        #ghodaghodi_hotel_details .form-table select#hotel_status option[value="open"] {
            background-color: #d1fae5;
            color: #065f46;
        }

        #ghodaghodi_hotel_details .form-table select#hotel_status option[value="closed"] {
            background-color: #fee2e2;
            color: #991b1b;
        }

        #ghodaghodi_hotel_details .form-table select#hotel_status option[value="temporarily_closed"] {
            background-color: #fef3c7;
            color: #b45309;
        }

        #ghodaghodi_hotel_details .form-table select#hotel_status optgroup,
        #ghodaghodi_hotel_details .form-table select#hotel_status option {
            padding: 6px 10px;
        }

        #ghodaghodi_hotel_details .form-table select#hotel_status.has-open {
            background-color: #d1fae5;
            color: #065f46;
            border-color: #6ee7b7;
        }

        #ghodaghodi_hotel_details .form-table select#hotel_status.has-closed {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
        }
    </style>
    <script>
        jQuery(function($) {
            var $sel = $('#hotel_status');

            function updateStatusStyle() {
                $sel.removeClass('has-open has-closed').addClass('has-' + $sel.val());
            }
            updateStatusStyle();
            $sel.on('change', updateStatusStyle);
        });
    </script>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="hotel_type"><?php _e('Type', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="hotel_type" name="hotel_type" value="<?php echo esc_attr($type); ?>" class="regular-text" placeholder="<?php _e('E.g.: Homestay, Hotel, Resort', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Specify the type of accommodation', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hotel_location"><?php _e('Location/Address', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="hotel_location" name="hotel_location" value="<?php echo esc_attr($location); ?>" class="regular-text" placeholder="<?php _e('E.g.: 123 Main Road, Ghodaghodi,  10001', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('The location or address where the accommodation is located', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hotel_beds"><?php _e('Beds Capacity', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="hotel_beds" name="hotel_beds" value="<?php echo esc_attr($beds); ?>" class="regular-text" placeholder="<?php _e('E.g.: 15 people', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Total number of beds available', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hotel_contact"><?php _e('Contact Number', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="hotel_contact" name="hotel_contact" value="<?php echo esc_attr($contact); ?>" class="regular-text" placeholder="<?php _e('E.g.: 9841234567', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Phone number for contact', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="hotel_status"><?php _e('Status', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <select id="hotel_status" name="hotel_status">
                    <option value="open" <?php selected($status, 'open'); ?>><?php _e('Open', 'ghodaghodi-view'); ?></option>
                    <option value="temporarily_closed" <?php selected($status, 'temporarily_closed'); ?>><?php _e('Temporarily Closed', 'ghodaghodi-view'); ?></option>
                    <option value="closed" <?php selected($status, 'closed'); ?>><?php _e('Closed', 'ghodaghodi-view'); ?></option>
                </select>
                <p class="description"><?php _e('Whether the accommodation is currently operating or not', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
    </table>
<?php
}

function ghodaghodi_hotel_save_meta($post_id)
{
    if (!isset($_POST['ghodaghodi_hotel_meta_nonce']) || !wp_verify_nonce($_POST['ghodaghodi_hotel_meta_nonce'], 'ghodaghodi_hotel_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = ['hotel_type', 'hotel_location', 'hotel_beds', 'hotel_contact'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }

    if (isset($_POST['hotel_status']) && in_array($_POST['hotel_status'], ['open', 'closed', 'temporarily_closed'])) {
        update_post_meta($post_id, '_hotel_status', $_POST['hotel_status']);
    }
}
add_action('save_post_ghodaghodi_hotel', 'ghodaghodi_hotel_save_meta');

function ghodaghodi_destination_add_meta_boxes()
{
    add_meta_box('ghodaghodi_destination_details', __('Destination Details', 'ghodaghodi-view'), 'ghodaghodi_destination_meta_callback', 'post', 'normal', 'high');
}
add_action('add_meta_boxes', 'ghodaghodi_destination_add_meta_boxes');

function ghodaghodi_destination_meta_callback($post)
{
    wp_nonce_field('ghodaghodi_destination_meta', 'ghodaghodi_destination_meta_nonce');
    $location  = get_post_meta($post->ID, '_destination_location', true);
    $best_time = get_post_meta($post->ID, '_destination_best_time', true);
    $season    = get_post_meta($post->ID, '_destination_season', true);

    $seasons = [
        'spring'   => __('Spring', 'ghodaghodi-view'),
        'summer'   => __('Summer', 'ghodaghodi-view'),
        'autumn'   => __('Autumn', 'ghodaghodi-view'),
        'winter'   => __('Winter', 'ghodaghodi-view'),
        'all_year' => __('All Year', 'ghodaghodi-view'),
    ];
?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="destination_location"><?php _e('Location', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="destination_location" name="destination_location" value="<?php echo esc_attr($location); ?>" class="regular-text" placeholder="<?php _e('E.g.: Ghodaghodi Lake Area', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('The location of the destination', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_best_time"><?php _e('Best Time to Visit', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="destination_best_time" name="destination_best_time" value="<?php echo esc_attr($best_time); ?>" class="regular-text" placeholder="<?php _e('E.g.: Sept–Nov, Feb–Apr', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Recommended time of year to visit', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_season"><?php _e('Recommended Season', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <select id="destination_season" name="destination_season">
                    <option value=""><?php _e('— Select Season —', 'ghodaghodi-view'); ?></option>
                    <?php foreach ($seasons as $value => $label): ?>
                        <option value="<?php echo esc_attr($value); ?>" <?php selected($season, $value); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e('The season recommended for visiting this destination', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
    </table>
<?php
}

function ghodaghodi_destination_save_meta($post_id)
{
    if (!isset($_POST['ghodaghodi_destination_meta_nonce']) || !wp_verify_nonce($_POST['ghodaghodi_destination_meta_nonce'], 'ghodaghodi_destination_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if ('post' !== get_post_type($post_id)) return;

    $fields = ['destination_location', 'destination_best_time'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }

    $seasons = ['spring', 'summer', 'autumn', 'winter', 'all_year'];
    if (isset($_POST['destination_season']) && in_array($_POST['destination_season'], $seasons, true)) {
        update_post_meta($post_id, '_destination_season', sanitize_text_field($_POST['destination_season']));
    } else {
        delete_post_meta($post_id, '_destination_season');
    }
}
add_action('save_post', 'ghodaghodi_destination_save_meta');

require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/walker.php';
require_once get_template_directory() . '/inc/customizer.php';
