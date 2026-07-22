<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition'); ?>>
    <h2 class="text-xl font-bold text-gray-900 mb-2">
        <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700 transition"><?php the_title(); ?></a>
    </h2>
    <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
        <?php ghodaghodi_posted_on(); ?>
        <span><?php _e('प्रकार:', 'ghodaghodi-view'); ?> <?php echo get_post_type_object(get_post_type())->labels->singular_name ?? get_post_type(); ?></span>
    </div>
    <p class="text-sm text-gray-600"><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 25); ?></p>
</article>
