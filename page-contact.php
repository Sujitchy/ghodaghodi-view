<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 */
get_header();
?>

<?php
$contact_bg = get_template_directory_uri() . '/assets/images/banner.jpg';
?>

<section class="relative bg-emerald-950 text-white overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-25" style="background-image: url('<?php echo esc_url($contact_bg); ?>');"></div>
    <div class="relative container mx-auto max-w-4xl px-4 py-28 md:py-40 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mt-8 mb-8 leading-tight text-amber-400">
            <?php the_title(); ?>
        </h1>
        <?php if (get_the_excerpt()): ?>
        <p class="text-base md:text-lg text-emerald-100 opacity-90 leading-relaxed">
            <?php echo esc_html(get_the_excerpt()); ?>
        </p>
        <?php else: ?>
        <p class="text-base md:text-lg text-emerald-100 opacity-90 leading-relaxed">
            <?php _e('कुनै पनि प्रश्न, सुझाव वा जानकारीको लागि हामीलाई सम्पर्क गर्नुहोस्।', 'ghodaghodi-view'); ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<main class="container mx-auto px-4 py-12 max-w-6xl">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
        <aside class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fa-solid fa-location-dot text-emerald-600 mr-2.5"></i><?php _e('ठेगाना', 'ghodaghodi-view'); ?>
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    <?php echo esc_html(get_theme_mod('ghodaghodi_contact_address', __('घोडाघोडी नगरपालिका, कैलाली जिल्ला, सुदूरपश्चिम प्रदेश, नेपाल', 'ghodaghodi-view'))); ?>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fa-solid fa-phone text-emerald-600 mr-2.5"></i><?php _e('फोन', 'ghodaghodi-view'); ?>
                </h2>
                <p class="text-sm text-gray-600">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', get_theme_mod('ghodaghodi_contact_phone', ''))); ?>" class="hover:text-emerald-700">
                        <?php echo esc_html(get_theme_mod('ghodaghodi_contact_phone', __('+९७७-९१-४१२३४५', 'ghodaghodi-view'))); ?>
                    </a>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fa-solid fa-envelope text-emerald-600 mr-2.5"></i><?php _e('इमेल', 'ghodaghodi-view'); ?>
                </h2>
                <p class="text-sm text-gray-600">
                    <a href="mailto:<?php echo esc_attr(get_theme_mod('ghodaghodi_contact_email', '')); ?>" class="hover:text-emerald-700">
                        <?php echo esc_html(get_theme_mod('ghodaghodi_contact_email', __('info@ghodaghodi.gov.np', 'ghodaghodi-view'))); ?>
                    </a>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fa-solid fa-clock text-emerald-600 mr-2.5"></i><?php _e('खुल्ने समय', 'ghodaghodi-view'); ?>
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    <?php echo esc_html(get_theme_mod('ghodaghodi_contact_hours', __('आइतबार – शुक्रबार: बिहान १० – साँझ ५', 'ghodaghodi-view'))); ?>
                </p>
            </div>
        </aside>

        <?php while (have_posts()): the_post(); ?>
        <div class="lg:col-span-3 bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <?php _e('हामीलाई सन्देश पठाउनुहोस्', 'ghodaghodi-view'); ?>
            </h2>

            <?php if (isset($_GET['contact_status']) && 'success' === $_GET['contact_status']): ?>
            <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-lg px-4 py-3 text-sm">
                <i class="fa-solid fa-circle-check mr-2"></i><?php _e('तपाईंको सन्देश सफलतापूर्वक पठाइएको छ। धन्यवाद!', 'ghodaghodi-view'); ?>
            </div>
            <?php elseif (isset($_GET['contact_status']) && 'error' === $_GET['contact_status']): ?>
            <div class="mb-6 bg-red-50 border border-red-300 text-red-800 rounded-lg px-4 py-3 text-sm">
                <i class="fa-solid fa-circle-exclamation mr-2"></i><?php _e('सन्देश पठाउन सकिएन। कृपया फेरि प्रयास गर्नुहोस्।', 'ghodaghodi-view'); ?>
            </div>
            <?php endif; ?>

            <form id="contact-form" class="space-y-5" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="ghodaghodi_contact_submit">
                <?php wp_nonce_field('ghodaghodi_contact_form', 'ghodaghodi_contact_nonce'); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-field">
                        <label for="cf-name" class="block text-sm font-semibold text-gray-700"><?php _e('पूरा नाम', 'ghodaghodi-view'); ?> *</label>
                        <input type="text" id="cf-name" name="cf_name" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div class="form-field">
                        <label for="cf-email" class="block text-sm font-semibold text-gray-700"><?php _e('इमेल', 'ghodaghodi-view'); ?> *</label>
                        <input type="email" id="cf-email" name="cf_email" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="form-field">
                    <label for="cf-subject" class="block text-sm font-semibold text-gray-700"><?php _e('विषय', 'ghodaghodi-view'); ?></label>
                    <input type="text" id="cf-subject" name="cf_subject"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="form-field">
                    <label for="cf-message" class="block text-sm font-semibold text-gray-700"><?php _e('सन्देश', 'ghodaghodi-view'); ?> *</label>
                    <textarea id="cf-message" name="cf_message" rows="6" required
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <button type="submit" class="submit-btn bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-lg transition">
                    <i class="fa-solid fa-paper-plane"></i><?php _e('सन्देश पठाउनुहोस्', 'ghodaghodi-view'); ?>
                </button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>

    <?php
    $map_url = get_theme_mod('ghodaghodi_contact_map', '');
    if ($map_url):
    ?>
    <div class="mt-8 rounded-xl overflow-hidden shadow-sm border border-gray-100 bg-gray-100">
        <div class="relative w-full aspect-[16/10] sm:aspect-[21/9]">
            <iframe src="<?php echo esc_url($map_url); ?>" class="absolute inset-0 w-full h-full" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php esc_attr_e('घोडाघोडी नक्सा', 'ghodaghodi-view'); ?>"></iframe>
        </div>
    </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
