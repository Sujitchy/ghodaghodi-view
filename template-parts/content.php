<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition mb-6'); ?>>
    <div class="md:flex">
        <?php if (has_post_thumbnail()): ?>
        <div class="md:w-1/3 h-48 md:h-auto overflow-hidden">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); ?>
            </a>
        </div>
        <?php endif; ?>
        <div class="p-6 md:w-2/3">
            <h2 class="text-xl font-bold text-gray-900 mb-2">
                <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700 transition"><?php the_title(); ?></a>
            </h2>
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                <?php ghodaghodi_posted_on(); ?>
                <?php ghodaghodi_posted_by(); ?>
            </div>
            <p class="text-sm text-gray-600 line-clamp-3"><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 30); ?></p>
            <?php ghodaghodi_post_categories(); ?>
        </div>
    </div>
</article>
