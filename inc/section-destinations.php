<section id="destinations" class="mb-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-emerald-950 flex items-center gap-2">
                <i class="fa-solid fa-compass text-amber-500"></i>
                <?php _e('प्रमुख गन्तव्यहरू अन्वेषण गर्नुहोस्', 'ghodaghodi-view'); ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1"><?php _e('नगरपालिका भित्रका विभिन्न विधाका पर्यटकीय स्थलहरू', 'ghodaghodi-view'); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $destinations = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category_name'  => 'destinations',
            'meta_key'       => '_thumbnail_id',
        ]);

        if ($destinations->have_posts()):
            while ($destinations->have_posts()): $destinations->the_post();
                $categories = get_the_category();
                $cat_name   = !empty($categories) ? $categories[0]->name : __('सामान्य', 'ghodaghodi-view');
                $location   = get_post_meta(get_the_ID(), '_destination_location', true);
                $best_time  = get_post_meta(get_the_ID(), '_destination_best_time', true);
                $season     = get_post_meta(get_the_ID(), '_destination_season', true);
                $duration   = get_post_meta(get_the_ID(), '_destination_trek_duration', true);
                $elevation  = get_post_meta(get_the_ID(), '_destination_trek_max_elevation', true);
                $difficulty = (int) get_post_meta(get_the_ID(), '_destination_trek_difficulty', true);
        ?>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition">
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); ?>
                        <?php endif; ?>
                        <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded">
                            <?php echo esc_html($cat_name); ?>
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-1"><?php the_title(); ?></h3>
                        <?php if ($location): ?>
                            <p class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-amber-500"></i> <?php echo esc_html($location); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($duration || $elevation || $difficulty): ?>
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <?php if ($duration): ?>
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <i class="fa-regular fa-clock"></i> <?php echo esc_html($duration); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($elevation): ?>
                                    <span class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <i class="fa-solid fa-mountain-sun"></i> <?php echo esc_html($elevation); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($difficulty): ?>
                                    <span class="inline-flex items-center gap-1 text-xs" title="<?php echo esc_attr(sprintf(__('Difficulty: %1$d / 5', 'ghodaghodi-view'), $difficulty)); ?>">
                                        <span class="sr-only"><?php _e('Difficulty:', 'ghodaghodi-view'); ?></span>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="<?php echo $i <= $difficulty ? 'fa-solid fa-star text-amber-400' : 'fa-regular fa-star text-gray-300'; ?>"></i>
                                        <?php endfor; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                            <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 25); ?>
                        </p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100 text-xs text-gray-500">
                            <div class="flex flex-wrap items-center gap-3">
                                <?php if ($season): ?>
                                    <span><i class="fa-solid fa-calendar-days text-amber-500"></i> <?php echo esc_html($season); ?></span>
                                <?php endif; ?>
                                <span><i class="fa-regular fa-clock"></i> <?php echo $best_time ? esc_html($best_time) : __('बाह्रै महिना', 'ghodaghodi-view'); ?></span>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="text-emerald-700 font-semibold hover:text-amber-600 transition">
                                <?php _e('विस्तृतमा हेर्नुहोस्', 'ghodaghodi-view'); ?> <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        else:
            ?>
            <div class="col-span-full text-center py-12 text-gray-500">
                <i class="fa-solid fa-map-location-dot text-4xl mb-4 block text-gray-300"></i>
                <p><?php _e('कुनै गन्तव्यहरू उपलब्ध छैनन्। कृपया "destinations" श्रेणीमा पोष्टहरू थप्नुहोस्।', 'ghodaghodi-view'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>