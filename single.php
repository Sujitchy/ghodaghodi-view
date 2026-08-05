<?php get_header(); ?>

<main>
    <?php
    while (have_posts()):
        the_post();
    ?>

    <?php if (in_category('destinations')): ?>

        <?php
        $duration    = get_post_meta(get_the_ID(), '_destination_trek_duration', true);
        $elevation   = get_post_meta(get_the_ID(), '_destination_trek_max_elevation', true);
        $difficulty  = (int) get_post_meta(get_the_ID(), '_destination_trek_difficulty', true);
        $permits     = get_post_meta(get_the_ID(), '_destination_trek_permits', true);
        $itinerary   = json_decode(get_post_meta(get_the_ID(), '_destination_trek_itinerary', true), true);
        $pack        = get_post_meta(get_the_ID(), '_destination_what_to_pack', true);
        $tips        = get_post_meta(get_the_ID(), '_destination_trek_tips', true);
        $region      = get_post_meta(get_the_ID(), '_destination_region', true);
        $best_season = get_post_meta(get_the_ID(), '_destination_best_season', true);
        $why_choose  = get_post_meta(get_the_ID(), '_destination_why_choose', true);
        $trek_map    = get_post_meta(get_the_ID(), '_destination_trek_map', true);
        $highlights  = json_decode(get_post_meta(get_the_ID(), '_destination_highlights', true), true);

        $itinerary   = is_array($itinerary) ? $itinerary : [];
        $highlights  = is_array($highlights) ? $highlights : [];
        $pack_items  = $pack ? array_values(array_filter(array_map('trim', explode(',', $pack)))) : [];
        $tip_items   = $tips ? array_values(array_filter(array_map('trim', explode(',', $tips)))) : [];
        $why_items   = $why_choose ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $why_choose)))) : [];

        $categories  = get_the_category();
        $primary_cat = !empty($categories) ? $categories[0] : null;

        $content_text = wp_strip_all_tags(get_post_field('post_content', get_the_ID()));
        $word_count   = count(preg_split('/\s+/', trim($content_text)));
        $reading_time = max(1, (int) round($word_count / 200));

        $difficulty_labels = [
            1 => __('Easy', 'ghodaghodi-view'),
            2 => __('Moderate', 'ghodaghodi-view'),
            3 => __('Challenging', 'ghodaghodi-view'),
            4 => __('Difficult', 'ghodaghodi-view'),
            5 => __('Extreme', 'ghodaghodi-view'),
        ];
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
                        <?php if ($primary_cat): ?>
                            <span class="inline-flex items-center gap-1.5 bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                                <i class="fa-solid fa-tag"></i> <?php echo esc_html($primary_cat->name); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($duration): ?>
                            <span class="inline-flex items-center gap-1.5 bg-amber-400 text-emerald-950 text-xs font-bold px-3 py-1.5 rounded-full">
                                <i class="fa-regular fa-clock"></i> <?php echo esc_html($duration); ?>
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

                    <?php // Overview ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                        <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-900 mb-4">
                            <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                            <?php _e('Overview', 'ghodaghodi-view'); ?>
                        </h2>
                        <div class="prose-ghodaghodi">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <?php // Trek Route Map ?>
                    <?php if ($trek_map): ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                            <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-900 mb-5">
                                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                                <i class="fa-solid fa-map text-emerald-600"></i> <?php _e('Trek Route Map', 'ghodaghodi-view'); ?>
                            </h2>
                            <button type="button" data-ghodaghodi-lightbox="<?php echo esc_url($trek_map); ?>" class="group relative w-full block overflow-hidden rounded-xl border border-gray-100 focus:outline-none" aria-label="<?php echo esc_attr(sprintf(__('Open route map for %s in a lightbox', 'ghodaghodi-view'), get_the_title())); ?>">
                                <img src="<?php echo esc_url($trek_map); ?>" alt="<?php echo esc_attr(sprintf(__('Route map for %s', 'ghodaghodi-view'), get_the_title())); ?>" class="w-full h-auto transition duration-300 group-hover:scale-[1.02]" loading="lazy" />
                                <span class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/40 transition pointer-events-none">
                                    <span class="inline-flex items-center gap-2 bg-white text-gray-900 text-sm font-semibold px-4 py-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition">
                                        <i class="fa-solid fa-magnifying-glass-plus"></i> <?php _e('View Larger Map', 'ghodaghodi-view'); ?>
                                    </span>
                                </span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php // Trek Itinerary ?>
                    <?php if (!empty($itinerary)): ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                            <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-900 mb-6">
                                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                                <i class="fa-solid fa-route text-emerald-600"></i> <?php _e('Trek Itinerary', 'ghodaghodi-view'); ?>
                            </h2>
                            <ol class="relative border-l-2 border-emerald-100 ml-2 space-y-10">
                                <?php foreach ($itinerary as $day): ?>
                                    <?php
                                    $day_label     = isset($day['day']) ? $day['day'] : '';
                                    $day_title     = isset($day['title']) ? $day['title'] : '';
                                    $day_transport = isset($day['transport']) ? $day['transport'] : '';
                                    $day_elevation = isset($day['elevation']) ? $day['elevation'] : '';
                                    $day_notes     = isset($day['notes']) ? $day['notes'] : '';
                                    ?>
                                    <li class="relative pl-8">
                                        <span class="absolute left-0 top-1.5 -translate-x-1/2 w-4 h-4 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full"><?php echo esc_html($day_label); ?></span>
                                            <h3 class="font-bold text-gray-900 text-lg"><?php echo esc_html($day_title); ?></h3>
                                        </div>
                                        <?php if ($day_transport || $day_elevation): ?>
                                            <div class="flex flex-wrap gap-4 text-xs text-gray-500 mb-2">
                                                <?php if ($day_transport): ?>
                                                    <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-car-side text-emerald-600"></i> <?php echo esc_html($day_transport); ?></span>
                                                <?php endif; ?>
                                                <?php if ($day_elevation): ?>
                                                    <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-arrow-trend-up text-amber-500"></i> <?php echo esc_html($day_elevation); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($day_notes): ?>
                                            <p class="text-[15px] text-gray-600 leading-relaxed"><?php echo esc_html($day_notes); ?></p>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    <?php endif; ?>

                    <?php // Why Choose This Trek ?>
                    <?php if ($why_items): ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                            <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-900 mb-5">
                                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                                <i class="fa-solid fa-heart text-rose-500"></i> <?php printf(__('Why Choose %s?', 'ghodaghodi-view'), esc_html(get_the_title())); ?>
                            </h2>
                            <ul class="space-y-3">
                                <?php foreach ($why_items as $item): ?>
                                    <li class="flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4">
                                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 shrink-0 mt-0.5">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </span>
                                        <span class="text-sm text-gray-700 leading-relaxed"><?php echo esc_html($item); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php // === Social Share === ?>
                    <?php
                    $share_url   = rawurlencode(get_permalink());
                    $share_title = rawurlencode(get_the_title());
                    ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <span class="font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-emerald-600"></i> <?php _e('Share This Trek', 'ghodaghodi-view'); ?>
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

                        <?php // Highlights Gallery ?>
                        <?php if (!empty($highlights)): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-images text-emerald-600"></i> <?php _e('Highlights Gallery', 'ghodaghodi-view'); ?>
                                </h3>
                                <div class="space-y-4">
                                    <?php foreach ($highlights as $item): ?>
                                        <?php if (empty($item['image'])) continue; ?>
                                        <figure class="overflow-hidden rounded-xl">
                                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr(isset($item['caption']) ? $item['caption'] : ''); ?>" class="w-full h-40 object-cover hover:scale-105 transition duration-300" loading="lazy" />
                                            <?php if (!empty($item['caption'])): ?>
                                                <figcaption class="text-xs text-gray-500 mt-1.5"><?php echo esc_html($item['caption']); ?></figcaption>
                                            <?php endif; ?>
                                        </figure>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php // Trek Facts ?>
                        <?php if ($region || $elevation || $duration || $difficulty || $best_season): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-mountain-sun text-amber-500"></i> <?php _e('Trek Facts', 'ghodaghodi-view'); ?>
                                </h3>
                                <ul class="space-y-3 text-sm">
                                    <?php if ($region): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-location-dot"></i></span>
                                            <span class="text-gray-500"><?php _e('Region', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto font-semibold text-gray-900 text-right"><?php echo esc_html($region); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($elevation): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-mountain"></i></span>
                                            <span class="text-gray-500"><?php _e('Max Elevation', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto font-semibold text-gray-900 text-right"><?php echo esc_html($elevation); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($duration): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center shrink-0"><i class="fa-regular fa-clock"></i></span>
                                            <span class="text-gray-500"><?php _e('Duration', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto font-semibold text-gray-900 text-right"><?php echo esc_html($duration); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($difficulty): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-signal"></i></span>
                                            <span class="text-gray-500"><?php _e('Difficulty', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto flex items-center gap-0.5" title="<?php echo esc_attr(isset($difficulty_labels[$difficulty]) ? $difficulty_labels[$difficulty] : sprintf(__('Difficulty: %1$d / 5', 'ghodaghodi-view'), $difficulty)); ?>">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="text-xs <?php echo $i <= $difficulty ? 'fa-solid fa-star text-amber-400' : 'fa-regular fa-star text-gray-300'; ?>"></i>
                                                <?php endfor; ?>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($best_season): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-calendar-days"></i></span>
                                            <span class="text-gray-500"><?php _e('Best Season', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto font-semibold text-gray-900 text-right"><?php echo esc_html($best_season); ?></span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php // Permits & Fees ?>
                        <?php if ($permits): ?>
                            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-6">
                                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-ticket text-emerald-600"></i> <?php _e('Permits & Fees', 'ghodaghodi-view'); ?>
                                </h3>
                                <p class="text-sm text-emerald-950 leading-relaxed whitespace-pre-line"><?php echo esc_html($permits); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php // What to Pack ?>
                        <?php if ($pack_items): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-suitcase text-emerald-600"></i> <?php _e('What to Pack', 'ghodaghodi-view'); ?>
                                </h3>
                                <ul class="space-y-2">
                                    <?php foreach ($pack_items as $item): ?>
                                        <li class="flex items-start gap-2 text-sm text-gray-700">
                                            <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i> <span><?php echo esc_html($item); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php // Tips for Trekkers ?>
                        <?php if ($tip_items): ?>
                            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6">
                                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-lightbulb text-amber-500"></i> <?php _e('Tips for Trekkers', 'ghodaghodi-view'); ?>
                                </h3>
                                <ul class="space-y-2">
                                    <?php foreach ($tip_items as $tip): ?>
                                        <li class="flex items-start gap-2 text-sm text-gray-700">
                                            <i class="fa-solid fa-leaf text-emerald-600 mt-0.5"></i> <span><?php echo esc_html($tip); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>
                </aside>
            </div>
        </div>

        <?php // === 3. You May Also Like === ?>
        <?php
        $related = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'category_name'  => 'destinations',
            'post__not_in'   => [get_the_ID()],
            'orderby'        => 'rand',
        ]);

        if ($related->have_posts()):
        ?>
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                <i class="fa-solid fa-route text-emerald-600"></i> <?php _e('You May Also Like', 'ghodaghodi-view'); ?>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php while ($related->have_posts()): $related->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="group bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition block">
                        <div class="h-44 bg-gray-200 relative overflow-hidden">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300', 'alt' => get_the_title()]); ?>
                            <?php endif; ?>
                            <span class="absolute top-3 left-3 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded"><?php _e('Destination', 'ghodaghodi-view'); ?></span>
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

    <?php else: ?>

        <?php get_template_part('template-parts/featured-hero'); ?>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100'); ?>>

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

                    <div class="prose-ghodaghodi">
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
        </div>

    <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
