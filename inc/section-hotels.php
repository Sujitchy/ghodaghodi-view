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