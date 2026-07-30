<section id="gallery" class="mb-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-emerald-950 flex items-center gap-2">
                <i class="fa-solid fa-images text-amber-500"></i>
                <?php _e('फोटो ग्यालरी', 'ghodaghodi-view'); ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1"><?php _e('घोडाघोडी क्षेत्रका सुन्दर दृश्यहरू', 'ghodaghodi-view'); ?></p>
        </div>
    </div>

    <div class="envira-gallery-wrapper">
        <?php echo do_shortcode('[envira-gallery id="34"]'); ?>
        <?php echo do_shortcode('[envira-gallery id="37"]'); ?>
    </div>

</section>