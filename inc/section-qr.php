<section id="qr-section" class="bg-gradient-to-r hover:from-emerald-900 hover:to-teal-950 from-emerald-950 to-emerald-900 text-white p-8 md:p-12 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
    <div class="max-w-xl text-center md:text-left">
        <h2 class="text-2xl font-bold text-amber-400 mb-2"><?php _e('स्मार्ट क्युआर गाइड प्रणाली', 'ghodaghodi-view'); ?></h2>
        <p class="text-sm opacity-90 leading-relaxed">
            <?php _e('Kobo Server मार्फत संकलन भएको डाटालाई प्रत्येक पर्यटकीय क्षेत्रमा क्युआर कोडको रूपमा राखिनेछ। पर्यटकले आफ्नो मोबाइलबाट स्क्यान गर्नासाथ सम्बन्धित स्थानको इतिहास, विशेषता, नक्सा र अडियो गाइड ३२ वटा भाषामा प्राप्त गर्न सक्नेछन्।', 'ghodaghodi-view'); ?>
        </p>
    </div>
    <div class="bg-white p-4 rounded-xl shadow-inner flex flex-col items-center shrink-0">
        <div class="w-32 h-32 bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200 overflow-hidden p-1">
            <div class="qr-code-wrapper flex items-center justify-center w-full h-full">
                <?php
                // Using Kaya QR Code Generator shortcode format
                echo do_shortcode('[kaya_qrcode content="Example string" size="120" eclevel="L"]');
                ?>
            </div>
        </div>
        <span class="text-[10px] text-gray-500 font-bold mt-2 tracking-wide uppercase"><?php _e('Scan to Test Profile', 'ghodaghodi-view'); ?></span>
    </div>
</section>