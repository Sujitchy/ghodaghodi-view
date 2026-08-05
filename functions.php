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

function ghodaghodi_trek_add_meta_boxes($post)
{
    $is_new = empty($post->ID) || 'auto-draft' === $post->post_status;

    $has_trek_data = metadata_exists('post', $post->ID, '_destination_trek_duration')
        || metadata_exists('post', $post->ID, '_destination_trek_max_elevation')
        || metadata_exists('post', $post->ID, '_destination_trek_difficulty')
        || metadata_exists('post', $post->ID, '_destination_trek_permits')
        || metadata_exists('post', $post->ID, '_destination_trek_itinerary')
        || metadata_exists('post', $post->ID, '_destination_what_to_pack')
        || metadata_exists('post', $post->ID, '_destination_trek_tips')
        || metadata_exists('post', $post->ID, '_destination_region')
        || metadata_exists('post', $post->ID, '_destination_best_season')
        || metadata_exists('post', $post->ID, '_destination_why_choose')
        || metadata_exists('post', $post->ID, '_destination_trek_map')
        || metadata_exists('post', $post->ID, '_destination_highlights');

    if (!$is_new && !$has_trek_data && !in_category('destinations', $post)) {
        return;
    }

    add_meta_box('ghodaghodi_trek_guide', __('Trek Route Guide', 'ghodaghodi-view'), 'ghodaghodi_trek_meta_callback', 'post', 'normal', 'high');
}
add_action('add_meta_boxes_post', 'ghodaghodi_trek_add_meta_boxes');

function ghodaghodi_trek_meta_callback($post)
{
    wp_nonce_field('ghodaghodi_trek_meta', 'ghodaghodi_trek_meta_nonce');
    wp_enqueue_media();

    $duration    = get_post_meta($post->ID, '_destination_trek_duration', true);
    $elevation   = get_post_meta($post->ID, '_destination_trek_max_elevation', true);
    $difficulty  = get_post_meta($post->ID, '_destination_trek_difficulty', true);
    $permits     = get_post_meta($post->ID, '_destination_trek_permits', true);
    $itinerary   = json_decode(get_post_meta($post->ID, '_destination_trek_itinerary', true), true);
    $pack        = get_post_meta($post->ID, '_destination_what_to_pack', true);
    $tips        = get_post_meta($post->ID, '_destination_trek_tips', true);
    $region      = get_post_meta($post->ID, '_destination_region', true);
    $best_season = get_post_meta($post->ID, '_destination_best_season', true);
    $why_choose  = get_post_meta($post->ID, '_destination_why_choose', true);
    $trek_map    = get_post_meta($post->ID, '_destination_trek_map', true);
    $highlights  = json_decode(get_post_meta($post->ID, '_destination_highlights', true), true);

    if (!is_array($itinerary)) {
        $itinerary = [];
    }

    if (!is_array($highlights)) {
        $highlights = [];
    }
?>
    <style>
        #ghodaghodi_trek_guide h4 {
            margin: 1.5em 0 0.25em;
            font-size: 14px;
        }

        #ghodaghodi_trek_guide .ghodaghodi-itinerary-row,
        #ghodaghodi_trek_guide .ghodaghodi-highlight-row {
            border: 1px solid #ccd0d4;
            border-radius: 6px;
            padding: 12px 14px;
            margin: 10px 0;
            background: #fff;
        }

        #ghodaghodi_trek_guide .ghodaghodi-itinerary-row-head,
        #ghodaghodi_trek_guide .ghodaghodi-highlight-row-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        #ghodaghodi_trek_guide .ghodaghodi-itinerary-row-title,
        #ghodaghodi_trek_guide .ghodaghodi-highlight-row-title {
            font-weight: 600;
        }

        #ghodaghodi_trek_guide .ghodaghodi-highlight-fields {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        #ghodaghodi_trek_guide .ghodaghodi-highlight-image {
            min-width: 170px;
        }

        #ghodaghodi_trek_guide .ghodaghodi-highlight-caption {
            flex: 1;
            min-width: 220px;
            margin: 0;
        }

        #ghodaghodi_trek_guide .ghodaghodi-highlight-caption label {
            display: block;
            font-weight: 600;
            margin-bottom: 3px;
        }

        #ghodaghodi_trek_guide .ghodaghodi-highlight-preview {
            margin-bottom: 6px;
        }

        #ghodaghodi_trek_guide .ghodaghodi-itinerary-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }

        #ghodaghodi_trek_guide .ghodaghodi-itinerary-fields p {
            margin: 0;
        }

        #ghodaghodi_trek_guide .ghodaghodi-itinerary-fields label {
            display: block;
            font-weight: 600;
            margin-bottom: 3px;
        }

        #ghodaghodi_trek_guide .ghodaghodi-itinerary-notes {
            grid-column: 1 / -1;
        }
    </style>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="destination_region"><?php _e('Region', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="destination_region" name="destination_region" value="<?php echo esc_attr($region); ?>" class="regular-text" placeholder="<?php _e('E.g.: Bajura, Nepal', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Geographic region where the trek is located', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_best_season"><?php _e('Best Season', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="destination_best_season" name="destination_best_season" value="<?php echo esc_attr($best_season); ?>" class="regular-text" placeholder="<?php _e('E.g.: Spring & Autumn', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Best seasons for this trek', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_trek_duration"><?php _e('Duration', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="destination_trek_duration" name="destination_trek_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text" placeholder="<?php _e('E.g.: 6 Days', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Total duration of the trek', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_trek_max_elevation"><?php _e('Max Elevation', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <input type="text" id="destination_trek_max_elevation" name="destination_trek_max_elevation" value="<?php echo esc_attr($elevation); ?>" class="regular-text" placeholder="<?php _e('E.g.: 4,200 m', 'ghodaghodi-view'); ?>" />
                <p class="description"><?php _e('Highest elevation reached on the trek', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_trek_difficulty"><?php _e('Difficulty Rating', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <select id="destination_trek_difficulty" name="destination_trek_difficulty">
                    <option value=""><?php _e('— Select Difficulty —', 'ghodaghodi-view'); ?></option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php selected($difficulty, (string) $i); ?>><?php echo $i; ?> / 5</option>
                    <?php endfor; ?>
                </select>
                <p class="description"><?php _e('Difficulty level from 1 (easy) to 5 (very challenging)', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_trek_permits"><?php _e('Permits & Fees', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <textarea id="destination_trek_permits" name="destination_trek_permits" rows="4" class="large-text" placeholder="<?php _e('E.g.: TIMS card NPR 1,000; park entry NPR 2,000...', 'ghodaghodi-view'); ?>"><?php echo esc_textarea($permits); ?></textarea>
                <p class="description"><?php _e('Required permits, entry fees and where to obtain them', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
    </table>

    <h4><?php _e('Why Choose This Trek?', 'ghodaghodi-view'); ?></h4>
    <p>
        <textarea id="destination_why_choose" name="destination_why_choose" rows="5" class="large-text" placeholder="<?php _e('E.g.: Stunning views of Badimalika Temple, Rich cultural heritage, Less crowded trail...', 'ghodaghodi-view'); ?>"><?php echo esc_textarea($why_choose); ?></textarea>
    </p>
    <p class="description"><?php _e('Key reasons/attractions, one per line or comma-separated.', 'ghodaghodi-view'); ?></p>

    <h4><?php _e('Trek Route Map', 'ghodaghodi-view'); ?></h4>
    <p>
        <input type="url" id="destination_trek_map" name="destination_trek_map" value="<?php echo esc_url($trek_map); ?>" class="widefat" placeholder="<?php _e('Image URL or use the button to upload', 'ghodaghodi-view'); ?>" />
    </p>
    <p>
        <button type="button" class="button" id="ghodaghodi-upload-map"><?php _e('Upload / Select Image', 'ghodaghodi-view'); ?></button>
    </p>
    <span id="ghodaghodi-map-preview">
        <?php if ($trek_map): ?>
            <img src="<?php echo esc_url($trek_map); ?>" alt="" style="max-width:100%;margin-top:8px;border:1px solid #ccd0d4;border-radius:4px;" />
        <?php endif; ?>
    </span>

    <h4><?php _e('Day-by-Day Itinerary', 'ghodaghodi-view'); ?></h4>
    <div id="ghodaghodi-itinerary-rows">
        <?php foreach ($itinerary as $index => $day): ?>
            <?php ghodaghodi_trek_itinerary_row($day, $index); ?>
        <?php endforeach; ?>
    </div>
    <p>
        <button type="button" class="button button-secondary" id="ghodaghodi-add-day"><?php _e('+ Add Day', 'ghodaghodi-view'); ?></button>
    </p>
    <p class="description"><?php _e('Add each day of the trek itinerary, including transport hours, elevation and route notes.', 'ghodaghodi-view'); ?></p>

    <h4><?php _e('Highlights Gallery', 'ghodaghodi-view'); ?></h4>
    <div id="ghodaghodi-highlight-rows">
        <?php foreach ($highlights as $index => $item): ?>
            <?php ghodaghodi_trek_highlight_row($item, $index); ?>
        <?php endforeach; ?>
    </div>
    <p>
        <button type="button" class="button button-secondary" id="ghodaghodi-add-highlight"><?php _e('+ Add Highlight Photo', 'ghodaghodi-view'); ?></button>
    </p>
    <p class="description"><?php _e('Highlight photos with optional captions shown in the gallery widget.', 'ghodaghodi-view'); ?></p>

    <h4><?php _e('Guidelines', 'ghodaghodi-view'); ?></h4>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="destination_what_to_pack"><?php _e('What to Pack', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <textarea id="destination_what_to_pack" name="destination_what_to_pack" rows="4" class="large-text" placeholder="<?php _e('E.g.: Hiking boots, Sleeping bag, Rain jacket, Water bottle', 'ghodaghodi-view'); ?>"><?php echo esc_textarea($pack); ?></textarea>
                <p class="description"><?php _e('Comma-separated list of packing essentials', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="destination_trek_tips"><?php _e('Tips for Trekkers', 'ghodaghodi-view'); ?></label>
            </th>
            <td>
                <textarea id="destination_trek_tips" name="destination_trek_tips" rows="4" class="large-text" placeholder="<?php _e('E.g.: Acclimatize slowly, Start early, Carry enough water', 'ghodaghodi-view'); ?>"><?php echo esc_textarea($tips); ?></textarea>
                <p class="description"><?php _e('Comma-separated list of trekking tips', 'ghodaghodi-view'); ?></p>
            </td>
        </tr>
    </table>

    <script type="text/html" id="ghodaghodi-itinerary-row-template">
        <?php ghodaghodi_trek_itinerary_row([], '__INDEX__'); ?>
    </script>
    <script>
        jQuery(function($) {
            var $rows = $('#ghodaghodi-itinerary-rows');
            var template = $('#ghodaghodi-itinerary-row-template').html();

            function reindexRows() {
                $rows.find('.ghodaghodi-itinerary-row').each(function(index) {
                    var $row = $(this);
                    $row.find(':input').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/itinerary\[\d+\]/, 'itinerary[' + index + ']'));
                        }
                    });
                });
            }

            $('#ghodaghodi-add-day').on('click', function() {
                var index = $rows.find('.ghodaghodi-itinerary-row').length;
                $rows.append(template.replace(/__INDEX__/g, index));
            });

            $(document).on('click', '.ghodaghodi-remove-day', function() {
                $(this).closest('.ghodaghodi-itinerary-row').remove();
                reindexRows();
            });
        });
    </script>

    <script type="text/html" id="ghodaghodi-highlight-row-template">
        <?php ghodaghodi_trek_highlight_row([], '__INDEX__'); ?>
    </script>
    <script>
        jQuery(function($) {
            var $highlightRows = $('#ghodaghodi-highlight-rows');
            var highlightTemplate = $('#ghodaghodi-highlight-row-template').html();

            function bindHighlightUploader($row) {
                $row.find('.ghodaghodi-upload-highlight').on('click', function(e) {
                    e.preventDefault();
                    var frame = wp.media({
                        title: '<?php echo esc_js(__('Select Highlight Image', 'ghodaghodi-view')); ?>',
                        button: { text: '<?php echo esc_js(__('Use this image', 'ghodaghodi-view')); ?>' },
                        multiple: false,
                        library: { type: 'image' }
                    });
                    frame.on('select', function() {
                        var attachment = frame.state().get('selection').first().toJSON();
                        $row.find('.ghodaghodi-highlight-image-input').val(attachment.url);
                        $row.find('.ghodaghodi-highlight-preview').html(
                            '<img src="' + attachment.url + '" alt="" style="max-width:150px;height:auto;display:block;" />'
                        );
                    });
                    frame.open();
                });
            }

            function reindexHighlights() {
                $highlightRows.find('.ghodaghodi-highlight-row').each(function(index) {
                    var $row = $(this);
                    $row.find(':input').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/highlights\[\d+\]/, 'highlights[' + index + ']'));
                        }
                    });
                });
            }

            $highlightRows.find('.ghodaghodi-highlight-row').each(function() {
                bindHighlightUploader($(this));
            });

            $('#ghodaghodi-add-highlight').on('click', function() {
                var index = $highlightRows.find('.ghodaghodi-highlight-row').length;
                $highlightRows.append(highlightTemplate.replace(/__INDEX__/g, index));
                bindHighlightUploader($highlightRows.find('.ghodaghodi-highlight-row').last());
            });

            $(document).on('click', '.ghodaghodi-remove-highlight', function() {
                $(this).closest('.ghodaghodi-highlight-row').remove();
                reindexHighlights();
            });

            $('#ghodaghodi-upload-map').on('click', function(e) {
                e.preventDefault();
                var frame = wp.media({
                    title: '<?php echo esc_js(__('Select Route Map Image', 'ghodaghodi-view')); ?>',
                    button: { text: '<?php echo esc_js(__('Use this image', 'ghodaghodi-view')); ?>' },
                    multiple: false,
                    library: { type: 'image' }
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#destination_trek_map').val(attachment.url);
                    $('#ghodaghodi-map-preview').html(
                        '<img src="' + attachment.url + '" alt="" style="max-width:100%;margin-top:8px;border:1px solid #ccd0d4;border-radius:4px;" />'
                    );
                });
                frame.open();
            });
        });
    </script>
<?php
}

function ghodaghodi_trek_itinerary_row($day, $index)
{
    $day = is_array($day) ? $day : [];
    $get = function ($key) use ($day) {
        return isset($day[$key]) ? $day[$key] : '';
    };
?>
    <div class="ghodaghodi-itinerary-row">
        <div class="ghodaghodi-itinerary-row-head">
            <span class="ghodaghodi-itinerary-row-title"><?php _e('Itinerary Day', 'ghodaghodi-view'); ?></span>
            <button type="button" class="button-link ghodaghodi-remove-day"><?php _e('Remove', 'ghodaghodi-view'); ?></button>
        </div>
        <div class="ghodaghodi-itinerary-fields">
            <p>
                <label><?php _e('Day Label', 'ghodaghodi-view'); ?></label>
                <input type="text" name="itinerary[<?php echo esc_attr($index); ?>][day]" value="<?php echo esc_attr($get('day')); ?>" class="widefat" placeholder="<?php _e('E.g.: Day 1', 'ghodaghodi-view'); ?>" />
            </p>
            <p>
                <label><?php _e('Title', 'ghodaghodi-view'); ?></label>
                <input type="text" name="itinerary[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($get('title')); ?>" class="widefat" placeholder="<?php _e('E.g.: Ghodaghodi to Jhiljhile', 'ghodaghodi-view'); ?>" />
            </p>
            <p>
                <label><?php _e('Transport / Hours', 'ghodaghodi-view'); ?></label>
                <input type="text" name="itinerary[<?php echo esc_attr($index); ?>][transport]" value="<?php echo esc_attr($get('transport')); ?>" class="widefat" placeholder="<?php _e('E.g.: 4-5 hrs drive / 3 hrs hike', 'ghodaghodi-view'); ?>" />
            </p>
            <p>
                <label><?php _e('Elevation', 'ghodaghodi-view'); ?></label>
                <input type="text" name="itinerary[<?php echo esc_attr($index); ?>][elevation]" value="<?php echo esc_attr($get('elevation')); ?>" class="widefat" placeholder="<?php _e('E.g.: 1,500m – 2,100m', 'ghodaghodi-view'); ?>" />
            </p>
            <p class="ghodaghodi-itinerary-notes">
                <label><?php _e('Route Notes', 'ghodaghodi-view'); ?></label>
                <textarea name="itinerary[<?php echo esc_attr($index); ?>][notes]" rows="3" class="widefat" placeholder="<?php _e('E.g.: Trail climbs through oak forest with views of Ghodaghodi Lake.', 'ghodaghodi-view'); ?>"><?php echo esc_textarea($get('notes')); ?></textarea>
            </p>
        </div>
    </div>
<?php
}

function ghodaghodi_trek_highlight_row($item, $index)
{
    $item    = is_array($item) ? $item : [];
    $image   = isset($item['image']) ? $item['image'] : '';
    $caption = isset($item['caption']) ? $item['caption'] : '';
?>
    <div class="ghodaghodi-highlight-row">
        <div class="ghodaghodi-highlight-row-head">
            <span class="ghodaghodi-highlight-row-title"><?php _e('Highlight Photo', 'ghodaghodi-view'); ?></span>
            <button type="button" class="button-link ghodaghodi-remove-highlight"><?php _e('Remove', 'ghodaghodi-view'); ?></button>
        </div>
        <div class="ghodaghodi-highlight-fields">
            <div class="ghodaghodi-highlight-image">
                <input type="hidden" name="highlights[<?php echo esc_attr($index); ?>][image]" value="<?php echo esc_attr($image); ?>" class="ghodaghodi-highlight-image-input" />
                <div class="ghodaghodi-highlight-preview">
                    <?php if ($image): ?>
                        <img src="<?php echo esc_url($image); ?>" alt="" style="max-width:150px;height:auto;display:block;" />
                    <?php endif; ?>
                </div>
                <button type="button" class="button ghodaghodi-upload-highlight"><?php _e('Choose Image', 'ghodaghodi-view'); ?></button>
            </div>
            <p class="ghodaghodi-highlight-caption">
                <label><?php _e('Caption', 'ghodaghodi-view'); ?></label>
                <input type="text" name="highlights[<?php echo esc_attr($index); ?>][caption]" value="<?php echo esc_attr($caption); ?>" class="widefat" placeholder="<?php _e('E.g.: Badimalika Temple (4,200m)', 'ghodaghodi-view'); ?>" />
            </p>
        </div>
    </div>
<?php
}

function ghodaghodi_trek_save_meta($post_id)
{
    if (!isset($_POST['ghodaghodi_trek_meta_nonce']) || !wp_verify_nonce($_POST['ghodaghodi_trek_meta_nonce'], 'ghodaghodi_trek_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if ('post' !== get_post_type($post_id)) return;

    if (isset($_POST['destination_trek_duration'])) {
        update_post_meta($post_id, '_destination_trek_duration', sanitize_text_field(wp_unslash($_POST['destination_trek_duration'])));
    }

    if (isset($_POST['destination_trek_max_elevation'])) {
        update_post_meta($post_id, '_destination_trek_max_elevation', sanitize_text_field(wp_unslash($_POST['destination_trek_max_elevation'])));
    }

    if (isset($_POST['destination_trek_difficulty']) && in_array($_POST['destination_trek_difficulty'], ['1', '2', '3', '4', '5'], true)) {
        update_post_meta($post_id, '_destination_trek_difficulty', sanitize_text_field($_POST['destination_trek_difficulty']));
    } else {
        delete_post_meta($post_id, '_destination_trek_difficulty');
    }

    if (isset($_POST['destination_trek_permits'])) {
        update_post_meta($post_id, '_destination_trek_permits', sanitize_textarea_field(wp_unslash($_POST['destination_trek_permits'])));
    }

    if (isset($_POST['itinerary']) && is_array($_POST['itinerary'])) {
        $days = [];
        foreach ($_POST['itinerary'] as $day) {
            if (!is_array($day)) {
                continue;
            }

            $days[] = [
                'day'       => isset($day['day']) ? sanitize_text_field(wp_unslash($day['day'])) : '',
                'title'     => isset($day['title']) ? sanitize_text_field(wp_unslash($day['title'])) : '',
                'transport' => isset($day['transport']) ? sanitize_text_field(wp_unslash($day['transport'])) : '',
                'elevation' => isset($day['elevation']) ? sanitize_text_field(wp_unslash($day['elevation'])) : '',
                'notes'     => isset($day['notes']) ? sanitize_textarea_field(wp_unslash($day['notes'])) : '',
            ];
        }

        $days = array_values(array_filter($days, function ($day) {
            return $day['day'] !== '' || $day['title'] !== '';
        }));

        update_post_meta($post_id, '_destination_trek_itinerary', wp_json_encode($days));
    }

    if (isset($_POST['destination_what_to_pack'])) {
        update_post_meta($post_id, '_destination_what_to_pack', sanitize_textarea_field(wp_unslash($_POST['destination_what_to_pack'])));
    }

    if (isset($_POST['destination_trek_tips'])) {
        update_post_meta($post_id, '_destination_trek_tips', sanitize_textarea_field(wp_unslash($_POST['destination_trek_tips'])));
    }

    if (isset($_POST['destination_region'])) {
        update_post_meta($post_id, '_destination_region', sanitize_text_field(wp_unslash($_POST['destination_region'])));
    }

    if (isset($_POST['destination_best_season'])) {
        update_post_meta($post_id, '_destination_best_season', sanitize_text_field(wp_unslash($_POST['destination_best_season'])));
    }

    if (isset($_POST['destination_why_choose'])) {
        update_post_meta($post_id, '_destination_why_choose', sanitize_textarea_field(wp_unslash($_POST['destination_why_choose'])));
    }

    if (isset($_POST['destination_trek_map'])) {
        $map = esc_url_raw(wp_unslash($_POST['destination_trek_map']));
        if ($map) {
            update_post_meta($post_id, '_destination_trek_map', $map);
        } else {
            delete_post_meta($post_id, '_destination_trek_map');
        }
    }

    if (isset($_POST['highlights']) && is_array($_POST['highlights'])) {
        $highlights = [];
        foreach ($_POST['highlights'] as $item) {
            if (!is_array($item)) {
                continue;
            }

            $image   = isset($item['image']) ? esc_url_raw(wp_unslash($item['image'])) : '';
            $caption = isset($item['caption']) ? sanitize_text_field(wp_unslash($item['caption'])) : '';

            if ($image) {
                $highlights[] = ['image' => $image, 'caption' => $caption];
            }
        }

        update_post_meta($post_id, '_destination_highlights', wp_json_encode(array_values($highlights)));
    }
}
add_action('save_post', 'ghodaghodi_trek_save_meta');

function ghodaghodi_add_user_social_fields($user)
{
?>
    <h3><?php _e('Author Social Profiles', 'ghodaghodi-view'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="ghodaghodi_facebook"><?php _e('Facebook', 'ghodaghodi-view'); ?></label></th>
            <td>
                <input type="url" name="ghodaghodi_facebook" id="ghodaghodi_facebook" value="<?php echo esc_attr(get_user_meta($user->ID, 'ghodaghodi_facebook', true)); ?>" class="regular-text" placeholder="https://facebook.com/username" />
            </td>
        </tr>
        <tr>
            <th><label for="ghodaghodi_twitter"><?php _e('Twitter / X', 'ghodaghodi-view'); ?></label></th>
            <td>
                <input type="url" name="ghodaghodi_twitter" id="ghodaghodi_twitter" value="<?php echo esc_attr(get_user_meta($user->ID, 'ghodaghodi_twitter', true)); ?>" class="regular-text" placeholder="https://twitter.com/username" />
            </td>
        </tr>
        <tr>
            <th><label for="ghodaghodi_instagram"><?php _e('Instagram', 'ghodaghodi-view'); ?></label></th>
            <td>
                <input type="url" name="ghodaghodi_instagram" id="ghodaghodi_instagram" value="<?php echo esc_attr(get_user_meta($user->ID, 'ghodaghodi_instagram', true)); ?>" class="regular-text" placeholder="https://instagram.com/username" />
            </td>
        </tr>
        <tr>
            <th><label for="ghodaghodi_linkedin"><?php _e('LinkedIn', 'ghodaghodi-view'); ?></label></th>
            <td>
                <input type="url" name="ghodaghodi_linkedin" id="ghodaghodi_linkedin" value="<?php echo esc_attr(get_user_meta($user->ID, 'ghodaghodi_linkedin', true)); ?>" class="regular-text" placeholder="https://linkedin.com/in/username" />
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'ghodaghodi_add_user_social_fields');
add_action('edit_user_profile', 'ghodaghodi_add_user_social_fields');

function ghodaghodi_save_user_social_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    $fields = ['facebook', 'twitter', 'instagram', 'linkedin'];
    foreach ($fields as $field) {
        if (isset($_POST['ghodaghodi_' . $field])) {
            update_user_meta($user_id, 'ghodaghodi_' . $field, esc_url_raw($_POST['ghodaghodi_' . $field]));
        }
    }
}
add_action('personal_options_update', 'ghodaghodi_save_user_social_fields');
add_action('edit_user_profile_update', 'ghodaghodi_save_user_social_fields');

require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/walker.php';
require_once get_template_directory() . '/inc/customizer.php';
