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

        $status_label = __('खुला छ', 'ghodaghodi-view');
        $status_icon  = 'fa-circle-check text-green-500';
        if ('closed' === $h_status) {
            $status_label = __('बन्द छ', 'ghodaghodi-view');
            $status_icon  = 'fa-circle-xmark text-red-500';
        } elseif ('temporarily_closed' === $h_status) {
            $status_label = __('अस्थायी रूपमा बन्द', 'ghodaghodi-view');
            $status_icon  = 'fa-clock text-amber-500';
        }
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden'); ?>>

            <?php if (has_post_thumbnail()): ?>
                <div class="h-64 md:h-96 overflow-hidden">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); ?>
                </div>
            <?php endif; ?>

            <div class="p-6 md:p-10">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8"><?php the_title(); ?></h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-2xl p-6" style="min-height:110px">
                        <div class="w-12 flex-shrink-0 flex items-center justify-center">
                            <i class="fa-solid fa-building text-amber-500" style="font-size:28px"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium" style="color:#6B7280"><?php _e('प्रकार', 'ghodaghodi-view'); ?></span>
                            <span class="text-[28px] font-bold mt-1" style="color:#0F172A"><?php echo esc_html($h_type ?: '—'); ?></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-2xl p-6" style="min-height:110px">
                        <div class="w-12 flex-shrink-0 flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-emerald-600" style="font-size:28px"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium" style="color:#6B7280"><?php _e('स्थान', 'ghodaghodi-view'); ?></span>
                            <span class="text-[28px] font-bold mt-1" style="color:#0F172A"><?php echo esc_html($h_location ?: '—'); ?></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-2xl p-6" style="min-height:110px">
                        <div class="w-12 flex-shrink-0 flex items-center justify-center">
                            <i class="fa-solid fa-bed text-blue-600" style="font-size:28px"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium" style="color:#6B7280"><?php _e('बेड क्षमता', 'ghodaghodi-view'); ?></span>
                            <span class="text-[28px] font-bold mt-1" style="color:#0F172A"><?php echo esc_html($h_beds ?: '—'); ?></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-2xl p-6" style="min-height:110px">
                        <div class="w-12 flex-shrink-0 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-purple-600" style="font-size:28px"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium" style="color:#6B7280"><?php _e('सम्पर्क', 'ghodaghodi-view'); ?></span>
                            <span class="text-[28px] font-bold mt-1" style="color:#0F172A"><?php echo esc_html($h_contact ?: '—'); ?></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-2xl p-6 md:col-span-2" style="min-height:110px">
                        <div class="w-12 flex-shrink-0 flex items-center justify-center">
                            <i class="fa-solid <?php echo $status_icon; ?>" style="font-size:28px"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-medium" style="color:#6B7280"><?php _e('स्थिति', 'ghodaghodi-view'); ?></span>
                            <span class="text-[28px] font-bold mt-1" style="color:#0F172A"><?php echo $status_label; ?></span>
                        </div>
                    </div>
                </div>

                <?php if (trim(get_the_content())): ?>
                    <div class="prose prose-gray max-w-none leading-relaxed text-gray-700">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>