<?php
/**
 * Ghodaghodi View Theme Functions
 */

define('GHODAGHODI_VERSION', '1.0.0');

if (!function_exists('ghodaghodi_setup')):
    function ghodaghodi_setup() {
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

function ghodaghodi_scripts() {
    $theme = wp_get_theme();

    wp_enqueue_style('ghodaghodi-tailwind', get_template_directory_uri() . '/assets/css/style.css', [], $theme->get('Version'));

    wp_enqueue_style('ghodaghodi-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], '6.4.0');

    wp_enqueue_script('ghodaghodi-script', get_template_directory_uri() . '/assets/js/theme.js', [], $theme->get('Version'), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ghodaghodi_scripts');

function ghodaghodi_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'font-mukta bg-gray-50 text-gray-800';
    }
    return $classes;
}
add_filter('body_class', 'ghodaghodi_body_classes');

function ghodaghodi_register_slider_post_type() {
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

function ghodaghodi_slider_add_meta_boxes() {
    add_meta_box('ghodaghodi_slide_options', __('Slide Options', 'ghodaghodi-view'), 'ghodaghodi_slide_meta_callback', 'ghodaghodi_slider', 'normal', 'high');
}
add_action('add_meta_boxes', 'ghodaghodi_slider_add_meta_boxes');

function ghodaghodi_slide_meta_callback($post) {
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

function ghodaghodi_slider_save_meta($post_id) {
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

require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/walker.php';
require_once get_template_directory() . '/inc/customizer.php';
