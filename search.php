<?php get_header(); ?>

<main class="container mx-auto px-4 py-12">
    <header class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-emerald-950 mb-2">
            <?php
            printf(
                __('खोजी परिणाम: %s', 'ghodaghodi-view'),
                '<span class="text-amber-600">' . get_search_query() . '</span>'
            );
            ?>
        </h1>
        <p class="text-gray-500">
            <?php
            global $wp_query;
            printf(
                _n('कुल %d परिणाम फेला पर्यो', 'कुल %d परिणामहरू फेला पर्यो', $wp_query->found_posts, 'ghodaghodi-view'),
                $wp_query->found_posts
            );
            ?>
        </p>
    </header>

    <?php if (have_posts()): ?>
    <div class="max-w-3xl mx-auto space-y-6">
        <?php
        while (have_posts()):
            the_post();
            get_template_part('template-parts/content', 'search');
        endwhile;
        ?>
    </div>

    <div class="mt-10 text-center">
        <?php
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
        ]);
        ?>
    </div>
    <?php else: ?>
        <div class="text-center py-12">
            <i class="fa-solid fa-search text-5xl text-gray-300 mb-4 block"></i>
            <p class="text-gray-500"><?php _e('कृपया फरक खोजी शब्द प्रयोग गर्नुहोस्।', 'ghodaghodi-view'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
