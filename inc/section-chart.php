<section id="bird-species" class="mb-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-emerald-950 flex items-center gap-2">
                <i class="fa-solid fa-dove text-amber-500"></i>
                <?php _e('चराका प्रजातिहरू', 'ghodaghodi-view'); ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1"><?php _e('वर्षभरि सर्वेक्षणमा देखिएका चरा प्रजातिहरूको मासिक सङ्ख्या (नमूना तथ्याङ्क)', 'ghodaghodi-view'); ?></p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="relative w-full h-72 md:h-96">
            <canvas id="ghodaghodi-bird-chart" role="img" aria-label="<?php echo esc_attr(__('चरा प्रजाति सर्वेक्षण लाइन चार्ट', 'ghodaghodi-view')); ?>"></canvas>
        </div>
        <p class="text-xs text-gray-400 mt-4 leading-relaxed">
            <i class="fa-solid fa-circle-info text-amber-500 mr-1"></i>
            <?php _e('घोडाघोडी सिमसार क्षेत्रमा अहिलेसम्म २९०+ चरा प्रजातिहरू पाइएका छन्। देखाइएका मूल्यहरू उदाहरणका लागि मात्र हुन्।', 'ghodaghodi-view'); ?>
        </p>
    </div>
</section>