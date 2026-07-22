<?php
/**
 * Custom template tags for Ghodaghodi View theme
 */

function ghodaghodi_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date())
    );

    echo '<span class="posted-on text-xs text-gray-500 flex items-center gap-1">';
    echo '<i class="fa-regular fa-calendar"></i> ' . $time_string;
    echo '</span>';
}

function ghodaghodi_posted_by() {
    echo '<span class="text-xs text-gray-500 flex items-center gap-1">';
    echo '<i class="fa-regular fa-user"></i> ';
    printf(
        '<a href="%s" class="hover:text-emerald-700 transition">%s</a>',
        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
        esc_html(get_the_author())
    );
    echo '</span>';
}

function ghodaghodi_post_categories() {
    $categories = get_the_category();
    if (!empty($categories)) {
        echo '<div class="flex flex-wrap gap-2 mt-2">';
        foreach ($categories as $cat) {
            echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full hover:bg-amber-100 transition">' . esc_html($cat->name) . '</a>';
        }
        echo '</div>';
    }
}
