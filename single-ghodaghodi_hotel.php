<?php get_header(); ?>

<main>
    <?php
    while (have_posts()):
        the_post();

        $h_id       = get_the_ID();
        $h_type     = get_post_meta($h_id, '_hotel_type', true);
        $h_location = get_post_meta($h_id, '_hotel_location', true);
        $h_beds     = get_post_meta($h_id, '_hotel_beds', true);
        $h_status   = get_post_meta($h_id, '_hotel_status', true);
        $h_contact  = get_post_meta($h_id, '_hotel_contact', true);

        // Status label, icon and pill colours (mirrors admin meta box colours).
        $status_label   = __('खुला छ', 'ghodaghodi-view');
        $status_icon    = 'fa-solid fa-circle-check';
        $status_pill_bg = 'bg-green-100';
        $status_pill_tx = 'text-green-700';
        if ('closed' === $h_status) {
            $status_label   = __('बन्द छ', 'ghodaghodi-view');
            $status_icon    = 'fa-solid fa-circle-xmark';
            $status_pill_bg = 'bg-red-100';
            $status_pill_tx = 'text-red-700';
        } elseif ('temporarily_closed' === $h_status) {
            $status_label   = __('अस्थायी रूपमा बन्द', 'ghodaghodi-view');
            $status_icon    = 'fa-solid fa-clock';
            $status_pill_bg = 'bg-amber-100';
            $status_pill_tx = 'text-amber-700';
        }

        // Hotel categories (ghodaghodi_hotel_cat taxonomy).
        $h_cat_terms = wp_get_post_terms($h_id, 'ghodaghodi_hotel_cat');

        // Safe tel: and map links built from existing meta values only.
        $h_tel      = $h_contact ? preg_replace('/[^\d+]/', '', $h_contact) : '';
        $h_maps_url = $h_location ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($h_location) : '';

        $has_facts = ($h_type || $h_location || $h_beds || $h_status);
        ?>

        <?php get_template_part('template-parts/featured-hero'); ?>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12">

            <?php // Breadcrumb / back link bar ?>
            <nav class="mb-6 flex flex-wrap items-center justify-between gap-3" aria-label="<?php esc_attr_e('ब्रेडक्रम्ब', 'ghodaghodi-view'); ?>">
                <a href="<?php echo esc_url(get_post_type_archive_link('ghodaghodi_hotel')); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 hover:text-amber-600 transition">
                    <i class="fa-solid fa-arrow-left"></i> <?php _e('सबै होटल तथा होमस्टे', 'ghodaghodi-view'); ?>
                </a>
                <span class="inline-flex items-center gap-1.5 <?php echo esc_attr($status_pill_bg . ' ' . $status_pill_tx); ?> text-xs font-bold px-3 py-1.5 rounded-full">
                    <i class="<?php echo esc_attr($status_icon); ?>"></i> <?php echo esc_html($status_label); ?>
                </span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <?php // === Main column === ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('lg:col-span-8 min-w-0 space-y-6'); ?>>

                    <?php // Title + categories ?>
                    <header class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-4"><?php the_title(); ?></h1>

                        <div class="flex flex-wrap items-center gap-2">
                            <?php if ($h_type): ?>
                                <span class="inline-flex items-center gap-1.5 bg-emerald-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                                    <i class="fa-solid fa-building"></i> <?php echo esc_html($h_type); ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($h_cat_terms) && !is_wp_error($h_cat_terms)): ?>
                                <?php foreach ($h_cat_terms as $h_cat_term): ?>
                                    <a href="<?php echo esc_url(get_term_link($h_cat_term)); ?>" class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-amber-100 transition">
                                        <i class="fa-solid fa-tag"></i> <?php echo esc_html($h_cat_term->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </header>

                    <?php // Description / content ?>
                    <?php if (trim(get_the_content())): ?>
                        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                            <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-900 mb-4">
                                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                                <?php _e('परिचय', 'ghodaghodi-view'); ?>
                            </h2>
                            <div class="prose-ghodaghodi">
                                <?php the_content(); ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php // Highlight Images (media attached to this hotel, excluding the featured image) ?>
                    <?php
                    $h_highlights = get_attached_media('image', $h_id);
                    unset($h_highlights[get_post_thumbnail_id($h_id)]);
                    $h_highlights = array_values($h_highlights);
                    ?>
                    <?php if (!empty($h_highlights)): ?>
                        <section class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                            <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-900 mb-5">
                                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                                <i class="fa-solid fa-images text-emerald-600"></i> <?php _e('हाइलाइट तस्बिरहरू', 'ghodaghodi-view'); ?>
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <?php foreach ($h_highlights as $h_image): ?>
                                    <?php
                                    $h_full     = wp_get_attachment_image_url($h_image->ID, 'full');
                                    $h_alt      = get_post_meta($h_image->ID, '_wp_attachment_image_alt', true);
                                    $h_caption  = wp_get_attachment_caption($h_image->ID);
                                    $h_img_name = $h_alt ? $h_alt : $h_image->post_title;
                                    if (!$h_full) {
                                        continue;
                                    }
                                    ?>
                                    <figure class="min-w-0">
                                        <button type="button" data-ghodaghodi-lightbox="<?php echo esc_url($h_full); ?>" class="group relative w-full block overflow-hidden rounded-xl border border-gray-100 focus:outline-none" aria-label="<?php echo esc_attr(sprintf(__('ठूलो गरेर हेर्नुहोस्: %s', 'ghodaghodi-view'), $h_img_name)); ?>">
                                            <?php echo wp_get_attachment_image($h_image->ID, 'medium_large', false, [
                                                'class'   => 'w-full h-48 object-cover transition duration-300 group-hover:scale-[1.02]',
                                                'alt'     => $h_img_name,
                                                'loading' => 'lazy',
                                            ]); ?>
                                            <span class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/40 transition pointer-events-none">
                                                <span class="inline-flex items-center gap-2 bg-white text-gray-900 text-sm font-semibold px-4 py-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition">
                                                    <i class="fa-solid fa-magnifying-glass-plus"></i> <?php _e('ठूलो गरेर हेर्नुहोस्', 'ghodaghodi-view'); ?>
                                                </span>
                                            </span>
                                        </button>
                                        <?php if ($h_caption): ?>
                                            <figcaption class="text-xs text-gray-500 mt-1.5 px-1"><?php echo esc_html($h_caption); ?></figcaption>
                                        <?php endif; ?>
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php // === Social Share (reused from destination single) === ?>
                    <?php
                    $share_url   = rawurlencode(get_permalink());
                    $share_title = rawurlencode(get_the_title());
                    ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <span class="font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-emerald-600"></i> <?php _e('यो आवास सेयर गर्नुहोस्', 'ghodaghodi-view'); ?>
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
                </article>

                <?php // === Sidebar (Right, Sticky) === ?>
                <aside class="lg:col-span-4 min-w-0" aria-label="<?php esc_attr_e('आवास विवरण', 'ghodaghodi-view'); ?>">
                    <div class="lg:sticky lg:top-24 space-y-6">

                        <?php // Hotel Facts (Trek Facts pattern) ?>
                        <?php if ($has_facts): ?>
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                                <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-info text-emerald-600"></i> <?php _e('आवास विवरण', 'ghodaghodi-view'); ?>
                                </h2>
                                <ul class="space-y-3 text-sm">
                                    <?php if ($h_type): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-building"></i></span>
                                            <span class="text-gray-500"><?php _e('प्रकार', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto font-semibold text-gray-900 text-right"><?php echo esc_html($h_type); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($h_location): ?>
                                        <li class="flex items-start gap-3">
                                            <span class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-location-dot"></i></span>
                                            <span class="text-gray-500 pt-1"><?php _e('स्थान', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto text-right pt-0.5">
                                                <span class="block font-semibold text-gray-900 leading-relaxed"><?php echo esc_html($h_location); ?></span>
                                                <a href="<?php echo esc_url($h_maps_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 hover:text-amber-600 transition mt-0.5">
                                                    <i class="fa-solid fa-map-location-dot"></i> <?php _e('नक्सामा हेर्नुहोस्', 'ghodaghodi-view'); ?>
                                                </a>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($h_beds): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-bed"></i></span>
                                            <span class="text-gray-500"><?php _e('बेड क्षमता', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto font-semibold text-gray-900 text-right"><?php echo esc_html($h_beds); ?></span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($h_status): ?>
                                        <li class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center shrink-0"><i class="<?php echo esc_attr($status_icon); ?>"></i></span>
                                            <span class="text-gray-500"><?php _e('स्थिति', 'ghodaghodi-view'); ?></span>
                                            <span class="ml-auto">
                                                <span class="inline-flex items-center gap-1.5 <?php echo esc_attr($status_pill_bg . ' ' . $status_pill_tx); ?> text-xs font-bold px-3 py-1 rounded-full">
                                                    <?php echo esc_html($status_label); ?>
                                                </span>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php // Contact & Booking (Permits & Fees card pattern) ?>
                        <?php if ($h_contact || $h_maps_url): ?>
                            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-6">
                                <h2 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-phone-volume text-emerald-600"></i> <?php _e('सम्पर्क तथा बुकिङ', 'ghodaghodi-view'); ?>
                                </h2>
                                <?php if ($h_contact): ?>
                                    <p class="text-lg font-bold text-emerald-950 mb-1">
                                        <i class="fa-solid fa-phone text-emerald-600 mr-1"></i> <?php echo esc_html($h_contact); ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($h_maps_url): ?>
                                    <p class="text-sm text-emerald-950/80 leading-relaxed mb-4">
                                        <i class="fa-solid fa-location-dot text-emerald-600 mr-1"></i> <?php echo esc_html($h_location); ?>
                                    </p>
                                <?php endif; ?>
                                <div class="flex flex-col gap-2">
                                    <?php if ($h_tel): ?>
                                        <a href="tel:<?php echo esc_attr($h_tel); ?>" class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold px-6 py-3 rounded-lg transition">
                                            <i class="fa-solid fa-phone"></i> <?php _e('अहिले नै सम्पर्क गर्नुहोस्', 'ghodaghodi-view'); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($h_maps_url): ?>
                                        <a href="<?php echo esc_url($h_maps_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-emerald-800 font-semibold px-6 py-3 rounded-lg border border-emerald-200 transition">
                                            <i class="fa-solid fa-diamond-turn-right"></i> <?php _e('बाटो देखाउनुहोस्', 'ghodaghodi-view'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </aside>
            </div>
        </div>

        <?php // === Similar Hotels (related-post logic reused from destination single) === ?>
        <?php
        $related = new WP_Query([
            'post_type'      => 'ghodaghodi_hotel',
            'posts_per_page' => 3,
            'post__not_in'   => [$h_id],
            'orderby'        => 'rand',
        ]);

        if ($related->have_posts()):
        ?>
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16" aria-label="<?php esc_attr_e('यी पनि हेर्नुहोस्', 'ghodaghodi-view'); ?>">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span class="w-1.5 h-7 bg-emerald-600 rounded-full"></span>
                <i class="fa-solid fa-bed text-amber-500"></i> <?php _e('यी पनि हेर्नुहोस्', 'ghodaghodi-view'); ?>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php while ($related->have_posts()): $related->the_post(); ?>
                    <?php
                    $r_type   = get_post_meta(get_the_ID(), '_hotel_type', true);
                    $r_status = get_post_meta(get_the_ID(), '_hotel_status', true);
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('group bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition block'); ?>>
                        <div class="h-44 bg-gray-200 relative overflow-hidden">
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300', 'alt' => get_the_title()]); ?>
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-building text-4xl"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <?php if ($r_type): ?>
                            <span class="absolute top-3 left-3 bg-emerald-900 bg-opacity-30 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <?php echo esc_html($r_type); ?>
                            </span>
                            <?php endif; ?>
                            <?php if ($r_status): ?>
                            <span class="absolute top-3 right-3 text-xs px-3 py-1 rounded-full font-bold <?php echo 'closed' === $r_status ? 'bg-red-500 text-white' : 'bg-green-500 text-white'; ?>">
                                <?php echo 'closed' === $r_status ? esc_html__('बन्द छ', 'ghodaghodi-view') : esc_html__('खुला छ', 'ghodaghodi-view'); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="p-5">
                            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></p>
                            <h3 class="font-bold text-gray-900 group-hover:text-emerald-700 transition">
                                <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700 transition"><?php the_title(); ?></a>
                            </h3>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
