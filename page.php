<?php get_header(); ?>

<main class="container mx-auto px-4 py-12 max-w-4xl">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-10'); ?>>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6"><?php the_title(); ?></h1>

            <?php if (has_post_thumbnail()): ?>
            <div class="mb-6 rounded-lg overflow-hidden">
                <?php the_post_thumbnail('large', ['class' => 'w-full h-auto']); ?>
            </div>
            <?php endif; ?>

            <div class="prose prose-gray max-w-none leading-relaxed text-gray-700">
                <?php the_content(); ?>
            </div>

            <?php
            wp_link_pages([
                'before' => '<div class="page-links mt-6 text-sm font-semibold">' . __('पृष्ठहरू:', 'ghodaghodi-view'),
                'after'  => '</div>',
            ]);
            ?>
        </article>
        <?php
        if (comments_open() || get_comments_number()):
            comments_template();
        endif;
    endwhile;
    ?>
</main>

<?php get_footer(); ?>
