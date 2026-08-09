<?php get_header(); ?>

<main>
    <?php
    while (have_posts()):
        the_post();
    ?>

        <?php
        $categories  = get_the_category();
        $primary_cat = !empty($categories) ? $categories[0] : null;

        $content_text = wp_strip_all_tags(get_post_field('post_content', get_the_ID()));
        $word_count   = count(preg_split('/\s+/', trim($content_text)));
        $reading_time = max(1, (int) round($word_count / 200));

        $dest_category = get_category_by_slug('destinations');
        $excluded_term = $dest_category ? $dest_category->term_id : 0;
        ?>

        <?php // === 1. Hero Banner === ?>
        <section class="relative flex items-end min-h-[440px] md:min-h-[560px] overflow-hidden bg-emerald-950">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('full', [
                    'class' => 'absolute inset-0 w-full h-full object-cover object-center',
                    'alt'   => esc_attr(get_the_title()),
                ]); ?>
            <?php else: ?>
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-teal-800 to-emerald-950"></div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/25" aria-hidden="true"></div>

            <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-12 md:pb-16 text-white">
                <div class="max-w-3xl">
                    <div class="flex flex-wrap items-center gap-2.5 mb-4">
                        <?php if (!empty($categories)): ?>
                            <?php foreach (array_slice($categories, 0, 3) as $cat): ?>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="inline-flex items-center gap-1.5 bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-emerald-700 transition">
                                    <i class="fa-solid fa-tag"></i> <?php echo esc_html($cat->name); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                                <i class="fa-solid fa-newspaper"></i> <?php _e('ब्लग', 'ghodaghodi-view'); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-5 drop-shadow-lg"><?php the_title(); ?></h1>

                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2.5 text-sm text-white/90">
                        <span class="inline-flex items-center gap-2">
                            <?php echo get_avatar(get_the_author_meta('ID'), 28, '', get_the_author(), ['class' => 'rounded-full border-2 border-white/30']); ?>
                            <span class="font-semibold"><?php the_author(); ?></span>
                        </span>
                        <span class="inline-flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span>
                        <span class="inline-flex items-center gap-1.5"><i class="fa-regular fa-clock"></i> <?php echo esc_html(sprintf(__('%d min read', 'ghodaghodi-view'), $reading_time)); ?></span>
                    </div>
                </div>
            </div>
        </section>

        <?php // === 2. Main Content (Left) + Sidebar (Right) === ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <article id="post-<?php the_ID(); ?>" <?php post_class('lg:col-span-8 min-w-0 space-y-6'); ?>>

                    <?php // Content ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                        <div class="prose-ghodaghodi">
                            <?php the_content(); ?>
                        </div>

                        <?php
                        wp_link_pages([
                            'before' => '<div class="page-links mt-6 text-sm">' . __('Pages:', 'ghodaghodi-view') . ' ',
                            'after'  => '</div>',
                        ]);
                        ?>
                    </div>

                    <?php // Tags ?>
                    <?php $tags = get_the_tags(); ?>
                    <?php if ($tags): ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-tags text-emerald-600"></i> <?php _e('ट्यागहरू', 'ghodaghodi-view'); ?>
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag): ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-amber-100 transition">
                                        <i class="fa-solid fa-hashtag"></i> <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php // === Social Share === ?>
                    <?php
                    $share_url   = rawurlencode(get_permalink());
                    $share_title = rawurlencode(get_the_title());
                    ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <span class="font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-emerald-600"></i> <?php _e('Share This Article', 'ghodaghodi-view'); ?>
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($share_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#1877F2] text-white hover:opacity-85 transition" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo esc_attr($share_url); ?>&text=<?php echo esc_attr($share_title); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black text-white hover:opacity-85 transition" aria-label="Twitter">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr($share_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#0A66C2] text-white hover:opacity-85 transition" aria-label="LinkedIn">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                            <button type="button" class="ghodaghodi-copy-link inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-800 text-white hover:opacity-85 transition" data-url="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php esc_attr_e('Copy link', 'ghodaghodi-view'); ?>">
                                <i class="fa-solid fa-link"></i>
                            </button>
                        </div>
                    </div>

                    <?php // === Author Box === ?>
                    <?php
                    $author_id        = get_the_author_meta('ID');
                    $author_website   = get_the_author_meta('url');
                    $author_facebook  = get_the_author_meta('ghodaghodi_facebook');
                    $author_twitter   = get_the_author_meta('ghodaghodi_twitter');
                    $author_instagram = get_the_author_meta('ghodaghodi_instagram');
                    $author_linkedin  = get_the_author_meta('ghodaghodi_linkedin');
                    ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 flex flex-col sm:flex-row gap-6">
                        <div class="shrink-0">
                            <?php echo get_avatar($author_id, 96, '', get_the_author(), ['class' => 'rounded-full']); ?>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400 mb-1"><?php _e('Written by', 'ghodaghodi-view'); ?></p>
                            <h3 class="text-lg font-bold text-gray-900 mb-2"><?php the_author(); ?></h3>
                            <?php if (get_the_author_meta('description')): ?>
                                <p class="text-sm text-gray-600 leading-relaxed mb-4"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                            <?php endif; ?>
                            <div class="flex items-center gap-2 flex-wrap">
                                <?php if ($author_website): ?>
                                    <a href="<?php echo esc_url($author_website); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition" aria-label="<?php esc_attr_e('Website', 'ghodaghodi-view'); ?>"><i class="fa-solid fa-globe"></i></a>
                                <?php endif; ?>
                                <?php if ($author_facebook): ?>
                                    <a href="<?php echo esc_url($author_facebook); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-[#1877F2]/10 text-[#1877F2] hover:bg-[#1877F2]/20 transition" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                                <?php endif; ?>
                                <?php if ($author_twitter): ?>
                                    <a href="<?php echo esc_url($author_twitter); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-black/5 text-black hover:bg-black/10 transition" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                                <?php endif; ?>
                                <?php if ($author_instagram): ?>
                                    <a href="<?php echo esc_url($author_instagram); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-pink-500/10 text-pink-600 hover:bg-pink-500/20 transition" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                                <?php endif; ?>
                                <?php if ($author_linkedin): ?>
                                    <a href="<?php echo esc_url($author_linkedin); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-[#0A66C2]/10 text-[#0A66C2] hover:bg-[#0A66C2]/20 transition" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                                <?php endif; ?>
                                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="text-sm font-semibold text-emerald-700 hover:text-amber-600 transition ml-1">
                                    <?php _e('View all posts', 'ghodaghodi-view'); ?> <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <?php // === Sidebar (Right, Sticky) === ?>
                <aside class="lg:col-span-4 min-w-0">
                    <div class="lg:sticky lg:top-24 space-y-6">

                        <?php // Recent Posts ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-file-lines text-emerald-600"></i> <?php _e('हालैका ब्लगहरू', 'ghodaghodi-view'); ?>
                            </h3>
                            <?php
                            $recent_args = [
                                'post_type'           => 'post',
                                'posts_per_page'      => 5,
                                'post__not_in'        => [get_the_ID()],
                                'ignore_sticky_posts' => true,
                            ];
                            if ($excluded_term) {
                                $recent_args['category__not_in'] = [$excluded_term];
                            }
                            $recent = new WP_Query($recent_args);
                            ?>
                            <?php if ($recent->have_posts()): ?>
                                <ul class="space-y-4">
                                    <?php while ($recent->have_posts()): $recent->the_post(); ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>" class="group flex gap-3">
                                                <?php if (has_post_thumbnail()): ?>
                                                    <span class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                                                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300', 'alt' => get_the_title()]); ?>
                                                    </span>
                                                <?php endif; ?>
                                                <span>
                                                    <span class="block text-sm font-semibold text-gray-900 leading-snug group-hover:text-emerald-700 transition"><?php the_title(); ?></span>
                                                    <span class="block text-xs text-gray-400 mt-1"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endwhile; wp_reset_postdata(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <?php // Categories ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-folder-open text-amber-500"></i> <?php _e('श्रेणीहरू', 'ghodaghodi-view'); ?>
                            </h3>
                            <?php
                            $cat_args = ['orderby' => 'count', 'order' => 'DESC'];
                            if ($excluded_term) {
                                $cat_args['exclude'] = [$excluded_term];
                            }
                            $cats = get_categories($cat_args);
                            ?>
                            <?php if (!empty($cats)): ?>
                                <ul class="space-y-2">
                                    <?php foreach ($cats as $cat): ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="flex items-center justify-between text-sm text-gray-700 hover:text-emerald-700 transition py-1.5 px-3 rounded-lg hover:bg-emerald-50">
                                                <span class="flex items-center gap-2"><i class="fa-solid fa-angle-right text-emerald-500"></i> <?php echo esc_html($cat->name); ?></span>
                                                <span class="text-xs text-gray-400 bg-gray-100 rounded-full px-2 py-0.5"><?php echo esc_html($cat->count); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <?php // Tags ?>
                        <?php
                        $all_tags = get_tags(['number' => 10, 'orderby' => 'count', 'order' => 'DESC']);
                        ?>
                        <?php if (!empty($all_tags)): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-tags text-emerald-600"></i> <?php _e('ट्याग क्लाउड', 'ghodaghodi-view'); ?>
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($all_tags as $tag): ?>
                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-amber-100 transition">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </aside>
            </div>
        </div>

        <?php // === 4. You May Also Like === ?>
        <?php
        $related_args = [
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post__not_in'   => [get_the_ID()],
            'orderby'        => 'rand',
            'ignore_sticky_posts' => true,
        ];
        if ($excluded_term) {
            $related_args['category__not_in'] = [$excluded_term];
        }
        $related = new WP_Query($related_args);

        if ($related->have_posts()):
        ?>
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                <i class="fa-solid fa-book-open text-emerald-600"></i> <?php _e('साथै पढ्नुहोस्', 'ghodaghodi-view'); ?>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php while ($related->have_posts()): $related->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="group bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition block">
                        <div class="h-44 bg-gray-200 relative overflow-hidden">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300', 'alt' => get_the_title()]); ?>
                            <?php endif; ?>
                            <?php
                            $rcat = get_the_category();
                            if (!empty($rcat)):
                            ?>
                                <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded"><?php echo esc_html($rcat[0]->name); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="p-5">
                            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></p>
                            <h4 class="font-bold text-gray-900 group-hover:text-emerald-700 transition"><?php the_title(); ?></h4>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
