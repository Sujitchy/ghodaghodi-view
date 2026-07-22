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

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ghodaghodi_hero_bg', [
        'label'    => __('Hero Background Image', 'ghodaghodi-view'),
        'section'  => 'ghodaghodi_stats',
        'settings' => 'ghodaghodi_hero_bg',
    ]));

    $stat_fields = [
        'ghodaghodi_stat_sites'    => __('कुल पर्यटकीय क्षेत्र (e.g. २४+)', 'ghodaghodi-view'),
        'ghodaghodi_stat_hotels'   => __('दर्ता होमस्टे/होटल (e.g. १५+)', 'ghodaghodi-view'),
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
}
add_action('customize_register', 'ghodaghodi_customize_register');
