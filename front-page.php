<?php get_header(); ?>

<section class="relative bg-emerald-950 text-white py-20 px-4 text-center">
    <div class="absolute inset-0 opacity-20 bg-cover bg-center"
         style="background-image: url('<?php echo esc_url(get_theme_mod('ghodaghodi_hero_bg', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80')); ?>');">
    </div>
    <div class="relative container mx-auto max-w-3xl">
        <span class="bg-amber-500 text-emerald-950 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
            <?php _e('विश्व रामसार क्षेत्र', 'ghodaghodi-view'); ?>
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold mt-4 mb-6 leading-tight text-amber-400">
            <?php _e('संरक्षण सहितको पर्या-पर्यटन र संस्कृति', 'ghodaghodi-view'); ?>
        </h1>
        <p class="text-base md:text-lg text-emerald-100 opacity-90 leading-relaxed">
            <?php _e('घोडाघोडी नगरपालिकाका प्राकृतिक तालतलैया, दुर्लभ जैविक विविधता, र मौलिक थारु संस्कृतिको आधिकारिक डिजिटल प्रोफाइल पोर्टल।', 'ghodaghodi-view'); ?>
        </p>
    </div>
</section>

<section id="dashboard" class="container mx-auto px-4 -mt-8 relative z-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php
        $stats = [
            ['icon' => 'fa-map-location-dot', 'color' => 'border-emerald-600', 'icon_color' => 'text-emerald-600', 'number' => get_theme_mod('ghodaghodi_stat_sites', '२४+'), 'label' => __('कुल पर्यटकीय क्षेत्र', 'ghodaghodi-view')],
            ['icon' => 'fa-hotel', 'color' => 'border-amber-500', 'icon_color' => 'text-amber-500', 'number' => get_theme_mod('ghodaghodi_stat_hotels', '१५+'), 'label' => __('दर्ता भएका होमस्टे/होटल', 'ghodaghodi-view')],
            ['icon' => 'fa-dove', 'color' => 'border-blue-500', 'icon_color' => 'text-blue-500', 'number' => get_theme_mod('ghodaghodi_stat_birds', '२९०+'), 'label' => __('चराका प्रजातिहरू', 'ghodaghodi-view')],
            ['icon' => 'fa-users', 'color' => 'border-purple-500', 'icon_color' => 'text-purple-500', 'number' => get_theme_mod('ghodaghodi_stat_tourists', '५०K+'), 'label' => __('वार्षिक पर्यटक (अनुमानित)', 'ghodaghodi-view')],
        ];
        foreach ($stats as $stat):
        ?>
        <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 <?php echo $stat['color']; ?> text-center">
            <i class="fa-solid <?php echo $stat['icon']; ?> text-3xl <?php echo $stat['icon_color']; ?> mb-2"></i>
            <h3 class="text-2xl font-bold text-gray-900"><?php echo esc_html($stat['number']); ?></h3>
            <p class="text-xs text-gray-500 font-semibold uppercase"><?php echo esc_html($stat['label']); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<main class="container mx-auto px-4 py-12">

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
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                        <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 25); ?>
                    </p>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-100 text-xs text-gray-500">
                        <span><i class="fa-regular fa-clock"></i> <?php echo $best_time ? esc_html($best_time) : __('बाह्रै महिना', 'ghodaghodi-view'); ?></span>
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

    <section id="hotels" class="mb-16">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-emerald-950 flex items-center gap-2">
                <i class="fa-solid fa-bed text-amber-500"></i>
                <?php _e('होटल तथा होमस्टे सूची', 'ghodaghodi-view'); ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1"><?php _e('स्थलगत प्राविधिकहरूबाट प्रमाणित आवासहरूको विवरण', 'ghodaghodi-view'); ?></p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-emerald-900 text-white text-xs font-semibold uppercase">
                            <th class="p-4"><?php _e('आवासको नाम', 'ghodaghodi-view'); ?></th>
                            <th class="p-4"><?php _e('प्रकार', 'ghodaghodi-view'); ?></th>
                            <th class="p-4"><?php _e('स्थान/वडा', 'ghodaghodi-view'); ?></th>
                            <th class="p-4"><?php _e('बेड क्षमता', 'ghodaghodi-view'); ?></th>
                            <th class="p-4"><?php _e('सम्पर्क / स्थिति', 'ghodaghodi-view'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        $hotels = new WP_Query([
                            'post_type'      => 'post',
                            'posts_per_page' => -1,
                            'category_name'  => 'hotels',
                            'orderby'        => 'menu_order',
                            'order'          => 'ASC',
                        ]);

                        if ($hotels->have_posts()):
                            while ($hotels->have_posts()): $hotels->the_post();
                                $h_type     = get_post_meta(get_the_ID(), '_hotel_type', true) ?: __('होमस्टे', 'ghodaghodi-view');
                                $h_location = get_post_meta(get_the_ID(), '_hotel_location', true);
                                $h_beds     = get_post_meta(get_the_ID(), '_hotel_beds', true);
                                $h_status   = get_post_meta(get_the_ID(), '_hotel_status', true);
                                $type_color = 'text-purple-700';
                                if (stripos($h_type, 'रिसोर्ट') !== false) {
                                    $type_color = 'text-emerald-700';
                                }
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-bold text-gray-900"><?php the_title(); ?></td>
                            <td class="p-4 <?php echo $type_color; ?> font-semibold"><?php echo esc_html($h_type); ?></td>
                            <td class="p-4 text-gray-600"><?php echo esc_html($h_location ?: '—'); ?></td>
                            <td class="p-4 font-semibold"><?php echo esc_html($h_beds ?: '—'); ?></td>
                            <td class="p-4">
                                <?php if ('closed' === $h_status): ?>
                                <span class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded-full font-bold"><?php _e('बन्द छ', 'ghodaghodi-view'); ?></span>
                                <?php else: ?>
                                <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded-full font-bold"><?php _e('खुला छ', 'ghodaghodi-view'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                        ?>
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                <?php _e('होटल वा होमस्टे सूची उपलब्ध छैन।', 'ghodaghodi-view'); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section id="qr-section" class="bg-gradient-to-r hover:from-emerald-900 hover:to-teal-950 from-emerald-950 to-emerald-900 text-white p-8 md:p-12 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="max-w-xl text-center md:text-left">
            <h2 class="text-2xl font-bold text-amber-400 mb-2"><?php _e('स्मार्ट क्युआर गाइड प्रणाली', 'ghodaghodi-view'); ?></h2>
            <p class="text-sm opacity-90 leading-relaxed">
                <?php _e('Kobo Server मार्फत संकलन भएको डाटालाई प्रत्येक पर्यटकीय क्षेत्रमा क्युआर कोडको रूपमा राखिनेछ। पर्यटकले आफ्नो मोबाइलबाट स्क्यान गर्नासाथ सम्बन्धित स्थानको इतिहास, विशेषता, नक्सा र अडियो गाइड ३२ वटा भाषामा प्राप्त गर्न सक्नेछन्।', 'ghodaghodi-view'); ?>
            </p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-inner flex flex-col items-center shrink-0">
            <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                <i class="fa-solid fa-qrcode text-6xl text-emerald-950"></i>
            </div>
            <span class="text-[10px] text-gray-500 font-bold mt-2 tracking-wide uppercase"><?php _e('Scan to Test Profile', 'ghodaghodi-view'); ?></span>
        </div>
    </section>

</main>

<?php get_footer(); ?>
