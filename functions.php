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

require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/walker.php';
require_once get_template_directory() . '/inc/customizer.php';
