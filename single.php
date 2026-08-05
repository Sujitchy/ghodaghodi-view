<?php get_header(); ?>

<main>
    <?php
    while (have_posts()):
        the_post();
    ?>

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
        </div>

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

            $difficulty_labels = [
                1 => __('Easy', 'ghodaghodi-view'),
                2 => __('Moderate', 'ghodaghodi-view'),
                3 => __('Challenging', 'ghodaghodi-view'),
                4 => __('Difficult', 'ghodaghodi-view'),
                5 => __('Extreme', 'ghodaghodi-view'),
            ];

            $has_itinerary  = !empty($itinerary);
            $has_highlights = !empty($highlights);
            $has_facts      = $region || $elevation || $duration || $difficulty || $best_season;
            $has_sidebar    = $has_facts || $has_highlights || $permits || $pack_items || $tip_items;
            $has_left       = $has_itinerary || $why_items || $trek_map;
            $has_guide      = $has_left || $has_sidebar;

            if ($has_guide):
            ?>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">
                <section class="trek-route-guide">
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-800 text-white p-6 md:p-8 mb-10 shadow-lg">
                        <div class="absolute -right-10 -top-10 w-44 h-44 bg-amber-400/10 rounded-full"></div>
                        <div class="absolute right-24 -bottom-12 w-28 h-28 bg-white/5 rounded-full"></div>
                        <div class="relative flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <p class="text-emerald-300 text-xs font-semibold uppercase tracking-[0.25em] mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-route"></i> <?php _e('Trek Route Guide', 'ghodaghodi-view'); ?>
                                </p>
                                <h2 class="text-2xl md:text-3xl font-extrabold"><?php the_title(); ?></h2>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <?php if ($duration): ?>
                                    <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2 text-sm font-semibold">
                                        <i class="fa-regular fa-clock text-amber-300"></i> <?php echo esc_html($duration); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($elevation): ?>
                                    <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2 text-sm font-semibold">
                                        <i class="fa-solid fa-mountain-sun text-amber-300"></i> <?php echo esc_html($elevation); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <?php if ($has_left): ?>
                        <div class="lg:col-span-2">
                            <?php if ($why_items): ?>
                                <div class="mb-10">
                                    <h3 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                                        <i class="fa-solid fa-heart text-rose-500"></i> <?php printf(__('Why Choose %s?', 'ghodaghodi-view'), esc_html(get_the_title())); ?>
                                    </h3>
                                    <ul class="space-y-3">
                                        <?php foreach ($why_items as $item): ?>
                                            <li class="flex items-start gap-3 bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 shrink-0 mt-0.5">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                </span>
                                                <span class="text-sm text-gray-700 leading-relaxed"><?php echo esc_html($item); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if ($trek_map): ?>
                                <div class="mb-10">
                                    <h3 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                                        <i class="fa-solid fa-map text-emerald-600"></i> <?php _e('Trek Route Map', 'ghodaghodi-view'); ?>
                                    </h3>
                                    <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                                        <img src="<?php echo esc_url($trek_map); ?>" alt="<?php echo esc_attr(sprintf(__('Route map for %s', 'ghodaghodi-view'), get_the_title())); ?>" class="w-full h-auto" loading="lazy" />
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($has_itinerary): ?>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                        <i class="fa-solid fa-route text-emerald-600"></i> <?php _e('Trek Itinerary', 'ghodaghodi-view'); ?>
                                    </h3>
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
                                                    <h4 class="font-bold text-gray-900"><?php echo esc_html($day_title); ?></h4>
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
                                                    <p class="text-sm text-gray-600 leading-relaxed"><?php echo esc_html($day_notes); ?></p>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ol>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($has_sidebar): ?>
                        <aside class="<?php echo $has_left ? 'space-y-6' : 'lg:col-span-3 md:grid md:grid-cols-3 md:gap-6 md:space-y-0'; ?>">
                            <?php if ($has_highlights): ?>
                                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                        <i class="fa-solid fa-images text-emerald-600"></i> <?php _e('Highlights Gallery', 'ghodaghodi-view'); ?>
                                    </h3>
                                    <div class="space-y-4">
                                        <?php foreach ($highlights as $item): ?>
                                            <?php if (empty($item['image'])) continue; ?>
                                            <figure>
                                                <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr(isset($item['caption']) ? $item['caption'] : ''); ?>" class="w-full h-40 object-cover rounded-xl" loading="lazy" />
                                                <?php if (!empty($item['caption'])): ?>
                                                    <figcaption class="text-xs text-gray-500 mt-1.5"><?php echo esc_html($item['caption']); ?></figcaption>
                                                <?php endif; ?>
                                            </figure>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($has_facts): ?>
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
                                                <span class="ml-auto flex items-center gap-0.5" title="<?php echo esc_attr(sprintf(__('Difficulty: %1$d / 5', 'ghodaghodi-view'), $difficulty)); ?>">
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

                            <?php if ($permits): ?>
                                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                    <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-ticket text-emerald-600"></i> <?php _e('Permits & Fees', 'ghodaghodi-view'); ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"><?php echo esc_html($permits); ?></p>
                                </div>
                            <?php endif; ?>

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

                            <?php if ($tip_items): ?>
                                <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6">
                                    <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-lightbulb text-amber-500"></i> <?php _e('Tips for Trekkers', 'ghodaghodi-view'); ?>
                                    </h3>
                                    <ul class="space-y-2">
                                        <?php foreach ($tip_items as $tip): ?>
                                            <li class="flex items-start gap-2 text-sm text-gray-700">
                                                <i class="fa-solid fa-circle-info text-amber-500 mt-0.5"></i> <span><?php echo esc_html($tip); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </aside>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
            <?php endif; ?>

            <?php
            $share_url   = rawurlencode(get_permalink());
            $share_title = rawurlencode(get_the_title());
            ?>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
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
            </div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
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
            </div>

            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
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
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-route text-emerald-600"></i> <?php _e('You May Also Like', 'ghodaghodi-view'); ?>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
