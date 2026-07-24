<?php get_header(); ?>
<?php get_template_part('inc/section', 'hero') ?>
<?php get_template_part('inc/section', 'highlights') ?>


<main class="container mx-auto px-4 py-12">
    <?php get_template_part('inc/section', 'destinations') ?>
    <?php get_template_part('inc/section', 'gallery') ?>

    <?php get_template_part('inc/section', 'hotels') ?>

    <?php get_template_part('inc/section', 'qr') ?>

</main>

<?php get_footer(); ?>