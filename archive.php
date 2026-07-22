<?php get_header(); ?>

<main class="container mx-auto px-4 py-12">
    <header class="mb-10 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-emerald-950">
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_author()) {
                the_post();
                printf(__('लेखक: %s', 'ghodaghodi-view'), get_the_author());
                rewind_posts();
            } elseif (is_day()) {
                printf(__('दिन: %s', 'ghodaghodi-view'), get_the_date());
            } elseif (is_month()) {
                printf(__('महिना: %s', 'ghodaghodi-view'), get_the_date('F Y'));
            } elseif (is_year()) {
                printf(__('वर्ष: %s', 'ghodaghodi-view'), get_the_date('Y'));
            } else {
                _e('अभिलेख', 'ghodaghodi-view');
            }
            ?>
        </h1>
        <?php
        $term_desc = term_description();
        if ($term_desc):
        ?>
        <p class="text-gray-500 mt-2 max-w-2xl mx-auto"><?php echo $term_desc; ?></p>
        <?php endif; ?>
    </header>

    <?php if (have_posts()): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        while (have_posts()):
            the_post();
            get_template_part('template-parts/content', 'archive');
        endwhile;
        ?>
    </div>

    <div class="mt-10">
        <?php
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
            'class'     => 'flex justify-center gap-2',
        ]);
        ?>
    </div>
    <?php else: ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
