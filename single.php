<?php get_header(); ?>

<main class="container mx-auto px-4 py-12 max-w-4xl">
    <?php
    while (have_posts()):
        the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden'); ?>>

            <?php if (has_post_thumbnail()): ?>
                <div class="h-64 md:h-96 overflow-hidden">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); ?>
                </div>
            <?php endif; ?>

            <div class="p-6 md:p-10">
                <div class="flex flex-wrap gap-2 mb-4">
                    <?php
                    $categories = get_the_category();
                    foreach ($categories as $cat) {
                        echo '<span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full">' . esc_html($cat->name) . '</span>';
                    }
                    ?>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4"><?php the_title(); ?></h1>

                <div class="flex items-center text-sm text-gray-500 mb-6 gap-4">
                    <span><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span>
                    <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                </div>

                <div class="prose prose-gray max-w-none leading-relaxed text-gray-700">
                    <?php the_content(); ?>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <?php
                    the_tags(
                        '<div class="flex flex-wrap gap-2 text-sm"><span class="font-semibold text-gray-700">ट्यागहरू:</span>',
                        '',
                        '</div>'
                    );
                    ?>
                </div>
            </div>
        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>