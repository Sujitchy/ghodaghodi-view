<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition'); ?>>
    <div class="h-48 bg-gray-200 relative overflow-hidden">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); ?>
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fa-solid fa-image text-4xl"></i>
                </div>
            <?php endif; ?>
        </a>
    </div>
    <div class="p-5">
        <?php
        $categories = get_the_category();
        if (!empty($categories)):
        ?>
        <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2 py-1 rounded-full mb-2 inline-block">
            <?php echo esc_html($categories[0]->name); ?>
        </span>
        <?php endif; ?>
        <h3 class="text-lg font-bold text-gray-900 mb-2">
            <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700 transition"><?php the_title(); ?></a>
        </h3>
        <p class="text-sm text-gray-500 line-clamp-2"><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 15); ?></p>
        <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-400 flex justify-between">
            <span><?php echo get_the_date(); ?></span>
            <a href="<?php the_permalink(); ?>" class="text-emerald-700 font-semibold hover:text-amber-600 transition"><?php _e('पढ्नुहोस्', 'ghodaghodi-view'); ?> &rarr;</a>
        </div>
    </div>
</article>
