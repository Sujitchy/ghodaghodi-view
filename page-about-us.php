<?php

/**
 * Template Name: About Us
 * Template Post Type: page
 */
get_header();
?>

<?php
$about_bg = get_template_directory_uri() . '/assets/images/banner.jpg';
$about_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
?>

<section class="relative bg-emerald-950 text-white overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-25" style="background-image: url('<?php echo esc_url($about_bg); ?>');"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/70"></div>
    <div class="relative container mx-auto max-w-4xl px-4 py-28 md:py-40 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mt-8 mb-6 leading-tight text-amber-400">
            <?php the_title(); ?>
        </h1>
        <p class="text-base md:text-xl text-white/90 font-medium leading-snug">
            <?php _e('प्रकृतिको काखमा जैविक विविधता र संस्कृतिको अनुपम संगम — घोडाघोडी सिमसार।', 'ghodaghodi-view'); ?>
        </p>
    </div>
</section>

<main class="container mx-auto px-4 py-12 max-w-5xl">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-10'); ?>>
                    <?php if ($about_image): ?>
                        <div class="mb-8 rounded-lg overflow-hidden">
                            <img src="<?php echo esc_url($about_image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-64 md:h-80 object-cover">
                        </div>
                    <?php endif; ?>

                    <div class="prose prose-gray max-w-none leading-relaxed text-gray-700">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    wp_link_pages([
                        'before' => '<div class="page-links mt-6 text-sm font-semibold">' . __('पृष्ठहरू:', 'ghodaghodi-view'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </article>
            <?php endwhile; ?>
        </div>

        <aside class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fa-solid fa-dove text-emerald-600 mr-2.5"></i><?php _e('हाम्रो मिशन', 'ghodaghodi-view'); ?>
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    <?php echo esc_html(get_theme_mod('ghodaghodi_about_mission', __('घोडाघोडीको प्राकृतिक, सांस्कृतिक र जैविक सम्पदाको संरक्षण गर्दै दिगो पर्यटन प्रवर्द्धन गर्नु।', 'ghodaghodi-view'))); ?>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fa-solid fa-eye text-amber-500 mr-2.5"></i><?php _e('हाम्रो दृष्टि', 'ghodaghodi-view'); ?>
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    <?php echo esc_html(get_theme_mod('ghodaghodi_about_vision', __('घोडाघोडीलाई संरक्षण र सामुदायिक विकासमा अग्रणी अन्तर्राष्ट्रिय पर्यटकीय गन्तव्य बनाउने।', 'ghodaghodi-view'))); ?>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fa-solid fa-handshake text-emerald-600 mr-2.5"></i><?php _e('हाम्रा मूल्य मान्यताहरू', 'ghodaghodi-view'); ?>
                </h2>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-600 mt-1"></i><?php _e('प्राकृतिक संरक्षण', 'ghodaghodi-view'); ?></li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-600 mt-1"></i><?php _e('सामुदायिक सहभागिता', 'ghodaghodi-view'); ?></li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-600 mt-1"></i><?php _e('दिगो विकास', 'ghodaghodi-view'); ?></li>
                    <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-emerald-600 mt-1"></i><?php _e('सांस्कृतिक सम्पदाको संरक्षण', 'ghodaghodi-view'); ?></li>
                </ul>
            </div>
        </aside>
    </div>
</main>

<?php get_footer(); ?>