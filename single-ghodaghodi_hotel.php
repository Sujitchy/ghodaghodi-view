<?php get_header(); ?>

<main class="container mx-auto px-4 py-12 max-w-4xl">
    <?php
    while (have_posts()):
        the_post();
        $h_type     = get_post_meta(get_the_ID(), '_hotel_type', true);
        $h_location = get_post_meta(get_the_ID(), '_hotel_location', true);
        $h_beds     = get_post_meta(get_the_ID(), '_hotel_beds', true);
        $h_status   = get_post_meta(get_the_ID(), '_hotel_status', true);
        $h_contact  = get_post_meta(get_the_ID(), '_hotel_contact', true);
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden'); ?>>

            <?php if (has_post_thumbnail()): ?>
            <div class="h-64 md:h-96 overflow-hidden">
                <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); ?>
            </div>
            <?php endif; ?>

            <div class="p-6 md:p-10">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6"><?php the_title(); ?></h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <?php if ($h_type): ?>
                    <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg">
                        <i class="fa-solid fa-tag text-amber-500 text-xl"></i>
                        <div>
                            <span class="text-xs text-gray-500 font-semibold uppercase"><?php _e('प्रकार', 'ghodaghodi-view'); ?></span>
                            <p class="font-bold text-gray-900"><?php echo esc_html($h_type); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($h_location): ?>
                    <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg">
                        <i class="fa-solid fa-location-dot text-emerald-600 text-xl"></i>
                        <div>
                            <span class="text-xs text-gray-500 font-semibold uppercase"><?php _e('स्थान/वडा', 'ghodaghodi-view'); ?></span>
                            <p class="font-bold text-gray-900"><?php echo esc_html($h_location); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($h_beds): ?>
                    <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg">
                        <i class="fa-solid fa-bed text-blue-600 text-xl"></i>
                        <div>
                            <span class="text-xs text-gray-500 font-semibold uppercase"><?php _e('बेड क्षमता', 'ghodaghodi-view'); ?></span>
                            <p class="font-bold text-gray-900"><?php echo esc_html($h_beds); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($h_contact): ?>
                    <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg">
                        <i class="fa-solid fa-phone text-purple-600 text-xl"></i>
                        <div>
                            <span class="text-xs text-gray-500 font-semibold uppercase"><?php _e('सम्पर्क', 'ghodaghodi-view'); ?></span>
                            <p class="font-bold text-gray-900"><?php echo esc_html($h_contact); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($h_status): ?>
                <div class="mb-8">
                    <?php if ('closed' === $h_status): ?>
                        <span class="bg-red-100 text-red-800 text-sm px-4 py-2 rounded-full font-bold inline-flex items-center gap-2">
                            <i class="fa-solid fa-circle-xmark"></i> <?php _e('बन्द छ', 'ghodaghodi-view'); ?>
                        </span>
                    <?php else: ?>
                        <span class="bg-green-100 text-green-800 text-sm px-4 py-2 rounded-full font-bold inline-flex items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> <?php _e('खुला छ', 'ghodaghodi-view'); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="prose prose-gray max-w-none leading-relaxed text-gray-700">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>

        <div class="mt-8">
            <a href="<?php echo get_post_type_archive_link('ghodaghodi_hotel'); ?>" class="text-emerald-700 font-semibold hover:text-amber-600 transition">
                <i class="fa-solid fa-arrow-left"></i> <?php _e('सबै आवासहरूमा फर्कनुहोस्', 'ghodaghodi-view'); ?>
            </a>
        </div>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
