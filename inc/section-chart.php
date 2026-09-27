<section id="bird-species" class="mb-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-emerald-950 flex items-center gap-2 flex-wrap">
                <i class="fa-solid fa-dove text-amber-500"></i>
                <span lang="ne"><?php _e('चराका प्रजातिहरू', 'ghodaghodi-view'); ?></span>
                <span class="text-base font-semibold text-gray-400" role="presentation">/ Bird Species</span>
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                <span lang="ne"><?php _e('वर्षभरि सर्वेक्षणमा देखिएका चरा प्रजातिहरूको मासिक सङ्ख्या', 'ghodaghodi-view'); ?></span>
                <span class="text-gray-400" role="presentation">/ Monthly count of bird species recorded across the year</span>
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="ghodaghodi-chart-legend" id="ghodaghodi-chart-legend" role="group" aria-label="<?php esc_attr_e('Chart legend', 'ghodaghodi-view'); ?>"></div>

        <div class="relative w-full h-72 md:h-96">
            <canvas id="ghodaghodi-bird-chart" role="img" aria-label="<?php echo esc_attr(__('Bird species survey line chart', 'ghodaghodi-view')); ?>"></canvas>
            <div id="ghodaghodi-chart-tooltip" class="ghodaghodi-chart-tooltip" aria-hidden="true"></div>
        </div>

        <p class="text-xs text-gray-400 mt-4 leading-relaxed">
            <i class="fa-solid fa-circle-info text-amber-500 mr-1"></i>
            <span lang="ne"><?php _e('घोडाघोडी सिमसार क्षेत्रमा अहिलेसम्म २९०+ चरा प्रजातिहरू पाइएका छन्। तथ्याङ्क नमूना मात्र हुन्।', 'ghodaghodi-view'); ?></span>
            <span class="text-gray-300" role="presentation"> / Over 290+ bird species have been recorded in the Ghodaghodi wetland area. Sample data only.</span>
        </p>
    </div>
</section>