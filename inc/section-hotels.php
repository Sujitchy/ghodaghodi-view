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
            <table class="w-full text-left border-collapse text-sm gh-hotel-table">
                <thead>
                    <tr class="bg-emerald-900 text-white text-xs font-semibold uppercase">
                        <th class="gh-col-name"><?php _e('आवासको नाम', 'ghodaghodi-view'); ?></th>
                        <th class="gh-col-type"><?php _e('प्रकार', 'ghodaghodi-view'); ?></th>
                        <th class="gh-col-location"><?php _e('स्थान', 'ghodaghodi-view'); ?></th>
                        <th class="gh-col-beds"><?php _e('बेड क्षमता', 'ghodaghodi-view'); ?></th>
                        <th class="gh-col-contact"><?php _e('सम्पर्क / स्थिति', 'ghodaghodi-view'); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $hotels = new WP_Query([
                        'post_type'      => 'ghodaghodi_hotel',
                        'posts_per_page' => -1,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                    ]);

                    if ($hotels->have_posts()):
                        while ($hotels->have_posts()): $hotels->the_post();
                            $h_type     = get_post_meta(get_the_ID(), '_hotel_type', true) ?: __('होमस्टे', 'ghodaghodi-view');
                            $h_location = get_post_meta(get_the_ID(), '_hotel_location', true);
                            $h_beds     = get_post_meta(get_the_ID(), '_hotel_beds', true);
                            $h_status   = get_post_meta(get_the_ID(), '_hotel_status', true);
                            $h_contact  = get_post_meta(get_the_ID(), '_hotel_contact', true);
                            $type_color = 'text-purple-700';
                            if (stripos($h_type, 'रिसोर्ट') !== false) {
                                $type_color = 'text-emerald-700';
                            }

                            $status_label = __('खुला छ', 'ghodaghodi-view');
                            $badge_class  = 'gh-badge-open';
                            if ('closed' === $h_status) {
                                $status_label = __('बन्द छ', 'ghodaghodi-view');
                                $badge_class  = 'gh-badge-closed';
                            } elseif ('temporarily_closed' === $h_status) {
                                $status_label = __('अस्थायी रूपमा बन्द', 'ghodaghodi-view');
                                $badge_class  = 'gh-badge-temp-closed';
                            }
                    ?>
                            <tr class="hover:bg-gray-50">
                                <td class="gh-cell-name">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-emerald-700 transition font-bold text-gray-900"><?php the_title(); ?></a>
                                </td>
                                <td class="gh-cell-type <?php echo $type_color; ?> font-semibold"><?php echo esc_html($h_type); ?></td>
                                <td class="gh-cell-location text-gray-600"><?php echo esc_html($h_location ?: '—'); ?></td>
                                <td class="gh-cell-beds font-semibold"><?php echo esc_html($h_beds ?: '—'); ?></td>
                                <td class="gh-cell-contact">
                                    <div class="gh-contact-stack">
                                        <?php if ($h_contact): ?>
                                        <span class="gh-phone"><i class="fa-solid fa-phone"></i> <?php echo esc_html($h_contact); ?></span>
                                        <?php endif; ?>
                                        <span class="gh-badge <?php echo $badge_class; ?>"><?php echo $status_label; ?></span>
                                    </div>
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

<style>
.gh-hotel-table { table-layout: fixed; }
.gh-hotel-table th,
.gh-hotel-table td { padding: 14px 16px; vertical-align: middle; }

.gh-col-name,
.gh-cell-name { width: 34%; }
.gh-col-type,
.gh-cell-type { width: 16%; }
.gh-col-location,
.gh-cell-location { width: 12%; }
.gh-col-beds,
.gh-cell-beds { width: 14%; }
.gh-col-contact,
.gh-cell-contact { width: 24%; }

.gh-cell-name { white-space: normal; word-break: break-word; }

.gh-contact-stack {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: flex-start;
    justify-content: center;
    min-height: 100%;
}

.gh-phone {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.4;
}

.gh-phone i { margin-right: 4px; }

.gh-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.2;
    white-space: nowrap;
}

.gh-badge-open {
    background-color: #DCFCE7;
    color: #15803D;
}

.gh-badge-closed {
    background-color: #FEE2E2;
    color: #B91C1C;
}

.gh-badge-temp-closed {
    background-color: #FEF3C7;
    color: #B45309;
}

@media (max-width: 768px) {
    .gh-hotel-table th,
    .gh-hotel-table td { padding: 10px 8px; font-size: 12px; }
    .gh-col-name,
    .gh-cell-name { width: 30%; }
    .gh-col-contact,
    .gh-cell-contact { width: 28%; }
    .gh-contact-stack { gap: 6px; }
    .gh-badge { font-size: 11px; padding: 4px 10px; }
    .gh-phone { font-size: 11px; }
}
</style>