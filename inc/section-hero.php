<section id="hero-slider" class="relative overflow-hidden bg-emerald-950 text-white">
    <?php
    $slides = new WP_Query([
        'post_type'      => 'ghodaghodi_slider',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'ASC',
    ]);

    if ($slides->have_posts()):
        $total = $slides->post_count;
        $i = 0;
    ?>
    <div class="hero-slides-wrapper">
        <?php while ($slides->have_posts()): $slides->the_post();
            $badge = get_post_meta(get_the_ID(), '_slide_badge', true);
            $btn_text = get_post_meta(get_the_ID(), '_slide_button_text', true);
            $btn_url = get_post_meta(get_the_ID(), '_slide_button_url', true);
            $bg_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $active_class = $i === 0 ? 'active' : '';
        ?>
        <div class="hero-slide <?php echo $active_class; ?>" data-index="<?php echo $i; ?>">
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('<?php echo esc_url($bg_url ?: get_theme_mod('ghodaghodi_hero_bg', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80')); ?>');"></div>
            <div class="relative container mx-auto max-w-3xl px-4 py-20 md:py-28 text-center">
                <?php if ($badge): ?>
                <span class="bg-amber-500 text-emerald-950 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                    <?php echo esc_html($badge); ?>
                </span>
                <?php endif; ?>
                <h1 class="text-4xl md:text-5xl font-extrabold mt-4 mb-6 leading-tight text-amber-400">
                    <?php the_title(); ?>
                </h1>
                <div class="text-base md:text-lg text-emerald-100 opacity-90 leading-relaxed">
                    <?php the_content(); ?>
                </div>
                <?php if ($btn_text && $btn_url): ?>
                <a href="<?php echo esc_url($btn_url); ?>" class="inline-block mt-6 bg-amber-500 hover:bg-amber-400 text-emerald-950 font-bold px-6 py-3 rounded-lg transition">
                    <?php echo esc_html($btn_text); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php $i++; endwhile; wp_reset_postdata(); ?>
    </div>

    <?php if ($total > 1): ?>
    <div class="hero-slider-dots absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
        <?php for ($d = 0; $d < $total; $d++): ?>
        <button class="hero-slider-dot <?php echo $d === 0 ? 'active' : ''; ?>" data-index="<?php echo $d; ?>" aria-label="<?php printf(__('Go to slide %d', 'ghodaghodi-view'), $d + 1); ?>"></button>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="py-20 px-4 text-center">
        <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('<?php echo esc_url(get_theme_mod('ghodaghodi_hero_bg', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80')); ?>');"></div>
        <div class="relative container mx-auto max-w-3xl">
            <span class="bg-amber-500 text-emerald-950 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                <?php _e('विश्व रामसार क्षेत्र', 'ghodaghodi-view'); ?>
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-4 mb-6 leading-tight text-amber-400">
                <?php _e('संरक्षण सहितको पर्या-पर्यटन र संस्कृति', 'ghodaghodi-view'); ?>
            </h1>
            <p class="text-base md:text-lg text-emerald-100 opacity-90 leading-relaxed">
                <?php _e('घोडाघोडी नगरपालिकाका प्राकृतिक तालतलैया, दुर्लभ जैविक विविधता, र मौलिक थारु संस्कृतिको आधिकारिक डिजिटल प्रोफाइल पोर्टल।', 'ghodaghodi-view'); ?>
            </p>
        </div>
    </div>
    <?php endif; ?>
>
    </div>
</section>