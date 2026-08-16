<?php get_header(); ?>

<main class="container mx-auto px-4 py-12">
    <header class="mb-10 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-emerald-950">
            <?php _e('होटल तथा होमस्टे सूची', 'ghodaghodi-view'); ?>
        </h1>
        <p class="text-gray-500 mt-2 max-w-2xl mx-auto">
            <?php _e('घोडाघोडी नगरपालिकामा रहेका आवासहरूको विवरण', 'ghodaghodi-view'); ?>
        </p>
    </header>

    <?php
    $hotel_terms = get_terms([
        'taxonomy'   => 'ghodaghodi_hotel_cat',
        'hide_empty' => true,
    ]);
    if (!is_wp_error($hotel_terms) && !empty($hotel_terms)):
    ?>
    <div class="gh-filter-bar mb-6" data-target="#gh-hotel-archive-grid > article" data-empty-msg="gh-hotel-archive-empty">
        <button type="button" class="gh-filter-chip active" data-filter="all"><?php _e('सबै', 'ghodaghodi-view'); ?></button>
        <?php foreach ($hotel_terms as $hotel_term): ?>
        <button type="button" class="gh-filter-chip" data-filter="<?php echo esc_attr($hotel_term->slug); ?>"><?php echo esc_html($hotel_term->name); ?></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (have_posts()): ?>
    <div id="gh-hotel-archive-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        while (have_posts()):
            the_post();
            $h_cat_terms = wp_get_post_terms(get_the_ID(), 'ghodaghodi_hotel_cat');
            $h_cat_slugs = !empty($h_cat_terms) && !is_wp_error($h_cat_terms) ? wp_list_pluck($h_cat_terms, 'slug') : [];
            $h_type     = get_post_meta(get_the_ID(), '_hotel_type', true);
            $h_location = get_post_meta(get_the_ID(), '_hotel_location', true);
            $h_beds     = get_post_meta(get_the_ID(), '_hotel_beds', true);
            $h_status   = get_post_meta(get_the_ID(), '_hotel_status', true);
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition'); ?> data-category="<?php echo esc_attr(implode(' ', $h_cat_slugs)); ?>">
            <div class="h-48 bg-gray-200 relative overflow-hidden">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); ?>
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-building text-4xl"></i>
                        </div>
                    <?php endif; ?>
                </a>
                <?php if ($h_type): ?>
                <span class="absolute top-3 left-3 bg-emerald-900 bg-opacity-30 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                    <?php echo esc_html($h_type); ?>
                </span>
                <?php endif; ?>
                <?php if ($h_status): ?>
                <span class="absolute top-3 right-3 text-xs px-3 py-1 rounded-full font-bold <?php echo 'closed' === $h_status ? 'bg-red-500 text-white' : 'bg-green-500 text-white'; ?>">
                    <?php echo 'closed' === $h_status ? __('बन्द छ', 'ghodaghodi-view') : __('खुला छ', 'ghodaghodi-view'); ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="p-5">
                <h3 class="text-lg font-bold text-gray-900 mb-3">
                    <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700 transition"><?php the_title(); ?></a>
                </h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <?php if ($h_location): ?>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-emerald-600 text-xs"></i>
                        <span><?php echo esc_html($h_location); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($h_beds): ?>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bed text-blue-600 text-xs"></i>
                        <span><?php echo esc_html($h_beds); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-400 flex justify-between">
                    <span><?php echo get_the_date(); ?></span>
                    <a href="<?php the_permalink(); ?>" class="text-emerald-700 font-semibold hover:text-amber-600 transition"><?php _e('विवरण हेर्नुहोस्', 'ghodaghodi-view'); ?> &rarr;</a>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
    </div>

    <div id="gh-hotel-archive-empty" class="gh-hidden text-center py-12 text-gray-500">
        <i class="fa-solid fa-building text-4xl mb-4 block text-gray-300"></i>
        <p><?php _e('यस श्रेणीमा होटल वा होमस्टे उपलब्ध छैनन्।', 'ghodaghodi-view'); ?></p>
    </div>

    <div class="mt-10">
        <?php
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
            'class'     => 'flex justify-center gap-2',
        ]);
        ?>
    </div>
    <?php else: ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
