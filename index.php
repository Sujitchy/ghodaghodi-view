<?php get_header(); ?>

<main class="container mx-auto px-4 py-12">
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
        ]);
    else:
        get_template_part('template-parts/content', 'none');
    endif;
    ?>
</main>

<?php get_footer(); ?>
