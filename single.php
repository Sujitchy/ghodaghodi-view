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
            $duration   = get_post_meta(get_the_ID(), '_destination_trek_duration', true);
            $elevation  = get_post_meta(get_the_ID(), '_destination_trek_max_elevation', true);
            $difficulty = (int) get_post_meta(get_the_ID(), '_destination_trek_difficulty', true);
            $permits    = get_post_meta(get_the_ID(), '_destination_trek_permits', true);
            $itinerary  = json_decode(get_post_meta(get_the_ID(), '_destination_trek_itinerary', true), true);
            $pack       = get_post_meta(get_the_ID(), '_destination_what_to_pack', true);
            $tips       = get_post_meta(get_the_ID(), '_destination_trek_tips', true);

            $itinerary  = is_array($itinerary) ? $itinerary : [];
            $pack_items = $pack ? array_values(array_filter(array_map('trim', explode(',', $pack)))) : [];
            $tip_items  = $tips ? array_values(array_filter(array_map('trim', explode(',', $tips)))) : [];

            $difficulty_labels = [
                1 => __('Easy', 'ghodaghodi-view'),
                2 => __('Moderate', 'ghodaghodi-view'),
                3 => __('Challenging', 'ghodaghodi-view'),
                4 => __('Difficult', 'ghodaghodi-view'),
                5 => __('Extreme', 'ghodaghodi-view'),
            ];

            $has_itinerary = !empty($itinerary);
            $has_sidebar   = $difficulty || $permits || $pack_items || $tip_items;

            if ($has_itinerary || $has_sidebar):
            ?>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
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
                        <?php if ($has_itinerary): ?>
                        <div class="lg:col-span-2">
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

                        <?php if ($has_sidebar): ?>
                        <aside class="<?php echo $has_itinerary ? 'space-y-6' : 'lg:col-span-3 md:grid md:grid-cols-3 md:gap-6 md:space-y-0'; ?>">
                            <?php if ($difficulty): ?>
                                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                    <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <i class="fa-solid fa-signal text-amber-500"></i> <?php _e('Difficulty Level', 'ghodaghodi-view'); ?>
                                    </h3>
                                    <div class="flex items-center gap-1 text-lg mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="<?php echo $i <= $difficulty ? 'fa-solid fa-star text-amber-400' : 'fa-regular fa-star text-gray-300'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <?php echo isset($difficulty_labels[$difficulty]) ? esc_html($difficulty_labels[$difficulty]) : ''; ?>
                                        <span class="text-gray-400">(<?php echo esc_html($difficulty); ?> / 5)</span>
                                    </p>
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
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>