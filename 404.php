<?php get_header(); ?>

<main class="container mx-auto px-4 py-24 text-center">
    <div class="max-w-md mx-auto">
        <i class="fa-solid fa-map-location-dot text-6xl text-emerald-300 mb-6 block"></i>
        <h1 class="text-6xl font-extrabold text-emerald-900 mb-4">४०४</h1>
        <p class="text-xl text-gray-600 mb-2"><?php _e('यो पृष्ठ भेटिएन', 'ghodaghodi-view'); ?></p>
        <p class="text-sm text-gray-400 mb-8"><?php _e('तपाईंले खोज्नुभएको पृष्ठ उपलब्ध छैन।', 'ghodaghodi-view'); ?></p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-6 py-3 rounded-lg transition">
            <i class="fa-solid fa-house"></i> <?php _e('गृह पृष्ठमा जानुहोस्', 'ghodaghodi-view'); ?>
        </a>
    </div>
</main>

<?php get_footer(); ?>
