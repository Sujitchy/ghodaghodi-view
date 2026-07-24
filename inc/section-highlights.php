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