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

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php
        $gallery = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 12,
            'category_name'  => 'gallery',
            'meta_key'       => '_thumbnail_id',
        ]);

        if ($gallery->have_posts()):
            while ($gallery->have_posts()): $gallery->the_post();
                $thumb_id = get_post_thumbnail_id();
                $full_url = wp_get_attachment_image_url($thumb_id, 'full');
        ?>
                <a href="<?php the_permalink(); ?>" class="group relative block bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition aspect-square">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-300', 'alt' => get_the_title()]); ?>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-3">
                        <h3 class="text-white text-sm font-bold truncate"><?php the_title(); ?></h3>
                    </div>
                </a>
            <?php
            endwhile;
            wp_reset_postdata();
        else:
            ?>
            <div class="col-span-full text-center py-12 text-gray-500">
                <i class="fa-solid fa-camera text-4xl mb-4 block text-gray-300"></i>
                <p><?php _e('ग्यालरीमा कुनै तस्बिर उपलब्ध छैन। कृपया "gallery" श्रेणीमा पोष्टहरू थप्नुहोस्।', 'ghodaghodi-view'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>