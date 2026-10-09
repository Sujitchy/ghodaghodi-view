<?php
get_header();

while (have_posts()) : the_post();
    // Get the current unique URL of this tourist spot post
    $current_url = get_permalink();

    // Get custom fields saved from Kobo
    $latitude  = get_post_meta(get_the_ID(), 'latitude', true);
    $longitude = get_post_meta(get_the_ID(), 'longitude', true);
    $kobo_id   = get_post_meta(get_the_ID(), 'kobo_submission_id', true);
?>

    <main class="container mx-auto px-4 py-10 max-w-5xl">
        <article class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 p-6 md:p-10">

            <header class="mb-6 border-b pb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-wider">
                        <?php _e('Smart QR Guide', 'ghodaghodi-view'); ?>
                    </span>
                    <h1 class="text-3xl font-extrabold text-emerald-950 mt-2"><?php the_title(); ?></h1>
                </div>

                <?php if ($kobo_id): ?>
                    <span class="text-xs text-gray-400 font-mono">Kobo ID: <?php echo esc_html($kobo_id); ?></span>
                <?php endif; ?>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

                <!-- Main Content (History & Features) -->
                <div class="md:col-span-2 prose max-w-none text-gray-700 leading-relaxed">
                    <?php the_content(); ?>
                </div>

                <!-- Dynamic QR Code Sidebar Card -->
                <aside class="bg-gradient-to-b from-emerald-50 to-teal-50 p-6 rounded-xl border border-emerald-200 shadow-sm flex flex-col items-center text-center">
                    <h3 class="text-sm font-bold text-emerald-950 mb-3"><?php _e('Scan This Spot', 'ghodaghodi-view'); ?></h3>

                    <div class="bg-white p-3 rounded-xl shadow-inner border border-gray-200">
                        <?php
                        // Dynamically generate the QR code pointing to this exact post URL using Kaya QR Code
                        echo do_shortcode('[kaya_qrcode content="' . esc_url($current_url) . '" size="140" eclevel="M"]');
                        ?>
                    </div>

                    <p class="text-[11px] text-gray-500 mt-3 leading-tight">
                        <?php _e('Scan with your mobile camera to view history, map & audio guide.', 'ghodaghodi-view'); ?>
                    </p>

                    <?php if ($latitude && $longitude): ?>
                        <a href="https://www.google.com/maps?q=<?php echo esc_attr($latitude); ?>,<?php echo esc_attr($longitude); ?>" target="_blank" class="mt-4 w-full bg-emerald-900 text-white text-xs font-bold py-2 px-4 rounded-lg hover:bg-emerald-800 transition shadow">
                            <i class="fa-solid fa-map-location-dot mr-1"></i> <?php _e('Open Google Map', 'ghodaghodi-view'); ?>
                        </a>
                    <?php endif; ?>
                </aside>

            </div>
        </article>
    </main>

<?php
endwhile;
get_footer();
?>