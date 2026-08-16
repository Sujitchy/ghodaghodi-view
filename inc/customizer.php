<?php
/**
 * Theme Customizer settings for Ghodaghodi View
 */

function ghodaghodi_customize_register($wp_customize) {

    $wp_customize->add_section('ghodaghodi_stats', [
        'title'    => __('Dashboard Statistics', 'ghodaghodi-view'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('ghodaghodi_hero_bg', [
        'default'           => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $stat_fields = [
        'ghodaghodi_stat_birds'    => __('चरा प्रजातिहरू (e.g. २९०+)', 'ghodaghodi-view'),
        'ghodaghodi_stat_tourists' => __('वार्षिक पर्यटक (e.g. ५०K+)', 'ghodaghodi-view'),
    ];

    foreach ($stat_fields as $key => $label) {
        $wp_customize->add_setting($key, [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
    
        $wp_customize->add_control($key, [
            'label'       => $label,
            'section'     => 'ghodaghodi_stats',
            'type'        => 'text',
        ]);
    }

    $wp_customize->add_section('ghodaghodi_about', [
        'title'    => __('About Us', 'ghodaghodi-view'),
        'priority' => 31,
    ]);

    $about_fields = [
        'ghodaghodi_about_mission' => __('हाम्रो मिशन (Mission)', 'ghodaghodi-view'),
        'ghodaghodi_about_vision'  => __('हाम्रो दृष्टि (Vision)', 'ghodaghodi-view'),
    ];

    foreach ($about_fields as $key => $label) {
        $wp_customize->add_setting($key, [
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ]);

        $wp_customize->add_control($key, [
            'label'   => $label,
            'section' => 'ghodaghodi_about',
            'type'    => 'textarea',
        ]);
    }

    $wp_customize->add_section('ghodaghodi_contact', [
        'title'    => __('Contact Info', 'ghodaghodi-view'),
        'priority' => 32,
    ]);

    $contact_fields = [
        'ghodaghodi_contact_address' => __('ठेगाना (Address)', 'ghodaghodi-view'),
        'ghodaghodi_contact_phone'    => __('फोन (Phone)', 'ghodaghodi-view'),
        'ghodaghodi_contact_email'    => __('इमेल (Email - form receives messages)', 'ghodaghodi-view'),
        'ghodaghodi_contact_hours'    => __('खुल्ने समय (Opening Hours)', 'ghodaghodi-view'),
        'ghodaghodi_contact_map'      => __('Google Maps Embed URL', 'ghodaghodi-view'),
    ];

    foreach ($contact_fields as $key => $label) {
        $type = 'ghodaghodi_contact_map' === $key ? 'url' : 'text';
        $sanitize = 'ghodaghodi_contact_map' === $key ? 'esc_url_raw' : 'sanitize_text_field';

        $wp_customize->add_setting($key, [
            'default'           => '',
            'sanitize_callback' => $sanitize,
        ]);

        $wp_customize->add_control($key, [
            'label'   => $label,
            'section' => 'ghodaghodi_contact',
            'type'    => $type,
        ]);
    }
}
add_action('customize_register', 'ghodaghodi_customize_register');
