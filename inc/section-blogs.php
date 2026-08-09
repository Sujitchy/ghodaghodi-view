<section id="blogs" class="mb-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-emerald-950 flex items-center gap-2">
                <i class="fa-solid fa-newspaper text-amber-500"></i>
                <?php _e('ब्लग तथा समाचार', 'ghodaghodi-view'); ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1"><?php _e('नगरपालिकाका ताजा समाचार, लेख र सूचनाहरू', 'ghodaghodi-view'); ?></p>
        </div>
        <?php $posts_page = get_option('page_for_posts'); ?>
        <?php if ($posts_page): ?>
            <a href="<?php echo esc_url(get_permalink($posts_page)); ?>" class="inline-flex items-center gap-2 text-emerald-700 font-semibold hover:text-amber-600 transition text-sm">
                <?php _e('सबै ब्लगहरू हेर्नुहोस्', 'ghodaghodi-view'); ?> <i class="fa-solid fa-arrow-right"></i>
            </a>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $blog_args = [
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'meta_key'       => '_thumbnail_id',
        ];

        $dest_category = get_category_by_slug('destinations');
        if ($dest_category) {
            $blog_args['category__not_in'] = [$dest_category->term_id];
        }

        $blogs = new WP_Query($blog_args);

        if ($blogs->have_posts()):
            while ($blogs->have_posts()): $blogs->the_post();
                $categories = get_the_category();
                $cat_name   = !empty($categories) ? $categories[0]->name : __('ब्लग', 'ghodaghodi-view');
        ?>
                <a href="<?php the_permalink(); ?>" class="group bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition block">
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300', 'alt' => get_the_title()]); ?>
                        <?php endif; ?>
                        <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded">
                            <?php echo esc_html($cat_name); ?>
                        </span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-400 mb-2 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?>
                        </p>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-emerald-700 transition"><?php the_title(); ?></h3>
                        <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                            <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 25); ?>
                        </p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100 text-xs text-gray-500">
                            <span><i class="fa-regular fa-user"></i> <?php the_author(); ?></span>
                            <span class="text-emerald-700 font-semibold group-hover:text-amber-600 transition">
                                <?php _e('पढ्नुहोस्', 'ghodaghodi-view'); ?> <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            <?php
            endwhile;
            wp_reset_postdata();
        else:
            ?>
            <div class="col-span-full text-center py-12 text-gray-500">
                <i class="fa-solid fa-file-lines text-4xl mb-4 block text-gray-300"></i>
                <p><?php _e('कुनै ब्लग उपलब्ध छैनन्। कृपया पोष्टहरू थप्नुहोस्।', 'ghodaghodi-view'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
